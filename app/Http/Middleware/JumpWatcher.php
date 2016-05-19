<?php

namespace App\Http\Middleware;

use Closure;
use Sunra\PhpSimple\HtmlDomParser;

class JumpWatcher
{
    static private $pass_ext = array();
    static private $cache_prefix = 'Jump:url:';
    private $currentTime = 0.0;
    private $args = array();
    private $query = '';
    private $uri_part = array();

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->currentTime = $this->microtime_float();
        $query = $request->query();
        $this->args = $query;
        if (isset($query['url'])) {
            $url = urldecode($query['url']);
            if (!starts_with($url, startsWith('http'))) {
                $url = 'http://' . $url;
            }
            if (!isset($query['nocache']) || empty($query['nocache'])) {
                $redis = \Redis::connection('default');
                $redis_key = self::$cache_prefix . $url;
                if ($redis->exists($redis_key)) {
                    return base64_decode($redis->get($redis_key));
                }
            }
            $code = $this->preAnalysis($url);
            switch ($code) {
                case 0:
                    return response($url);
                case 1:
                    return redirect($url);
            }
            list($code, $content) = $this->getHeaders($url);
            switch ($code) {
                case 1:
                    return response($this->replaceHTML($content));
                case 2:
                    return redirect($url);
                default:
                    return response($content);
            }
        } else {
            return $next($request);
        }
    }

    /**
     * Analysis the url
     *
     * @param $url
     * @return int
     */
    private function preAnalysis($url)
    {
        $this->uri_part = parse_url($url);
        if ($this->uri_part == FALSE)
            return 0;
        unset($this->args['url']);
        $query = http_build_query($this->args);
        if (!empty($query)) {
            $this->query = '&' . $query;
        }
        if (!isset($uri_part['path'])) {
            return 2;
        }
        $path_parts = pathinfo($uri_part['path']);
        if (isset($path_parts['extension'])) {
            $ext = $path_parts['extension'];
            if (array_key_exists($ext, self::$pass_ext)) {
                return 1;
            }
        }
        return 2;
    }

    /**
     * Replace all links to localhost
     *
     * @param string $headers
     * @return string
     */
    private function replaceHTML($headers)
    {
        $url = $headers['url'];
        $https = starts_with($url, 'https');

        $options = array(
            CURLOPT_HEADER => 0,
            CURLOPT_REFERER => $this->uri_part['host'],
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_BINARYTRANSFER => true,
            CURLOPT_ENCODING => 'gzip,deflate',
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.101 Safari/537.36'
        );

        $ch = curl_init();
        curl_setopt_array($ch, $options);
        if (!$result = curl_exec($ch)) {
            return (curl_error($ch));
        }
        curl_close($ch);

        $result = $this->safeEncoding($result);
        $html = HtmlDomParser::str_get_html($result);
        foreach ($html->find('a') as $element) {
            if (isset($element->href) && !starts_with($element->href, '#')) {
                $element->href = $this->transUrl($element->href, $url, $https);
            }
        }
        foreach ($html->find('link') as $element) {
            if (isset($element->href)) {
                if (isset($element->rel) && $element->rel === 'dns-prefetch') {

                } else {
                    $element->href = $this->transUrl($element->href, $url, $https, false);
                }
            }
        }
        foreach ($html->find('img') as $element) {
            if (isset($element->src) && !starts_with($element->src, '#')) {
                $element->src = $this->transUrl($element->src, $url, $https, false);
            }
        }
        foreach ($html->find('script') as $element) {
            if (isset($this->args['killjs']) && !empty($this->args['killjs'])) {
                $element->src = '//cdn.bajdcc.com/services/injection/null.js';
            } else {
                if (isset($element->src)) {
                    $element->src = $this->transUrl($element->src, $url, $https, false);
                }
            }
        }
        //foreach ($html->find('img') as $element) {
        //    $element->src = $this->transUrl($element->src, $url, $https);
        //}
        foreach ($html->find('title') as $element) {
            $element->innertext = $element->innertext . ' -- HOOKED! by bajdcc';
        }

        if ($html->find('body', 0)) {
            $inject = '';
            $inject .= '<script>injected_time_bajdcc=';
            $inject .= ($this->microtime_float() - $this->currentTime);
            $inject .= '</script>';
            $inject .= '<script src="//cdn.bajdcc.com/services/injection/inject.js"></script>';
            if (isset($this->args['script']) && !empty($this->args['script'])) {
                $inject .= "<script src='//cdn.bajdcc.com/services/injection/www/{$this->args['script']}.js''></script>";
            }
            $html->find('body', 0)->innertext = $html->find('body', 0)->innertext . $inject;
        }
        if (!isset($query['nocache']) || empty($query['nocache'])) {
            $redis = \Redis::connection('default');
            $redis_key = self::$cache_prefix . $url;
            $redis->setex($redis_key, 300, base64_encode($html));
        }

        return $html;
    }

    /**
     * @param string $str
     * @return string
     */
    function safeEncoding($str)
    {
        //$code = mb_detect_encoding($str, array('GBK', 'UTF-8', 'ASCII'));//检测字符串编码
        //if ($code == "CP936") {
        //    $result = $str;
        //} else {
        //$result = mb_convert_encoding($str, 'UTF-8', $code);//将编码$code转换为utf-8编码
        //$result = iconv($code, "UTF-8", $str);
        //}
        return mb_convert_encoding($str, 'UTF-8', 'ASCII,UTF-8,GBK');
    }

    /**
     * @param string $href
     * @param string $url
     * @param bool $https
     * @param bool $redirect
     * @return string
     */
    private function transUrl($href, $url, $https, $redirect = true)
    {
        if (starts_with($href, 'javascript:')) {
            return $href;
        }
        if (starts_with($href, '//')) {
            $href = ($https ? 'https:' : 'http:') . $href;
        } else {
            $href = $this->filter_relative_url($href, $url);
            if (is_null($href)) {
                $href = '#';
            }
        }
        if ($redirect) {
            return url('/jump?url=' . urlencode($href) . $this->query);
        } else {
            return $href;
        }
    }

    /**
     * Get headers
     *
     * @param string $url
     * @return mixed
     */
    private function getHeaders($url)
    {
        $ch = curl_init();

        $options = array(
            CURLOPT_URL => $url,
            CURLOPT_HEADER => 1,
            CURLOPT_NOBODY => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.101 Safari/537.36'
        );

        curl_setopt_array($ch, $options);
        curl_exec($ch);
        if (curl_errno($ch)) {
            return array(0, curl_error($ch));
        }

        $headers = curl_getinfo($ch);
        curl_close($ch);
        $content_type = '';
        if (isset($headers['content_type'])) {
            $content_type = $headers['content_type'];
        }
        if (starts_with($content_type, 'text/html')) {
            return array(1, $headers);
        } else {
            return array(2, $content_type);
        }
    }

    /**
     * 把从HTML源码中获取的相对路径转换成绝对路径
     * @param string $url HTML中获取的网址
     * @param string $uri 用来参考判断的原始地址
     * @return string 返回修改过的网址，如果网址有误则返回NULL
     */
    private function filter_relative_url($url, $uri)
    {
        //STEP1: 先去判断URL中是否包含协议，如果包含说明是绝对地址则可以原样返回
        if (strpos($url, '://') !== FALSE) {
            return $url;
        }

        //STEP2: 解析传入的URI
        $uri_part = parse_url($uri);
        if ($uri_part == FALSE)
            return NULL;
        $uri_root = $uri_part['scheme'] . '://' . $uri_part['host'] . (isset($uri_part['port']) ? ':' . $uri_part['port'] : '');

        //STEP3: 如果URL以左斜线开头，表示位于根目录
        if (strpos($url, '/') === 0) {
            return $uri_root . $url;
        }

        //STEP4: 不位于根目录，也不是绝对路径，考虑如果不包含'./'的话，需要把相对地址接在原URL的目录名上
        $uri_dir = (isset($uri_part['path']) &&
            $uri_part['path']) ? '/' . ltrim($uri_part['path'], '/') : '';
        if (strpos($url, './') === FALSE) {
            if ($uri_dir != '') {
                return $uri_root . $uri_dir . '/' . $url;
            } else {
                return $uri_root . '/' . $url;
            }
        }

        //STEP5: 如果相对路径中包含'../'或'./'表示的目录，需要对路径进行解析并递归
        //STEP5.1: 把路径中所有的'./'改为'/'，'//'改为'/'
        $url = preg_replace('/[^\.]\.\/|\/\//', '/', $url);
        if (strpos($url, './') === 0)
            $url = substr($url, 2);

        //STEP5.2: 使用'/'分割URL字符串以获取目录的每一部分进行判断
        $uri_full_dir = ltrim($uri_dir . '/' . $url, '/');
        $URL_arr = explode('/', $uri_full_dir);

        if ($URL_arr[0] == '..')
            return NULL;

        //因为数组的第一个元素不可能为'..'，所以这里从第二个元素可以循环
        $dst_arr = $URL_arr;  //拷贝一个副本，用于最后组合URL
        for ($i = 1; $i < count($URL_arr); $i++) {
            if ($URL_arr[$i] == '..') {
                $j = 1;
                while (TRUE) {
                    if (isset($dst_arr[$i - $j]) &&
                        $dst_arr[$i - $j] != FALSE
                    ) {
                        $dst_arr[$i - $j] = FALSE;
                        $dst_arr[$i] = FALSE;
                        break;
                    } else {
                        $j++;
                    }
                }
            }
        }

        // 组合最后的URL并返回
        $dst_str = $uri_root;
        foreach ($dst_arr as $val) {
            if ($val != FALSE)
                $dst_str .= '/' . $val;
        }

        return $dst_str;
    }

    /**
     * Get current time
     *
     * @return float
     */
    function microtime_float()
    {
        list($usec, $sec) = explode(" ", microtime());
        return ((float)$usec + (float)$sec);
    }
}
