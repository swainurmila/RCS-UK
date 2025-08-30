@extends('layouts.guest')
@section('content')
<div class="container-fluid form-fluid">
    <div class="row login-row">
        <div class="col-lg-6 col-md-6 text-center p-0">
            <div class="login-rt-col">
                <img src="{{ asset('assets/images/Group.png') }}" class="img-fluid">
            </div>
        </div>

        <div class="col-lg-6 col-md-6 login-left-col">
            <div class="card">
                <div class="card-body p-4">
                    <div class="text-left login-heading">
                        <h5>{{ __('messages.SignupHere') }}</h5>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="row w-100 m-0 registrationForm">
                                <form method="POST" action="{{ route('create.registration') }}"
                                    id="registrationSubmit">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for=""
                                                    class="form-label">{{ __('messages.FullName') }}</label><span
                                                    class="text-danger">*</span>
                                                <input type="text" class="form-control" id="txtFirstName"
                                                    placeholder="{{ __('messages.FullName') }}" maxlength="35"
                                                    name="name" />
                                                <span id="error-full_name" class="text-danger"></span>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for=""
                                                    class="form-label">{{ __('messages.ContactNumber') }}</label><span
                                                    class="text-danger">*</span>
                                                <input type="text" class="form-control" id="MobileNo"
                                                    inputmode="numeric" maxlength="10"
                                                    placeholder="{{ __('messages.ContactNumber') }}"
                                                    onkeypress="return event.charCode >=48 && event.charCode <=57"
                                                    autocomplete="off" name="mob_no" />
                                                <span id="error-contact" class="text-danger"></span>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for=""
                                                    class="form-label">{{ __('messages.EmailId') }}</label><span
                                                    class="text-danger"></span>
                                                <input type="text" class="form-control" id="txtEmailId"
                                                    placeholder="{{ __('messages.EmailId') }}" maxlength="50"
                                                    autocomplete="off" name="email" />
                                                <span id="error-email" class="text-danger"></span>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="" class="form-label"> {{ __('messages.Password') }}
                                                </label><span class="text-danger">*</span>
                                                <input type="password" class="form-control" id="txtPassword"
                                                    placeholder="{{ __('messages.Password') }}" maxlength="20"
                                                    autocomplete="off" name="password" />
                                                <span id="error-password" class="text-danger"></span>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="" class="form-label">
                                                    {{ __('messages.ConfirmPassword') }}
                                                </label><span class="text-danger">*</span>
                                                <input type="password" class="form-control" id="ConfirmPassword"
                                                    placeholder="{{ __('messages.ConfirmPassword') }}" maxlength="20"
                                                    autocomplete="off" name="confpassword" />
                                                <input type="hidden" name="role_id" value="1">
                                                <span id="error-confirm_password" class="text-danger"></span>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="role" class="form-label" hidden>Role Name</label><span
                                                    class="text-danger" hidden>*</span>
                                                <select class="form-control" id="role_id" name="role_id" hidden>
                                                    @foreach ($roles as $role)
                                                    @if ($role->id == 1)
                                                    <option value="{{ $role->id }}" selected>
                                                        {{ $role->name }}
                                                    </option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                                <input type="hidden" name="role_id" value="1">
                                                <span id="error-role" class="text-danger"></span>
                                            </div>
                                        </div>


                                        <div class="col-lg-12 d-flex justify-content-end mt-2 mb-3">
                                            <button type="button" class="btn btn-primary" id="generateOtpBtn"
                                                onkeypress="return event.charCode >=48 && event.charCode <=57"
                                                onclick="SendOTP()">
                                                {{ __('messages.GenerateOTP') }}
                                            </button>
                                        </div>

                                </form>
                            </div>
                            <!-- New OTP Verification Form -->
                            <form id="otp-verify-form" style="display: none;">
                                <div class="form-group text-center">
                                    <label>Enter OTP</label>
                                    <div class="d-flex justify-content-center">
                                        @for ($i = 1; $i <= 4; $i++)
                                            <input type="text" maxlength="1"
                                            class="otp-input mx-1 text-center form-control d-inline-block"
                                            style="width:40px; display:inline-block;" id="otp{{ $i }}"
                                            name="otp[]" oninput="handleOtpInput(this, {{ $i }})">
                                            @endfor
                                    </div>
                                    <div class="text-danger text-center mt-2" id="otp-error"></div>
                                </div>

                                <div class="form-group text-center">
                                    <span id="timer" class="text-muted">Resend OTP in <span
                                            id="countdown">30</span>s</span>
                                    <br>
                                    <!-- <button type="button" class="btn btn-secondary" id="resend-otp"
                                        style="display:none;" onclick="resendOtp()">Resend OTP</button> -->
                                    <a href="javascript:void(0);" id="resend-otp"
                                        style="display:none;" onclick="resendOtp()">Resend OTP</a>


                                </div>
                                <div class="d-flex justify-content-center mt-3">
                                    <button type="button" id="cancelBtn" class="btn btn-danger mx-1"
                                        onclick="ClearData()">{{ __('messages.Cancel') }}</button>
                                    <button type="button" class="btn btn-primary" id="registrationSumbit"
                                        onclick="verifyOtp()">{{ __('messages.submit') }}</button>
                                </div>
                            </form>
                        </div>

                    </div>

                </div>
            </div>
            <h6 class="register-txt">{{ __('messages.Alreadyhaveanaccount') }}<a
                    href="{{ route('login.view') }}">{{ __('messages.SignIn') }}</a></h6>
        </div>
    </div>

</div>

<!-- end row -->
@endsection
@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('#MobileNo').on('blur', function() {
            var mob_no = $(this).val();

            if (mob_no.length === 10) {
                $.ajax({
                    url: "{{ route('check.mobile.exists') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        mob_no: mob_no
                    },
                    success: function(response) {
                        if (response.exists) {
                            $('#error-contact').text('Mobile number already exists');
                            $('#registrationSumbit').attr('disabled', true);
                        } else {
                            $('#error-contact').text('');
                            $('#registrationSumbit').attr('disabled', false);
                        }
                    },
                    error: function() {
                        console.log('Mobile check failed');
                    }
                });
            }
        });
        $('#txtEmailId').on('blur', function() {
            var email = $(this).val();

            if (email) {
                $.ajax({
                    url: "{{ route('check.mobile.exists') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        email: email
                    },
                    success: function(response) {
                        if (response.email_exists) {
                            $('#error-email').text('Email is already Exist.').show();
                            $('#registrationSumbit').attr('disabled', true);
                        } else {
                            $('#error-email').text('').hide();
                            $('#registrationSumbit').attr('disabled', false);
                        }
                    },
                    error: function() {
                        console.log('Email check failed');
                    }
                });
            }
        });

    });
</script>

<script>
    $(document).ready(function() {
        // Automatically hide errors when user starts typing
        $('#txtFirstName').on('input', function() {
            $('#error-full_name').text('').hide();
        });

        // $('#txtEmailId').on('input', function() {
        //     $('#error-email').text('').hide();
        // });

        $('#txtPassword').on('input', function() {
            $('#error-password').text('').hide();
        });

        $('#ConfirmPassword').on('input', function() {
            $('#error-confirm_password').text('').hide();
        });

    });


    function SendOTP() {
        $('[id^="error-"]').text('').hide();

        let mob_no = $("#MobileNo").val().trim();
        let email = $("#txtEmailId").val().trim();
        let full_name = $("#txtFirstName").val().trim();
        let password = $("#txtPassword").val().trim();
        let confirm_password = $("#ConfirmPassword").val().trim();
        let errors = {};

        if (!mob_no) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please enter Mobile Number'
            });
            return;
        }

        if (!full_name) errors.full_name = "Full Name is required";
        if (!email) {
            errors.email = "Email is required";
        } else if (!/^\S+@\S+\.\S+$/.test(email)) {
            errors.email = "Enter a valid email";
        }
        if (!password) errors.password = "Password is required";
        if (!confirm_password) {
            errors.confirm_password = "Confirm Password is required";
        } else if (password !== confirm_password) {
            errors.confirm_password = "Passwords do not match";
        }

        if (Object.keys(errors).length > 0) {
            for (let field in errors) {
                $("#error-" + field).text(errors[field]).show();
            }
            return;
        }


        $.ajax({
            url: "{{ route('check.mobile.exists') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                mob_no: mob_no,
                email: email
            },
            success: function(response) {
                if (response.mobile_exists) {
                    $('#error-contact').text('This mobile number is already registered.').show();
                    return;
                }
                if (response.email_exists) {
                    $('#error-email').text('Email is already Exist.').show();
                    return;
                }

                // If not exists, proceed to send OTP
                $('#registrationSubmit').remove();
                $('#otp-verify-form').show();
                $('#generateOtpBtn').hide();
                $('#otp-error').hide();
                $('#timer').show();
                $("#generateOtpBtn").prop("disabled", true);

                $.ajax({
                    url: "{{ route('send.otp') }}",
                    type: "POST",
                    data: {
                        mob_no: mob_no,
                        email: email,
                        full_name: full_name,
                        contact: mob_no,
                        password: password,
                        confirm_password: confirm_password,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.message === 'OTP sent successfully!') {
                            $("#generateOtpBtn").addClass("d-none");
                            startTimer(30);
                        } else {
                            $("#generateOtpBtn").prop("disabled", false);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message || 'Failed to send OTP'
                            });
                        }
                    },
                    error: function() {
                        $("#generateOtpBtn").prop("disabled", false);
                    }
                });
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Server error during validation.'
                });
            }
        });
    }


    function resendOtp() {
        $.ajax({
            url: "{{ route('reset.otp') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                if (response.message === 'OTP resent successfully!') {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        text: 'OTP resent successfully!', // normal-sized text
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    });

                    $('.otp-input').val(''); // Clear OTP input fields
                    $('#timer').show();
                    startTimer(30);
                } else {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'error',
                        text: response.message || 'Failed to resend OTP',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    });

                    $("#generateOtpBtn").prop("disabled", false);
                }
            },
            error: function(xhr) {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    text: 'Something went wrong while resending OTP',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });

                $("#generateOtpBtn").prop("disabled", false);
            }
        });
    }



    function handleOtpInput(current, position) {
        // Auto-focus next input
        if (current.value.length === 1 && position < 4) {
            $(`#otp${position + 1}`).focus();
        }

        // Auto-submit when all fields are filled
        if ($('.otp-input').toArray().every(i => i.value.length === 1)) {
            //  verifyOtp();
        }
    }

    function startTimer(duration = 30) {
        let timer = duration;
        $('#countdown').text(timer);
        $('#resend-otp').hide();

        const interval = setInterval(() => {
            timer--;
            $('#countdown').text(timer);

            if (timer <= 0) {
                clearInterval(interval);
                $('#timer').hide();
                $('#resend-otp').show();
            }
        }, 1000);
    }

    // function verifyOtp() {
    //     const otp = $('.otp-input').toArray().map(i => i.value).join('');
    //     $.ajax({
    //         url: '/verify-otp',
    //         method: 'POST',
    //         data: {
    //             otp: otp,
    //             _token: '{{ csrf_token() }}'
    //         },

    //         success: function(response) {
    //             if (response.success) {
    //                 $('#otp-error').text('').hide();
    //                 $('#registrationSumbit').prop('disabled', false);
    //                 window.location.href = '/';
    //             } else {
    //                 $('#otp-error').text(response.message).show();
    //             }
    //         }
    //     });
    // }
    function verifyOtp() {
    const otp = $('.otp-input').toArray().map(i => i.value).join('');

    $.ajax({
        url: '/verify-otp',
        method: 'POST',
        data: {
            otp: otp,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            if (response.success) {
                $('#otp-error').text('').hide();
                $('#registrationSumbit').prop('disabled', false);

                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    text: 'OTP verified successfully!',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });

                setTimeout(() => {
                    window.location.href = '/';
                }, 1500); // small delay to allow toast to display
            } else {
                $('#otp-error').text(response.message).show();

                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    text: response.message || 'Invalid OTP. Please try again.',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
            }
        },
        error: function(xhr) {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                text: 'An error occurred while verifying OTP.',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
        }
    });
}

</script>
@endsection