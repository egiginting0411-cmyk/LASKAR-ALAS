    <aside class="left-sidebar">
        <!-- Sidebar scroll-->
        <div>
            <div class="brand-logo d-flex align-items-center justify-content-between">
                <a href="./index.html" class="text-nowrap logo-img">
                    <img src="{{asset('assets/images/logos/image.png')}}" width="180" alt="" />
                </a>
                <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                    <i class="ti ti-x fs-8" style="color: #ffff;"></i>
                </div>
            </div>
            <!-- Sidebar navigation-->
            <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
                <ul id="sidebarnav">
                    @auth
                    @php
                    $role = auth()->user()->role;
                    @endphp
                    @if ($role === 'super')
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Home</span>
                    </li>
                    <li class="sidebar-item {{ request()->is('super/dashboard') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ url('/super/dashboard') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-layout-dashboard"></i>
                            </span>
                            <span class="hide-menu">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Pegawai</span>
                    </li>
                    <li class="sidebar-item  {{ request()->routeIs('pegawai.index') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('pegawai.index') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-user"></i>
                            </span>
                            <span class="hide-menu">Data Pegawai</span>
                        </a>
                    </li>
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Daftar BKPH</span>
                    </li>
                    <li class="sidebar-item {{ request()->routeIs('bkphrogojampi.index') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('bkphrogojampi.index') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-location"></i>
                            </span>
                            <span class="hide-menu">BKPH Rogojampi</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ request()->routeIs('bkphlicin.index') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('bkphlicin.index') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-location"></i>
                            </span>
                            <span class="hide-menu">BKPH Licin</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ request()->routeIs('bkphglenmore.index') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('bkphglenmore.index') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-location"></i>
                            </span>
                            <span class="hide-menu">BKPH Glenmore</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ request()->routeIs('bkphsempu.index') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('bkphsempu.index') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-location"></i>
                            </span>
                            <span class="hide-menu">BKPH Sempu</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ request()->routeIs('bkphkalibaru.index') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('bkphkalibaru.index') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-location"></i>
                            </span>
                            <span class="hide-menu">BKPH Kalibaru</span>
                        </a>
                    </li>
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Polhuter</span>
                    </li>
                    <li class="sidebar-item  {{ request()->routeIs('jadwal.index') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('jadwal.index') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-bookmark"></i>
                            </span>
                            <span class="hide-menu">Jadwal</span>
                        </a>
                    </li>
                    @elseif ($role === 'user')
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Home</span>
                    </li>
                    <li class="sidebar-item {{ request()->is('user/dashboard') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ url('/user/dashboard') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-layout-dashboard"></i>
                            </span>
                            <span class="hide-menu">Dashboard</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ request()->routeIs('laporan.index') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('laporan.index') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-book"></i>
                            </span>
                            <span class="hide-menu">Laporan</span>
                        </a>
                    </li>
                    <li class="sidebar-item  {{ request()->routeIs('jadwaluser.index') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('jadwaluser.index') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-bookmark"></i>
                            </span>
                            <span class="hide-menu">Jadwal</span>
                        </a>
                    </li>
                    @elseif ($role == 'admin')
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Home</span>
                    </li>
                    <li class="sidebar-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ url('/admin/dashboard') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-layout-dashboard"></i>
                            </span>
                            <span class="hide-menu">Dashboard</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ request()->routeIs('adminbkph.index') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('adminbkph.index') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-book"></i>
                            </span>
                            <span class="hide-menu">BKPH</span>
                        </a>
                    </li>
                    <li class="sidebar-item  {{ request()->routeIs('jadwalbkph.index') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('jadwalbkph.index') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-bookmark"></i>
                            </span>
                            <span class="hide-menu">Jadwal Polhuter</span>
                        </a>
                    </li>
                    @endif
                    @endauth
                    
                </ul>
            </nav>
            <!-- End Sidebar navigation -->
        </div>
        <!-- End Sidebar scroll-->
    </aside>