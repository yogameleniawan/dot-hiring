<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.layouts.head')
</head>

<body>
    <div id="app">
        <div id="sidebar" class="active">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header">
                    <div class="d-flex justify-content-between">
                        <div>
                            <a href=""><img src="{{ url('assets/images/logo.png') }}" alt="Logo" style="width: 80%;height: 100%;"></a>
                        </div>
                        <div class="toggler">
                            <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="sidebar-item {{ Route::is('categories.*') ? 'active' : '' }}">
                            <a href="{{ route('categories.index') }}" class='sidebar-link'>
                                <i class="bi bi-grid-fill"></i>
                                <span>Categories</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ Route::is('news.*') ? 'active' : '' }}">
                            <a href="{{ route('news.index') }}" class='sidebar-link'>
                                <i class="bi bi-person-fill"></i>
                                <span>News</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
            </div>
        </div>
        <div id="main">
            <header class='mb-3'>
                <nav class="navbar navbar-expand navbar-light ">
                    <div class="container-fluid">
                        <a href="#" class="burger-btn d-block">
                            <i class="bi bi-justify fs-3"></i>
                        </a>

                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">

                            </ul>
                            <div class="dropdown">
                                <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="user-menu d-flex">
                                        <div class="user-img d-flex align-items-center">
                                            <div class="avatar avatar-md">
                                                <img
                                                    src="{{ Auth::user() != null && Auth::user()->profile_photo_path != null? url(Auth::user()->profile_photo_path): url('mazer/assets/images/faces/1.jpg') }}">
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                    <li>
                                        <h6 class="dropdown-header">Hello,
                                            {{ Auth::user()->email != null ? Auth::user()->email : 'email' }}!
                                        </h6>
                                    </li>
                                    <hr class="dropdown-divider">

                                    <li><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();" role="button">
                                            <i class="icon-mid bi bi-box-arrow-left me-2"></i>

                                            {{ __('Sign Out') }}
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
            </header>

            <div class="page-heading">
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-md-6 order-md-1 order-last">
                            <h3>@yield('title_table')</h3>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    @yield('breadcumb')
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <section class="section">
                    @yield('content')
                </section>
            </div>

            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p>2022 &copy; Copyright</p>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    @include('admin.layouts.script')
</body>

</html>
