@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">{{ __('messages.Section-34-Inspection') }}</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">
                                        {{ __('messages.cooperatives_department') }}
                                    </a>
                                </li>
                                <li class="breadcrumb-item active">{{ __('messages.Section-34-Inspection') }}</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card ">
                        <div class="card-body p-0">
                            <form method="POST" action="{{ route('store-inspection') }}" enctype="multipart/form-data">
                                @csrf
                                <fieldset>
                                    <legend>{{ __('messages.Section-34-Inspection') }}</legend>

                                    <div class="row">
                                        <div class="col-md-3 form-group">
                                            <label class="form-label"> {{ __('messages.Financial-year') }} <span
                                                    class="text-danger">*</span></label>
                                            <select id="financial_year_id" name="financial_year_id"
                                                class="form-select form-control select2">
                                                <option value="">{{ __('messages.Select-Financial-year') }}</option>
                                                @foreach ($financial_year as $financialyear)
                                                    <option value="{{ $financialyear->id }}"
                                                        {{ $loop->first ? 'selected' : '' }}>
                                                        {{ $financialyear->financial_year }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-3 form-group">
                                            <label class="form-label"> {{ __('messages.Inspection-Month') }} <span
                                                    class="text-danger">*</span></label>
                                            <select id="inspection_month" name="inspection_month"
                                                class="form-select form-control select2">
                                                <option value="">{{ __('messages.Select-Inspection-Month') }}
                                                </option>
                                                @foreach (range(1, 12) as $month)
                                                    <option value="{{ $month }}">
                                                        {{ \Carbon\Carbon::create()->month($month)->format('F') }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-3 form-group">
                                            <label class="form-label"> {{ __('messages.district') }} <span
                                                    class="text-danger">*</span></label>
                                            <select id="district_id" name="district_id"
                                                class="form-select form-control select2" onchange="getBlock(this)">
                                                <option value="">{{ __('messages.Select-District') }}
                                                </option>
                                                @foreach ($district as $districts)
                                                    <option value="{{ $districts->id }}">{{ $districts->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label class="form-label"> {{ __('messages.Block') }} <span
                                                    class="text-danger">*</span></label>
                                            <select id="block_id" name="block_id" class="form-select form-control select2">
                                                <option value="0">{{ __('messages.Select-Block') }}</option>
                                                @foreach ($block as $blocks)
                                                    <option value="{{ $blocks->id }}">{{ $blocks->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-3 form-group">
                                            <label class="form-label"> {{ __('messages.Type-of-society') }} <span
                                                    class="text-danger">*</span></label>
                                            <select id="society_type" name="society_type"
                                                class="form-select form-control select2">
                                                <option value="">{{ __('messages.Select-Type-of-society') }}</option>
                                                @foreach ($society_type as $societytype)
                                                    <option value="{{ $societytype->id }}">{{ $societytype->type }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-3 form-group">
                                            <label class="form-label"> {{ __('messages.Select-Society') }} <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select form-control select2" id="society_id"
                                                name="society_id">
                                                <option value="">{{ __('messages.Select-Society') }}
                                                </option>
                                                {{--  @foreach ($society as $societys)
                                                    <option value="{{ $societys->id }}"
                                                        {{ collect(old('society_id'))->contains($societys->id) ? 'selected' : '' }}>
                                                        {{ $societys->society_name }}
                                                    </option>
                                                @endforeach --}}
                                            </select>
                                        </div>

                                        <div class="col-md-3 form-group">
                                            <label class="form-label"> {{ __('messages.Assign-Officer') }} <span
                                                    class="text-danger">*</span></label>
                                            <select id="officer_id" name="officer_id"
                                                class="form-select form-control select2">
                                                <optgroup label="Choose Authority">
                                                    <option value="">--</option>
                                                    @foreach ($authority as $authoritys)
                                                        <option value="{{ $authoritys->id }}">
                                                            {{ strtoupper($authoritys->name) }}
                                                        </option>
                                                    @endforeach
                                                </optgroup>
                                                <optgroup label="Available Inspectors">
                                                    @foreach ($inspector as $inspectors)
                                                        <option value="{{ $inspectors->id }}">
                                                            {{ ucfirst($inspectors->name) }}
                                                        </option>
                                                    @endforeach
                                                </optgroup>
                                            </select>
                                        </div>

                                        {{-- <div class="col-md-3 form-group">
                                            <label>{{ __('messages.Inspection-Form') }}</label>
                                            <input type="file" class="form-control" id="File"
                                                name="inspection_attachment" />
                                        </div> --}}

                                        <div class="col-md-3 form-group">
                                            <label class="form-label"> {{ __('messages.Upload-Inspection-Form') }} <span
                                                    class="text-danger">*</span></label>
                                            <input type="file" class="form-control" id="File1"
                                                name="upload_inspection" />
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label"> {{ __('messages.Remarks') }} <span
                                                    class="text-danger">*</span></label>
                                            <textarea id="txtRemarks" name="remark" class="form-control" rows="10"></textarea>
                                        </div>

                                    </div><!-- end row -->

                                </fieldset>

                                <div class="row">
                                    <div class="col-lg-12 text-center">
                                        <button type="submit"
                                            class="btn btn-md btn-success px-3">{{ __('messages.submit') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('js')
<script>
    function getBlock(d) {
        var url = "{{ route('get-block') }}";
        var district_id = d.value;
        alert(district_id);
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
                    // Reset society_id when district changes
                    $('#society_id').html('<option value="">Select Society Name</option>');
                },
                error: function(error) {                    
                    console.error(error);
                }
            });
        } else {
            // If district is cleared, also clear block and society
            $('#block_id').empty();
            $('#society_id').html('<option value="">Select Society Name</option>');
        }
    }

    // Add change event for block_id
    $('#block_id').on('change', function() {
        // Reset society_id when block changes
        $('#society_id').html('<option value="">Select Society Name</option>');
        
        // Optionally, you can trigger society_type change if it's already selected
        let society_type = $('#society_type').val();
        if (society_type) {
            updateSocietyDropdown();
        }
    });

    $('#society_type').on('change', function() {
        updateSocietyDropdown();
    });

    // Common function to update society dropdown
    function updateSocietyDropdown() {
        let society_type = $('#society_type').val();
        let district_id = $('#district_id').val();
        let block_id = $('#block_id').val();

        if (society_type && district_id && block_id) {
            $.ajax({
                url: '{{ route('get.society.name') }}',
                type: 'GET',
                data: {
                    society_type: society_type,
                    district_id: district_id,
                    block_id: block_id
                },
                success: function(response) {
                    let options = '<option value="">Select Society Name</option>';
                    $.each(response, function(key, value) {
                        options += '<option value="' + value.id + '">' + value.society_name + '</option>';
                    });
                    $('#society_id').html(options);
                }
            });
        } else {
            $('#society_id').html('<option value="">Select Society Name</option>');
        }
    }
</script>

<script>
    $(document).ready(function() {
    // Add custom method for file extension validation
    $.validator.addMethod("fileExtension", function(value, element, param) {
        param = typeof param === "string" ? param.replace(/,/g, '|') : "pdf|doc|docx|xls|xlsx|jpg|jpeg|png";
        return this.optional(element) || value.match(new RegExp("\\.(" + param + ")$", "i"));
    }, "Please upload a valid file (PDF, DOC, DOCX, XLS, XLSX, JPG, JPEG, PNG)");

    // Form validation
    $('form').validate({
        rules: {
            financial_year_id: { required: true },
            inspection_month: { required: true },
            district_id: { required: true, min: 1 },
            block_id: { required: true, min: 1 },
            society_type: { required: true },
            society_id: { required: true },
            officer_id: { required: true },
            upload_inspection: {
                required: true,
                fileExtension: true,
                filesize: 10485760 // 10MB in bytes
            },
            remark: {
                required: true,
                minlength: 10,
                maxlength: 1000
            }
        },
        messages: {
            financial_year_id: { required: "Please select financial year" },
            inspection_month: { required: "Please select inspection month" },
            district_id: {
                required: "Please select district",
                min: "Please select valid district"
            },
            block_id: {
                required: "Please select block",
                min: "Please select valid block"
            },
            society_type: { required: "Please select society type" },
            society_id: { required: "Please select society" },
            officer_id: { required: "Please assign an officer" },
            upload_inspection: {
                required: "Please upload inspection form",
                fileExtension: "Only PDF, DOC, DOCX, XLS, XLSX, JPG, JPEG, PNG files allowed",
                filesize: "File size must be less than 10MB"
            },
            remark: {
                required: "Please enter remarks",
                minlength: "Remarks must be at least 10 characters",
                maxlength: "Remarks cannot exceed 1000 characters"
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
            $('button[type="submit"]').prop('disabled', true)
                .html('<i class="fas fa-spinner fa-spin"></i> Processing...');
            form.submit();
        }
    });

    // $('.select2').on('change', function() {
    //     $(this).valid();
    // });
});
</script>
@endsection
