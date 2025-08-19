

<!--begin::Header-->
    <div id="kt_app_header" class="app-header d-flex" style="border-bottom: 1px solid #d1d5db;"
>
        <!--begin::Header container-->
        <div class="app-container container-fluid d-flex align-items-center justify-content-between" id="kt_app_header_container">
            <!--begin::Logo-->
            <div class="app-header-logo d-flex flex-center">
                <!--begin::Logo image-->
                <a href="index.html">
                    <img alt="Logo" src="{{ asset('assets/media/logos/demo-58.svg') }}" class="mh-25px" />
                </a>
                <!--end::Logo image-->

                <!--begin::Sidebar toggle-->
                <button class="btn btn-icon btn-sm btn-active-color-primary d-flex d-lg-none" id="kt_app_sidebar_mobile_toggle">
                    <i class="ki-outline ki-abstract-14 fs-1"></i>
                </button>
                <!--end::Sidebar toggle-->
                
            </div>
            <!--end::Logo-->
            <div class="d-flex flex-lg-grow-1 flex-stack" id="kt_app_header_wrapper">
                
                <div class="app-header-wrapper d-flex align-items-center justify-content-around justify-content-lg-between flex-wrap gap-6 gap-lg-0 mb-6 mb-lg-0" data-kt-swapper="true" data-kt-swapper-mode="{default: 'prepend', lg: 'prepend'}" data-kt-swapper-parent="{default: '#kt_app_content_container', lg: '#kt_app_header_wrapper'}">
                    <!--begin::Page title-->
                    <div class="d-flex flex-column justify-content-center">
                        <!--begin::Title-->
                        <h1 class="text-gray-900 fw-bold fs-6 mb-2">@yield('title')</h1>
                        <!--end::Title-->
                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-base">
                            <!--begin::Item-->
                            <li class="breadcrumb-item text-muted">
                                <a href="#" class="text-muted text-hover-primary">Home</a>
                            </li>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <li class="breadcrumb-item text-muted">/</li>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <li class="breadcrumb-item text-muted">@yield('subtitle')</li>
                            <!--end::Item-->
                        </ul>
                        <!--end::Breadcrumb-->
                    </div>
                    <!--end::Page title-->
                    <div class="d-none d-md-block h-40px border-start border-gray-200 mx-10"></div>
                </div>
                <!--begin::Navbar-->

                <div class="app-navbar flex-shrink-0 gap-2 gap-lg-4">
                   
                    <!--begin::Notifications-->
                    <div class="app-navbar-item">
                        <!--begin::Menu- wrapper-->
                        <div class="btn btn-icon border border-200 bg-gray-100 btn-color-gray-600 btn-active-color-primary w-40px h-40px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end" id="kt_menu_item_wow">
                            <i class="ki-outline ki-notification-status fs-4"></i>
                        </div>
                        <!--begin::Menu-->
                        <div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-375px" data-kt-menu="true" id="kt_menu_notifications">
                            <!--begin::Heading-->
                            <div class="d-flex flex-column bgi-no-repeat rounded-top" style="background-image:url('assets/media/misc/menu-header-bg.jpg')">
                                <!--begin::Title-->
                                <h3 class="text-white fw-semibold px-9 mt-10 mb-6">Notifications 
                                <span class="fs-8 opacity-75 ps-3">24 reports</span></h3>
                                <!--end::Title-->
                                <!--begin::Tabs-->
                                <ul class="nav nav-line-tabs nav-line-tabs-2x nav-stretch fw-semibold px-9">
                                    <li class="nav-item">
                                        <a class="nav-link text-white opacity-75 opacity-state-100 pb-4" data-bs-toggle="tab" href="#kt_topbar_notifications_1">Alerts</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-white opacity-75 opacity-state-100 pb-4 active" data-bs-toggle="tab" href="#kt_topbar_notifications_2">Updates</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-white opacity-75 opacity-state-100 pb-4" data-bs-toggle="tab" href="#kt_topbar_notifications_3">Logs</a>
                                    </li>
                                </ul>
                                <!--end::Tabs-->
                            </div>
                            <!--end::Heading-->
                            <!--begin::Tab content-->
                            <div class="tab-content">
                   
                            </div>
                            <!--end::Tab content-->
                        </div>
                        <!--end::Menu-->
                        <!--end::Menu wrapper-->
                    </div>
                    <!--end::Notifications-->
                    
                    <!--begin::User menu-->
                    <div class="app-navbar-item" id="kt_header_user_menu_toggle">
                        <!--begin::Menu wrapper-->
                        <div class="cursor-pointer symbol symbol-40px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                            <img src="{{ asset('assets/media/avatars/300-2.jpg') }}" class="rounded-3" alt="user" />
                        </div>
                        <!--begin::User account menu-->
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
                            
                            <!-- User Profile -->
                            <div class="d-flex align-items-center px-5">
                                <div class="symbol symbol-50px me-4">
                                    <img src="{{ asset('assets/media/avatars/300-2.jpg') }}" class="rounded-circle shadow" alt="user" />
                                </div>
                                <div class="d-flex flex-column">
                                    <span class="fw-bold text-gray-900 fs-5">
                                        {{ strtoupper(auth()->user()->fullname) }}
                                    </span>
                    
                                    <span class="text-muted fs-8">
                                        {{ auth()->user()->department->dept_name ?? 'Department' }}
                                    </span>
                                </div>
                            </div>

                            <div class="separator my-3"></div>
                            
                            <!--begin:: SIGN OUT-->
                            <div class="menu-item px-5">
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>

                                <a href="#" class="menu-link px-5" 
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Sign Out
                                </a>
                            </div>
                            <!--end:: SIGN OUT-->

                        </div>
                        <!--end::User account menu-->
                        <!--end::Menu wrapper-->
                    </div>
                    <!--end::User menu-->
                </div>
                <!--end::Navbar-->
            </div>
        </div>
        <!--end::Header container-->
    </div>
<!--end::Header-->