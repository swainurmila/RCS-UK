@extends('layouts.guest')
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
                    <div class="text-left login-heading mb-4">
                        <h5>{{ __('messages.ForgotYourPassword') }}</h5>
                        <p class="text-muted">
                            {{ __('messages.ForgotPasswordDescription') ?? __('Forgot your password? No problem. Enter your email and we will send you a link to reset your password.') }}
                        </p>
                    </div>

                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="email" class="form-label">{{ __('messages.Email') }}</label>
                            <input type="email" name="email" id="email" placeholder="e.g.johndoe@gmail.com"
                                class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                                required autofocus>

                            @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-3 d-flex justify-content-center">
                            <button type="submit" class="btn submit-btn w-100" style="max-width: 300px;">
                                {{ __('messages.EmailPasswordResetLink') ?? __('Send Reset Link') }}
                                <i class="fas fa-paper-plane ms-2"></i>
                            </button>
                        </div>

                </div>

                </form>

            </div>
        </div>
    </div>
</div>
</div>

@endsection