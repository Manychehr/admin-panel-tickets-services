<nav id="sidebar">
    <!-- Sidebar Content -->
    <div class="sidebar-content">
        <!-- Side Header -->
        <div class="content-header content-header-fullrow px-15">
            <!-- Mini Mode -->
            <div class="content-header-section sidebar-mini-visible-b">
                <!-- Logo -->
                <span class="content-header-item font-w700 font-size-xl float-left animated fadeIn">
                    <span class="text-dual-primary-dark">t</span><span class="text-primary">m</span>
                </span>
                <!-- END Logo -->
            </div>
            <!-- END Mini Mode -->

            <!-- Normal Mode -->
            <div class="content-header-section text-center align-parent sidebar-mini-hidden">
                <!-- Close Sidebar, Visible only on mobile screens -->
                <!-- Layout API, functionality initialized in Codebase() -> uiApiLayout() -->
                <button type="button" class="btn btn-circle btn-dual-secondary d-lg-none align-v-r" data-toggle="layout" data-action="sidebar_close">
                    <i class="fa fa-times text-danger"></i>
                </button>
                <!-- END Close Sidebar -->

                <!-- Logo -->
                <div class="content-header-item">
                    <a class="link-effect font-w700" href="">
                        <i class="si si-fire text-primary"></i>
                        <span class="font-size-xl text-dual-primary-dark">ticket</span><span class="font-size-xl text-primary">men</span>
                    </a>
                </div>
                <!-- END Logo -->
            </div>
            <!-- END Normal Mode -->
        </div>
        <!-- END Side Header -->

        <!-- Side Navigation -->
        <div class="content-side content-side-full">
            <ul class="nav-main">
                <li>
                    <a class="@if (Route::currentRouteName() === 'home') active @endif" href="{{ route('home') }}">
                        <i class="si si-list"></i>
                        <span class="sidebar-mini-hide">Home</span>
                    </a>
                </li>
                <li>
                    <a class="@if (Route::currentRouteName() === 'domains.index') active @endif" href="{{ route('domains.index') }}">
                        <i class="fa fa-internet-explorer"></i>
                        <span class="sidebar-mini-hide">Hosts</span>
                    </a>
                </li> 
                <li>
                    <a class="@if (Route::currentRouteName() === 'export.index') active @endif" href="{{ route('export.index') }}">
                        <i class="fa fa-upload"></i>
                        <span class="sidebar-mini-hide">Export</span>
                    </a>
                </li>
                <li>
                    <a class="@if (Route::currentRouteName() === 'api_tickets.index') active @endif" href="{{ route('api_tickets.index') }}">
                        <i class="fa fa-gears"></i>
                        <span class="sidebar-mini-hide">Api Details</span>
                    </a>
                </li>
                
            </ul>
        </div>
        <!-- END Side Navigation -->
    </div>
    <!-- Sidebar Content -->
</nav>