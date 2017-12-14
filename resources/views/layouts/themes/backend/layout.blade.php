<!--
 * CoreUI - Open Source Bootstrap Admin Template
 * @version v1.0.0-alpha.6
 * @link http://coreui.io
 * Copyright (c) 2017 creativeLabs Łukasz Holeczek
 * @license MIT
 -->
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
    <meta name="author" content="Wondo Choung">
    <meta name="keyword" content="">
    <link rel="shortcut icon" href="img/favicon.png">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>dolodol - Admin Page</title>

    <!-- Icons -->
    {{-- <link rel="stylesheet" type="text/css" href="{{ mix('/css/app.css') }}"> --}}

    <link rel="stylesheet" type="text/css" href="{{ mix('/css/themes/coreui/style.css') }}">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css">
    <link rel="stylesheet" type="text/css" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <!-- Main styles for this application -->
    
    <link rel="stylesheet" type="text/css" href="{{ mix('/css/views/admins/general.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.standalone.min.css">
    @yield('styles')
</head>

<!-- BODY options, add following classes to body to change options

// Header options
1. '.header-fixed'                  - Fixed Header

// Sidebar options
1. '.sidebar-fixed'                 - Fixed Sidebar
2. '.sidebar-hidden'                - Hidden Sidebar
3. '.sidebar-off-canvas'        - Off Canvas Sidebar
4. '.sidebar-minimized'         - Minimized Sidebar (Only icons)
5. '.sidebar-compact'             - Compact Sidebar

// Aside options
1. '.aside-menu-fixed'          - Fixed Aside Menu
2. '.aside-menu-hidden'         - Hidden Aside Menu
3. '.aside-menu-off-canvas' - Off Canvas Aside Menu

// Footer options
1. '.footer-fixed'                      - Fixed footer

-->

<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">
    <header class="app-header navbar">
        @include('layouts.themes.backend.partials.nav')
    </header>

    <div class="app-body" >
        @include('layouts.themes.backend.partials.sidebar')

        <!-- Main content -->
        <main id="root" class="main">
            @include('flash::message')
            @yield('content')
            @yield('modals')
        </main>

        <aside id="aside-root" class="aside-menu" data="{{ json_encode($contact_get) }}" >
            @include('layouts.themes.backend.partials.aside')
        </aside>
        <!-- Modals -->
        
    </div>
    @yield('variables')
    <!-- Footer -->
    <footer class="app-footer">
        @include('layouts.themes.backend.partials.footer')    
    </footer>

    <!-- Bootstrap and necessary plugins -->
    <!--   Core JS Files   -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script type="text/javascript" src="{{ mix('/js/backend.js') }}"></script>
    
    <script type="text/javascript" src="{{ mix('/js/themes/coreui/pace.min.js') }}"></script>
    
    <!-- Custom scripts required by this view -->
    <script type="text/javascript" src="{{ mix('/js/views/admins/general.js') }}"></script>
    
    <!-- Page specific scripts -->
    <script type="text/javascript" src="{{ mix('/js/themes/coreui/coreui.js') }}"></script>
    <!-- Bootstrap Datepicker -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js"></script>
    @yield('scripts')
    
    
    
</body>

</html>
