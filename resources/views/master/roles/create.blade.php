@extends('layouts.app')
@section('title')
    {{ $title }}
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">{{ __('messages.create-new-role') }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="javascript: void(0);">{{ __('messages.CooperativesDepartment') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('messages.create-new-role') }}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('roles-store') }}">
                @csrf
                <div class="row">
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="form-group">
                            <strong>{{ __('messages.Role-Name') }}:</strong>
                            <input type="text" name="name" placeholder="{{ __('messages.Role-Name') }}"
                                class="form-control">
                        </div>
                    </div>

                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="form-group">
                            <strong>{{ __('messages.Display-Name') }}:</strong>
                            <input type="text" name="display_name" placeholder="{{ __('messages.Display-Name') }}"
                                class="form-control">
                        </div>
                    </div>

                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="form-group">
                            <strong>{{ __('messages.Description') }}:</strong>
                            <textarea class="form-control" name="description" id="" cols="3" rows="1"
                                placeholder="{{ __('messages.Description') }}..."></textarea>
                        </div>
                    </div>

                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="form-group">
                            <strong>{{ __('messages.Import-from-Role') }}:</strong>
                            <select name="import_from_role" id="import_from_role" class="form-select select2">
                                <option value="">--</option>
                                @foreach ($role as $item)
                                    <option value="{{ $item->id }}">{{ ucfirst($item->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 d-flex align-items-center gap-2">
                        <button type="submit" class="btn btn-success" style="height: 42px"><i class="fa fa-check me-1"></i>
                            {{ __('messages.submit') }}</button>
                        <a class="btn btn-warning" href="{{ route('roles') }}" style="height: 42px"><i
                                class="fa fa-arrow-left me-1"></i>
                            {{ __('messages.back') }}</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            $.validator.addMethod("letterswithspace", function(value, element) {
                return this.optional(element) || /^[a-zA-Z\s]+$/.test(value);
            }, "Only letters and spaces are allowed");

            // Form validation
            $('form').validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 3,
                        maxlength: 50,
                        letterswithspace: true
                    },
                    display_name: {
                        required: true,
                        minlength: 3,
                        maxlength: 50
                    },
                    description: {
                        required: false,
                        maxlength: 255
                    },
                    import_from_role: {
                        required: false // Explicitly set as not required
                    }
                },
                messages: {
                    name: {
                        required: "Please enter role name",
                        minlength: "Role name must be at least 3 characters",
                        maxlength: "Role name cannot exceed 50 characters",
                        letterswithspace: "Only letters and spaces are allowed"
                    },
                    display_name: {
                        required: "Please enter display name",
                        minlength: "Display name must be at least 3 characters",
                        maxlength: "Display name cannot exceed 50 characters"
                    },
                    description: {
                        maxlength: "Description cannot exceed 555 characters"
                    }

                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
                submitHandler: function(form) {
                    // Form submission handler
                    form.submit();
                }
            });
        });
    </script>
@endsection
