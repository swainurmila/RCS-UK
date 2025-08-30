<head>

    <meta charset="utf-8" />
    <title> Cooperatives Department</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />

    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700&display=swap">
    <link rel="stylesheet" href="assets/libs/datepicker/datepicker.min.css">

    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css" />



    <style>
        .authentication-bg {
            height: 100vh;
            background-color: transparent;
            position: relative;
        }

        .account-pages.authentication-bg:after {
            content: "";
            background-image: url(assets/images/login-bg.jpg);
            background-size: cover;
            background-position: -1px;
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0.5;
            transform: scaleX(-1);
        }

        .forgot-pwd-form h5 {
            font-size: 16px;
            border-bottom: solid 1px rgb(22 37 109 / 12%);
            padding-bottom: 0.7rem;
            margin-bottom: 1rem;
        }

        @media (min-width: 769px) {
            body[data-sidebar-size=sm] {
                min-height: auto;
            }
        }
    </style>
</head>

<body>
    <div class="account-pages authentication-bg">
        <div class="container-fluid login-header">
            <div class="row">
                <div class="col-lg-7">
                    <div class="login-header-left">
                        <a href class="bihar-logo">

                            <img src="assets/images/Seal_of_Uttarakhand.svg.png" alt="logo img" class="img-fluid">
                            <p> <strong>ई - सहकारी, सहकारिता विभाग, उत्तराखंड
                                    सरकार</strong> <br><span>{{ __('messages.CooperativeDepartmentGovtOfUttarakhand') }}
                                </span></p>
                        </a>
                    </div>
                </div>
                <div class="col-lg-5 d-flex justify-content-end">
                    <div class="me-4">
                        <select class="form-select mt-4" aria-label="Default select example"
                            style="box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px; border: 1px solid #dcdcdc;"
                            onchange="switchLanguage(this.value)">
                            <option value="1" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>English</option>
                            <option value="2" {{ app()->getLocale() == 'hi' ? 'selected' : '' }}>Hindi</option>
                        </select>
                    </div>


                    <div class="login-header-right">
                        <h5> {{ __('messages.PushkarSinghDhami') }}<span>{{ __('messages.HonbleChiefMinister') }}</span>
                        </h5>
                        <img src="assets/images/cm.png" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
        <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/libs/toastr/build/toastr.min.js') }}"></script>
        <link href="{{ asset('assets/libs/toastr/build/toastr.min.css') }}" rel="stylesheet" type="text/css">
        <script>
            function showToastr(toastrMessage, toastrType) {
                if ($('.toast').length) {
                    toastr.remove();
                }

                var defaults = {
                    "closeButton": false,
                    "debug": false,
                    "positionClass": "toast-top-right",
                    "onclick": null,
                    "progressBar": true,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "2000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                };
                toastrType = typeof toastrType !== 'undefined' ? toastrType : 'success';
                toastr[toastrType](toastrMessage);
            };


            function switchLanguage(lang) {
                // Map values to their corresponding language codes
                let languageCode = '';

                if (lang === "1") {
                    languageCode = 'en'; // English
                } else if (lang === "2") {
                    languageCode = 'hi'; // Hindi
                } else {
                    return; // If the selected value is not valid (e.g., 'Language'), do nothing
                }

                $.ajax({
                    url: '/change-language',
                    type: 'POST',
                    data: {
                        lang: languageCode,
                        _token: '{{ csrf_token() }}' // Include CSRF token
                    },
                    success: function(response) {
                        if (response.success) {
                            window.location.reload(); // Reload the page after successful language change
                        }
                    },
                    error: function(xhr) {
                        console.error("Error changing language:", xhr.responseText);
                    }
                });
            }
        </script>
