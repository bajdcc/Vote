<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
    <title>@yield('title')</title>

    <link rel="dns-prefetch" href="http://a0.twimg.com"/>

    <!-- CSS  -->
    <link href="//cdn.bajdcc.com/bower_components/Materialize/dist/css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    @yield('head')
</head>

<body>
    <nav class="red lighten-1" role="navigation">
        <div class="container">
            <div class="nav-wrapper">
                {{ link_to_route('home', $title = 'Service', $parameters = array(), $attributes = array('class' => 'brand-logo', 'id' => 'logo-container' )) }}
                <ul class="right hide-on-med-and-down">
                    @if (Sentry::check() && Sentry::getUser()->hasAccess('admin'))
                        <li {!! (Request::is('users*') ? 'class="active"' : '') !!}>{{ link_to_route('sentinel.users.index', $title = trans('pages.users'), $parameters = array(), $attributes = array('class' => 'waves-effect' )) }}</li>
                        <li {!! (Request::is('groups*') ? 'class="active"' : '') !!}>{{ link_to_route('sentinel.groups.index', $title = trans('pages.groups'), $parameters = array(), $attributes = array('class' => 'waves-effect' )) }}</li>
                    @endif
                    @if (Sentry::check())
                        <li {!! (Request::is('profile') ? 'class="active"' : '') !!}>
                            {{ link_to_route('sentinel.profile.show', $title = Sentry::getUser()->username) }}
                        </li>
                        <li><a href="{{ route('sentinel.logout') }}">{{ trans('pages.logout') }}</a></li>
                    @else
                        <li {!! (Request::is('login') ? 'class="active"' : '') !!}>{{ link_to_route('sentinel.login', $title = trans('pages.login'), $parameters = array(), $attributes = array('class' => 'waves-effect' )) }}</li>
                        <li {!! (Request::is('register') ? 'class="active"' : '') !!}>{{ link_to_route('sentinel.register.form', $title = trans('pages.register'), $parameters = array(), $attributes = array('class' => 'waves-effect' )) }}</li>
                    @endif
                </ul>
                <ul id="nav-mobile" class="side-nav">
                    @if (Sentry::check() && Sentry::getUser()->hasAccess('admin'))
                        <li {!! (Request::is('users*') ? 'class="active"' : '') !!}>{{ link_to_route('sentinel.users.index', $title = trans('pages.users'), $parameters = array(), $attributes = array('class' => 'waves-effect' )) }}</li>
                        <li {!! (Request::is('groups*') ? 'class="active"' : '') !!}>{{ link_to_route('sentinel.groups.index', $title = trans('pages.groups'), $parameters = array(), $attributes = array('class' => 'waves-effect' )) }}</li>
                    @endif
                    @if (Sentry::check())
                        <li {!! (Request::is('profile') ? 'class="active"' : '') !!}>
                            {{ link_to_route('sentinel.profile.show', $title = Sentry::getUser()->username) }}
                        </li>
                        <li><a href="{{ route('sentinel.logout') }}">{{ trans('pages.logout') }}</a></li>
                    @else
                        <li {!! (Request::is('login') ? 'class="active"' : '') !!}>{{ link_to_route('sentinel.login', $title = trans('pages.login'), $parameters = array(), $attributes = array('class' => 'waves-effect' )) }}</li>
                        <li {!! (Request::is('register') ? 'class="active"' : '') !!}>{{ link_to_route('sentinel.register.form', $title = trans('pages.register'), $parameters = array(), $attributes = array('class' => 'waves-effect' )) }}</li>
                    @endif
                </ul>
                <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="mdi-navigation-menu"></i></a>
            </div>
        </div>
    </nav>

    <!-- Container -->
    <div class="section no-pad-bot" id="index-banner">
        <div class="container">
            <!-- Content -->
            @yield('content')
            <!-- ./ Content -->
        </div>
    </div>
    <!-- ./ Container -->
    <!-- Footer -->
    <footer class="page-footer">
        <div class="container hide-on-med-and-down">
            <div class="row">
                <div class="col l6 s12">
                    <h5 class="white-text">Bajdcc Service</h5>
                    <p class="grey-text text-lighten-4">This is a service based on Laravel.</p>
                </div>
                <div class="col l4 offset-l2 s12">
                    <h5 class="white-text">Services</h5>
                    <ul>
                        <li>{{ link_to_route('service.jump.index', $title = 'Jump', $parameters = array(), $attributes = array('class' => 'grey-text text-lighten-3' )) }}</li>
                        <li>{{ link_to_route('service.vote.index', $title = 'Vote', $parameters = array(), $attributes = array('class' => 'grey-text text-lighten-3' )) }}</li>
                        <li>{{ link_to_route('service.link.index', $title = 'Link', $parameters = array(), $attributes = array('class' => 'grey-text text-lighten-3' )) }}</li>
                        <li>{{ link_to('#', $title = '...',$attributes = array('class' => 'grey-text text-lighten-3' )) }}</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <div class="container">
                © 2016 Copyright
            </div>
        </div>
    </footer>
    <!-- ./ Footer -->

    <!-- Javascripts
    ================================================== -->
    <script src="//cdn.bajdcc.com/ajax/libs/jquery/jquery/jquery-2.1.3.min.js"></script>
    <script src="//cdn.bajdcc.com/bower_components/Materialize/dist/js/materialize.min.js"></script>
    <script src="//cdn.bajdcc.com/bower_components/restfulizer/jquery.restfulizer.js"></script>
    <!-- Thanks to Zizaco for the Restfulizer script.  http://zizaco.net  -->
    <script language="javascript">
        (function($){
            $(function(){
                $('.button-collapse').sideNav();

                // Show session messages if necessary
                @if ($message = Session::get('success'))
                    toast("{!! $message !!}", 5000);
                @endif
                @if ($message = Session::get('error'))
                    toast("{!! $message !!}", 5000);
                @endif
                @if ($message = Session::get('warning'))
                    toast("{!! $message !!}", 5000);
                @endif
                @if ($message = Session::get('info'))
                    toast("{!! $message !!}", 5000);
                @endif
            }); // end of document ready
        })(jQuery); // end of jQuery name space
    </script>

    @yield('postscript')
</body>
</html>
