<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-boxx">
                <a href="" class="bihar-logo">
                    <img src="{{ asset('assets/images/Seal_of_Uttarakhand.svg.png') }}" alt="logo img" class="img-fluid"
                        style="height: 60px;">
                    <p>
                        <strong>ई - सहकारी, सहकारिता विभाग, उत्तराखंड सरकार</strong>
                        <br>
                        <span>Cooperative Department, Govt. Of Uttarakhand</span>
                    </p>
                </a>
            </div>
        </div>
        <!-- User Profile Dropdown -->
        <div class="d-flex align-items-center">
            @if(Request::path() !== "all-dashboard")
                <a href={{ route("all.dashboard") }} class="main-dash-link">Go to Main Dashboard</a>
            @endif
            <div class="dropdown d-inline-block">
                <button type="button" class="btn waves-effect btn-primary" id="page-header-user-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="d-none d-xl-inline-block ms-1 fw-medium font-size-15">
                        {{ app()->getLocale() == 'en' ? 'English' : 'हिंदी' }}
                    </span>
                    <i class="uil-angle-down d-none d-xl-inline-block font-size-15"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="#" onclick="switchLanguage('en'); return false;">
                        <span class="align-middle {{ app()->getLocale() == 'en' ? 'fw-bold' : '' }}">English</span>
                    </a>
                    <a class="dropdown-item" href="#" onclick="switchLanguage('hi'); return false;">
                        <span class="align-middle {{ app()->getLocale() == 'hi' ? 'fw-bold' : '' }}">हिंदी</span>
                    </a>
                </div>
            </div>
            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect admin-avatar-btn"
                    id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user avatar"></i>
                    <span
                        class="d-none d-xl-inline-block ms-1 fw-medium font-size-15">{{ Auth()->user()->name ?? '' }}</span>
                    <i class="uil-angle-down d-none d-xl-inline-block font-size-15"></i>
                </button>

                <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="#">
                        <i class="uil uil-user-circle font-size-18 align-middle text-muted me-1"></i>
                        <span class="align-middle">View Profile</span>
                    </a>
                    <!-- <a class="dropdown-item" href="/">
                      <i class="uil uil-sign-out-alt font-size-18 align-middle me-1 text-muted"></i>
                      <span class="align-middle">Sign out</span>
                  </a> -->
                    <a class="dropdown-item" href="{{ route('logout') }}">
                        <i class="uil uil-sign-out-alt font-size-18 align-middle me-1 text-muted"></i>
                        <span class="align-middle">Sign out</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
