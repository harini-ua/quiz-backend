<!DOCTYPE html>
<html class="no-js css-menubar" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Liqor43 App">
    <meta name="author" content="">

    <title>@yield('head-title', 'Liqor43')</title>

    <link rel="apple-touch-icon" href="/assets/images/liqor.png">
    <link rel="shortcut icon" href="/assets/images/favicon.ico">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/bootstrap-extend.min.css">
    <link rel="stylesheet" href="/assets/css/site.min.css">

    <!-- Plugins -->
    <link rel="stylesheet" href="/assets/vendor/animsition/animsition.css">
    <link rel="stylesheet" href="/assets/vendor/asscrollable/asScrollable.css">
    <link rel="stylesheet" href="/assets/vendor/switchery/switchery.css">
    <link rel="stylesheet" href="/assets/vendor/intro-js/introjs.css">
    <link rel="stylesheet" href="/assets/vendor/slidepanel/slidePanel.css">
    <link rel="stylesheet" href="/assets/vendor/flag-icon-css/flag-icon.css">

    <link rel="stylesheet" href="/assets/vendor/chartist/chartist.css">
    <link rel="stylesheet" href="/assets/vendor/jvectormap/jquery-jvectormap.css">
    <link rel="stylesheet" href="/assets/vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.css">
    <link rel="stylesheet" href="/assets/css/v1.min.css">
    <link rel="stylesheet" href="/assets/css/yellow.min.css">


    <!-- Fonts -->
    <link rel="stylesheet" href="/assets/fonts/weather-icons/weather-icons.css">
    <link rel="stylesheet" href="/assets/fonts/web-icons/web-icons.min.css">
    <link rel="stylesheet" href="/assets/fonts/brand-icons/brand-icons.min.css">
    <link rel="stylesheet" href="/assets/fonts/font-awesome/all.min.css">
    <link rel="stylesheet" href="/assets/fonts/font-awesome/fontawesome.css">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>

    <!--[if lt IE 9]>
    <script src="/assets/vendor/html5shiv/html5shiv.min.js"></script>
    <![endif]-->

    <!--[if lt IE 10]>
    <script src="/assets/vendor/media-match/media.match.min.js"></script>
    <script src="/assets/vendor/respond/respond.min.js"></script>
    <![endif]-->

    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Scripts -->
    <script src="/assets/vendor/breakpoints/breakpoints.js"></script>
    <script>
        Breakpoints();
    </script>
</head>
<body class="animsition dashboard">
<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<nav class="site-navbar navbar navbar-default navbar-fixed-top navbar-mega" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggler hamburger hamburger-close navbar-toggler-left hided"
                data-toggle="menubar">
            <span class="sr-only">Toggle navigation</span>
            <span class="hamburger-bar"></span>
        </button>
        <button type="button" class="navbar-toggler collapsed" data-target="#site-navbar-collapse"
                data-toggle="collapse">
            <i class="icon wb-more-horizontal" aria-hidden="true"></i>
        </button>
        <div class="navbar-brand navbar-brand-center site-gridmenu-toggle" data-toggle="gridmenu">
            <img class="navbar-brand-logo" src="/assets/images/liqor.png" title="Liqor">
            <span class="navbar-brand-text hidden-xs-down"> Liqor43 App</span>
        </div>
    </div>
    <div class="navbar-container container-fluid">
        <!-- Navbar Collapse -->
        <div class="collapse navbar-collapse navbar-collapse-toolbar" id="site-navbar-collapse">
            <!-- Navbar Toolbar -->
            <ul class="nav navbar-toolbar">
                <li class="nav-item hidden-float" id="toggleMenubar">
                    <a class="nav-link" data-toggle="menubar" href="#" role="button">
                        <i class="icon hamburger hamburger-arrow-left">
                            <span class="sr-only">Toggle menubar</span>
                            <span class="hamburger-bar"></span>
                        </i>
                    </a>
                </li>
                <li class="nav-item hidden-sm-down" id="toggleFullscreen">
                    <a class="nav-link icon icon-fullscreen" data-toggle="fullscreen" href="#" role="button">
                        <span class="sr-only">Toggle fullscreen</span>
                    </a>
                </li>
            </ul>
            <!-- End Navbar Toolbar -->
            <!-- Navbar Toolbar Right -->
            <ul class="nav navbar-toolbar navbar-right navbar-toolbar-right">
                <li class="nav-item dropdown">
                    <a class="nav-link navbar-avatar" data-toggle="dropdown" href="#" aria-expanded="false"
                       data-animation="scale-up" role="button">
                <span class="avatar avatar-online">
                  <img src="/assets/images/liqor.png" alt="...">
                  <i></i>
                </span>
                    </a>
                    <div class="dropdown-menu" role="menu">
                        <a class="dropdown-item" href="javascript:void(0)" role="menuitem"><i class="icon wb-user" aria-hidden="true"></i> Profile</a>
                        <a class="dropdown-item" href="javascript:void(0)" role="menuitem"><i class="icon wb-settings" aria-hidden="true"></i> Settings</a>
                        <div class="dropdown-divider" role="presentation"></div>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" role="menuitem"><i class="icon wb-power" aria-hidden="true"></i> Logout</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
            <!-- End Navbar Toolbar Right -->
        </div>
        <!-- End Navbar Collapse -->
        <!-- Site Navbar Seach -->
        <div class="collapse navbar-search-overlap" id="site-navbar-search">
            <form role="search">
                <div class="form-group">
                    <div class="input-search">
                        <i class="input-search-icon wb-search" aria-hidden="true"></i>
                        <input type="text" class="form-control" name="site-search" placeholder="Search...">
                        <button type="button" class="input-search-close icon wb-close" data-target="#site-navbar-search"
                                data-toggle="collapse" aria-label="Close"></button>
                    </div>
                </div>
            </form>
        </div>
        <!-- End Site Navbar Seach -->
    </div>
</nav>
<div class="site-menubar">
    <div class="site-menubar-body">
        <div>
            <div>
                @yield('menu')
            </div>
        </div>
    </div>
</div>

@yield('content')

<!-- Core  -->
<script src="/assets/vendor/babel-external-helpers/babel-external-helpers.js"></script>
<script src="/assets/vendor/jquery/jquery.js"></script>
<script src="/assets/vendor/popper-js/umd/popper.min.js"></script>
<script src="/assets/vendor/bootstrap/bootstrap.js"></script>
<script src="/assets/vendor/animsition/animsition.js"></script>
<script src="/assets/vendor/mousewheel/jquery.mousewheel.js"></script>
<script src="/assets/vendor/asscrollbar/jquery-asScrollbar.js"></script>
<script src="/assets/vendor/asscrollable/jquery-asScrollable.js"></script>
<script src="/assets/vendor/ashoverscroll/jquery-asHoverScroll.js"></script>

<!-- Plugins -->
<script src="/assets/vendor/switchery/switchery.js"></script>
<script src="/assets/vendor/intro-js/intro.js"></script>
<script src="/assets/vendor/screenfull/screenfull.js"></script>
<script src="/assets/vendor/slidepanel/jquery-slidePanel.js"></script>
<script src="/assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>

<script src="/assets/vendor/skycons/skycons.js"></script>
<script src="/assets/vendor/chartist/chartist.min.js"></script>
{{--
<script src="/assets/vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.js"></script>
--}}
<script src="/assets/vendor/aspieprogress/jquery-asPieProgress.min.js"></script>
<script src="/assets/vendor/jvectormap/jquery-jvectormap.min.js"></script>
<script src="/assets/vendor/jvectormap/maps/jquery-jvectormap-au-mill-en.js"></script>
<script src="/assets/vendor/matchheight/jquery.matchHeight-min.js"></script>

<!-- Scripts -->
<script src="/assets/js/Component.js"></script>
<script src="/assets/js/Plugin.js"></script>
<script src="/assets/js/Base.js"></script>
<script src="/assets/js/Config.js"></script>

<script src="/assets/base/js/Section/Menubar.js"></script>
<script src="/assets/base/js/Section/GridMenu.js"></script>
<script src="/assets/base/js/Section/Sidebar.js"></script>
<script src="/assets/base/js/Section/PageAside.js"></script>
<script src="/assets/base/js/Plugin/menu.js"></script>

<script src="/assets/js/config/colors.js"></script>
<script src="/assets/base/js/config/tour.js"></script>
<script>Config.set('assets', '/assets');</script>

<!-- Page -->
<script src="/assets/base/js/Site.js"></script>
<script src="/assets/js/Plugin/asscrollable.js"></script>
<script src="/assets/js/Plugin/slidepanel.js"></script>
<script src="/assets/js/Plugin/switchery.js"></script>
<script src="/assets/js/Plugin/matchheight.js"></script>
<script src="/assets/js/Plugin/jvectormap.js"></script>

<script src="/assets/js/v1.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
@yield('js')

</body>
</html>
