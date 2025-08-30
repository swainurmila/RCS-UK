@extends('layouts.app')
@section('title')
    {{ $title }}
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">{{ __('messages.edit-user') }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="javascript: void(0);">{{ __('messages.CooperativesDepartment') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('messages.edit-user') }}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form id="userForm" method="POST" action="{{ route('users-update', $user->id) }}">
                @csrf
                <div class="row">
                    <div id="formErrors" class="alert alert-danger d-none"></div>
                    <div class="col-xs-3 col-sm-3 col-md-3 mb-2">
                        <div class="form-group">
                            <strong>{{ __('messages.name') }}:</strong>
                            <input type="text" name="name" placeholder="{{ __('messages.name') }}"
                                class="form-control" onkeypress="return /[a-z A-Z\.]/i.test(event.key)" autocomplete="off"
                                value="{{ old('name', $user->name) }}">
                        </div>
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-3 mb-2">
                        <div class="form-group">
                            <strong>{{ __('messages.email_title') }}:</strong>
                            <input type="email" name="email" placeholder="{{ __('messages.email_title') }}"
                                class="form-control" autocomplete="off"
                                pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[cC][oO][mM]$"
                                value="{{ old('email', $user->email) }}">
                        </div>
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-3 mb-2">
                        <div class="form-group">
                            <strong>{{ __('messages.mobile_number') }}:</strong>
                            <input type="text" name="mob_no" placeholder="{{ __('messages.mobile_number') }}"
                                class="form-control mobile" autocomplete="off" value="{{ old('mob_no', $user->mob_no) }}">
                        </div>
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-3 mb-2">
                        <div class="form-group">
                            <strong>{{ __('messages.age') }}:</strong>
                            <input type="number" name="age" placeholder="{{ __('messages.age') }}"
                                class="form-control" autocomplete="off" value="{{ old('age', $user->age) }}">
                        </div>
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-3 mb-2">
                        <div class="form-group">
                            <strong>{{ __('messages.Role') }}:</strong>
                            <select name="role_id" class="form-select select2">
                                <option value="">--</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}"
                                        {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                        {{ ucfirst($role->name) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-3 mb-2">
                        <div class="form-group">
                            <strong>{{ __('messages.Division') }}:</strong>
                            <select name="division_id" id="division_id" class="form-select select2"
                                onchange="getDistrict(this)">
                                <option value="">--</option>
                                @foreach ($division as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $user->division_id == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-3 mb-2">
                        <div class="form-group">
                            <strong>{{ __('messages.district') }}:</strong>
                            <select name="district_id" id="district_id" class="form-select select2"
                                onchange="getBlock(this)">
                                <option value="">--</option>
                                @foreach ($district as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $user->district_id == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-3 mb-2">
                        <div class="form-group">
                            <strong>{{ __('messages.Block') }}:</strong>
                            <select name="block_id" id="block_id" class="form-select select2">
                                <option value="">--</option>
                                @foreach ($block as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $user->block_id == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-xs-3 col-sm-3 col-md-3 mb-2">
                        <div class="form-group">
                            <strong>{{ __('messages.password_title') }}:</strong>
                            <input type="password" name="password" placeholder="{{ __('messages.password_title') }}"
                                class="form-control" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-xs-3 col-sm-3 col-md-3 mb-2">
                        <div class="form-group">
                            <strong>{{ __('messages.confirm_password_title') }}:</strong>
                            <input type="password" name="confirm-password"
                                placeholder="{{ __('messages.confirm_password_title') }}" class="form-control"
                                autocomplete="off">
                        </div>
                    </div>

                    <div class="col-xs-3 col-sm-3 col-md-3" style="margin-top: 5px;">
                        <button type="submit" class="btn btn-primary mb-3" style="margin-top: 18px;"><i
                                class="fa-solid fa-floppy-disk"></i>
                            {{ __('messages.submit') }}</button>
                        <a class="btn btn-warning" href="{{ route('users-index') }}"><i class="fa fa-arrow-left1"></i>
                            {{ __('messages.back') }}</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('js')
    <script>
        function getDistrict(d) {
            var url = "{{ route('get-district') }}";
            var division_id = d.value;
            if (division_id != '') {
                $('#district_id').empty();
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "division_id": division_id
                    },
                    dataType: "JSON",
                    success: function(res) {
                        $('#district_id').html(res.options);
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            }
        }

        function getBlock(d) {
            var url = "{{ route('get-block') }}";
            var district_id = d.value;
            if (district_id != '') {
                $('#block_id').empty();
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "district_id": district_id
                    },
                    dataType: "JSON",
                    success: function(res) {
                        $('#block_id').html(res.options);
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            }
        }
    </script>
    <script>
        $(document).ready(function() {
            $.validator.addMethod("regex", function(value, element, regexp) {
                return this.optional(element) || regexp.test(value);
            }, "Invalid format.");

            $('#userForm').validate({
                rules: {
                    name: {
                        required: true,
                        regex: /^[a-zA-Z\s.]+$/
                    },
                    email: {
                        required: true,
                        email: true,
                        regex: /^[a-z0-9._%+-]+@[a-z0-9.-]+\.com$/i
                    },
                    mob_no: {
                        required: true,
                        digits: true,
                        minlength: 10,
                        maxlength: 10,
                        // regex: /^[6-9]\d{9}$/
                        regex: /^\d{10}$/
                    },
                    age: {
                        required: true,
                        digits: true,
                        min: 18,
                        max: 100
                    },
                    role_id: "required",
                    division_id: "required",
                    district_id: "required",
                    block_id: "required",
                    password: {
                        required: false,
                        minlength: 8
                    },
                    'confirm-password': {
                        required: false,
                        equalTo: "[name='password']"
                    }
                },
                messages: {
                    name: {
                        required: "Please enter your name",
                        regex: "Only letters, spaces and dots are allowed"
                    },
                    email: {
                        required: "Email is required",
                        email: "Please enter a valid email address",
                        regex: "Only .com domains are allowed"
                    },
                    mob_no: {
                        required: "Mobile number is required",
                        digits: "Please enter only digits",
                        minlength: "Mobile number must be 10 digits",
                        maxlength: "Mobile number must be 10 digits",
                        regex: "Please enter a valid mobile number starting with 6-9"
                    },
                    age: {
                        required: "Age is required",
                        digits: "Please enter a valid age",
                        min: "Minimum age is 18",
                        max: "Maximum age is 100"
                    },
                    role_id: "Please select a role",
                    division_id: "Please select a division",
                    district_id: "Please select a district",
                    block_id: "Please select a block",
                    password: {
                        minlength: "Password must be at least 8 characters"
                    },
                    'confirm-password': {
                        equalTo: "Passwords do not match"
                    }
                },
                errorPlacement: function(error, element) {
                    error.addClass('text-danger');
                    error.insertAfter(element);
                },
                highlight: function(element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid');
                },
                invalidHandler: function(event, validator) {
                    let errors = validator.numberOfInvalids();
                    if (errors) {
                        $('#formErrors').removeClass('d-none').html(
                            'Please fix the errors in the form.');
                    } else {
                        $('#formErrors').addClass('d-none').html('');
                    }
                }
            });
        });
    </script>
@endsection
