<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="CAMS">
    <meta name="robots" content="index, follow">
    <meta name="keywords" content="{{ config('app.name', 'Laravel') }}">
    <meta name="description" content="">

    <title>@yield('title', '') | Admin | {{ config('app.name', 'Laravel') }}</title>
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">-->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicon-16x16.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="48x48" href="{{ asset('img/favicon-48x48.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/apple-touch-icon.png') }}">
    <meta property="og:image" content="{{ asset('img/logo.png') }}">
    <meta property="og:site_name" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Custom fonts for this template -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

    @stack('style')
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- =====================================================
            SIDEBAR
        ====================================================== -->

        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar"
            style="background: #1d1639;">


            <!-- =================================================
                SIDEBAR BRAND
            ================================================== -->

            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.home') }}">

                <div class="sidebar-brand-text mx-3">

                    <img src="{{ asset('img/logo.png') }}"
                        style="
                            width: 143px;
                            height: 46px;
                            margin-left: 26px;
                            margin-top: 12px;
                        ">

                </div>

            </a>


            <!-- =================================================
                DIVIDER
            ================================================== -->

            <hr class="sidebar-divider my-0">


            <!-- =================================================
                DASHBOARD
            ================================================== -->

            <li class="nav-item {{ request()->is('admin') ? 'active' : '' }}">

                <a class="nav-link" href="{{ route('admin.home') }}">

                    <i class="fas fa-fw fa-tachometer-alt"></i>

                    <span>
                        Dashboard
                    </span>

                </a>

            </li>


            <!-- =================================================
                DIVIDER
            ================================================== -->

            <hr class="sidebar-divider">


            <!-- =========================================================
                HOME VARIABLES
            ========================================================== -->

            @php

                /*
                |--------------------------------------------------------------------------
                | Home Service Lines
                |--------------------------------------------------------------------------
                */

                $homeServiceLinesOpen =
                    request()->is('admin/service-lines/1*') || request()->is('admin/service-lines-intro/1*');

                /*
                |--------------------------------------------------------------------------
                | Home Operating Model
                |--------------------------------------------------------------------------
                */

                $homeOperatingModelOpen =
                    request()->is('admin/operating-models/1*') || request()->is('admin/operating-model-intro/1*');

                /*
                    |--------------------------------------------------------------------------
                    | Home Connected Journey
                    |--------------------------------------------------------------------------
                    */

                $homeConnectedJourneyOpen = request()->is('admin/connected-journeys/1*');

                /*
                |--------------------------------------------------------------------------
                | Home Proof Points
                |--------------------------------------------------------------------------
                */

                $proofPointsOpen = request()->is('admin/proof-points/1*');

                /*
                |--------------------------------------------------------------------------
                | Home Testimonials
                |--------------------------------------------------------------------------
                */

                $testimonialsOpen = request()->is('admin/testimonials/1*');

                /*
                |--------------------------------------------------------------------------
                | Home partners
                |--------------------------------------------------------------------------
                */

                $partnersOpen = request()->is('admin/partners*');

                /*
                    |--------------------------------------------------------------------------
                    | Home Parent
                    |--------------------------------------------------------------------------
                    */

                $homeMenuOpen =
                    request()->is('admin/home-about*') ||
                    request()->is('admin/home-why-ziproh*') ||
                    $homeServiceLinesOpen ||
                    $homeOperatingModelOpen ||
                    $homeConnectedJourneyOpen ||
                    $proofPointsOpen ||
                    $testimonialsOpen ||
                    $partnersOpen;

            @endphp


            <!-- =========================================================
                HOME
            ========================================================== -->

            <li class="nav-item {{ $homeMenuOpen ? 'active' : '' }}">


                <a class="nav-link {{ $homeMenuOpen ? '' : 'collapsed' }}" href="#" data-toggle="collapse"
                    data-target="#collapseHome" aria-expanded="{{ $homeMenuOpen ? 'true' : 'false' }}"
                    aria-controls="collapseHome">

                    <i class="fas fa-fw fa-home"></i>

                    <span>
                        Home
                    </span>

                </a>


                <div id="collapseHome" class="collapse {{ $homeMenuOpen ? 'show' : '' }}" aria-labelledby="headingHome"
                    data-parent="#accordionSidebar">


                    <div class="bg-white py-2 collapse-inner rounded">


                        <h6 class="collapse-header">
                            Home:
                        </h6>


                        <!-- =================================================
                            ABOUT ZIPROH
                        ================================================== -->

                        <a class="collapse-item {{ request()->is('admin/home-about*') ? 'active' : '' }}"
                            href="{{ route('admin.home-about.edit') }}">

                            <i class="fas fa-fw fa-info-circle mr-2"></i>

                            About ZIPROH

                        </a>


                        <!-- =================================================
                            WHY ZIPROH
                        ================================================== -->

                        <a class="collapse-item {{ request()->is('admin/home-why-ziproh*') ? 'active' : '' }}"
                            href="{{ route('admin.home-why-ziproh.index') }}">

                            <i class="fas fa-fw fa-question-circle mr-2"></i>

                            Why ZIPROH

                        </a>


                        <!-- =================================================
                            HOME SERVICE LINES
                        ================================================== -->

                        <a class="collapse-item {{ $homeServiceLinesOpen ? 'active' : 'collapsed' }}" href="#"
                            data-toggle="collapse" data-target="#collapseHomeServiceLines"
                            aria-expanded="{{ $homeServiceLinesOpen ? 'true' : 'false' }}"
                            aria-controls="collapseHomeServiceLines">

                            <i class="fas fa-fw fa-list mr-2"></i>

                            Service Lines

                        </a>


                        <div id="collapseHomeServiceLines"
                            class="collapse ml-3 {{ $homeServiceLinesOpen ? 'show' : '' }}">


                            <div class="bg-light py-2 collapse-inner rounded">


                                <!-- Service Lines Intro -->

                                <a class="collapse-item {{ request()->is('admin/service-lines-intro/1*') ? 'active' : '' }}"
                                    href="{{ route('admin.service-lines-intro.edit', ['type' => 1]) }}">

                                    <i class="fas fa-edit mr-2"></i>

                                    Service Lines Intro

                                </a>


                                <!-- Service Lines -->

                                <a class="collapse-item {{ request()->is('admin/service-lines/1*') ? 'active' : '' }}"
                                    href="{{ route('admin.service-lines.index', ['type' => 1]) }}">

                                    <i class="fas fa-list mr-2"></i>

                                    Service Lines

                                </a>


                            </div>

                        </div>


                        <!-- =================================================
                            HOME OPERATING MODEL
                        ================================================== -->

                        <a class="collapse-item {{ $homeOperatingModelOpen ? 'active' : 'collapsed' }}" href="#"
                            data-toggle="collapse" data-target="#collapseHomeOperatingModel"
                            aria-expanded="{{ $homeOperatingModelOpen ? 'true' : 'false' }}"
                            aria-controls="collapseHomeOperatingModel">

                            <i class="fas fa-fw fa-cogs mr-2"></i>

                            Operating Model

                        </a>


                        <div id="collapseHomeOperatingModel"
                            class="collapse ml-3 {{ $homeOperatingModelOpen ? 'show' : '' }}">


                            <div class="bg-light py-2 collapse-inner rounded">

                                <!-- Operating Model Intro -->

                                <a class="collapse-item {{ request()->is('admin/operating-model-intro/1*') ? 'active' : '' }}"
                                    href="{{ route('admin.operating-model-intro.edit', ['type' => 1]) }}">

                                    <i class="fas fa-edit mr-2"></i>

                                    Operating Model Intro

                                </a>

                                <!-- Operating Model -->

                                <a class="collapse-item {{ request()->is('admin/operating-models/1*') ? 'active' : '' }}"
                                    href="{{ route('admin.operating-models.index', ['type' => 1]) }}">

                                    <i class="fas fa-list mr-2"></i>

                                    Operating Model

                                </a>





                            </div>

                        </div>

                        <!-- =================================================
                            HOME CONNECTED JOURNEY
                        ================================================== -->

                        <a class="collapse-item {{ request()->is('admin/connected-journeys/1*') ? 'active' : '' }}"
                            href="{{ route('admin.connected-journeys.index', ['type' => 1]) }}">
                            <i class="fas fa-list mr-2"></i>
                            Connected Journey
                        </a>

                        <!-- =================================================
                            HOME PROOF POINTS
                        ================================================== -->
                        <a class="collapse-item {{ $proofPointsOpen ? 'active' : '' }}"
                            href="{{ route('admin.proof-points.index', ['type' => 1]) }}">
                            <i class="fas fa-fw fa-award mr-2"></i>
                            Proof Points
                        </a>

                        <!-- =================================================
                            HOME TESTIMONIALS
                        ================================================== -->

                        <a class="collapse-item {{ $testimonialsOpen ? 'active' : '' }}"
                            href="{{ route('admin.testimonials.index', ['type' => 1]) }}">

                            <i class="fas fa-fw fa-comments mr-2"></i>

                            Testimonials

                        </a>

                        <!-- =================================================
                            HOME PARTNERS
                        ================================================== -->

                        <a class="collapse-item {{ $partnersOpen ? 'active' : '' }}"
                            href="{{ route('admin.partners.index') }}">

                            <i class="fas fa-fw fa-handshake mr-2"></i>

                            Partners

                        </a>

                    </div>

                </div>

            </li>


            <!-- =========================================================
                MENU
            ========================================================== -->

            <li class="nav-item {{ request()->is('admin/navigations*') ? 'active' : '' }}">

                <a class="nav-link" href="{{ route('admin.navigations.index') }}">

                    <i class="fas fa-fw fa-bars"></i>

                    <span>
                        Menu
                    </span>

                </a>

            </li>


            <!-- =========================================================
                BANNERS VARIABLES
            ========================================================== -->

            @php

                $bannerMenuOpen = request()->is('admin/banners/1*') || request()->is('admin/banners/2*');

            @endphp


            <!-- =========================================================
                BANNERS
            ========================================================== -->

            <li class="nav-item {{ $bannerMenuOpen ? 'active' : '' }}">


                <a class="nav-link {{ $bannerMenuOpen ? '' : 'collapsed' }}" href="#" data-toggle="collapse"
                    data-target="#collapseBanner" aria-expanded="{{ $bannerMenuOpen ? 'true' : 'false' }}"
                    aria-controls="collapseBanner">

                    <i class="fas fa-fw fa-images"></i>

                    <span>
                        Banners
                    </span>

                </a>


                <div id="collapseBanner" class="collapse {{ $bannerMenuOpen ? 'show' : '' }}"
                    aria-labelledby="headingBanner" data-parent="#accordionSidebar">


                    <div class="bg-white py-2 collapse-inner rounded">


                        <h6 class="collapse-header">
                            Banner Management:
                        </h6>


                        <!-- =================================================
                            HOME BANNER
                        ================================================== -->

                        <a class="collapse-item {{ request()->is('admin/banners/1*') ? 'active' : '' }}"
                            href="{{ route('admin.banners.index', ['type' => 1]) }}">

                            <i class="fas fa-home mr-2"></i>

                            Home Banner

                        </a>


                        <!-- =================================================
                            PAGE BANNERS
                        ================================================== -->

                        <a class="collapse-item {{ request()->is('admin/banners/2*') ? 'active' : '' }}"
                            href="{{ route('admin.banners.index', ['type' => 2]) }}">

                            <i class="fas fa-file-alt mr-2"></i>

                            Page Banners

                        </a>


                    </div>

                </div>

            </li>


            <!-- =========================================================
                SERVICE LINES TYPE 2
            ========================================================== -->

            @php

                $serviceLinesMenuOpen =
                    request()->is('admin/service-lines/2*') || request()->is('admin/service-lines-intro/2*');

            @endphp


            <li class="nav-item {{ $serviceLinesMenuOpen ? 'active' : '' }}">


                <a class="nav-link {{ $serviceLinesMenuOpen ? '' : 'collapsed' }}" href="#"
                    data-toggle="collapse" data-target="#collapseServiceLines"
                    aria-expanded="{{ $serviceLinesMenuOpen ? 'true' : 'false' }}"
                    aria-controls="collapseServiceLines">

                    <i class="fas fa-fw fa-list"></i>

                    <span>
                        Service Lines
                    </span>

                </a>


                <div id="collapseServiceLines" class="collapse {{ $serviceLinesMenuOpen ? 'show' : '' }}"
                    aria-labelledby="headingServiceLines" data-parent="#accordionSidebar">


                    <div class="bg-white py-2 collapse-inner rounded">


                        <h6 class="collapse-header">
                            Service Lines:
                        </h6>


                        <!-- =================================================
                            SERVICE LINES INTRO
                        ================================================== -->

                        <a class="collapse-item {{ request()->is('admin/service-lines-intro/2*') ? 'active' : '' }}"
                            href="{{ route('admin.service-lines-intro.edit', ['type' => 2]) }}">

                            <i class="fas fa-edit mr-2"></i>

                            Service Lines Intro

                        </a>


                        <!-- =================================================
                            SERVICE LINES
                        ================================================== -->

                        <a class="collapse-item {{ request()->is('admin/service-lines/2*') ? 'active' : '' }}"
                            href="{{ route('admin.service-lines.index', ['type' => 2]) }}">

                            <i class="fas fa-list mr-2"></i>

                            Service Lines

                        </a>


                    </div>

                </div>

            </li>


            <!-- =========================================================
                DISC VARIABLES
            ========================================================== -->

            @php

                /*
                |--------------------------------------------------------------------------
                | DISC Operating Model
                |--------------------------------------------------------------------------
                */

                $discOperatingModelOpen =
                    request()->is('admin/operating-models/2*') || request()->is('admin/operating-model-intro/2*');

                /*
                |--------------------------------------------------------------------------
                | DISC Parent
                |--------------------------------------------------------------------------
                */

                $discMenuOpen = $discOperatingModelOpen;

            @endphp


            <!-- =========================================================
                DISC™
            ========================================================== -->

            <li class="nav-item {{ $discMenuOpen ? 'active' : '' }}">


                <a class="nav-link {{ $discMenuOpen ? '' : 'collapsed' }}" href="#" data-toggle="collapse"
                    data-target="#collapseDisc" aria-expanded="{{ $discMenuOpen ? 'true' : 'false' }}"
                    aria-controls="collapseDisc">

                    <i class="fas fa-fw fa-project-diagram"></i>

                    <span>
                        DISC™
                    </span>

                </a>


                <div id="collapseDisc" class="collapse {{ $discMenuOpen ? 'show' : '' }}"
                    aria-labelledby="headingDisc" data-parent="#accordionSidebar">


                    <div class="bg-white py-2 collapse-inner rounded">

                        {{--
                        <h6 class="collapse-header">
                            DISC™:
                        </h6>  --}}


                        <!-- =================================================
                            DISC OPERATING MODEL
                        ================================================== -->

                        <a class="collapse-item {{ $discOperatingModelOpen ? 'active' : 'collapsed' }}"
                            href="#" data-toggle="collapse" data-target="#collapseDiscOperatingModel"
                            aria-expanded="{{ $discOperatingModelOpen ? 'true' : 'false' }}"
                            aria-controls="collapseDiscOperatingModel">

                            <i class="fas fa-fw fa-cogs mr-2"></i>

                            DISC™:

                        </a>


                        <div id="collapseDiscOperatingModel"
                            class="collapse ml-3 {{ $discOperatingModelOpen ? 'show' : '' }}">


                            <div class="bg-light py-2 collapse-inner rounded">

                                <!-- Operating Model Intro -->

                                <a class="collapse-item {{ request()->is('admin/operating-model-intro/2*') ? 'active' : '' }}"
                                    href="{{ route('admin.operating-model-intro.edit', ['type' => 2]) }}">

                                    <i class="fas fa-edit mr-2"></i>

                                    Intro

                                </a>


                                <!-- Operating Model -->

                                <a class="collapse-item {{ request()->is('admin/operating-models/2*') ? 'active' : '' }}"
                                    href="{{ route('admin.operating-models.index', ['type' => 2]) }}">

                                    <i class="fas fa-list mr-2"></i>

                                    Four Stages

                                </a>





                            </div>

                        </div>

                        @php
                            $discConnectedJourneyOpen = request()->is('admin/connected-journeys/2*');
                        @endphp

                        <a class="collapse-item {{ $discConnectedJourneyOpen ? 'active' : 'collapsed' }}"
                            href="#" data-toggle="collapse" data-target="#collapseDiscConnectedJourney"
                            aria-expanded="{{ $discConnectedJourneyOpen ? 'true' : 'false' }}"
                            aria-controls="collapseDiscConnectedJourney">
                            <i class="fas fa-fw fa-route mr-2"></i>
                            Connected Journey
                        </a>

                        <div id="collapseDiscConnectedJourney"
                            class="collapse ml-3 {{ $discConnectedJourneyOpen ? 'show' : '' }}">
                            <div class="bg-light py-2 collapse-inner rounded">

                                <a class="collapse-item {{ request()->is('admin/connected-journeys/2*') ? 'active' : '' }}"
                                    href="{{ route('admin.connected-journeys.index', ['type' => 2]) }}">
                                    <i class="fas fa-list mr-2"></i>
                                    Connected Journey
                                </a>

                            </div>
                        </div>




                    </div>

                </div>

            </li>


            {{-- About ZIPROH Menu --}}
            @php
                $aboutMenuOpen =
                    request()->is('admin/about-page-contents*') ||
                    request()->is('admin/core-values*') ||
                    request()->is('admin/what-we-bring*') ||
                    request()->is('admin/way-of-working*');
            @endphp

            <li class="nav-item {{ $aboutMenuOpen ? 'active' : '' }}">

                <a class="nav-link {{ $aboutMenuOpen ? '' : 'collapsed' }}" href="#" data-toggle="collapse"
                    data-target="#collapseAboutZiproh" aria-expanded="{{ $aboutMenuOpen ? 'true' : 'false' }}"
                    aria-controls="collapseAboutZiproh">

                    <i class="fas fa-fw fa-info-circle"></i>

                    <span>About ZIPROH</span>

                </a>

                <div id="collapseAboutZiproh" class="collapse {{ $aboutMenuOpen ? 'show' : '' }}"
                    aria-labelledby="headingAboutZiproh" data-parent="#accordionSidebar">

                    <div class="bg-white py-2 collapse-inner rounded">

                        <h6 class="collapse-header">
                            About Sections:
                        </h6>


                        {{-- About Introduction --}}
                        <a class="collapse-item
                {{ request()->is('admin/about-page-contents*') ? 'active' : '' }}"
                            href="{{ route('admin.about-page-contents.index') }}">

                            About Introduction

                        </a>


                        {{-- Core Values --}}
                        <a class="collapse-item {{ request()->is('admin/core-values*') ? 'active' : '' }}"
                            href="{{ route('admin.core-values.index') }}">

                            Core Values

                        </a>


                        {{-- What We Bring --}}
                        <a class="collapse-item {{ request()->is('admin/what-we-bring*') ? 'active' : '' }}"
                            href="{{ route('admin.what-we-bring.index') }}">

                            What We Bring

                        </a>


                        {{-- Way of Working --}}
                        <a class="collapse-item {{ request()->is('admin/way-of-working*') ? 'active' : '' }}"
                            href="{{ route('admin.way-of-working.index') }}">

                            Way of Working

                        </a>

                    </div>

                </div>

            </li>




            <!-- =========================================================
                DIVIDER
            ========================================================== -->

            <hr class="sidebar-divider">


            <!-- =========================================================
                SIDEBAR TOGGLER
            ========================================================== -->

            <div class="text-center d-none d-md-inline">

                <button class="rounded-circle border-0" id="sidebarToggle">
                </button>

            </div>


        </ul>


        <!-- =========================================================
            END SIDEBAR
        ========================================================== -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <form class="form-inline">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fas fa-bars"></i>
                        </button>
                    </form>


                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span
                                    class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                                <img class="img-profile rounded-circle" src="{{ asset('img/undraw_profile.svg') }}">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#" data-toggle="modal"
                                    data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                @yield('content')
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>© {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All Rights Reserved.</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Are you sure you want to logout?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="#"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>

                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>

                </div>
            </div>
        </div>
    </div>

    @stack('modal')

    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>-->
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>-->
    <!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>-->

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

    @stack('script')

</body>

</html>
