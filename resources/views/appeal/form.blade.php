@extends('appeal.layouts.app')


@section('content')
    <div class="page-content">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">{{ __('messages.appeal_form') }}</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a
                                    href="javascript: void(0);">{{ __('messages.cooperatives_department') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('messages.new_registration') }}</li>
                        </ol>
                    </div>
                </div>
                <p>({{ __('messages.section_06_up_act_2003') }})</p>
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
                                                <a class="nav-link active" id="step1-tab" data-bs-toggle="tab"
                                                    href="#step1" role="tab"
                                                    onclick="return validateTabAccess(1)"><span
                                                        class="d-none d-sm-block">{{ __('messages.appellant_details') }}</span></a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link disabled" id="step2-tab" data-bs-toggle="tab" href="#step2"
                                                    role="tab" onclick="return validateTabAccess(2)"><span
                                                        class="d-none d-sm-block">{{ __('messages.appeal_details') }}</span></a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link disabled" id="step3-tab" data-bs-toggle="tab" href="#step3"
                                                    role="tab" onclick="return validateTabAccess(3)"><span
                                                        class="d-none d-sm-block">{{ __('messages.appeal_against_appeal_to') }}</span></a>
                                            </li>
                                        </ul>

                                        <div class="tab-content p-3 text-muted">
                                            <div class="tab-pane active" id="step1" role="tabpanel">
                                                <form id="step_form1">
                                                    @csrf

                                                    <fieldset class="border p-3 mb-3">
                                                        <div class="row g-3">
                                                            <div class="col-md-6 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.appellant_name') }}:</label>
                                                                <span class="text-danger">*</span>
                                                                <input class="form-control form-control-sm" name="step"
                                                                    type="hidden" id="step1" value="1" />
                                                                <input class="form-control form-control-sm" type="text"
                                                                    onkeyup="validateData(this,'appellant_name')"
                                                                    id="appellant_name"
                                                                    placeholder="{{ __('messages.enter_appellantname') }}"
                                                                    name="appellant_name" />
                                                                <span class="error" id="appellant_name_err"></span>
                                                            </div>

                                                            <div class="col-md-6 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.father_name') }}:</label>
                                                                <span class="text-danger">*</span>
                                                                <input type="text" class="form-control"
                                                                    onkeyup="validateData(this,'father_name')"
                                                                    placeholder="{{ __('messages.enter_father_name') }}"
                                                                    name="father_name" id="father_name" />
                                                                <span class="error" id="father_name_err"></span>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.phone_number') }}:</label>
                                                                <span class="text-danger">*</span>
                                                                <input type="text" class="form-control" id="phone_number"
                                                                    onkeyup="validateData(this,'phone_number')"
                                                                    placeholder="{{ __('messages.enter_phonenumber') }}"
                                                                    name="phone_number" />
                                                                <span class="error" id="phone_number_err"></span>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.designation') }}:</label>
                                                                <span class="text-danger">*</span>
                                                                <input type="text" class="form-control"
                                                                    onkeyup="validateData(this,'designation')"
                                                                    placeholder="{{ __('messages.enter_designation') }}"
                                                                    id="designation" name="designation" />
                                                                <span class="error" id="designation_err"></span>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.district_dropdown') }}:</label>
                                                                <span class="text-danger">*</span>
                                                                <select class="form-select form-control"
                                                                    onchange="validateData(this,'district')"
                                                                    id="district" name="district">
                                                                    <option value="">{{ __('messages.district') }}
                                                                    </option>
                                                                    @foreach ($districts as $district)
                                                                        <option value="{{ $district->id }}">
                                                                            {{ $district->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <span class="error" id="district_err"></span>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.full_address') }}:</label>
                                                                <span class="text-danger">*</span>
                                                                <input type="text" class="form-control"
                                                                    id="full_address"
                                                                    onkeyup="validateData(this,'full_address')"
                                                                    placeholder="{{ __('messages.enter_full_address') }}"
                                                                    name="full_address" />
                                                                <span class="error" id="full_address_err"></span>
                                                            </div>

                                                            <div class="col-md-12 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.aadhar') }}:
                                                                    <span class="text-danger">*</span></label>
                                                                <input type="file" class="form-control form-control-sm"
                                                                    name="aadhar" accept="image/*,application/pdf"
                                                                    required onchange="validateData(this,'aadhar')" />
                                                                <span id="aadhar_err" class="error"></span>
                                                            </div>

                                                            <div class="col-md-12 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.signature_of_appellant') }}:
                                                                    <span class="text-danger">*</span></label>
                                                                <input type="file" class="form-control form-control-sm"
                                                                    name="signature_of_appellant"
                                                                    accept="image/*,application/pdf" required
                                                                    onchange="validateData(this,'signature_of_appellant')" />
                                                                <span id="signature_of_appellant_err"
                                                                    class="error"></span>
                                                            </div>
                                                        </div>
                                                    </fieldset>

                                                    <div>
                                                        <button class="btn btn-primary float-end" type="button"
                                                            id="submit_btn1"
                                                            onclick="nextStep(1)">{{ __('messages.next') }}</button>
                                                    </div>
                                                </form>
                                            </div>

                                            <div class="tab-pane" id="step2" role="tabpanel">
                                                <form id="step_form2" enctype="multipart/form-data">
                                                    @csrf

                                                    <fieldset class="border p-3 mb-3">
                                                        <div class="row g-3">
                                                            <div class="col-md-6 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.typeoforder') }}:</label>
                                                                <span class="text-danger">*</span>
                                                                <select class="form-select form-control"
                                                                    onchange="validateData(this,'typeoforder')"
                                                                    id="typeoforder" name="typeoforder">
                                                                    <option value="">
                                                                        {{ __('messages.typeoforder') }}</option>
                                                                    <option
                                                                        value="Refusal to register a cooperative society (Sec 7)">
                                                                        Refusal to register a cooperative society (Sec 7)
                                                                    </option>
                                                                    <option
                                                                        value="Refusal to register/amend bye-laws (Sec 12/14)">
                                                                        Refusal to register/amend bye-laws (Sec 12/14)
                                                                    </option>
                                                                    <option
                                                                        value="Award by arbitrator or board (Sec 71(1)/(2))">
                                                                        Award by arbitrator or board (Sec 71(1)/(2))
                                                                    </option>
                                                                    <option value="Winding up of society (Sec 72)">Winding
                                                                        up of society (Sec 72)</option>
                                                                    <option value="Liquidator's order under Sec 74(b)/(g)">
                                                                        Liquidator's order under Sec 74(b)/(g)</option>
                                                                    <option value="Property attachment order (Sec 94)">
                                                                        Property attachment order (Sec 94)</option>
                                                                    <option
                                                                        value="Annulment of resolution/revoking order (Sec 126)">
                                                                        Annulment of resolution/revoking order (Sec 126)
                                                                    </option>
                                                                </select>
                                                                <span class="error" id="typeoforder_err"></span>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.orderno') }}:</label>
                                                                <span class="text-danger">*</span>
                                                                <input class="form-control form-control-sm" name="step"
                                                                    type="hidden" id="step2" value="2" />
                                                                <input class="form-control form-control-sm" type="text"
                                                                    onkeyup="validateData(this,'orderno')" id="orderno"
                                                                    placeholder="{{ __('messages.enter_appellantname') }}"
                                                                    name="orderno" />
                                                                <span class="error" id="orderno_err"></span>
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.subject') }}:</label>
                                                                <span class="text-danger">*</span>
                                                                <input type="text" class="form-control"
                                                                    onkeyup="validateData(this,'subject')"
                                                                    placeholder="{{ __('messages.enter_subject') }}"
                                                                    name="subject" id="subject" />
                                                                <span class="error" id="subject_err"></span>
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.order_upload') }}:
                                                                    <span class="text-danger">*</span></label>
                                                                <input type="file" class="form-control form-control-sm"
                                                                    name="order" accept="image/*,application/pdf"
                                                                    required onchange="validateData(this,'order')" />
                                                                <span id="order_err" class="error"></span>
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.evidence') }}:
                                                                    <span class="text-danger">*</span></label>
                                                                <input type="file" class="form-control form-control-sm"
                                                                    name="evidence" accept="image/*,application/pdf"
                                                                    required onchange="validateData(this,'evidence')" />
                                                                <span id="evidence_err" class="error"></span>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.amtofchallan') }}:</label>
                                                                <span class="text-danger">*</span>
                                                                <input type="text" class="form-control"
                                                                    onkeyup="validateData(this,'amtofchallan')"
                                                                    placeholder="{{ __('messages.challanamt') }}"
                                                                    id="amtofchallan" name="amtofchallan" />
                                                                <span class="error" id="amtofchallan_err"></span>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.challanreceipt') }}:
                                                                    <span class="text-danger">*</span></label>
                                                                <input type="file" class="form-control form-control-sm"
                                                                    name="challanreceipt" accept="image/*,application/pdf"
                                                                    required
                                                                    onchange="validateData(this,'challanreceipt')" />
                                                                <span id="challanreceipt_err" class="error"></span>
                                                            </div>
                                                        </div>
                                                    </fieldset>

                                                    <div class="d-flex justify-content-between">
                                                        <button class="btn btn-secondary" type="button"
                                                            onclick="showPreviousStep(1)">{{ __('messages.back') }}</button>
                                                        <button class="btn btn-primary" type="button" id="submit_btn2"
                                                            onclick="nextStep(2)">{{ __('messages.next') }}</button>
                                                    </div>
                                                </form>
                                            </div>

                                            <div class="tab-pane" id="step3" role="tabpanel">
                                                <form id="step_form3" enctype="multipart/form-data">
                                                    @csrf

                                                    <fieldset class="border p-3 mb-3">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.appeal_against') }}:</label>
                                                                <span class="text-danger">*</span>
                                                                <select class="form-select form-control"
                                                                    onchange="updateAppealToOptions(this.value)"
                                                                    id="appeal_against" name="appeal_against">
                                                                    <option value="">
                                                                        {{ __('messages.appeal_against') }}</option>
                                                                    <option value="7">Society</option>
                                                                    <option value="3">ARCS</option>
                                                                    <option value="5">DRCS</option>
                                                                    <option value="6">RCS</option>
                                                                    <option value="2">Secretary</option>
                                                                </select>
                                                                <span class="error" id="typeoforder_err"></span>
                                                            </div>

                                                            <div class="col-md-6 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.district_dropdown') }}:</label>
                                                                <span class="text-danger">*</span>
                                                                <select class="form-select form-control"
                                                                    onchange="validateData(this,'appeal_against_district')"
                                                                    id="appeal_against_district"
                                                                    name="appeal_against_district">
                                                                    <option value="">
                                                                        {{ __('messages.appeal_against_district') }}
                                                                    </option>
                                                                    @foreach ($districts as $district)
                                                                        <option value="{{ $district->id }}">
                                                                            {{ $district->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <span class="error"
                                                                    id="appeal_against_district_err"></span>
                                                            </div>


                                                            <div class="col-md-6 mb-3" id="appeal_to_container"
                                                                style="display: none;">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.appeal_to') }}:</label>
                                                                <span class="text-danger">*</span>
                                                                <select class="form-select form-control" id="appeal_to"
                                                                    name="appeal_to">
                                                                    <option value="">{{ __('messages.appeal_to') }}
                                                                    </option>
                                                                    <!-- Options will be populated dynamically -->
                                                                </select>
                                                                <span class="error" id="appeal_to_err"></span>
                                                            </div>
                                                        </div>


                                                    </fieldset>

                                                    <div class="d-flex justify-content-between">
                                                        <button class="btn btn-secondary" type="button"
                                                            onclick="showPreviousStep(2)">{{ __('messages.back') }}</button>
                                                        <button class="btn btn-success" type="button" id="submit_btn3"
                                                            onclick="nextStep(3)">Save & Submit</button>
                                                    </div>
                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="viewModal" tabindex="-1" role="dialog"
                            aria-labelledby="viewModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Application Details</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div id="modalContent">Loading...</div>
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
        function toggleReason(show) {
            const reasonSection = document.getElementById('reason_section');
            const reasonField = reasonSection.querySelector('textarea');
            if (show) {
                reasonSection.style.display = 'block';
                reasonField.setAttribute('required', 'required');
            } else {
                reasonSection.style.display = 'none';
                reasonField.removeAttribute('required');
                reasonField.value = '';
            }
        }
    </script>

    <script>
        function updateAppealToOptions(appealAgainstValue) {
            const appealToContainer = $('#appeal_to_container');
            const appealToSelect = $('#appeal_to');

            // Clear previous options and hide by default
            appealToSelect.empty().append('<option value="">{{ __('messages.appeal_to') }}</option>');
            appealToContainer.hide();

            // Show and populate based on selected value
            switch (appealAgainstValue) {
                case '3':
                    appealToContainer.show();
                    appealToSelect.append('<option value="5">DRCS</option>');
                    appealToSelect.append('<option value="6">RCS</option>');
                    appealToSelect.append('<option value="2">Secretary</option>');
                    break;

                case '5':
                    appealToContainer.show();
                    appealToSelect.append('<option value="6">RCS</option>');
                    appealToSelect.append('<option value="2">Secretary</option>');
                    break;

                case '6':
                    appealToContainer.show();
                    appealToSelect.append('<option value="Secretary">2</option>');
                    break;
                case '7':
                    appealToContainer.show();
                    appealToSelect.append('<option value="3">ARCS</option>');
                    appealToSelect.append('<option value="5">DRCS</option>');
                    appealToSelect.append('<option value="6">RCS</option>');
                    appealToSelect.append('<option value="2">Secretary</option>');
                    break;

                case 'Secretary':
                    // Don't show the appeal_to field for Secretary
                    break;

                default:
                    // For RCS or any other unexpected value, don't show
                    break;
            }
        }


        let completedSteps = {
            step1: false,
            step2: false
        };

        // Disable all tab click events
        $('[data-bs-toggle="tab"]').on('click', function(e) {
            e.preventDefault();
            return false;
        });

        function enableTab(tabNumber) {
            // Enable the tab and make it look active
            $(`#step${tabNumber}-tab`)
                .removeClass('disabled')
                .attr('data-bs-toggle', 'tab')
                .attr('href', `#step${tabNumber}`);
        }


        function nextStep(step) {
            if (step === 1) {
                // Step 1 Validation
                let isValid = validateStep1();
                if (!isValid) return;
                completedSteps.step1 = true;

                // No AJAX call here, just move to next step
                $('#step1').removeClass('active');
                $('#step2').addClass('active');
                $('.nav-tabs a[href="#step1"]').removeClass('active');
                $('.nav-tabs a[href="#step2"]').addClass('active');

            } else if (step === 2) {
                // Step 2 Validation
                let isValid = validateStep2();
                if (!isValid) return;
                completedSteps.step2 = true;

                // No AJAX call here, just move to next step
                $('#step2').removeClass('active');
                $('#step3').addClass('active');
                $('.nav-tabs a[href="#step2"]').removeClass('active');
                $('.nav-tabs a[href="#step3"]').addClass('active');

                // Update review section with all collected data
                updateReviewSection();

            } else if (step === 3) {

                // Prepare final FormData with all steps
                let formData = new FormData();

                // Step 1 Data
                formData.append('appellant_name', $('#appellant_name').val().trim());
                formData.append('father_name', $('#father_name').val().trim());
                formData.append('phone_number', $('#phone_number').val().trim());
                formData.append('designation', $('#designation').val().trim());
                formData.append('district', $('#district').val().trim());
                formData.append('full_address', $('#full_address').val().trim());

                // Append file only if it exists
                let signatureFile = $('[name="signature_of_appellant"]')[0].files[0];
                if (signatureFile) {
                    formData.append('signature_of_appellant', signatureFile);
                }

                // Step 2 Data
                formData.append('typeoforder', $('#typeoforder').val().trim());
                formData.append('orderno', $('#orderno').val().trim());
                formData.append('subject', $('#subject').val().trim());
                formData.append('amtofchallan', $('#amtofchallan').val().trim());

                // Append files only if they exist
                let orderFile = $('[name="order"]')[0].files[0];
                if (orderFile) {
                    formData.append('order', orderFile);
                }

                let aadharFile = $('[name="aadhar"]')[0].files[0];
                if (aadharFile) {
                    formData.append('aadhar', aadharFile);
                }


                let evidenceFile = $('[name="evidence"]')[0].files[0];
                if (evidenceFile) {
                    formData.append('evidence', evidenceFile);
                }

                let challanReceiptFile = $('[name="challanreceipt"]')[0].files[0];
                if (challanReceiptFile) {
                    formData.append('challanreceipt', challanReceiptFile);
                }


                formData.append('appeal_against', $('#appeal_against').val().trim());
                formData.append('appeal_against_district', $('#appeal_against_district').val().trim());
                formData.append('appeal_to', $('#appeal_to').val().trim());




                // Final submission marker
                formData.append('final_submission', true);
                formData.append('_token', $('input[name="_token"]').val());


                // Submit final form
                $.ajax({
                    url: "{{ route('appeal.form.store') }}",
                    method: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#submit_btn3').prop('disabled', true)
                            .html(
                                '<span class="spinner-border spinner-border-sm" role="status"></span> Submitting...'
                            );
                    },
                    success: function(response) {
                        if (response.success) {
                            // Redirect on success
                            window.location.href = "{{ route('appeal.list') }}";
                        } else {
                            // Show error message
                            alert(response.message || 'Submission failed. Please try again.');
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            // Validation errors
                            let errors = xhr.responseJSON.errors;
                            let errorMessages = [];
                            $.each(errors, function(key, value) {
                                errorMessages.push(value[0]);
                            });
                            alert('Validation errors:\n' + errorMessages.join('\n'));
                        } else {
                            // Server error
                            alert('Server error. Please try again later.');
                        }
                    },
                    complete: function() {
                        $('#submit_btn3').prop('disabled', false).text('Final Submit');
                    }
                });
            }
        }

        function updateReviewSection() {
            // Personal Info
            $('#review_appellant_name').text($('#appellant_name').val());
            $('#review_father_name').text($('#father_name').val());
            $('#review_phone_number').text($('#phone_number').val());
            $('#review_designation').text($('#designation').val());
            $('#review_district').text($('#district option:selected').text());
            $('#review_full_address').text($('#full_address').val());

            // Appeal Info
            $('#review_typeoforder').text($('#typeoforder').val());
            $('#review_orderno').text($('#orderno').val());
            $('#review_subject').text($('#subject').val());
            $('#review_amtofchallan').text($('#amtofchallan').val());

            // Files info (just show if they exist)
            $('#review_signature').text($('[name="signature_of_appellant"]')[0].files[0] ? 'Uploaded' : 'Not uploaded');
            $('#review_order').text($('[name="order"]')[0].files[0] ? 'Uploaded' : 'Not uploaded');
            $('#review_evidence').text($('[name="evidence"]')[0].files[0] ? 'Uploaded' : 'Not uploaded');
            $('#review_challan').text($('[name="challanreceipt"]')[0].files[0] ? 'Uploaded' : 'Not uploaded');
        }

        function showPreviousStep(step) {
            if (step === 1) {
                $('#step2').removeClass('active');
                $('#step1').addClass('active');
                $('.nav-tabs a[href="#step1"]').tab('show');
            } else if (step === 2) {
                $('#step3').removeClass('active');
                $('#step2').addClass('active');
                $('.nav-tabs a[href="#step2"]').tab('show');
            }
        }

        function validateStep1() {
            let isValid = true;
            $('.error').text('');

            const appellantName = $('#appellant_name').val().trim();
            const fatherName = $('#father_name').val().trim();
            const phoneNumber = $('#phone_number').val().trim();
            const designation = $('#designation').val().trim();
            const district = $('#district').val().trim();
            const fullAddress = $('#full_address').val().trim();
            const signature = $('[name="signature_of_appellant"]')[0].files[0];

            if (!appellantName) {
                $('#appellant_name_err').text("Appellant name is required");
                isValid = false;
            }
            if (!fatherName) {
                $('#father_name_err').text("Father's name is required");
                isValid = false;
            }
            if (!phoneNumber) {
                $('#phone_number_err').text("Phone number is required");
                isValid = false;
            } else if (!/^\d{10}$/.test(phoneNumber)) {
                $('#phone_number_err').text("Enter a valid 10-digit phone number");
                isValid = false;
            }
            if (!designation) {
                $('#designation_err').text("Designation is required");
                isValid = false;
            }
            if (!district) {
                $('#district_err').text("Please select a district");
                isValid = false;
            }
            if (!fullAddress) {
                $('#full_address_err').text("Full address is required");
                isValid = false;
            }
            if (!signature) {
                $('#signature_of_appellant_err').text("Signature file is required");
                isValid = false;
            }

            return isValid;
        }

        function validateStep2() {
            let isValid = true;
            $('.error').text('');

            const typeOfOrder = $('#typeoforder').val().trim();
            const orderNo = $('#orderno').val().trim();
            const subject = $('#subject').val().trim();
            const orderFile = $('[name="order"]')[0].files[0];
            const evidenceFile = $('[name="evidence"]')[0].files[0];
            const amtOfChallan = $('#amtofchallan').val().trim();
            const challanReceipt = $('[name="challanreceipt"]')[0].files[0];

            if (!typeOfOrder) {
                $('#typeoforder_err').text("Type of order is required");
                isValid = false;
            }
            if (!orderNo) {
                $('#orderno_err').text("Order number is required");
                isValid = false;
            }
            if (!subject) {
                $('#subject_err').text("Subject is required");
                isValid = false;
            }
            if (!orderFile) {
                $('#order_err').text("Order file is required");
                isValid = false;
            }
            if (!evidenceFile) {
                $('#evidence_err').text("Evidence file is required");
                isValid = false;
            }
            if (!amtOfChallan) {
                $('#amtofchallan_err').text("Challan amount is required");
                isValid = false;
            } else if (!/^\d+(\.\d{1,2})?$/.test(amtOfChallan)) {
                $('#amtofchallan_err').text("Enter a valid amount");
                isValid = false;
            }
            if (!challanReceipt) {
                $('#challanreceipt_err').text("Challan receipt is required");
                isValid = false;
            }

            return isValid;
        }

        function submitStep(formData, step, submitBtn, currentStep, nextStep) {
            $.ajax({
                url: "{{ route('appeal.form.store') }}",
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $(submitBtn).prop('disabled', true).text('Saving...');
                },
                success: function(response) {
                    if (response.success) {
                        $(currentStep).removeClass('active');
                        $(nextStep).addClass('active');
                        // Update navigation tabs
                        $('.nav-tabs a[href="' + currentStep + '"]').removeClass('active');
                        $('.nav-tabs a[href="' + nextStep + '"]').addClass('active');
                    } else {
                        alert(response.message || 'Something went wrong');
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            $('#' + key + '_err').text(value[0]);
                        });
                    } else {
                        alert('Server error. Please try again.');
                    }
                },
                complete: function() {
                    $(submitBtn).prop('disabled', false).text(step === 1 ? 'Next' : 'Save & Continue');
                }
            });
        }

        function validateData(element, fieldName) {
            let value = $(element).val().trim();
            let isValid = true;

            switch (fieldName) {
                case 'appellant_name':
                case 'father_name':
                case 'designation':
                case 'subject':
                    if (!value) {
                        $('#' + fieldName + '_err').text("This field is required");
                        isValid = false;
                    } else {
                        $('#' + fieldName + '_err').text("");
                    }
                    break;

                case 'phone_number':
                    if (!value) {
                        $('#' + fieldName + '_err').text("Phone number is required");
                        isValid = false;
                    } else if (!/^\d{10}$/.test(value)) {
                        $('#' + fieldName + '_err').text("Enter a valid 10-digit phone number");
                        isValid = false;
                    } else {
                        $('#' + fieldName + '_err').text("");
                    }
                    break;

                case 'district':
                case 'typeoforder':
                    if (!value) {
                        $('#' + fieldName + '_err').text("Please select an option");
                        isValid = false;
                    } else {
                        $('#' + fieldName + '_err').text("");
                    }
                    break;

                case 'amtofchallan':
                    if (!value) {
                        $('#' + fieldName + '_err').text("Amount is required");
                        isValid = false;
                    } else if (!/^\d+(\.\d{1,2})?$/.test(value)) {
                        $('#' + fieldName + '_err').text("Enter a valid amount");
                        isValid = false;
                    } else {
                        $('#' + fieldName + '_err').text("");
                    }
                    break;
            }

            return isValid;
        }
    </script>
@endsection
