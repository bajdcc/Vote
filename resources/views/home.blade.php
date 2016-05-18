@extends(config('sentinel.layout'))

{{-- Web site Title --}}
@section('title')
    Home
@stop

{{-- Content --}}
@section('content')
    <div class="slider">
        <div class="hide-on-med-and-down ribbon"></div>
        <ul class="slides center" style="background-color: white">
            <li>
                <img class="image-border" src="//cdn.bajdcc.com/services/img/bg/bilibili/mei.jpg">
            </li>
            <li>
                <img class="image-border" src="//cdn.bajdcc.com/services/img/bg/bilibili/mei2.jpg">
            </li>
            <li>
                <img class="image-border" src="//cdn.bajdcc.com/services/img/bg/bilibili/22.jpg">
            </li>
            <li>
                <img class="image-border" src="//cdn.bajdcc.com/services/img/bg/bilibili/33.jpg">
            </li>
        </ul>
    </div>
@stop

@section('head')
    <style type="text/css">
        .image-border {
            padding: 5px;
            margin: 5px;
            border: 1px solid #CCC;
        }

        div.slider {
            height: 500px;
        }

        .slider .slides li img {
            height: 450px;
            width: 600px;
        }

        .ribbon {
            position: absolute;
            top: 0;
            left: 0;
            width: 130px;
            height: 40px;
            background: -webkit-gradient(linear, 555% 20%, 0% 92%, from(rgba(0, 0, 0, 0.1)), to(rgba(0, 0, 0, 0.0)), color-stop(.1, rgba(0, 0, 0, 0.2)));
            border-left: 1px dashed rgba(0, 0, 0, 0.1);
            border-right: 1px dashed rgba(0, 0, 0, 0.1);
            -webkit-box-shadow: 0 0 12px rgba(0, 0, 0, 0.2);
            -webkit-transform: rotate(-30deg) skew(0deg, 0deg) translate(-30px, -20px);
            z-index: 999;
        }

        div.slider {
            margin: auto;
            width: 618px;
            min-height: 310px;
            padding: 10px;
            position: relative;
            background: -webkit-gradient(linear, 100% 100%, 50% 10%, from(#fff), to(#f3f3f3), color-stop(.1, #fff));
            border: 1px solid #ccc;
            -webkit-box-shadow: 1px 1px 4px rgba(0, 0, 0, 0.1);
            -webkit-border-bottom-right-radius: 60px 5px;
        }

        div.slider:before {
            content: '';
            width: 98%;
            z-index: -1;
            height: 100%;
            padding: 0 0 1px 0;
            position: absolute;
            bottom: 0;
            right: 0;
            background: -webkit-gradient(linear, 0% 20%, 0% 92%, from(#fff), to(#f9f9f9), color-stop(.1, #fff));
            border: 1px solid #ccc;
            -webkit-box-shadow: 1px 1px 8px rgba(0, 0, 0, 0.1);
            -webkit-border-bottom-right-radius: 60px 5px;
            -webkit-transform: skew(2deg, 2deg) translate(3px, 8px)
        }

        div.slider:after {
            content: '';
            width: 98%;
            z-index: -1;
            height: 98%;
            padding: 0 0 1px 0;
            position: absolute;
            bottom: 0;
            right: 0;
            background: -webkit-gradient(linear, 0% 20%, 0% 100%, from(#f3f3f3), to(#f6f6f6), color-stop(.1, #fff));
            border: 1px solid #ccc;
            -webkit-box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
            -webkit-transform: skew(2deg, 2deg) translate(-1px, 2px)
        }
    </style>
@stop

@section('postscript')
    <script type="text/javascript">
        (function () {

            function Toast() {
                this.promise = Promise.resolve();
            }

            Toast.prototype = {
                constructor: Toast,
                toast: function (text, during, shape) {
                    text = text || "Toast";
                    during = during || 1000;
                    shape = shape || "";
                    this.promise = this.promise.then(function () {
                        return (function (text, during, shape) {
                            return new Promise(function (resolve) {
                    Materialize.            toast(text, during, shape, resolve);
                            })
                        })(text, during, shape);
                    });
                    return this;
               }
            };
            $.extend({
                Toast: function () {
                    return new Toast();
                }
            });
        })();

        (function ($) {
            $(function () {
                $('.slider').slider({height: '450px'});
                $.Toast()
                        .toast('Welcome!', 3000, 'rounded')
                        .toast('This is bajdcc\'s service web app!', 4000, 'rounded')
                        .toast('Have fun!', 2500, 'rounded')
                        .toast('o(∩_∩)o ', 2000, 'rounded');
            }); // end of document ready
        })(jQuery); // end of jQuery name space
    </script>
@stop