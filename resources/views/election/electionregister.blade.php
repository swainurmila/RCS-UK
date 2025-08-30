@extends('layouts.app')

@section('content')
<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">{{ __('messages.app_rcs') }}</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="javascript: void(0);">{{ __('messages.cooperatives_department') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('messages.new_registration') }}</li>
                    </ol>
                </div>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body p-0 dash-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body p-0">
                                    <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active disabled" id="nav-link-1" data-bs-toggle="tab"
                                                href="javascript:void(0);" role="tab">
                                                <span class="d-none d-sm-block">{{ __('messages.step_01') }}</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link disabled" id="nav-link-2" data-bs-toggle="tab"
                                                href="javascript:void(0);" role="tab">
                                                <span class="d-none d-sm-block">{{ __('messages.step_02') }}</span>
                                            </a>
                                        </li>

                                    </ul>

                                    <div class="tab-content p-0 text-muted">
                                        <!-- Step 1: Basic Society Details -->
                                        <div class="tab-pane active" id="step1" role="tabpanel">
                                            <form id="step_form1">
                                                @csrf
                                                <input type="hidden" name="step" value="1">
                                                <input type="hidden" id="nomination_id" name="nomination_id" value="{{ $nomination->id ?? '' }}">

                                                <!-- Society Name -->
                                                <fieldset class="border p-3 mb-3">
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label fw-bold">{{ __('messages.societyname') }}<span class="text-danger">*</span></label>
                                                            <input class="form-control form-control-sm" type="text"
                                                                id="society_name" name="society_name"
                                                                placeholder="{{ __('messages.enter_societyname') }}"
                                                                value="{{ $nomination->society_name ?? '' }}"
                                                                onkeyup="validateData(this,'society_name')">
                                                            <span class="error" id="society_name_err"></span>
                                                        </div>
                                                    </div>
                                                </fieldset>

                                                <!-- Category of Society -->
                                                <fieldset class="border p-3 mb-3">
                                                    <div class="row">
                                                        <div class="col-md-12 mb-3">
                                                            <label class="form-label fw-bold">{{ __('messages.categoryofsociety') }} <span class="text-danger">*</span></label>
                                                            <div class="d-flex justify-content-evenly">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="society_category" id="primary" value="1"
                                                                        {{ (isset($nomination) && $nomination->society_category == '1') ? 'checked' : '' }}
                                                                        onchange="toggleSocietyTypeFields(this.value)">
                                                                    <label class="form-check-label ms-2" for="primary">Primary</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="society_category" id="central" value="2"
                                                                        {{ (isset($nomination) && $nomination->society_category == '2') ? 'checked' : '' }}
                                                                        onchange="toggleSocietyTypeFields(this.value)">
                                                                    <label class="form-check-label ms-2" for="central">Central</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="society_category" id="apex" value="3"
                                                                        {{ (isset($nomination) && $nomination->society_category == '3') ? 'checked' : '' }}
                                                                        onchange="toggleSocietyTypeFields(this.value)">
                                                                    <label class="form-check-label ms-2" for="apex">Apex</label>
                                                                </div>
                                                            </div>
                                                            <span class="error" id="society_category_err"></span>
                                                        </div>
                                                    </div>
                                                </fieldset>

                                                <!-- District and Block -->
                                                <fieldset class="border p-3 mb-3">
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3" id="district_field">
                                                            <label class="form-label fw-bold">{{ __('messages.district') }}<span class="text-danger">*</span></label>
                                                            <select class="form-select form-control select2"
                                                                name="district" id="district"
                                                                onchange="validateData(this,'district')">
                                                                <option value="">{{ __('messages.Select-District') }}</option>
                                                                @foreach ($districts as $district)
                                                                <option value="{{ $district->id }}" {{ old('district', $nomination->district_id ?? '') == $district->id ? 'selected' : '' }}>
                                                                    {{ $district->name }}
                                                                </option>
                                                                @endforeach

                                                            </select>
                                                            <span class="error" id="district_err"></span>
                                                        </div>
                                                        <div class="col-md-6 mb-3" id="block_field">
                                                            <label class="form-label fw-bold">{{ __('messages.Block') }}<span class="text-danger">*</span></label>
                                                            <select class="form-select form-control"
                                                                name="block" id="block"
                                                                onchange="validateData(this,'block')">
                                                                <option value="">{{ __('messages.Select-Block') }}</option>
                                                                @foreach ($blocks as $block)
                                                                <option value="{{ $block->id }}"
                                                                    @if(isset($nomination) && $block->id == $nomination->block_id) selected @endif>
                                                                    {{ $block->name }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                            <span class="error" id="block_err"></span>
                                                        </div>
                                                    </div>
                                                </fieldset>

                                                <!-- Registration Number -->
                                                <fieldset class="border p-3 mb-3">
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label fw-bold">{{ __('messages.Registration Number') }} <span class="text-danger">*</span></label>
                                                            <input class="form-control form-control-sm" type="text"
                                                                id="registration_number" name="registration_number"
                                                                placeholder="{{ __('messages.Enter registration number') }}"
                                                                value="{{ $nomination->registration_number ?? '' }}"
                                                                onkeyup="validateData(this,'registration_number')">
                                                            <span class="error" id="registration_number_err"></span>
                                                        </div>
                                                    </div>
                                                </fieldset>

                                                <!-- Total Number of Members -->
                                                <fieldset class="border p-3 mb-3">
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label fw-bold">{{ __('messages.totalnoofmembers') }} <span class="text-danger">*</span></label>
                                                            <input class="form-control form-control-sm" type="number"
                                                                id="total_members" name="total_members"
                                                                placeholder="{{ __('messages.entertotalmembers') }}"
                                                                value="{{ $nomination->total_members ?? '' }}"
                                                                onkeyup="validateData(this,'total_members')">
                                                            <span class="error" id="total_members_err"></span>
                                                        </div>
                                                    </div>
                                                </fieldset>

                                                <div class="d-flex justify-content-end">
                                                    <button class="btn btn-primary" type="button" id="submit_btn1"
                                                        onclick="nextStep(1)">{{__('messages.Save & Continue')}}</button>
                                                </div>
                                            </form>
                                        </div>

                                        <!-- Step 2: Document Upload -->
                                        <div class="tab-pane" id="step2" role="tabpanel">
                                            <form id="step_form2" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="step" value="2">
                                                <input type="hidden" id="nomination_id" name="nomination_id" value="{{ $nomination->id ?? '' }}">

                                                <!-- Society Formation Status -->
                                                <fieldset class="border p-3 mb-3">
                                                    <div class="row">
                                                        <div class="col-md-12 mb-3">
                                                            <label class="form-label fw-bold">{{ __('messages.isthissocietynewlyformed?') }} <span class="text-danger">*</span></label>
                                                            <div class="d-flex justify-content-evenly">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="is_new_society" id="new_society_yes" value="1"
                                                                        {{ (isset($nomination) && $nomination->is_new_society == '1') ? 'checked' : '' }}
                                                                        onchange="toggleNewSocietyFields(this.value)">
                                                                    <label class="form-check-label ms-2" for="new_society_yes">{{ __('messages.yes') }}</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="is_new_society" id="new_society_no" value="0"
                                                                        {{ (isset($nomination) && $nomination->is_new_society == '0') ? 'checked' : '' }}
                                                                        onchange="toggleNewSocietyFields(this.value)">
                                                                    <label class="form-check-label ms-2" for="new_society_no">{{ __('messages.no') }}</label>
                                                                </div>
                                                            </div>
                                                            <span class="error" id="is_new_society_err"></span>
                                                        </div>
                                                    </div>
                                                </fieldset>

                                                <!-- New Society Fields (Visible when is_new_society=1) -->
                                                <div id="new_society_fields" style="display: {{ (isset($nomination) && $nomination->is_new_society == '1') ? 'block' : 'none' }}">
                                                    <fieldset class="border p-3 mb-3">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label fw-bold">{{ __('messages.dateofformation') }}<span class="text-danger">*</span></label>
                                                                <input class="form-control form-control-sm" type="date"
                                                                    id="formation_date" name="formation_date"
                                                                    max="{{ date('Y-m-d') }}"
                                                                    value="{{ $nomination->formation_date ?? '' }}"
                                                                    onchange="validateData(this,'formation_date')">
                                                                <span class="error" id="formation_date_err"></span>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </div>

                                                <!-- Existing Society Fields (Visible when is_new_society=0) -->
                                                <div id="existing_society_fields" style="display: {{ (isset($nomination) && $nomination->is_new_society == '0') ? 'block' : 'none' }}">
                                                    <fieldset class="border p-3 mb-3">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label fw-bold">{{ __('messages.dateOflastelection') }}<span class="text-danger">*</span></label>
                                                                <input class="form-control form-control-sm" type="date"
                                                                    id="last_election_date" name="last_election_date"
                                                                    max="{{ date('Y-m-d') }}"
                                                                    value="{{ $nomination->last_election_date ?? '' }}"
                                                                    onchange="validateData(this,'last_election_date')">
                                                                <span class="error" id="last_election_date_err"></span>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label fw-bold">{{ __('messages.lastelectioncertificate') }} <span class="text-danger">*</span></label>
                                                                <input class="form-control form-control-sm" type="file"
                                                                    id="election_certificate" name="election_certificate"
                                                                    accept=".pdf,.jpg,.jpeg,.png"
                                                                    onchange="validateFile(this,'election_certificate')">
                                                                @if(isset($nomination) && $nomination->election_certificate)
                                                                <a href="javascript:void(0);" class="mt-2"
                                                                    onclick="viewAttachment('{{ asset('storage/'.$nomination->election_certificate) }}')">
                                                                    View Uploaded File
                                                                </a>
                                                                @endif
                                                                <span class="error" id="election_certificate_err"></span>
                                                            </div>
                                                        </div>
                                                    </fieldset>

                                                    <fieldset class="border p-3 mb-3">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label fw-bold">{{ __('messages.balancesheet') }}<span class="text-danger">*</span></label>
                                                                <input class="form-control form-control-sm" type="file"
                                                                    id="balance_sheet" name="balance_sheet"
                                                                    accept=".pdf,.jpg,.jpeg,.png"
                                                                    onchange="validateFile(this,'balance_sheet')">
                                                                @if(isset($nomination) && $nomination->balance_sheet)
                                                                <a href="javascript:void(0);" class="mt-2"
                                                                    onclick="viewAttachment('{{ asset('storage/'.$nomination->balance_sheet) }}')">
                                                                    View Uploaded File
                                                                </a>
                                                                @endif
                                                                <span class="error" id="balance_sheet_err"></span>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label fw-bold">{{ __('messages.auditreport') }} <span class="text-danger">*</span></label>
                                                                <input class="form-control form-control-sm" type="file"
                                                                    id="audit_report" name="audit_report"
                                                                    accept=".pdf,.jpg,.jpeg,.png"
                                                                    onchange="validateFile(this,'audit_report')">
                                                                @if(isset($nomination) && $nomination->audit_report)
                                                                <a href="javascript:void(0);" class="mt-2"
                                                                    onclick="viewAttachment('{{ asset('storage/'.$nomination->audit_report) }}')">
                                                                    View Uploaded File
                                                                </a>
                                                                @endif
                                                                <span class="error" id="audit_report_err"></span>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </div>

                                                <!-- Common Upload Fields -->
                                                <fieldset class="border p-3 mb-3">
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label fw-bold">{{ __('messages.uploadproposal') }} <span class="text-danger">*</span></label>
                                                            <input class="form-control form-control-sm" type="file"
                                                                id="proposal" name="proposal"
                                                                accept=".pdf,.jpg,.jpeg,.png"
                                                                onchange="validateFile(this,'proposal')">
                                                            @if(isset($nomination) && $nomination->proposal)
                                                            <a href="javascript:void(0);" class="mt-2"
                                                                onclick="viewAttachment('{{ asset('storage/'.$nomination->proposal) }}')">
                                                                View Uploaded File
                                                            </a>
                                                            @endif
                                                            <span class="error" id="proposal_err"></span>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label fw-bold">{{ __('messages.uploadmemberlist') }} <span class="text-danger">*</span></label>
                                                            <input class="form-control form-control-sm" type="file"
                                                                id="members_list" name="members_list"
                                                                accept=".pdf,.jpg,.jpeg,.png"
                                                                onchange="validateFile(this,'members_list')">
                                                            @if(isset($nomination) && $nomination->members_list)
                                                            <a href="javascript:void(0);" class="mt-2"
                                                                onclick="viewAttachment('{{ asset('storage/'.$nomination->members_list) }}')">
                                                                View Uploaded File
                                                            </a>
                                                            @endif
                                                            <span class="error" id="members_list_err"></span>
                                                        </div>
                                                    </div>
                                                </fieldset>

                                                <fieldset class="border p-3 mb-3">
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label fw-bold">{{ __('messages.uploadwardwisemember') }} <span class="text-danger">*</span></label>
                                                            <input class="form-control form-control-sm" type="file"
                                                                id="ward_allocation" name="ward_allocation"
                                                                accept=".pdf,.jpg,.jpeg,.png"
                                                                onchange="validateFile(this,'ward_allocation')">
                                                            @if(isset($nomination) && $nomination->ward_allocation)
                                                            <a href="javascript:void(0);" class="mt-2"
                                                                onclick="viewAttachment('{{ asset('storage/'.$nomination->ward_allocation) }}')">
                                                                View Uploaded File
                                                            </a>
                                                            @endif
                                                            <span class="error" id="ward_allocation_err"></span>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label fw-bold">{{ __('messages.uploadchallanreceipt') }} <span class="text-danger">*</span></label>
                                                            <input class="form-control form-control-sm" type="file"
                                                                id="challan_receipt" name="challan_receipt"
                                                                accept=".pdf,.jpg,.jpeg,.png"
                                                                onchange="validateFile(this,'challan_receipt')">
                                                            @if(isset($nomination) && $nomination->challan_receipt)
                                                            <a href="javascript:void(0);" class="mt-2"
                                                                onclick="viewAttachment('{{ asset('storage/'.$nomination->challan_receipt) }}')">
                                                                View Uploaded File
                                                            </a>
                                                            @endif
                                                            <span class="error" id="challan_receipt_err"></span>
                                                        </div>
                                                    </div>
                                                </fieldset>

                                                <!-- Authorized Persons -->
                                                <fieldset class="border p-3 mb-3">
                                                    <div class="row">
                                                        <div class="col-md-12 mb-3">
                                                            <label class="form-label fw-bold">{{ __('messages.secretarydetails') }} <span class="text-danger">*</span></label>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <input type="text" class="form-control form-control-sm"
                                                                        id="secretary_name" name="secretary_name"
                                                                        placeholder="Secretary Name"
                                                                        value="{{ $nomination->secretary_name ?? '' }}"
                                                                        onkeyup="validateData(this,'secretary_name')">
                                                                    <span class="error" id="secretary_name_err"></span>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <input type="file" class="form-control form-control-sm"
                                                                        id="secretary_signature" name="secretary_signature"
                                                                        accept=".jpg,.jpeg,.png"
                                                                        onchange="validateFile(this,'secretary_signature')">
                                                                    @if(isset($nomination) && $nomination->secretary_signature)
                                                                    <a href="javascript:void(0);" class="mt-2"
                                                                        onclick="viewAttachment('{{ asset('storage/'.$nomination->secretary_signature) }}')">
                                                                        View Uploaded Signature
                                                                    </a>
                                                                    @endif
                                                                    <span class="error" id="secretary_signature_err"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 mb-3">
                                                            <label class="form-label fw-bold">{{ __('messages.chairmandetails') }} <span class="text-danger">*</span></label>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <input type="text" class="form-control form-control-sm"
                                                                        id="chairman_name" name="chairman_name"
                                                                        placeholder="Chairman Name"
                                                                        value="{{ $nomination->chairman_name ?? '' }}"
                                                                        onkeyup="validateData(this,'chairman_name')">
                                                                    <span class="error" id="chairman_name_err"></span>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <input type="file" class="form-control form-control-sm"
                                                                        id="chairman_signature" name="chairman_signature"
                                                                        accept=".jpg,.jpeg,.png"
                                                                        onchange="validateFile(this,'chairman_signature')">
                                                                    @if(isset($nomination) && $nomination->chairman_signature)
                                                                    <a href="javascript:void(0);" class="mt-2"
                                                                        onclick="viewAttachment('{{ asset('storage/'.$nomination->chairman_signature) }}')">
                                                                        View Uploaded Signature
                                                                    </a>
                                                                    @endif
                                                                    <span class="error" id="chairman_signature_err"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </fieldset>

                                                <div class="d-flex justify-content-between">
                                                    <button class="btn btn-secondary" type="button"
                                                        onclick="showPreviousStep(1)">{{ __('messages.back') }}</button>
                                                    <button class="btn btn-primary" type="button" id="submit_btn2"
                                                        onclick="nextStep(2)">{{ __('messages.submitnomination') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        // Initialize form based on existing data
        if ($("input[name='society_category']:checked").val()) {
            toggleSocietyTypeFields($("input[name='society_category']:checked").val());
        }
        if ($("input[name='is_new_society']:checked").val()) {
            toggleNewSocietyFields($("input[name='is_new_society']:checked").val());
        }

        // District dropdown change event
        $('#district').on('change', function() {
            let districtId = this.value;
            $('#block').html('<option value="">Loading...</option>');
            if (districtId) {
                fetch(`/get-blocks/${districtId}`)
                    .then(response => response.json())
                    .then(data => {
                        let options = '<option value="">-- Select Block --</option>';
                        data.forEach(block => {
                            options += `<option value="${block.id}" ${(block.id == '{{ $nomination->block ?? '' }}') ? 'selected' : ''}>${block.name}</option>`;
                        });
                        $('#block').html(options);
                    });
            } else {
                $('#block').html('<option value="">-- Select Block --</option>');
            }
        });
    });

    function toggleSocietyTypeFields(category) {
        // Reset validation errors
        $('#district_err, #block_err').text('');

        if (category == 1) { // Primary
            $('#district_field, #block_field').show();
            $('#district').attr('required', true);
            $('#block').attr('required', true);
        } else if (category == 2) { // Central
            $('#district_field').show();
            $('#block_field').hide();
            $('#district').attr('required', true);
            $('#block').removeAttr('required');
        } else { // Apex
            $('#district_field, #block_field').hide();
            $('#district, #block').removeAttr('required');
        }
    }

    function toggleNewSocietyFields(isNew) {
        if (isNew == 1) { // New society
            $('#new_society_fields').show();
            $('#existing_society_fields').hide();
            $('#formation_date').attr('required', true);
            $('#last_election_date, #election_certificate, #balance_sheet, #audit_report').removeAttr('required');
        } else { // Existing society
            $('#new_society_fields').hide();
            $('#existing_society_fields').show();
            $('#formation_date').removeAttr('required');
            $('#last_election_date, #election_certificate, #balance_sheet, #audit_report').attr('required', true);
        }
    }

    function validateData(inputElement, field_id) {
        var field_val = inputElement.value;
        if (field_val != "") {
            $("#" + field_id + "_err").text("");
        }
    }

    function validateFile(inputElement, field_id) {
        const file = inputElement.files[0];
        const errorElement = $("#" + field_id + "_err");

        if (!file) {
            errorElement.text("Please select a file.");
            return;
        }

        // Check file type
        const validTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
        if (!validTypes.includes(file.type)) {
            errorElement.text("Invalid file format. Please upload PDF, JPEG, JPG or PNG.");
            inputElement.value = '';
            return;
        }

        // Check file size (5MB max for most files, 1MB for signatures)
        let maxSize = 5 * 1024 * 1024; // 5MB default
        if (field_id.includes('signature')) {
            maxSize = 1 * 1024 * 1024; // 1MB for signatures
        }

        if (file.size > maxSize) {
            errorElement.text(`File size exceeds ${maxSize/(1024*1024)}MB limit.`);
            inputElement.value = '';
            return;
        }

        errorElement.text("");
    }

    function validateStep(step) {
        let isValid = true;

        if (step == 1) {
            // Clear previous errors
            $('.error').text('');

            // Society Name
            if (!$("#society_name").val()) {
                $("#society_name_err").text("Enter Society Name.");
                isValid = false;
            }

            // Society Category
            if (!$("input[name='society_category']:checked").val()) {
                $("#society_category_err").text("Select Society Category.");
                isValid = false;
            }

            // District (if required)
            const category = $("input[name='society_category']:checked").val();
            if ((category == 1 || category == 2) && !$("#district").val()) {
                $("#district_err").text("Select District.");
                isValid = false;
            }

            // Block (if required)
            if (category == 1 && !$("#block").val()) {
                $("#block_err").text("Select Block.");
                isValid = false;
            }

            // Registration Number
            if (!$("#registration_number").val()) {
                $("#registration_number_err").text("Enter Registration Number.");
                isValid = false;
            }

            // Total Members
            if (!$("#total_members").val()) {
                $("#total_members_err").text("Enter Total Number of Members.");
                isValid = false;
            } else if (isNaN($("#total_members").val())) {
                $("#total_members_err").text("Enter a valid number.");
                isValid = false;
            }

        } else if (step == 2) {
            // Clear previous errors
            $('.error').text('');

            // New Society status
            if (!$("input[name='is_new_society']:checked").val()) {
                $("#is_new_society_err").text("Select if society is newly formed.");
                isValid = false;
            }

            // Conditional fields based on new society status
            const isNewSociety = $("input[name='is_new_society']:checked").val() == 1;

            if (isNewSociety) {
                // Formation date for new societies
                if (!$("#formation_date").val()) {
                    $("#formation_date_err").text("Enter Formation Date.");
                    isValid = false;
                }
            } else {
                // Existing society fields
                if (!$("#last_election_date").val()) {
                    $("#last_election_date_err").text("Enter Last Election Date.");
                    isValid = false;
                }

                // Check if file is uploaded or already exists
                if (!$("#election_certificate").val() && !$("a[onclick*='election_certificate']").length) {
                    $("#election_certificate_err").text("Upload Election Certificate.");
                    isValid = false;
                }

                if (!$("#balance_sheet").val() && !$("a[onclick*='balance_sheet']").length) {
                    $("#balance_sheet_err").text("Upload Balance Sheet.");
                    isValid = false;
                }

                if (!$("#audit_report").val() && !$("a[onclick*='audit_report']").length) {
                    $("#audit_report_err").text("Upload Audit Report.");
                    isValid = false;
                }
            }

            // Common upload fields
            if (!$("#proposal").val() && !$("a[onclick*='proposal']").length) {
                $("#proposal_err").text("Upload Proposal.");
                isValid = false;
            }

            if (!$("#members_list").val() && !$("a[onclick*='members_list']").length) {
                $("#members_list_err").text("Upload Members List.");
                isValid = false;
            }

            if (!$("#ward_allocation").val() && !$("a[onclick*='ward_allocation']").length) {
                $("#ward_allocation_err").text("Upload Ward Wise Members Allocation.");
                isValid = false;
            }

            if (!$("#challan_receipt").val() && !$("a[onclick*='challan_receipt']").length) {
                $("#challan_receipt_err").text("Upload Challan Receipt.");
                isValid = false;
            }

            // Authorized persons
            if (!$("#secretary_name").val()) {
                $("#secretary_name_err").text("Enter Secretary Name.");
                isValid = false;
            }

            if (!$("#secretary_signature").val() && !$("a[onclick*='secretary_signature']").length) {
                $("#secretary_signature_err").text("Upload Secretary Signature.");
                isValid = false;
            }

            if (!$("#chairman_name").val()) {
                $("#chairman_name_err").text("Enter Chairman Name.");
                isValid = false;
            }

            if (!$("#chairman_signature").val() && !$("a[onclick*='chairman_signature']").length) {
                $("#chairman_signature_err").text("Upload Chairman Signature.");
                isValid = false;
            }
        }

        return isValid;
    }

    function nextStep(stepVal) {
        var step = stepVal;
        if (step) {
            $("#submit_btn" + step).prop('disabled', true);
            let formValidate = validateStep(step);

            if (!formValidate) {
                $("#submit_btn" + step).prop('disabled', false);
                return;
            }

            var form_data = new FormData($("#step_form" + step)[0]);

            $.ajax({
                url: '{{ route("election.nomination.save") }}',
                method: 'POST',
                data: form_data,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.success) {
                        if (step < 2) {
                            // Move to next step
                            $("#nav-link-" + step).removeClass("active");
                            $("#nav-link-" + (step + 1)).addClass("active");
                            $("#step" + step).removeClass("active");
                            $("#step" + (step + 1)).addClass("active");

                            // Set nomination ID if this is the first save
                            if (response.nomination_id) {
                                $("#nomination_id").val(response.nomination_id);
                            }
                        } else {
                            // Final submission - show success and redirect
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Nomination submitted successfully!',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = "{{ route('show.election-dashboard') }}";
                            });
                        }
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message || 'Submission failed. Please try again.'
                        });
                    }
                    $("#submit_btn" + step).prop('disabled', false);
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Something went wrong. Please try again.'
                    });
                    $("#submit_btn" + step).prop('disabled', false);
                }
            });
        }
    }

    function showPreviousStep(previousStep) {
        $("#nav-link-" + (previousStep + 1)).removeClass("active");
        $("#nav-link-" + previousStep).addClass("active");
        $("#step" + (previousStep + 1)).removeClass("active");
        $("#step" + previousStep).addClass("active");
        $(".error").text("");
    }

    function viewAttachment(url) {
        window.open(url, '_blank', 'width=1000,height=800');
    }
</script>
@endsection