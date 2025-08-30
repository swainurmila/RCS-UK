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
                        <h5>{{ __('messages.ResetYourPassword') }}</h5>
                        <p class="text-muted">
                            {{ __('messages.ResetPasswordDescription') ?? __('Enter your new password below.') }}
                        </p>
                    </div>

                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif

                    {{-- Add error display for expired token --}}
                    @isset($error)
                    <div class="alert alert-danger">
                        {{ $error }}

                    </div>
                    @else
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">
                        <input type="hidden" name="email" value="{{ old('email', $email) }}">

                        <div class="mb-4">
                            <label for="password" class="form-label">{{ __('messages.NewPassword') }}</label>
                            <input id="password" type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror" required autofocus>

                            @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation"
                                class="form-label">{{ __('messages.ConfirmPassword') }}</label>
                            <input id="password_confirmation" type="password" name="password_confirmation"
                                class="form-control @error('password_confirmation') is-invalid @enderror" required>

                            @error('password_confirmation')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-3 text-end">
                            <button type="submit" class="btn submit-btn w-100">
                                {{ __('messages.ResetPasswordButton') ?? __('Reset Password') }}
                            </button>
                        </div>
                    </form>
                    @endisset

                </div>
            </div>
        </div>
    </div>
</div>
@endsection