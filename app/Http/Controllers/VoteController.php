<?php

namespace App\Http\Controllers;

use App\Http\Requests\VotePostRequest;

use App\Http\Requests;

class VoteController extends Controller
{
    static private $vote_key = 'vote.question';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $redis = \Redis::connection('default');
        $question = $redis->get(self::$vote_key);
        if (!$question) {
            $array = array(
                'data' => array(
                    array('choice' => 'A', 'count' => 0),
                    array('choice' => 'B', 'count' => 0),
                    array('choice' => 'C', 'count' => 0),
                    array('choice' => 'D', 'count' => 0)
                ),
                'count' => 0
            );
            $redis->set(self::$vote_key, base64_encode(json_encode($array, true)));
        }
    }

    /**
     * Register route
     */
    static public function registerRoute()
    {
        \Route::get('/vote', 'VoteController@index');
        \Route::get('/vote/broadcast', 'VoteController@broadcast');
        \Route::get('/vote/query', 'VoteController@query')->name('vote_query');
        \Route::get('/vote/query_init', 'VoteController@query_init')->name('vote_query_init');
        \Route::post('/vote/post', 'VoteController@post')->name('vote_post');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('vote.index');
    }

    /**
     * Broadcast messages.
     *
     * @return \Illuminate\Http\Response
     */
    public function broadcast()
    {
        $redis = \Redis::connection('default');
        $question = $redis->get(self::$vote_key);
        $obj = json_decode(base64_decode($question), true);
        return response()->json($obj);
    }

    /**
 * Vote query data of json
 *
 * @return \Illuminate\Http\JsonResponse
 */
    public function query()
    {
        $redis = \Redis::connection('default');
        $question = $redis->get(self::$vote_key);
        $question = json_decode(base64_decode($question), true);
        return response($question);
    }

    /**
     * Vote query data of json, init
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function query_init()
    {
        $redis = \Redis::connection('default');
        $question = $redis->get(self::$vote_key);
        $obj = json_decode(base64_decode($question), true);
        $data = $obj['data'];
        return response()->json($data);
    }

    /**
     * Post data
     *
     * @param Requests\VotePostRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function post(VotePostRequest $request)
    {
        $char = $request->input('choice')[0];
        $choice = ord(strtolower($char)) - ord('a');
        if ($choice >= 0 && $choice < 4) {
            $uid = $request->input('uid');
            $redis = \Redis::connection('default');
            $question = $redis->get(self::$vote_key);
            $obj = json_decode(base64_decode($question), true);
            $data = $obj['data'];
            $code = $data[$choice];
            $obj['data'][$choice]['count'] = $obj['data'][$choice]['count'] + 1;
            $obj['count'] = $obj['count'] + 1;
            $redis->set(self::$vote_key, base64_encode(json_encode($obj)));
            $responseJson = array(
                'uid' => $uid,
                'count' => $obj['count'],
                'code' => $code['count']
            );
            return response()->json($responseJson);
        }
        abort(403);
    }
}
