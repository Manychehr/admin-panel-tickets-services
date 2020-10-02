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

        <!-- Side User -->
        {{-- <div class="content-side content-side-full content-side-user px-10 align-parent">
            <!-- Visible only in mini mode -->
            <div class="sidebar-mini-visible-b align-v animated fadeIn">
                <img class="img-avatar img-avatar32" src="assets/media/avatars/avatar0.jpg" alt="">
            </div>
            <!-- END Visible only in mini mode -->

            <!-- Visible only in normal mode -->
            <div class="sidebar-mini-hidden-b text-center">
                <a class="img-link" href="">
                    <img class="img-avatar" src="assets/media/avatars/avatar0.jpg" alt="">
                </a>
                <ul class="list-inline mt-10">
                    <li class="list-inline-item">
                        <a class="link-effect text-dual-primary-dark font-size-sm font-w600 text-uppercase" href="">J. Smith</a>
                    </li>
                    <li class="list-inline-item">
                        <!-- Layout API, functionality initialized in Codebase() -> uiApiLayout() -->
                        <a class="link-effect text-dual-primary-dark" data-toggle="layout" data-action="sidebar_style_inverse_toggle" href="javascript:void(0)">
                            <i class="si si-drop"></i>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a class="link-effect text-dual-primary-dark" href="">
                            <i class="si si-logout"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- END Visible only in normal mode -->
        </div> --}}
        <!-- END Side User -->

        <!-- Side Navigation -->
        <div class="content-side content-side-full">
            <ul class="nav-main">
                {{-- <li>
                    <a class="@if (Route::currentRouteName() === 'home') active @endif" href="{{ route('home') }}">
                        <i class="si si-list"></i>
                        <span class="sidebar-mini-hide">Home</span>
                    </a>
                </li>
                <li>
                    <a class="@if (Route::currentRouteName() === 'import.index') active @endif" href="{{ route('import.index') }}">
                        <i class="fa fa-download"></i>
                        <span class="sidebar-mini-hide">Import</span>
                    </a>
                </li>
                <li>
                    <a class="@if (Route::currentRouteName() === 'export.index') active @endif" href="{{ route('export.index') }}">
                        <i class="fa fa-upload"></i>
                        <span class="sidebar-mini-hide">Export</span>
                    </a>
                </li>
                <li>
                    <a class="@if (Route::currentRouteName() === 'blacklist.index') active @endif" href="{{ route('blacklist.index') }}">
                        <i class="fa fa-list-ul"></i>
                        <span class="sidebar-mini-hide">Blacklist</span>
                    </a>
                </li> --}}
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