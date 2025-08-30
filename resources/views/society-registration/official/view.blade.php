@php
// In your view file, add this at the top as a safeguard
$verifiedCount = $verifiedCount ?? 0;
$totalDocuments = $totalDocuments ?? 8;
@endphp

<div class="card">
    <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs" id="societyTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="form-details-tab" data-bs-toggle="tab"
                    data-bs-target="#form-details" type="button" role="tab" aria-controls="form-details"
                    aria-selected="true">
                    Form Details
                </button>
            </li>
            @if(auth()->user()->role_id==4 && $verifiedCount == $totalDocuments)
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="inspection-report-tab" data-bs-toggle="tab"
                    data-bs-target="#inspection-report" type="button" role="tab"
                    aria-controls="inspection-report" aria-selected="false">
                    Inspection Report
                </button>
            </li>
            @endif
        </ul>
    </div>

    <div class="card-body">
        <div class="tab-content" id="societyTabsContent">
            <!-- Form Details Tab -->
            <div class="tab-pane fade show active" id="form-details" role="tabpanel" aria-labelledby="form-details-tab">
                <div class="accordion" id="formDetailsAccordion">
                    <!-- Society Details Section -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingSocietyDetails">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseSocietyDetails" aria-expanded="true"
                                aria-controls="collapseSocietyDetails">
                                Society Details
                            </button>
                        </h2>
                        <div id="collapseSocietyDetails" class="accordion-collapse collapse show"
                            aria-labelledby="headingSocietyDetails" data-bs-parent="#formDetailsAccordion">
                            <div class="accordion-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <th width="30%">Name of Proposed Cooperative Society</th>
                                                <td>{{ $societyDetails->society_name ?? 'NA' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Operational Area of the Society</th>
                                                <td>
                                                    {{ optional($members_objective)->society_operational_area ?? 'NA' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Is Credit Society?</th>
                                                <td>{{ optional($societyDetails->feasibilityReport)->is_credit_society ? 'Yes' : 'No' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Purpose of the Society</th>
                                                <td>{{ optional($members_objective)->society_objective ?? 'NA' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Value of One Share</th>
                                                <td>₹{{ optional($members_objective)->subscription_rate ?? 'NA' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Total Shares</th>
                                                <td>{{ optional($members_objective)->capital_amount ?? 'NA' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Authorized Share Capital</th>
                                                <td>₹{{ optional($members_objective)->authorized_capital ?? 'NA' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Total Share Capital</th>
                                                <td>₹{{ optional($members_objective)->total_capital ?? 'NA' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Full Name and Address of Main Promoter</th>
                                                <td>{{ optional($members_objective)->society_representative_name ?? 'N/A' }},
                                                    {{ optional($members_objective)->society_representative_address ?? 'NA' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Bank Name Associated with the Society</th>
                                                <td>{{ optional($societyDetails->feasibilityReport)->bank_name ?? 'NA' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Uploaded Documents Section -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingDocuments">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseDocuments" aria-expanded="false"
                                aria-controls="collapseDocuments">
                                Uploaded Documents Verification
                                @php
                                $verifiedCount = 0;
                                $totalDocuments = 8;
                                $documents = $societyDetails->registerDocuments ?? null;
                                $isADO = auth()->user()->role_id == 4;

                                if ($documents) {
                                $documentFields = ['meeting1', 'meeting2', 'meeting3', 'society_by_laws',
                                'all_id_proof', 'all_application_form', 'all_declaration_form', 'challan_proof'];

                                foreach ($documentFields as $field) {
                                if ($documents->{"{$field}_status"} === 'approved' || $documents->{"{$field}_status"} === 'rejected') {
                                $verifiedCount++;
                                }
                                }
                                }
                                @endphp
                                <span id="verificationBadge" class="badge bg-{{ $verifiedCount == $totalDocuments ? 'success' : ($verifiedCount > 0 ? 'warning' : 'danger') }} ms-2">
                                    {{ $verifiedCount }}/{{ $totalDocuments }} Verified
                                </span>

                            </button>
                        </h2>
                        <div id="collapseDocuments" class="accordion-collapse collapse"
                            aria-labelledby="headingDocuments" data-bs-parent="#formDetailsAccordion">
                            <div class="accordion-body">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i> Please verify each document individually. All documents must be approved before submitting the inspection report.
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="25%">Document</th>
                                                <th>File</th>
                                                <th width="15%">Status</th>
                                                <th width="25%">Remarks</th>
                                                <th width="20%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach([
                                            'Proposal Meeting 1' => 'meeting1',
                                            'Proposal Meeting 2' => 'meeting2',
                                            'Proposal Meeting 3' => 'meeting3',
                                            'By-Laws Document' => 'society_by_laws',
                                            'All Members ID Proofs' => 'all_id_proof',
                                            'Application Forms' => 'all_application_form',
                                            'Declaration Forms' => 'all_declaration_form',
                                            'Challan Receipt' => 'challan_proof'
                                            ] as $docName => $field)
                                            @php
                                            $currentStatus = $documents ? ($documents->{"{$field}_status"} ?? 'pending') : 'pending';
                                            $remarks = $documents->{"{$field}_remarks"} ?? '';
                                            $fileUrl = $documents ? asset('storage/' . $documents->{$field}) : '#';
                                            $hasFile = $documents && $documents->{$field};
                                            $isVerified = $currentStatus === 'approved';
                                            @endphp
                                            <tr id="docRow_{{ $field }}" data-document="{{ $field }}">

                                                <td>{{ $docName }}</td>
                                                <td>
                                                    @if($hasFile)
                                                    <a href="{{ $fileUrl }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-eye me-1"></i> View Document
                                                    </a>
                                                    @if($documents->{"{$field}_revised"})
                                                    <a href="{{ asset('storage/' . $documents->{"{$field}_revised"}) }}"
                                                        target="_blank"
                                                        class="btn btn-sm btn-outline-warning mt-1">
                                                        <i class="fas fa-file-edit me-1"></i> Revised Version
                                                    </a>
                                                    @endif
                                                    @else
                                                    <span class="badge bg-danger">Not Uploaded</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span id="statusBadge_{{ $field }}" class="status-badge badge bg-{{ $isVerified ? 'success' : ($currentStatus === 'rejected' ? 'danger' : 'warning') }}">
                                                        {{ ucfirst($currentStatus) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if($isADO && !$isVerified)
                                                    <textarea class="form-control verification-remarks"
                                                        rows="2"
                                                        placeholder="Enter remarks..."
                                                        id="remarks_{{ $field }}">{{ $remarks }}</textarea>
                                                    @else
                                                    {{ $remarks ?: 'N/A' }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($isADO && $hasFile && !$isVerified)
                                                    <div class="d-flex gap-2">
                                                        <select class="form-select form-select-sm verification-action"
                                                            id="action_{{ $field }}">
                                                            <option value="pending" {{ $currentStatus === 'pending' ? 'selected' : '' }}>Pending</option>
                                                            <option value="approved">Approve</option>
                                                            <option value="rejected">Reject</option>
                                                        </select>
                                                        <button class="btn btn-sm btn-primary verify-document-btn"
                                                            data-field="{{ $field }}"
                                                            data-application-id="{{ $societyAppDetail->id }}">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    </div>
                                                    @elseif($isVerified)
                                                    <span class="text-success">
                                                        <i class="fas fa-check-circle"></i> Verified
                                                    </span>
                                                    @elseif(!$isADO)
                                                    <span class="text-muted">Only ADO can verify</span>
                                                    @endif

                                                    @if($currentStatus === 'rejected' && $isADO)
                                                    <div class="mt-2">
                                                        <input type="file"
                                                            class="form-control form-control-sm revised-file d-none"
                                                            id="revised_{{ $field }}"
                                                            data-field="{{ $field }}">
                                                        <button class="btn btn-sm btn-outline-primary upload-revised-btn mt-1 w-100"
                                                            data-field="{{ $field }}"
                                                            data-application-id="{{ $societyAppDetail->id }}">
                                                            <i class="fas fa-upload me-1"></i> Upload Revised
                                                        </button>
                                                    </div>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    @if($isADO && $verifiedCount < $totalDocuments)
                                        <div class="alert alert-warning mt-3">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        Please verify all documents before proceeding with the inspection report.
                                </div>
                                @endif

                                @if($isADO && $verifiedCount == $totalDocuments)
                                <!-- <div class="text-end mt-3">
                                    <button class="btn btn-success complete-verification-btn"
                                        data-application-id="{{ $societyAppDetail->id }}">
                                        <i class="fas fa-check-circle me-2"></i> Complete Document Verification
                                    </button>
                                </div> -->
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Board Members Section -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingMembers">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseMembers" aria-expanded="false"
                            aria-controls="collapseMembers">
                            Board Members <span class="badge bg-primary ms-2">{{ count($members) }}</span>
                        </button>
                    </h2>
                    <div id="collapseMembers" class="accordion-collapse collapse"
                        aria-labelledby="headingMembers" data-bs-parent="#formDetailsAccordion">
                        <div class="accordion-body">
                            <div class="table-responsive" style="overflow-x: auto;">
                                <table class="table table-bordered table-striped">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Designation</th>
                                            <th>Gender</th>
                                            <th>Marital Status</th>
                                            <th>Father/Husband</th>
                                            <th>Business</th>
                                            <th style="min-width: 300px;">Documents</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($members as $key => $member)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $member->name ?? 'NA' }}</td>
                                            <td>{{ $member->designation ?? 'NA' }}</td>
                                            <td>
                                                {{ $member->gender == 1 ? 'Male' : ($member->gender == 2 ? 'Female' : ($member->gender == 3 ? 'Transgender' : 'N/A')) }}
                                            </td>
                                            <td>{{ $member->is_married == 1 ? 'Married' : 'Unmarried' }}</td>
                                            <td>{{ $member->father_spouse_name ?? 'NA' }}</td>
                                            <td>{{ $member->buisness_name ?? 'NA' }}</td>
                                            <td>
                                                <div class="d-flex flex-wrap gap-2" style="max-width: 400px; overflow-x: auto;">
                                                    @foreach([
                                                    'aadhar_no' => 'Aadhaar',
                                                    'membership_form' => 'Application',
                                                    'declaration1' => 'Declaration 1',
                                                    'declaration2' => 'Declaration 2',
                                                    'signature' => 'Signature'
                                                    ] as $doc => $label)
                                                    @if($member->{$doc})
                                                    @php
                                                    $url = asset('storage/' . $member->{$doc});
                                                    $extension = strtolower(pathinfo($member->{$doc}, PATHINFO_EXTENSION));
                                                    $iconClass = $extension === 'pdf' ? 'fa-file-pdf text-danger' : 'fa-file-image text-info';
                                                    @endphp
                                                    <a href="{{ $url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas {{ $iconClass }}"></i> {{ $label }}
                                                    </a>
                                                    @endif
                                                    @endforeach
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Final Action Buttons -->
            <div class="row mt-4">
                <div class="col-md-12 text-end">
                    @if(auth()->user()->role_id == 4)
                    <button class="btn btn-primary" id="proceedToInspectionBtn"
                        {{ $verifiedCount == $totalDocuments ? '' : 'disabled' }}>
                        <i class="fas fa-clipboard-check"></i> Proceed to Inspection
                    </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- Inspection Report Tab -->
        <div class="tab-pane fade" id="inspection-report" role="tabpanel" aria-labelledby="inspection-report-tab">
            <form id="inspectionReportForm">
                @csrf
                <input type="hidden" name="society_id" value="{{ $societyDetails->id ?? '' }}">

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="inspection_date" class="form-label">Date of Permanent Inspection</label>
                        <input type="date" class="form-control" id="inspection_date" name="permanent_inspection_date">
                    </div>
                    <span class="error" id="permanent_inspection_date_err"></span>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Member Knowledge and Enthusiasm</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="member_knowledge" id="knowledge_yes" value="1">
                            <label class="form-check-label" for="knowledge_yes">Yes</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="member_knowledge" id="knowledge_no" value="0">
                            <label class="form-check-label" for="knowledge_no">No</label>
                        </div>
                        <span class="error" id="member_knowledge_err"></span>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Panchayat Suitability</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="panchayat_suitability" id="suitability_yes" value="1">
                            <label class="form-check-label" for="suitability_yes">Yes</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="panchayat_suitability" id="suitability_no" value="0">
                            <label class="form-check-label" for="suitability_no">No</label>
                        </div>
                        <span class="error" id="panchayat_suitability_err"></span>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">80% Member Willingness</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="family_wilingness" id="willingness_yes" value="1">
                            <label class="form-check-label" for="willingness_yes">Yes</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="family_wilingness" id="willingness_no" value="0">
                            <label class="form-check-label" for="willingness_no">No</label>
                        </div>
                        <div id="willingness_reason_div" class="mt-2" style="display: none;">
                            <label for="willingness_reason" class="form-label">Reason</label>
                            <textarea class="form-control" id="willingness_reason" name="family_wilingness_reason" rows="2"></textarea>
                            <span class="error" id="family_wilingness_reason_err"></span>
                        </div>
                        <span class="error" id="family_wilingness_err"></span>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Capital from Bank Availability</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="is_bank_capital_available" id="capital_yes" value="1">
                            <label class="form-check-label" for="capital_yes">Yes</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="is_bank_capital_available" id="capital_no" value="0">
                            <label class="form-check-label" for="capital_no">No</label>
                        </div>
                        <span class="error" id="is_bank_capital_available_err"></span>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="authority_name" class="form-label">Authority Person Name</label>
                        <input type="text" class="form-control" id="authority_name" name="authority_name">
                        <span class="error" id="authority_name_err"></span>
                    </div>
                    <div class="col-md-6">
                        <label for="authority_designation" class="form-label">Designation</label>
                        <input type="text" class="form-control" id="authority_designation" name="authority_designation">
                        <span class="error" id="authority_designation_err"></span>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="authority_signature" class="form-label">Upload Signature</label>
                        <input type="file" class="form-control" id="authority_signature" name="authority_signature">
                        <span class="error" id="authority_signature_err"></span>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-12 text-end">
                        <button type="button" class="btn btn-primary" id="saveInspectionReport">
                            <i class="fas fa-save"></i> Save & Submit
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>

<!-- Document Viewer Modal -->
<div class="modal fade" id="documentViewerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Document Viewer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <iframe id="documentFrame" src="" style="width:100%; height:70vh; border:none;"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="#" id="downloadDocLink" class="btn btn-primary" download>
                    <i class="fas fa-download"></i> Download
                </a>
            </div>
        </div>
    </div>
</div>