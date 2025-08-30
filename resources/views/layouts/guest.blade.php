<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('layouts.header')

<body style="display: none;" onload="document.body.style.display = 'block'">
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
                            <option value="en" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>English</option>
                            <option value="hi" {{ app()->getLocale() == 'hi' ? 'selected' : '' }}>Hindi</option>
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
    </div>
    @yield('content')
    @include('layouts.script')
</body>

</html>
