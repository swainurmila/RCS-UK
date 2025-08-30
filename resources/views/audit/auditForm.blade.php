@extends('layouts.app')

@section('content')
<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Audit Submission Form</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body p-0 dash-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form id="auditForm" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="audit_id" id="audit_id" value="">
                                <div class="card">
                                    <div class="card-body p-0">
                                        <!-- Step Navigation Tabs -->
                                        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="nav-link-1" data-bs-toggle="tab"
                                                    href="#step1" role="tab" aria-controls="step1" aria-selected="true">
                                                    <span class="d-none d-sm-block">Step 1</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="nav-link-2" data-bs-toggle="tab"
                                                    href="#step2" role="tab" aria-controls="step2" aria-selected="false">
                                                    <span class="d-none d-sm-block">Step 2</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="nav-link-3" data-bs-toggle="tab"
                                                    href="#step3" role="tab" aria-controls="step3" aria-selected="false">
                                                    <span class="d-none d-sm-block">Step 3</span>
                                                </a>
                                            </li>
                                        </ul>

                                        <!-- Step Content -->
                                        <div class="tab-content p-3 text-muted" id="myTabContent">
                                            <!-- Step 1: CA Details -->
                                            <div class="tab-pane fade show active" id="step1" role="tabpanel" aria-labelledby="nav-link-1">
                                                <h4 class="fw-bold mb-4">CA Details</h4>

                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label fw-bold">CA Firm Name</label>
                                                        <input type="hidden" class="form-control form-control-sm" name="audit_id" value="{{ $auditDetails->id??"" }}">
                                                        <input type="text" class="form-control form-control-sm" name="firm_name" value="{{ $auditDetails->ca_firm_name??"" }}">
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label fw-bold">Firm Registration Number</label>
                                                        <input type="number" class="form-control form-control-sm" name="firm_registration_number" value="{{ $auditDetails->ca_firm_reg_no??"" }}">
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label fw-bold">CA Name</label>
                                                        <input type="text" class="form-control form-control-sm" name="ca_name" value="{{ $auditDetails->ca_name??"" }}">
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label fw-bold">Membership Number</label>
                                                        <input type="number" class="form-control form-control-sm" name="membership_number" value="{{ $auditDetails->ca_membership_no??"" }}">
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label fw-bold">Audit Period</label>
                                                        <select class="form-select form-control" name="audit_period" id="audit_period">
                                                            <option value="">Select Period</option>
                                                            @foreach ($financial_year as $year)
                                                                <option value="{{ $year }}" {{ isset($auditDetails) && $auditDetails->audit_period == $year ? 'selected' : '' }}>{{ $year }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label fw-bold">Email ID</label>
                                                        <input type="email" class="form-control form-control-sm" name="email" value="{{ $auditDetails->ca_email??"" }}">
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label fw-bold">Address</label>
                                                        <textarea class="form-control form-control-sm" name="address">{{ $auditDetails->ca_address??"" }}</textarea>
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label fw-bold">Mobile No.</label>
                                                        <input type="text" class="form-control form-control-sm" name="mobile" value="{{ $auditDetails->ca_mobile_no??"" }}">
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label fw-bold">Website</label>
                                                        <input type="url" class="form-control form-control-sm" name="website" value="{{ $auditDetails->ca_website??"" }}">
                                                    </div>
                                                </div>

                                                <div class="text-end">
                                                    <button type="button" class="btn btn-primary next-step" data-step="1">
                                                        Next
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Step 2: Audit Type and Details -->
                                            <div class="tab-pane fade" id="step2" role="tabpanel" aria-labelledby="nav-link-2">
                                                <h4 class="fw-bold mb-4">Audit Details</h4>

                                                <div class="row mb-4">
                                                    <div class="col-md-12">
                                                        <label class="form-label fw-bold">Audit For</label>
                                                        <div class="d-flex justify-content-evenly">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="audit_for" id="audit_bank" value="1" {{ isset($auditDetails) && $auditDetails->audit_for == '1' ? 'checked' : '' }}
                                                                    onchange="showAuditDetails('bank')">
                                                                <label class="form-check-label ms-2" for="audit_bank">Bank</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="audit_for" id="audit_society" value="2" {{ isset($auditDetails) && $auditDetails->audit_for == '2' ? 'checked' : '' }}
                                                                    onchange="showAuditDetails('society')">
                                                                <label class="form-check-label ms-2" for="audit_society">Society</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Bank Details -->
                                                <div id="bank-details" style="display: {{ isset($auditDetails) && $auditDetails->audit_for == '1' ? 'block' : 'none' }}">
                                                <!-- <div id="bank-details" style="display:  none; "> -->
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label fw-bold">Bank Name</label>
                                                            <select class="form-select form-control" name="bank_name">
                                                                <option value="">Select Bank</option>
                                                                @foreach($bank as $bankname)
                                                                <option value="{{$bankname->id}}">{{$bankname->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label fw-bold">Bank Branch District</label>
                                                            <select class="form-select form-control" name="bank_branch_district">
                                                                <option value="">Select District</option>
                                                                @foreach($district as $dis)
                                                                <option value="{{$dis->id}}">{{$dis->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label fw-bold">Bank Branch Address</label>
                                                            <input type="text" class="form-control form-control-sm" name="bank_branch_address">
                                                        </div>

                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label fw-bold">Bank Head Office</label>
                                                            <input type="text" class="form-control form-control-sm" name="bank_head_office">
                                                        </div>
                                                    </div>
                                                    <h4 class="fw-bold mb-4">Upload Bank Docs</h4>
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label fw-bold">Bank Letter to RBI</label>
                                                            <input type="file" class="form-control form-control-sm" name="bank_letter_to_rbi">
                                                        </div>

                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label fw-bold">Balance Sheet</label>
                                                            <input type="file" class="form-control form-control-sm" name="bank_balance_sheet">
                                                        </div>

                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label fw-bold">Statement of Profit & Loss Amount</label>
                                                            <input type="file" class="form-control form-control-sm" name="bank_statement">
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label fw-bold">LFAR & Annexure BRANCH WISE</label>
                                                            <input type="file" class="form-control form-control-sm" name="bank_annexure">
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label fw-bold">Other Documents</label>
                                                            <input type="file" class="form-control form-control-sm" name="bank_other_file">
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Society Details -->
                                                <div id="society-details" style="display: {{ isset($auditDetails) && $auditDetails->audit_for == '2' ? 'block' : 'none' }}">
                                                    <h4 class="fw-bold mb-4">Society Located</h4>
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label fw-bold">Society District</label>
                                                            <select class="form-select form-control" id="society_district" name="society_district">
                                                                <option value="">Select District</option>
                                                                @foreach($district as $data)
                                                                <option value="{{ $data->id }}">{{ $data->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label fw-bold">Society Block</label>
                                                            <select class="form-select form-control" name="society_block" id="society_block">
                                                                <option value="">Select Block</option>
                                                                @foreach($blocks as $block)
                                                                <option value="{{ $block->id }}">{{ $block->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label fw-bold">Society Type</label>
                                                            <select class="form-select form-control" name="society_type">
                                                                <option value="">Select Type</option>
                                                                <option value="primary">Primary</option>
                                                                <option value="central">Central</option>
                                                                <option value="apex">Apex</option>   
                                                            </select>
                                                        </div>

                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label fw-bold">Society Sector</label>
                                                            <select class="form-select form-control" id="society_sector" name="society_sector">
                                                                <option value="">Select Sector</option>
                                                                @foreach($societySectors as $sector)
                                                                <option value="{{$sector->id}}">{{$sector->cooperative_sector_name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label fw-bold">Society Name</label>
                                                            <input type="text" class="form-control form-control-sm" name="society_name">
                                                        </div>

                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label fw-bold">Society Chairman Name</label>
                                                            <input type="text" class="form-control form-control-sm" name="society_chairman_name">
                                                        </div>

                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label fw-bold">Society Secretary Name</label>
                                                            <input type="text" class="form-control form-control-sm" name="society_secretary_name">
                                                        </div>

                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label fw-bold">Balance Sheet</label>
                                                            <input type="file" class="form-control form-control-sm" name="society_balance_sheet">
                                                        </div>

                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label fw-bold">Profit & Loss Statement</label>
                                                            <input type="file" class="form-control form-control-sm" name="profit_loss_statement">
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label fw-bold">Other Document</label>
                                                            <input type="file" class="form-control form-control-sm" name="society_other_docs">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="d-flex justify-content-between">
                                                    <button type="button" class="btn btn-secondary prev-step" data-step="2">
                                                        Previous
                                                    </button>
                                                    <button type="button" class="btn btn-primary next-step" data-step="2">
                                                        Next
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Step 3: Upload Documents -->
                                            <div class="tab-pane fade" id="step3" role="tabpanel" aria-labelledby="nav-link-3">
                                                <h4 class="fw-bold mb-4">Upload CA Report</h4>

                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label fw-bold">Auditor Certificate & Opinion</label>
                                                        <input type="file" class="form-control form-control-sm" name="auditor_certificate">
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label fw-bold">Audit Type</label>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="audit_type" id="special_audit" value="special">
                                                            <label class="form-check-label" for="special_audit">Special Audit</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="audit_type" id="general_audit" value="general">
                                                            <label class="form-check-label" for="general_audit">General Audit</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label fw-bold">Remark</label>
                                                        <textarea class="form-control form-control-sm" name="remark"></textarea>
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label fw-bold">Upload Signature</label>
                                                        <input type="file" class="form-control form-control-sm" name="signature">
                                                    </div>
                                                </div>

                                                <div class="d-flex justify-content-between">
                                                    <button type="button" class="btn btn-secondary prev-step" data-step="3">
                                                        Previous
                                                    </button>
                                                    <button type="button" class="btn btn-success" id="final-submit">
                                                        Submit
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
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
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tabs
        var tab = new bootstrap.Tab(document.querySelector('#nav-link-1'));
        tab.show();

        // Generate audit periods
        // generateAuditPeriods();
    });

    function showAuditDetails(type) {
        document.getElementById('bank-details').style.display = 'none';
        document.getElementById('society-details').style.display = 'none';

        if (type === 'bank') {
            document.getElementById('bank-details').style.display = 'block';
        } else if (type === 'society') {
            document.getElementById('society-details').style.display = 'block';
        }
    }

    /*function generateAuditPeriods() {
        const currentYear = new Date().getFullYear();
        const selectElement = document.getElementById('audit_period');

        while (selectElement.options.length > 1) {
            selectElement.remove(1);
        }

        for (let i = 0; i <= 10; i++) {
            const year = currentYear - i;
            const nextYear = year + 1;
            const optionText = `${year}-${nextYear}`;
            const optionValue = `${year}-${nextYear}`;

            const option = document.createElement('option');
            option.value = optionValue;
            option.textContent = optionText;
            selectElement.appendChild(option);
        }
    }*/

    // Navigation handlers
    document.querySelectorAll('.next-step').forEach(button => {
        button.addEventListener('click', function() {
            const step = this.getAttribute('data-step');
            saveStepData(step);
        });
    });

    document.querySelectorAll('.prev-step').forEach(button => {
        button.addEventListener('click', function() {
            const step = this.getAttribute('data-step');
            const prevTabId = step === '2' ? '1' : '2';
            const prevTab = document.querySelector(`#nav-link-${prevTabId}`);
            const tab = new bootstrap.Tab(prevTab);
            tab.show();
        });
    });

    document.getElementById('final-submit').addEventListener('click', function() {
        saveStepData(3);
    });

    function saveStepData(step) {
        const form = document.getElementById('auditForm');
        const formData = new FormData(form);
        formData.append('step', step);

        fetch("{{ route('audit.submit') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (data.audit_id) {
                        document.getElementById('audit_id').value = data.audit_id;
                    }

                    if (step == 1) {
                        const nextTab = document.querySelector('#nav-link-2');
                        const tab = new bootstrap.Tab(nextTab);
                        tab.show();
                    } else if (step == 2) {
                        const nextTab = document.querySelector('#nav-link-3');
                        const tab = new bootstrap.Tab(nextTab);
                        tab.show();
                    } else if (step == 3) {
                        const auditFor = formData.get('audit_for');

                        if (auditFor === 'bank') {
                            window.location.href = "{{ route('audits.bank') }}";
                        } else if (auditFor === 'society') {
                            window.location.href = "{{ route('audits.society') }}";
                        } else {
                            alert('Audit type not selected');
                        }
                    }
                } 
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while saving data');
            });
    }

    $('#society_district').on('change', function() {
            let districtId = this.value;
            $('#society_block').html('<option value="">Loading...</option>');
            if (districtId) {
                $("#society_district_err").text("");
                fetch(`/get-blocks/${districtId}`)
                    .then(response => response.json())
                    .then(data => {
                        let options = '<option value="">-- Select --</option>';
                        data.forEach(block => {
                            options += `<option value="${block.id}">${block.name}</option>`;
                        });
                        $('#society_block').html(options);
                    });
            } else {
                $('#society_block').html('<option value="">-- Select --</option>');
            }
        });
</script>
@endsection