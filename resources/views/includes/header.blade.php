<head>

    <meta charset="utf-8" />
    <title> Cooperatives Department</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700&display=swap" rel="stylesheet">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('assets/images/logo.png')}}">

    <!-- DataTables -->
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="{{asset('assets/libs/datepicker/datepicker.min.css')}}">

    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />

    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/rcs-style.css')}}" rel="stylesheet" type="text/css" />


</head>

<body>
    <header id="page-topbar">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-boxx">
                    <a href="" class="bihar-logo">
                        <img src="{{asset('assets/images/Seal_of_Uttarakhand.svg.png')}}" alt="logo img"
                            class="img-fluid" style="height: 60px;">
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
                <div class="dropdown d-inline-block">
                    @if (Route::currentRouteName() !== 'all.dashboard')
                        <a href="{{url('/all-dashboard')}}" class="main-dash-link" id="GoToMainDashboardID">Go To Main
                            Dashboard</a>
                    @endif
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
                        id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class="fas fa-user avatar"></i>
                        <span
                            class="d-none d-xl-inline-block ms-1 fw-medium font-size-15">{{Auth()->user()->name}}</span>
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

    <script>
        function switchLanguage(lang) {
            $.ajax({
                url: '/change-language',
                type: 'POST',
                data: {
                    lang: lang,
                    _token: '{{ csrf_token() }}' // Include CSRF token
                },
                success: function (response) {
                    if (response.success) {
                        window.location.reload(); // Reload the page after successful language change
                    }
                },
                error: function (xhr) {
                    console.error("Error changing language:", xhr.responseText);
                }
            });
        }
    </script>