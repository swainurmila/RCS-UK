@extends('layouts.app')
@section('content')
    <div class="container-fluid form-fluid">
        <div class="row login-row">

            <div class="col-lg-6 col-md-6 text-center p-0">
                <div class="login-rt-col">
                    <img src="{{ asset('assets/images/login-rt-bg.png') }}" class="img-fluid" alt>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 login-left-col">
                <div class="card">

                    <div class="card-body p-4">
                        <div class="text-left login-heading">
                            <h5>{{ __('messages.Welcometo') }}<br>
                                {{ __('messages.CooperativesDepartment') }}</h5>

                        </div>
                        <div class="col-md-12 btn-group">
                            <button class="society-login-btn active" type="button">{{ __('messages.Society') }}</button>
                            <button class="official-login-btn" type="button">{{ __('messages.Official') }}</button>
                        </div>
                        <!-- <div class="mt-4">
                            <div class="col-lg-12 society-message">
                                <h3>{{ __('messages.Society') }}</h3>
                            </div>
                            <div class="col-lg-12 official-message">
                                <h3>{{ __('messages.Official') }}</h3>
                            </div>
                        </div> -->
                        <div class="society-form">

                            <form method="POST" action="{{ route('user-login') }}">
                                @csrf
                                <input type="hidden" name="is_society_form" value="1">
                                <div class="form-step1">
                                    <div class="mb-4">
                                        <label class="form-label"
                                            for="username">{{ __('messages.PleaseEnteryourPhoneorEmail') }}</label>
                                        <input type="text"
                                            class="form-control @error('society_email') is-invalid @enderror"
                                            name="society_email" placeholder="{{ __('messages.PhoneorEmail') }}">

                                        @error('society_email')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>

                                    <div class="mb-4">
                                        <!-- <div class="float-end">
                                            <span  class="text-muted forgot-pwd-txt">Forgot password?</span>
                                        </div> -->
                                        <label class="form-label"
                                            for="userpassword">{{ __('messages.PleaseenteryourPassword') }}</label>
                                        <input type="password" name="society_password"
                                            class="form-control @error('society_password') is-invalid @enderror"
                                            placeholder="Password">
                                        @error('society_password')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="auth-remember-check">
                                            <label class="form-check-label"
                                                for="auth-remember-check">{{ __('messages.Rememberme') }}</label>
                                        </div>
                                        <div class="float-end forgot">
                                            <a
                                                href="{{ url('/forgot-password') }}">{{ __('messages.Forgotpassword') }}</a>
                                        </div>
                                    </div>

                                    <div class="mt-1 text-end">
                                        
                                        <button type="submit"
                                            class="btn submit-btn w-100">{{ __('messages.Login') }}</button>
                                    </div>
                                </div>

                            </form>

                            <h6 class="register-txt">{{ __('messages.Donthaveanaccount') }}<a href="/registration">
                                    {{ __('messages.Register') }}</a></h6>

                        </div>

                        <div class="official-form" style="display: none;">
                            <form method="POST" action="{{ route('user-login') }}">
                                @csrf
                                <input type="hidden" name="is_society_form" value="2">
                                <div class="form-step1">
                                    <div class="mb-4">
                                        <label class="form-label"
                                            for="username">{{ __('messages.PleaseEnteryourPhoneorEmail') }}</label>
                                        <input type="text"
                                            class="form-control @error('official_email') is-invalid @enderror"
                                            name="official_email"
                                            placeholder="{{ __('messages.PleaseEnteryourPhoneorEmail') }}">

                                        @error('official_email')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <!-- <div class="float-end">
                                            <span  class="text-muted forgot-pwd-txt">Forgot password?</span>
                                        </div> -->
                                        <label class="form-label"
                                            for="userpassword">{{ __('messages.PleaseenteryourPassword') }}</label>
                                        <input type="password" name="official_password"
                                            class="form-control @error('official_password') is-invalid @enderror"
                                            placeholder="{{ __('messages.PleaseenteryourPassword') }}">
                                        @error('official_password')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror

                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="auth-remember-check">
                                            <label class="form-check-label"
                                                for="auth-remember-check">{{ __('messages.Rememberme') }}</label>
                                        </div>
                                        <div class="float-end forgot">
                                            <a href="/forgot-password">{{ __('messages.Forgotpassword') }}</a>
                                        </div>
                                    </div>

                                    <div class="mt-1 text-end">
                                        <button type="submit"
                                            class="btn submit-btn w-100">{{ __('messages.Login') }}</button>
                                    </div>
                                </div>
                            </form>

                            <h6 class="register-txt">{{ __('messages.Donthaveanaccount') }}<a
                                    href="{{ url('/registration') }}">{{ __('messages.Register') }}</a></h6>
                        </div>

                    </div>
                </div>

            </div>

        </div>
        <!-- end row -->
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            // Show Society Form and Message
            $('.society-login-btn').click(function() {
                $('.society-form').show();
                $('.official-form').hide();
                $('.society-login-btn').addClass('active');
                $('.official-login-btn').removeClass('active');

                $('.society-message').show();
                $('.official-message').hide();
            });

            // Show Official Form and Message
            $('.official-login-btn').click(function() {
                $('.official-form').show();
                $('.society-form').hide();
                $('.official-login-btn').addClass('active');
                $('.society-login-btn').removeClass('active');

                $('.official-message').show();
                $('.society-message').hide();
            });

            // Initialize with Society Form and Message
            $('.society-login-btn').trigger('click');
        });
    </script>
@endsection
