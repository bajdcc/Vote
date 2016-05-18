@extends(config('sentinel.layout'))

{{-- Web site Title --}}
@section('title')
    Chat
@stop

{{-- Content --}}
@section('content')
    <div id="fixed-radio-group" class="fixed-action-btn"
         style="top: 65px; left: 24px; width: 60px; height: 100px;">
        <div class="z-depth-1">
            <form id="radioForm">
                <p>
                    <input class="with-gap" name="group1" type="radio" id="test1" value="A"/>
                    <label for="test1">A</label>
                </p>

                <p>
                    <input class="with-gap" name="group1" type="radio" id="test2" value="B"/>
                    <label for="test2">B</label>
                </p>

                <p>
                    <input class="with-gap" name="group1" type="radio" id="test3" value="C"/>
                    <label for="test3">C</label>
                </p>

                <p>
                    <input class="with-gap" name="group1" type="radio" id="test4" value="D"/>
                    <label for="test4">D</label>
                </p>
            </form>
        </div>
    </div>
    <div id="fixed-button-group" class="fixed-action-btn hide-on-med-and-down"
         style="bottom: 45px; left: 24px; width: 50px;">
        <a class="btn-floating btn-large red">
            <i class="large mdi-content-add"></i>
        </a>
        <ul>
            <li><a class="btn-floating red" data-val="A"><i class="large mdi-image-looks-one"></i></a></li>
            <li><a class="btn-floating yellow darken-1" data-val="B"><i class="mdi-image-looks-two"></i></a></li>
            <li><a class="btn-floating green" data-val="C"><i class="large mdi-image-looks-3"></i></a></li>
            <li><a class="btn-floating blue" data-val="D"><i class="large mdi-image-looks-4"></i></a></li>
        </ul>
    </div>
    <div class="row">
        <div id="chart" class="col s12">
        </div>
    </div>
    <div class="row hide-on-med-and-down">
        <div class="range-field col s4">
            <label for="angle">Angle</label>
            <input id="angle" data-property="angle" type="range" min="0" max="60" value="30" step="1"/>
        </div>
        <div class="range-field col s4">
            <label for="depth3D">Depth</label>
            <input id="depth3D" data-property="depth3D" type="range" min="1" max="25" value="10" step="1"/>
        </div>
        <div class="range-field col s4">
            <label for="innerRadius">Inner-Radius</label>
            <input id="innerRadius" data-property="innerRadius" type="range" min="0" max="80" value="0" step="1"/>
        </div>
    </div>
    <div class="row hide-on-med-and-down">
        <div class="col l6 offset-l3 m8 offset-m2 s12">
            <form id="chatForm">
                <h2>Chat Room</h2>

                {!! csrf_field() !!}

                <div class="row" style="margin: 50px 0 50px 0;">
                    <div class="input-field col s12">
                        <i class="mdi-communication-email prefix"></i>
                        <textarea id="text" name="text" class="materialize-textarea"></textarea>
                        <label for="text">Message</label>
                    </div>
                </div>

                <p>
                    <button class="btn waves-effect waves-light red" id="submit" type="button" name="action">Send
                        <i class="mdi-content-send right"></i>
                    </button>
                </p>

            </form>
        </div>
    </div>
@stop

@section('head')
    <link rel='stylesheet' href='//cdn.bajdcc.com/bower_components/amcharts3/amcharts/plugins/export/export.css'
          type='text/css' media='all'/>
    <style type="text/css">
        #chart {
            width: 100%;
            height: 600px;
        }

        /* label color */
        .input-field label {
            color: #000;
        }

        /* label focus color */
        .input-field input[type=text]:focus + label {
            color: #000;
        }

        /* label underline focus color */
        .input-field input[type=text]:focus {
            border-bottom: 1px solid #000;
            box-shadow: 0 1px 0 0 #000;
        }

        /* valid color */
        .input-field input[type=text].valid {
            border-bottom: 1px solid #000;
            box-shadow: 0 1px 0 0 #000;
        }

        /* invalid color */
        .input-field input[type=text].invalid {
            border-bottom: 1px solid #000;
            box-shadow: 0 1px 0 0 #000;
        }

        /* icon prefix focus color */
        .input-field .prefix.active {
            color: #000;
        }
    </style>
@stop

@section('postscript')
    <script type="text/javascript" src="//cdn.bajdcc.com/github/brain-socket-js/lib/brain-socket.min.js"></script>
    <script src="//cdn.bajdcc.com/bower_components/amcharts3/amcharts/amcharts.js"></script>
    <script src="//cdn.bajdcc.com/bower_components/amcharts3/amcharts/lang/zh.js"></script>
    <script src="//cdn.bajdcc.com/bower_components/amcharts3/amcharts/pie.js"></script>
    <script src="//cdn.bajdcc.com/bower_components/amcharts3/amcharts/plugins/animate/animate.min.js"></script>
    <script src="//cdn.bajdcc.com/bower_components/amcharts3/amcharts/plugins/export/export.js"
            type="text/javascript"></script>
    <script src="//cdn.bajdcc.com/bower_components/amcharts3/amcharts/plugins/responsive/responsive.min.js"
            type="text/javascript"></script>
    <script src="//cdn.bajdcc.com/bower_components/amcharts3/amcharts/plugins/dataloader/dataloader.min.js"
            type="text/javascript"></script>
    <script src="//cdn.bajdcc.com/bower_components/amcharts3/amcharts/themes/light.js"></script>
    <script type="text/javascript">
        (function ($) {
            $(function () {
                // Decorate toast
                window.toast_old = Materialize.toast;
                window.toast = (function () {
                    return function () {
                        var args = Array.prototype.slice.call(arguments);
                        var obj = args.shift(1);
                        var id = obj.id || '[ID]';
                        var text = obj.text || '[TEXT]';
                        var type = obj.type || 'INFO';
                        var color = '';
                        if (type === 'INFO') {
                            color = 'white';
                        } else if (type === 'WARN') {
                            color = 'yellow';
                        } else if (type === 'ERROR') {
                            color = 'red';
                        } else {
                            color = 'blue';
                        }
                        return window.toast_old.apply(this, [
                            '<a class="' + color + '-text">[' + id + ']<a>&emsp;' +
                            '<span class="white-text">' + text + '</span>'
                        ].concat(args));
                    };
                })();
                window.toast_new = window.toast;

                if (window.Notification) {
                    Notification.requestPermission(function () {
                        if (Notification.permission === 'granted') {
                            // Decorate toast => HTML5 Notification
                            window.toast = function (obj, during) {
                                window.toast_new(obj, during);
                                var id = obj.id || '[ID]';
                                var text = obj.text || '[TEXT]';
                                var title = obj.title || '[TITLE]';
                                var tag = obj.tag || 'msg';
                                during = during || 1000;

                                var notification = new Notification(title, {
                                    dir: 'auto',
                                    lang: 'zh-CN',
                                    body: '[' + id + '] ' + text,
                                    tag: 'msg',
                                    icon: '/favicon.ico'
                                });
                                notification.onclick = function (event) {
                                    event.preventDefault()
                                };
                                notification.onerror = function () {
                                };
                                notification.onshow = function () {
                                    setTimeout(function () {
                                        notification.close();
                                    }, during);
                                };
                                notification.onclose = function () {
                                };
                            }
                        }
                    });
                }

                window.app = {};

                app.fake_user_id = Math.floor((Math.random() * 1000) + 1);
                app.csrf_token = $('input[type="hidden"]').val();

                app.ws = '{{ str_replace('http', 'ws', url('')) }}:{{ config('websocket.port') }}';
                console.log(app.ws);
                app.BrainSocket = new BrainSocket(
                        new WebSocket(app.ws),
                        new BrainSocketPubSub()
                );

                app.BrainSocket.connection.onopen = function (e) {
                    app.ws_state = true;
                    console.info(e);
                    toast_new({
                        type: 'INFO',
                        id: 'WebSocket',
                        text: 'Connected to server.'
                    }, 3000);
                };

                app.BrainSocket.connection.onerror = function (e) {
                    console.error(e);
                    toast_new({
                        type: 'ERROR',
                        id: 'WebSocket',
                        text: 'Error'
                    }, 3000);
                };

                app.report_choice = function (uid, choice) {
                    app.BrainSocket.message('generic.event',
                            {
                                'message': choice,
                                'user_id': uid
                            }
                    );
                }

                app.ws_error = function (event) {
                    if (event.code == 1000)
                        reason = "Normal closure, meaning that the purpose for which the connection was established has been fulfilled.";
                    else if (event.code == 1001)
                        reason = "An endpoint is \"going away\", such as a server going down or a browser having navigated away from a page.";
                    else if (event.code == 1002)
                        reason = "An endpoint is terminating the connection due to a protocol error";
                    else if (event.code == 1003)
                        reason = "An endpoint is terminating the connection because it has received a type of data it cannot accept (e.g., an endpoint that understands only text data MAY send this if it receives a binary message).";
                    else if (event.code == 1004)
                        reason = "Reserved. The specific meaning might be defined in the future.";
                    else if (event.code == 1005)
                        reason = "No status code was actually present.";
                    else if (event.code == 1006)
                        reason = "The connection was closed abnormally, e.g., without sending or receiving a Close control frame";
                    else if (event.code == 1007)
                        reason = "An endpoint is terminating the connection because it has received data within a message that was not consistent with the type of the message (e.g., non-UTF-8 [http://tools.ietf.org/html/rfc3629] data within a text message).";
                    else if (event.code == 1008)
                        reason = "An endpoint is terminating the connection because it has received a message that \"violates its policy\". This reason is given either if there is no other sutible reason, or if there is a need to hide specific details about the policy.";
                    else if (event.code == 1009)
                        reason = "An endpoint is terminating the connection because it has received a message that is too big for it to process.";
                    else if (event.code == 1010) // Note that this status code is not used by the server, because it can fail the WebSocket handshake instead.
                        reason = "An endpoint (client) is terminating the connection because it has expected the server to negotiate one or more extension, but the server didn't return them in the response message of the WebSocket handshake. <br /> Specifically, the extensions that are needed are: " + event.reason;
                    else if (event.code == 1011)
                        reason = "A server is terminating the connection because it encountered an unexpected condition that prevented it from fulfilling the request.";
                    else if (event.code == 1015)
                        reason = "The connection was closed due to a failure to perform a TLS handshake (e.g., the server certificate can't be verified).";
                    else
                        reason = "Unknown reason";
                    return reason;
                };

                app.BrainSocket.connection.onclose = function (e) {
                    app.ws_state = false;
                    console.info(e);
                    toast_new({
                        type: 'ERROR',
                        id: 'WebSocket',
                        text: app.ws_error(e)
                    }, 10000);
                };

                app.load_chart = function () {
                    $.getJSON('{{ route('vote_query') }}', function (data) {
                        var chart = window.chart;
                        chart.allLabels[0].text = data.count;
                        chart.animateData(data.data, {
                            duration: 600,
                            complete: function () {
                                toast({
                                    type: 'INFO',
                                    title: 'Update chart',
                                    id:'Chart',
                                    text: 'Count: ' + data.count
                                }, 3000);
                                console.info('refresh chart: ' + data.count);
                            }
                        });
                    });
                };

                app.BrainSocket.Event.listen('generic.event', function (msg) {
                    /*if (msg.client.data.user_id == fake_user_id) {
                     toast('<a class="yellow-text">[Me]<a>&emsp;' +
                     '<span class="white-text">' + msg.client.data.message + '</span>', 3000);
                     } else {
                     toast('<a class="yellow-text">[' + msg.client.data.user_id + ']<a>&emsp;' +
                     '<span class="white-text">' + msg.client.data.message + '</span>', 5000);
                     }*/
                    if (msg.client.data.user_id == app.fake_user_id) {
                        toast({
                            type: 'INFO',
                            title: 'Chat Message',
                            id: 'Me',
                            text: msg.client.data.message
                        }, 3000);
                    } else {
                        toast({
                            type: 'INFO',
                            title: 'Chat Message',
                            id: msg.client.data.user_id,
                            text: msg.client.data.message
                        }, 5000);
                    }
                    console.info('refresh chart...');
                    app.load_chart();
                });

                app.BrainSocket.Event.listen('client.connect', function (msg) {
                    //toast('<span class="white-text">' + data + '</span>', 4000, 'rounded');
                    toast({
                        type: 'INFO',
                        title: 'A client connected',
                        id: 'WebSocket',
                        text: 'Client #' + msg.client.data.id + ' connected, all: ' + msg.client.data.count
                    }, 4000);
                });

                app.BrainSocket.Event.listen('client.disconnect', function (msg) {
                    //toast('<span class="white-text">' + data + '</span>', 4000, 'rounded');
                    toast({
                        type: 'INFO',
                        title: 'A client disconnected',
                        id: 'WebSocket',
                        text: 'Client #' + msg.client.data.id + ' disconnected, all: ' + msg.client.data.count
                    }, 4000);
                });

                app.BrainSocket.Event.listen('app.success', function (msg) {
                    //toast('<span class="white-text">' + data + '</span>', 4000, 'rounded');
                    toast({
                        type: 'INFO',
                        title: 'Success',
                        id: 'App',
                        text: msg.client.data.message
                    }, 4000);
                });

                app.BrainSocket.Event.listen('app.error', function (msg) {
                    //toast('<span class="white-text">' + data + '</span>', 4000, 'rounded');
                    toast({
                        type: 'ERROR',
                        title: 'Error',
                        id: 'App',
                        text: msg.client.data.message
                    }, 4000);
                });
            }); // end of document ready
        })(jQuery); // end of jQuery name space
        $("#chatForm").on('post-data', function (event, uid, choice, token) {
            var hide_action = function () {
                $("input[name='group1']").attr('disabled', '');
                $("#text").attr('disabled', '');
                $("#fixed-button-group").hide();
            };
            var show_action = function () {
                $("input[name='group1']").removeAttr('disabled');
                $("#text").removeAttr('disabled');
                $("#fixed-button-group").show();
            };
            hide_action();
            setTimeout(function () {
                $.post('{{ route("vote_post") }}', {
                    uid: uid,
                    choice: choice,
                    _token: token
                }).success(function () {
                    setTimeout(function () {
                        show_action();
                    }, 3000);
                    app.report_choice(uid, choice);
                }).error(function () {
                    toast({
                        type: 'ERROR',
                        title: 'An error occured',
                        id: 'Ajax',
                        text: 'Invalid data'
                    }, 4000);
                    setTimeout(function () {
                        show_action();
                    }, 3000);
                });
            }, 100);
        });
        $("input[name='group1']").on('change', function (event) {
            var choice = $("input[name='group1']:checked").val();
            if (choice) {
                $("#chatForm").trigger('post-data', [app.fake_user_id, choice, app.csrf_token]);
            }
        });
        $("a[data-val]").on('click', function (event) {
            var choice = $(this).data('val');
            if (choice) {
                $("#chatForm").trigger('post-data', [app.fake_user_id, choice, app.csrf_token]);
            }
        });
        $(document).ready(function () {
            $("#submit").on('click', function (e) {
                //e.preventDefault();
                var $text = $("#text");
                if (!$text.val()) return;
                $("#chatForm").trigger('post-data', [app.fake_user_id, $text.val(), app.csrf_token]);
                $text.val('');
                $text.css('height', '22px');
            });
        })
        ;
    </script>
    <script type="text/javascript">
        (function () {
            /**
             * Create the chart
             */
            window.chart = AmCharts.makeChart("chart", {
                "type": "pie",
                "theme": "light",
                //"dataProvider": [],
                "valueField": "count",
                "titleField": "choice",
                "startDuration": 1,
                "innerRadius": 80,
                "pullOutRadius": 20,
                "marginTop": 30,
                "titles": [{
                    "text": "Question"
                }],
                "language": 'zh',
                "addClassNames": true,
                "legend": {
                    "position": "bottom",
                    "autoMargins": true,
                    "align": "center",
                    "markerType": "circle"
                },
                "allLabels": [{
                    "y": "54%",
                    "align": "center",
                    "size": 25,
                    "bold": true,
                    "text": "-",
                    "color": "#555"
                }, {
                    "y": "49%",
                    "align": "center",
                    "size": 15,
                    "text": "Vote",
                    "color": "#555"
                }],
                "dataLoader": {
                    "url": "{{ route('vote_query_init') }}",
                    "showCurtain": false,
                    "complete": function () {
                        setTimeout(function () {
                            app.load_chart();
                        }, 1500);
                    }
                },
                "outlineAlpha": 0.4,
                "depth3D": 15,
                "angle": 30,
                "balloonText": "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>",
                "responsive": {
                    "enabled": true
                },
                "export": {
                    "enabled": true
                }
            });

            /*chart.addListener("init", handleInit);

             chart.addListener("rollOverSlice", function(e) {
             handleRollOver(e);
             });

             function handleInit(){
             chart.legend.addListener("rollOverItem", handleRollOver);
             }

             function handleRollOver(e){
             var wedge = e.dataItem.wedge.node;
             wedge.parentNode.appendChild(wedge);
             }*/
            jQuery('input[type="range"]').off().on('input change', function () {
                var property = jQuery(this).data('property');
                var target = chart;
                var value = Number(this.value);
                chart.startDuration = 0;

                if (property == 'innerRadius') {
                    value += "%";
                }

                target[property] = value;
                chart.validateNow();
            });
        })();
    </script>
@stop