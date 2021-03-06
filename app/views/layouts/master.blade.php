<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>{{ (isset($title) ? "$title -" : '') }} tools.io</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- Le styles -->
        <link href="/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <style type="text/css">
            body {
                padding-top: 40px;
                padding-bottom: 40px;
            }

            .sidebar-nav {
                padding: 9px 0;
            }

            @media (max-width: 980px) {
                /* Enable use of floated navbar text */
                .navbar-text.pull-right {
                    float: none;
                    padding-left: 5px;
                    padding-right: 5px;
                }
            }
        </style>
        <link href="/assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
    </head>

    <body>

        <div class="container">
            <div class="row">
                <div class="span3">
                    <div class="well sidebar-nav">
                        <ul class="nav nav-list">
                            <li class="nav-header">Network</li>
                            <li class="{{(Request::is('network/ip/port')? 'active' : '')}}">
                                {{HTML::linkAction('IPController@getPort', 'Port Status')}}
                            </li>
                            <li class="{{(Request::is('network/ip/ping')? 'active' : '')}}">
                                {{HTML::linkAction('IPController@getPing', 'Ping IP Address')}}
                            </li>
                            <li class="{{(Request::is('network/ip/mtr')? 'active' : '')}}">
                                {{HTML::linkAction('IPController@getMtr', 'Traceroute')}}
                            </li>

                            <!--<li class="nav-header">Website</li>
                            <li class="{{(Request::is('website/monitor')? 'active' : '')}}">
                                {{HTML::linkAction('WebsiteController@getMonitor', 'Uptime Monitor')}}
                            </li>-->
                        </ul>
                    </div>
                    <!--/.well -->
                </div>
                <!--/span-->
                <div class="span9">
                    @yield('content')
                </div>
                <!--/span-->
            </div>
            <!--/row-->

            <hr>

            <footer>
                <p><a href="https://github.com/clone1018/tools.io">Open Source on Github</a></p>
            </footer>

        </div>
        <!--/.fluid-container-->

        <!-- Le javascript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="/assets/js/jquery.js"></script>
        <script src="/assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="/assets/js/modernizr.custom.34693.js"></script>

        @yield('scripts')

    </body>
</html>
