<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="no-focus">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Icons -->
        <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
        <link rel="shortcut icon" href="{{ asset('assets/media/favicons/favicon.png') }}">
        <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('assets/media/favicons/favicon-192x192.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/media/favicons/apple-touch-icon-180x180.png') }}">
        <!-- END Icons -->

        <!-- Stylesheets -->
        @stack('css_before')
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,400i,600,700&display=swap">
        <link rel="stylesheet" id="css-main" href="{{ asset('assets/css/codebase.min.css') }}">
        <!-- You can include a specific file from css/themes/ folder to alter the default color theme of the template. eg: -->
        <!-- <link rel="stylesheet" id="css-theme" href="assets/css/themes/flat.min.css"> -->
        @stack('css_after')
        <style>
            #page-loader {
                position: fixed;
                top: 0;
                right: 0;
                bottom: 0;
                left: 0;
                background-color: rgb(63 156 232 / 0.5);
                background: linear-gradient(135deg, rgb(38 198 218 / 0.5) 0px, rgb(156 204 101 / 0.8) 100%) !important;
                z-index: 999998;
                transition: -webkit-transform .35s ease-out;
                transition: transform .35s ease-out;
                transition: transform .35s ease-out,-webkit-transform .35s ease-out;
                -webkit-transform: translateY(-100%);
                transform: translateY(-100%);
                will-change: transform;
            }
            #page-loader::before {
                margin-top: -30px;
                margin-left: -30px;
                width: 60px;
                height: 60px;
                background-color: rgb(5 5 255 / 1);
                -webkit-animation: page-loader-outer 1.5s infinite ease-in;
                animation: page-loader-outer 1.5s infinite ease-in;
            }
            #page-loader::after {
                margin-top: -100px;
                margin-left: -100px;
                width: 200px;
                height: 200px;
                background-color: rgb(5 5 255 / 50%);
                border: 3px solid rgb(0 0 0 / 75%);
                -webkit-animation: page-loader-inner 1.5s infinite ease-out;
                animation: page-loader-inner 1.5s infinite ease-out;
            }
        </style>
        <!-- END Stylesheets -->
    </head>
    <body>
        <!-- Start of testa3645i Zendesk Widget script -->
{{-- <script id="ze-snippet" src="https://static.zdassets.com/ekr/snippet.js?key=46985de8-f0e1-49d1-a6fd-f6053d61d0ed"> </script> --}}
<!-- End of testa3645i Zendesk Widget script -->

        <!-- Page loader (functionality is initialized in Template._uiHandlePageLoader()) -->
        <!-- If #page-loader markup and also the "show" class is added, the loading screen will be enabled and auto hide once the page loads -->
        <!-- Default background color is the primary color but you can use a bg-* class for a custom bg color -->
        <div id="page-loader"></div>
        <!-- Page Container -->
        <div id="page-container" class="sidebar-o side-scroll page-header-modern main-content-boxed enable-page-overlay">
            <!-- Side Overlay-->
            @include('components.side-overlay')
            <!-- END Side Overlay -->

            <!-- Sidebar -->
            @include('components.nav-sidebar')
            <!-- END Sidebar -->

            <!-- Header -->
            @include('components.header')
            <!-- END Header -->

            <!-- Main Container -->
            <main id="main-container">
                <!-- Page Content -->
                @yield('content')
                <!-- END Page Content -->
            </main>
            <!-- END Main Container -->

            <!-- Footer -->
            @include('components.footer')
            <!-- END Footer -->
        </div>
        <!-- END Page Container -->

        <!-- Codebase JS -->
        <script src="{{ asset('assets/js/codebase.core.min.js') }}"></script>
        <script src="{{ asset('assets/js/codebase.app.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
        <script>jQuery(function(){ Codebase.helpers('notify'); });</script>
        @stack('js_after')
    </body>
</html>
