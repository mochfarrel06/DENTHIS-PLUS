<header id="header" class="header fixed-top">
    <!-- Start Top Bar -->
    <div class="topbar d-flex align-items-center">
        <div class="container d-flex justify-content-center justify-content-md-between">
            <div class="contact-info d-flex align-items-center">
                <i class="bi bi-envelope d-flex align-items-center"><a href="">denthis@gmail.com</a></i>
                <i class="bi bi-phone d-flex align-items-center ms-4"><span>+62 858503750132</span></i>
            </div>
            <div class="social-links d-none d-md-flex align-items-center">
                <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
            </div>
        </div>
    </div>
    <!-- End Top Bar -->

    <!-- Start Navbar -->
    <div class="branding d-flex align-items-center">
        <div class="container position-relative d-flex align-items-center justify-content-between">
            <a href="{{ route('home') }}" class="logo d-flex align-items-center">
                <h1 class="sitename">DENTHIS.PLUS</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li>
                        <a href="{{ route('home') }}"
                            class="{{ request()->routeIs('home') ? 'active' : '' }}">Home<br /></a>
                    </li>
                    <li><a href="{{ route('index-dokter') }}"
                            class="{{ request()->routeIs('index-dokter') ? 'active' : '' }}">Dokter</a></li>
                    <li><a href="{{ route('index-tentangKami') }}"
                            class="{{ request()->routeIs('index-tentangKami') ? 'active' : '' }}">Tentang Kami</a></li>
                    <li><a href="{{ route('login') }}" class="btn-login">Login</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>
        </div>
    </div>
    <!-- End Navbar -->
</header>
