@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row login-row mt-4">
            <div class="col-lg-6">
                <img src="{{ asset('assets/images/Group.png') }}" class="img-fluid">
            </div>

            <div class=" col-lg-6">
                <div class="card">
                    <div class="card-body p-4" style="width: 90%;">
                        <h4 class="text-center mb-4">{{ __('messages.ResetYourPassword') }}</h4>
                        <p class="otp-text sub_heading">
                            {{ __('messages.TheOTPwillbesenttoyourregisteredemailandmobilenumber') }}</p>

                        <div class="row">
                            <div class="col-xl-12">
                                <div class="row w-100 m-0 registrationForm">
                                    <div class="user-section">
                                        <div class="col-md-12 form-group">
                                            <label for="email" class="form-label">{{ __('messages.EmailId') }}</label>
                                            <input type="text" class="form-control email" name="email" id="email"
                                                placeholder="{{ __('messages.EmailId') }}">
                                            <small class="text-danger email-error d-none"></small>
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <label for="mob_no" class="form-label">{{ __('messages.MobileNo') }}</label>
                                            <input type="text" class="form-control mob_no" name="mob_no" id="mob_no"
                                                placeholder="{{ __('messages.MobileNo') }}" maxlength="10"
                                                onkeypress="return event.charCode >=48 && event.charCode <=57">
                                            <small class="text-danger mob-error d-none"></small>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input class="submit-button1 send-otp" type="button"
                                                    value="{{ __('messages.SendOTP') }}">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="otp-section d-none">
                                        <div class="col-md-12 form-group">
                                            <label for="otp" class="form-label">{{ __('messages.OTP') }}</label>
                                            <input type="text" name="otp" class="form-control otp-value numeric"
                                                id="otp" placeholder="{{ __('messages.EnterOTP') }}" required>

                                            <!-- Resend OTP Link -->
                                            <p class="float-end otp-div d-none">
                                                <a href="javascript:void(0);"
                                                    class="text-info send-otp">{{ __('messages.ResendOTP') }}</a>
                                            </p>

                                            <!-- Timer -->
                                            <p class="float-end text-info d-none timer" id="timer">
                                                {{ __('messages.Resendafterseconds') }}</p>

                                            <!-- OTP Expiry Message -->
                                            <p><small
                                                    class="text-danger text-mute">{{ __('messages.OTPwillexpireafterminutes') }}</small>
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Password Reset Section -->
                                    <div class="password-reset-section d-none">
                                        <div class="col-md-12 form-group">
                                            <label for="new-password"
                                                class="form-label">{{ __('messages.newPassword') }}</label>
                                            <input type="password" class="form-control" id="new-password"
                                                placeholder="{{ __('messages.newPassword') }}" disabled>
                                            <small class="text-danger pass-error d-none"></small>

                                        </div>
                                        <div class="col-md-12 form-group">
                                            <label for="confirm-password"
                                                class="form-label">{{ __('messages.ConfirmPassword') }}</label>
                                            <input type="password" class="form-control" id="confirm-password"
                                                placeholder="{{ __('messages.ConfirmPassword') }}" disabled>
                                            <small class="text-danger confpass-error d-none"></small>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input class="submit-button1 reset-password" type="button"
                                                    value="Reset Password" disabled>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Back to Login Link -->
                                    <div class="col-md-12 form-group">
                                        <a href="/"
                                            class="float-end back-to-login">{{ __('messages.BacktoLogin') }}</a>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>
        <!-- end row -->
    @endsection
    @section('js')
        <script>
            function validateForm() {
                let errors = {}; // Reset errors object

                let email = $('.email').val().trim();
                let mob_no = $('.mob_no').val().trim();

                // Validate Email
                if (!email) {
                    errors.email = "Please enter your email address.";
                } else if (!validateEmail(email)) {
                    errors.email = "Please enter a valid email address.";
                }

                // Validate Mobile Number
                if (!mob_no) {
                    errors.mob_no = "Please enter your mobile number.";
                } else if (!validateMobile(mob_no)) {
                    errors.mob_no = "Please enter a valid 10-digit mobile number.";
                }

                displayErrors(errors);

                // Return true if no errors, false otherwise
                return Object.values(errors).every(error => !error);
            }

            function validateEmail(email) {
                const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return regex.test(email);
            }

            function validateMobile(mob_no) {
                const regex = /^\d{10}$/; // Assumes a 10-digit mobile number
                return regex.test(mob_no);
            }

            function validateReset() {
                let errors = {}; // Reset errors object

                let newpass = $('#new-password').val().trim();
                let confpass = $('#confirm-password').val().trim();

                // Validate New Password
                if (!newpass) {
                    errors.newpass = "Please enter your new password.";
                } else if (newpass.length < 8) {
                    errors.newpass = "Password must be at least 8 characters long.";
                }

                // Validate Confirm Password
                if (!confpass) {
                    errors.confpass = "Please confirm your new password.";
                } else if (newpass !== confpass) {
                    errors.confpass = "Passwords do not match.";
                }

                displayResetErrors(errors); // Call a separate function to display reset-specific errors

                // Return true if no errors, false otherwise
                return Object.keys(errors).length === 0;
            }

            function displayErrors(errors) {
                // Clear previous errors
                $('.email-error').text('').addClass('d-none');
                $('.mob-error').text('').addClass('d-none');

                // Display new errors
                if (errors.email) {
                    $('.email-error').text(errors.email).removeClass('d-none');
                }
                if (errors.mob_no) {
                    $('.mob-error').text(errors.mob_no).removeClass('d-none');
                }
            }

            function displayResetErrors(errors) {
                // Clear previous errors
                $('.pass-error').text('').addClass('d-none');
                $('.confpass-error').text('').addClass('d-none');

                // Display new errors
                if (errors.newpass) {
                    $('.pass-error').text(errors.newpass).removeClass('d-none');
                }
                if (errors.confpass) {
                    $('.confpass-error').text(errors.confpass).removeClass('d-none');
                }
            }

            $(document).ready(function() {

                // Function to start the timer
                function startTimer() {
                    let seconds = 30;
                    const timerElement = $('#timer');

                    const timerInterval = setInterval(function() {
                        seconds--;
                        timerElement.text(`Resend after: ${seconds} seconds`);

                        if (seconds == 0) {
                            clearInterval(timerInterval);
                            $('.otp-div').removeClass('d-none');
                            $('.timer').addClass('d-none');
                        }
                    }, 1000);
                }

                // Send OTP Button Click
                $('.send-otp').on('click', function(e) {
                    e.preventDefault();
                    if (!validateForm()) {
                        return; // Stop execution if validation fails
                    }

                    const email = $('.email').val(); // Ensure the input field has the class `username`
                    const mob_no = $('.mob_no').val(); // Ensure the input field has the class `username`

                    if (email) {
                        // Make an AJAX call to the /reset-otp endpoint
                        $.ajax({
                            url: "{{ route('reset.otp') }}", // Laravel route
                            type: 'POST',
                            data: {
                                "_token": "{{ csrf_token() }}", // CSRF token for Laravel
                                "email": email,
                                "mob_no": mob_no // Email from the input field
                            },
                            dataType: "JSON",
                            beforeSend: function() {
                                // Show a loader or disable the button to indicate processing
                                $('.send-otp').prop('disabled', true).text('Sending OTP...');
                            },
                            success: function(response) {
                                // Handle success response
                                if (response.message === 'OTP sent successfully!') {
                                    // Show OTP Section and Hide User Section
                                    $('.otp-section').removeClass('d-none');
                                    $('.user-section').addClass('d-none');
                                    $('.timer').removeClass('d-none');
                                    $('.sub_heading').html(
                                        `OTP has been sent to your registered email & mobile no.`
                                        );

                                    // Start the timer
                                    startTimer();
                                } else {
                                    alert('Failed to send OTP. Please try again.');
                                }
                            },
                            error: function(xhr, status, error) {
                                showToastr(xhr.responseJSON.message, 'error');
                            },
                            complete: function() {
                                // Re-enable the button and reset its text
                                $('.send-otp').prop('disabled', false).text('Send OTP');
                            }
                        });
                    } else {
                        errors = {};
                        let formdata = {
                            email,
                            mob_no
                        }
                    }
                });


                // OTP Input Keyup Event
                $('.otp-value').on('keyup', function() {
                    const otp = $(this).val();

                    if (otp.length == 4) { // Adjusted to 4-digit OTP as per backend
                        $.ajax({
                            url: "{{ route('verify.otp') }}", // Using named route // Using named route
                            type: 'POST',
                            data: {
                                otp: otp,
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                if (response.success) {
                                    // Enable Password Reset Section
                                    $('.password-reset-section').removeClass('d-none');
                                    $('#new-password').prop('disabled', false);
                                    $('#confirm-password').prop('disabled', false);
                                    $('.reset-password').prop('disabled', false);

                                    // Hide OTP Section
                                    $('.otp-section').addClass('d-none');
                                } else {
                                    alert(response.message); // Show error message
                                }
                            },
                            error: function(xhr) {
                                alert(xhr.responseJSON.message || "Something went wrong!");
                            }
                        });
                    }
                });


                // Reset Password Button Click
                $('.reset-password').on('click', function(e) {
                    e.preventDefault();
                    if (!validateReset()) {
                        return; // Stop execution if validation fails
                    }
                    const newPassword = $('#new-password').val();
                    const confirmPassword = $('#confirm-password').val();

                    if (newPassword && confirmPassword && newPassword === confirmPassword) {
                        $.ajax({
                            url: "{{ route('reset.password') }}", // Backend route
                            type: 'POST',
                            data: {
                                new_password: newPassword,
                                new_password_confirmation: confirmPassword, // Laravel expects `field_confirmation`
                                _token: "{{ csrf_token() }}" // CSRF token for security
                            },
                            success: function(response) {
                                window.location.href = "/"; // Redirect after success
                            },
                            error: function(xhr) {
                                alert(xhr.responseJSON.message || "Something went wrong!");
                            }
                        });
                    } else {
                        alert('Passwords do not match. Please try again.');
                    }
                });
            });
        </script>
    @endsection
