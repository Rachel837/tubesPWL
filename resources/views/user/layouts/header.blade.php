<div class="header-area ">
    <div id="sticky-header" class="main-header-area">
        <div class="container">
            <div class="header_bottom_border" style="border-bottom: 2px solid rgba(255, 255, 255, 0.2);">
                <div class="row align-items-center">
                    <div class="col-xl-3 col-lg-3">
                        <div class="logo">
                            <a href="{{ route('landing') }}">
                                <img src="{{ asset('assets/img/logo.png') }}" alt="Logo">
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6">
                        <div class="main-menu d-none d-lg-block">
                            <nav>
                                <ul id="navigation">
                                    <li><a href="{{ route('landing') }}">Home</a></li>
                                    <li><a href="{{ route('user.home') }}">Events</a></li>
                                    @auth
                                    <li><a href="{{ route('user.history') }}">Riwayat</a></li>
                                    <li><a href="{{ route('user.waiting_list') }}">Waiting List</a></li>
                                    
                                    <li><a href="#">Profil <i class="ti-angle-down"></i></a>
                                        <ul class="submenu">
                                            <li><a href="{{ route('profile.edit') }}">Pengaturan Akun</a></li>
                                            <li>
                                                <form method="POST" action="{{ route('logout') }}" id="logout-user-form" style="display: none;">
                                                    @csrf
                                                </form>
                                                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-user-form').submit();">Keluar</a>
                                            </li>
                                        </ul>
                                    </li>
                                    @else
                                    <li><a href="{{ route('login') }}">Login</a></li>
                                    <li><a href="{{ route('register') }}">Register</a></li>
                                    @endauth
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mobile_menu d-block d-lg-none"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
