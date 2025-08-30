@extends('appeal.layouts.app')


@section('content')
    <div class="page-content">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">{{ __('messages.AppealList') }}</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('messages.appeal') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('messages.ApplicationsList') }}</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">
                        <div class="table-responsive" style="overflow-x: auto;">

                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>{{ __('messages.SINo') }}</th>
                                        <th>{{ __('messages.appeal_no') }}</th>
                                        <th>{{ __('messages.district_dropdown') }}</th>
                                        <th>{{ __('messages.appellant_name') }}</th>
                                        <th>{{ __('messages.appellant_docs_view') }}</th>
                                        <th>{{ __('messages.appeal_against') }}</th>
                                        <th>{{ __('messages.appeal_against_docs_view') }}</th>
                                        <th>{{ __('messages.appeal_to') }}</th>
                                        <th>{{ __('messages.final_decisions') }}</th>
                                        <th>{{ __('messages.status') }}</th>
                                        <th>{{ __('messages.hiring_date') }}</th>
                                        <th>{{ __('messages.Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($appeals as $key => $appeal)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $appeal->appeal_no }}</td>
                                            <td>{{ @$appeal->district->name }}</td>
                                            <td>{{ $appeal->appellant_name ?? 'N/A' }}</td>
                                            <td>


                                                <button data-bs-target="#documentsModal"
                                                    data-aadhar="{{ asset($appeal->aadhar) ?? '' }}"
                                                    data-order="{{ asset($appeal->order) ?? '' }}"
                                                    data-evidence="{{ asset($appeal->evidence) ?? '' }}"
                                                    data-challan="{{ asset($appeal->challanreceipt) ?? '' }}"
                                                    data-bs-toggle="modal" class="btn btn-sm btn-info">View</button>
                                            </td>


                                            <td>
                                                @if ($appeal->appeal_against == '3')
                                                    ARCS
                                                @elseif ($appeal->appeal_against == '7')
                                                    Society
                                                @elseif ($appeal->appeal_against == '2')
                                                    Secretary
                                                @elseif ($appeal->appeal_against == '5')
                                                    DRCS
                                                @else
                                                    ---
                                                @endif

                                            </td>
                                            <td>
                                                @if (@$appeal->documents->status == '1')
                                                    <p class="uploaded-docs-btn">

                                                        <a href="{{ asset(@$appeal->documents->document_one) }}"
                                                            class="btn btn-sm btn-info" target="_blank">View</a>
                                                        <a href="{{ asset(@$appeal->documents->document_one) }}"
                                                            class="btn btn-sm btn-info" target="_blank">View</a>

                                                    </p>
                                                @else
                                                    ---
                                                @endif
                                            </td>


                                            <td>

                                                @if ($appeal->appeal_to == '3')
                                                    ARCS
                                                @elseif ($appeal->appeal_to == '7')
                                                    Society
                                                @elseif ($appeal->appeal_to == '2')
                                                    Secretary
                                                @elseif ($appeal->appeal_to == '5')
                                                    DRCS
                                                @elseif ($appeal->appeal_to == '6')
                                                    RCS
                                                @else
                                                    ---
                                                @endif
                                            </td>



                                            <td>
                                                {{-- <button class="btn btn-primary view-docs-btn btn-sm"
                                                    {{ @$appeal->status == 'Hiring' && (isset($appeal->hiring_date) && $appeal->hiring_date >= now()->toDateString()) ? '' : 'disabled' }}
                                                    data-id="{{ $appeal->id }}" data-bs-toggle="modal"
                                                    data-bs-target="#finalDecisionModal">
                                                    Final Decision
                                                </button> --}}


                                                @if (!$appeal->decision && @$appeal->appeal_by != Auth::user()->id)
                                                    <button class="btn btn-primary view-docs-btn btn-sm finalDecision"
                                                        {{ @$appeal->status == 'Hiring' && (isset($appeal->hiring_date) && $appeal->hiring_date >= now()->toDateString()) ? '' : 'disabled' }}
                                                        data-id="{{ $appeal->id }}"
                                                        data-decision="{{ $appeal->decision ? '1' : '0' }}"
                                                        data-bs-toggle="modal" data-bs-target="#finalDecisionModal">
                                                        Final Decision
                                                    </button>
                                                @else
                                                    
                                                    @if (@$appeal->decision)
                                                        <button class="btn btn-info view-docs-btn btn-sm"
                                                            data-id="{{ @$appeal->id }}"
                                                            data-document="{{ asset(@$appeal->decision->docs) }}"
                                                            data-remarks="{{ @$appeal->decision->remarks }}"
                                                            data-bs-toggle="modal" data-bs-target="#viewFinalDecisionModal">
                                                            View Decision
                                                        </button>
                                                    @else
                                                        ---
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    $status = $appeal->status ?? 'Pending';
                                                    $badgeClass = [
                                                        'Pending' => 'bg-secondary',
                                                        'Approved' => 'bg-success',
                                                        'Awaiting Documents' => 'bg-success',
                                                        'Rejected' => 'bg-danger',
                                                        'Hiring' => 'bg-warning',
                                                        'Final Decision Made' => 'bg-primary',
                                                        'Document Received'=>'bg-success'
                                                    ][$status];
                                                @endphp
                                                <span class="badge {{ $badgeClass }}">{{ $status }}</span>
                                            </td>

                                            <td>{{ @$appeal->hiring_date ?? '---' }}</td>


                                            <td>
                                                @if (in_array($appeal->appeal_to, [Auth::user()->role_id]) && $appeal->appeal_to != Auth::user()->id)
                                                    @if ($appeal->status == 'Pending')
                                                        <button class="btn btn-sm btn-primary btn-sm approve-appeal"
                                                            data-id="{{ $appeal->id }}" data-bs-toggle="modal"
                                                            data-bs-target="#approveModal">Accept</button>

                                                        <button class="btn btn-sm btn-danger btn-sm view-application"
                                                            data-id="{{ $appeal->id }}" data-bs-toggle="modal"
                                                            data-bs-target="#rejectModal">Reject</button>
                                                    @elseif ($appeal->status == 'Approved')
                                                        <button class="btn btn-sm btn-info btn-sm request-documents"
                                                            data-id="{{ $appeal->id }}" data-bs-toggle="modal"
                                                            data-bs-target="#requestDocumentsModal">Ask for
                                                            Documents</button>
                                                    @elseif ($appeal->status == 'Document Received')
                                                        <button class="btn btn-sm btn-info btn-sm request-hiring"
                                                            data-id="{{ $appeal->id }}"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#requestHiringModal">Assign Hiring</button>
                                                    {{-- @elseif ($appeal->status == 'Document Received')
                                                        <button class="btn btn-sm btn-info btn-sm request-documents"
                                                            data-id="{{ $appeal->id }}"
                                                            {{ @$appeal->documents->status == '0' ? 'disabled' : '' }}
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#requestHiringModal">Assign Hiring</button> --}}
                                                    @elseif ($appeal->status == 'Final Decision Made')
                                                        <span class="badge bg-info">Resolved</span>
                                                    @else
                                                        <span>---</span>
                                                    @endif
                                                @endif
                                                    <button class="btn btn-sm btn-primary btn-sm view-appeal"
                                                        data-appeal='{!! json_encode($appeal->toArray()) !!}' data-bs-toggle="modal"
                                                        data-bs-target="#appealViewModal">View</button>
                                            </td>

                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>


                <div class="modal fade" id="documentsModal" tabindex="-1" aria-labelledby="documentsModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="documentsModalLabel">Appellant Documents</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <h6>Aadhar Card</h6>
                                        <a href="#" target="_blank" class="btn btn-sm btn-primary mt-2"
                                            id="aadhar-download">View</a>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <h6>Order Upload</h6>
                                        <a href="#" target="_blank" class="btn btn-sm btn-primary mt-2"
                                            id="order-download">View</a>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <h6>Evidence File</h6>
                                        <a href="#" target="_blank" class="btn btn-sm btn-primary mt-2"
                                            id="evidence-download">View</a>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <h6>Challan Report</h6>
                                        <a href="#" target="_blank" class="btn btn-sm btn-primary mt-2"
                                            id="challan-download">View</a>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="rejectModalLabel">Reject Appeal</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form id="rejectForm" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <input type="hidden" name="appeal_id" id="reject_appeal_id">
                                    <div class="mb-3">
                                        <label for="rejection_remarks" class="form-label">Remarks <span
                                                class="text-danger">*</span></label>
                                        <textarea class="form-control" id="rejection_remarks" name="rejection_remarks" rows="3" required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="rejection_docs" class="form-label">Supporting Documents
                                            (Optional)</label>
                                        <input class="form-control" type="file" id="rejection_docs"
                                            name="rejection_docs" accept=".pdf,.jpg,.jpeg,.png">
                                        <small class="text-muted">Upload any supporting documents for this
                                            rejection</small>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger">Confirm Rejection</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                <div class="modal fade" id="finalDecisionModal" tabindex="-1" aria-labelledby="finalDecisionModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <form id="finalDecisionForm" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="appeal_id" id="finalappealId">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="finalDecisionModalLabel">Add Final Decision</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="remarks" class="form-label">Remarks</label>
                                        <textarea name="remarks" id="remarks" class="form-control" required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="document" class="form-label">Upload Document</label>
                                        <input type="file" name="document" id="document" class="form-control"
                                            required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Submit Decision</button>
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


                <div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="approveModalLabel">Accept Appeal</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form id="approveForm" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="appeal_id" id="approve_appeal_id">
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="respondent_phone" class="form-label">Respondent Officer Phone Number
                                            <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" pattern="[0-9]{10}" maxlength="10"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')" id="respondent_phone"
                                            name="respondent_phone" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="approval_remarks" class="form-label">Remarks</label>
                                        <textarea class="form-control" id="approval_remarks" name="approval_remarks" rows="3"></textarea>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Confirm Acceptance</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                <div class="modal fade" id="requestDocumentsModal" tabindex="-1"
                    aria-labelledby="requestDocumentsModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="requestDocumentsModalLabel">Ask For Documents</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form id="requestDocumentsForm" method="POST">
                                @csrf
                                <input type="hidden" name="appeal_id" id="request_documents_appeal_id">
                                <div class="modal-body">


                                    <div class="mb-3">
                                        <label for="request_message" class="form-label">Ask To<span
                                                class="text-danger">*</span></label>
                                        <select class="form-control" name="ask_to" id="" required>
                                            <option value="">Select</option>
                                            <option value="Appellant">Appellant</option>
                                            <option value="Respondent">Respondent Officer</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="request_message" class="form-label">Document Request Details <span
                                                class="text-danger">*</span></label>
                                        <textarea class="form-control" id="request_message" name="request_message" rows="5" required
                                            placeholder="Specify which documents you need from the appellant..."></textarea>
                                    </div>




                                    {{-- <div class="mb-3">
                                        <label for="hearing_date" class="form-label">Hearing Date <span
                                                class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="hearing_date" name="hearing_date"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="approval_remarks" class="form-label">Remarks</label>
                                        <textarea class="form-control" id="approval_remarks" name="approval_remarks" rows="3"></textarea>
                                    </div> --}}


                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Send Request</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>



                <div class="modal fade" id="requestHiringModal" tabindex="-1" aria-labelledby="requestHiringModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="requestHiringModalLabel">Assign Hiring</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form id="assignHiringForm" method="POST">
                                @csrf
                                <input type="hidden" name="appeal_id" id="hiring_appeal_id">
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="hiring_date" class="form-label">Hiring Date <span
                                                class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="hiring_date" name="hiring_date"
                                            required min="{{ date('Y-m-d') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="hiring_remark" class="form-label">Remarks <span
                                                class="text-danger">*</span></label>
                                        <textarea class="form-control" id="hiring_remark" name="hiring_remark" rows="3" required
                                            placeholder="Enter hiring details..."></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Assign Hiring</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                <div class="modal fade" id="viewFinalDecisionModal" tabindex="-1"
                    aria-labelledby="finalDecisionModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="finalDecisionModalLabel">Decision Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <h6>Remarks:</h6>
                                <p id="decisionRemarks"></p>

                                <h6 class="mt-3">Document:</h6>
                                <a id="decisionDocumentLink" href="#" target="_blank">View Document</a>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>




                <!-- Appeal View Modal -->
                <div class="modal fade" id="appealViewModal" tabindex="-1" aria-labelledby="appealViewModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="appealViewModalLabel">Appeal Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6>Basic Information</h6>
                                        <p><strong>Appeal No:</strong> <span id="modal-appeal-no"></span></p>
                                        <p><strong>Appellant Name:</strong> <span id="modal-appellant-name"></span></p>
                                        <p><strong>Father's Name:</strong> <span id="modal-father-name"></span></p>
                                        <p><strong>Phone:</strong> <span id="modal-phone"></span></p>
                                        <p><strong>Designation:</strong> <span id="modal-designation"></span></p>
                                        <p><strong>District:</strong> <span id="modal-district"></span></p>
                                        <p><strong>Address:</strong> <span id="modal-address"></span></p>
                                    </div>
                                    <div class="col-md-6">
                                        <h6>Case Details</h6>
                                        <p><strong>Type of Order:</strong> <span id="modal-order-type"></span></p>
                                        <p><strong>Order No:</strong> <span id="modal-order-no"></span></p>
                                        <p><strong>Subject:</strong> <span id="modal-subject"></span></p>
                                        <p><strong>Challan Amount:</strong> <span id="modal-challan-amt"></span></p>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-12">
                                        <h6>Documents</h6>
                                        <div class="d-flex flex-wrap gap-2">
                                            <a id="modal-aadhar-link" href="#"
                                                class="btn btn-sm btn-outline-primary" target="_blank">
                                                <i class="fas fa-id-card"></i> Aadhar
                                            </a>
                                            <a id="modal-signature-link" href="#"
                                                class="btn btn-sm btn-outline-primary" target="_blank">
                                                <i class="fas fa-signature"></i> Signature
                                            </a>
                                            <a id="modal-order-link" href="#"
                                                class="btn btn-sm btn-outline-primary" target="_blank">
                                                <i class="fas fa-file-alt"></i> Order
                                            </a>
                                            <a id="modal-evidence-link" href="#"
                                                class="btn btn-sm btn-outline-primary" target="_blank">
                                                <i class="fas fa-file-contract"></i> Evidence
                                            </a>
                                            <a id="modal-challan-link" href="#"
                                                class="btn btn-sm btn-outline-primary" target="_blank">
                                                <i class="fas fa-receipt"></i> Challan Receipt
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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



            function setDocumentLink(selector, filePath) {
                var element = $(selector);
                if (filePath && filePath !== 'null') {
                    // If filePath is already a full URL (e.g., starts with http), use as-is
                    // Otherwise, assume it's in public folder (e.g., /uploads/filename.pdf)
                    var fullPath = filePath.startsWith('http') ? filePath : '/' + filePath;
                    element.attr('href', fullPath);
                    element.removeClass('d-none');
                } else {
                    element.addClass('d-none');
                }
            }

            $('#appealViewModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var appealJson = button.attr('data-appeal');

                try {
                    var appealData = JSON.parse(appealJson);

                    $('#modal-appeal-no').text(appealData.appeal_no || 'N/A');
                    $('#modal-appellant-name').text(appealData.appellant_name || 'N/A');
                    $('#modal-father-name').text(appealData.father_name || 'N/A');
                    $('#modal-phone').text(appealData.phone_number || 'N/A');
                    $('#modal-designation').text(appealData.designation || 'N/A');
                    $('#modal-district').text(appealData.district?.name || appealData.district_id || 'N/A');
                    $('#modal-address').text(appealData.full_address || 'N/A');

                    $('#modal-order-type').text(appealData.typeoforder || 'N/A');
                    $('#modal-order-no').text(appealData.orderno || 'N/A');
                    $('#modal-subject').text(appealData.subject || 'N/A');
                    $('#modal-challan-amt').text(appealData.amtofchallan ?
                        '₹' + parseFloat(appealData.amtofchallan).toFixed(2) : 'N/A');

                    setDocumentLink('#modal-aadhar-link', appealData.aadhar);
                    setDocumentLink('#modal-signature-link', appealData.signature_of_appellant);
                    setDocumentLink('#modal-order-link', appealData.order);
                    setDocumentLink('#modal-evidence-link', appealData.evidence);
                    setDocumentLink('#modal-challan-link', appealData.challanreceipt);

                } catch (e) {
                    alert('Error loading appeal details');
                }
            });


            $('#viewFinalDecisionModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var remarks = button.data('remarks');
                var documentUrl = button.data('document');

                var modal = $(this);
                modal.find('#decisionRemarks').text(remarks || 'No remarks provided');

                var docLink = modal.find('#decisionDocumentLink');
                if (documentUrl) {
                    docLink.attr('href', documentUrl);
                    docLink.show();
                } else {
                    docLink.hide();
                }
            });


            $('.view-docs-btn').on('click', function() {
                // Get document paths from data attributes
                const aadharPath = $(this).data('aadhar');
                const orderPath = $(this).data('order');
                const evidencePath = $(this).data('evidence');
                const challanPath = $(this).data('challan');


                console.log(aadharPath, orderPath)

                // Set download links
                $('#aadhar-download').attr('href', aadharPath);
                $('#order-download').attr('href', orderPath);
                $('#evidence-download').attr('href', evidencePath);
                $('#challan-download').attr('href', challanPath);

                // Function to display documents
                const displayDocument = (elementId, filePath) => {
                    const viewer = $(`#${elementId}`);
                    viewer.empty();

                    if (!filePath) {
                        viewer.html('<p class="text-muted">No document available</p>');
                        return;
                    }

                    const extension = filePath.split('.').pop().toLowerCase();

                    if (['jpg', 'jpeg', 'png', 'gif'].includes(extension)) {
                        viewer.html(`<img src="${filePath}" class="img-fluid" alt="Document">`);
                    } else if (extension === 'pdf') {
                        viewer.html(`
                    <iframe src="${filePath}" 
                            style="width:100%; height:300px;" 
                            frameborder="0">
                    </iframe>
                `);
                    } else {
                        viewer.html('<p class="text-muted">Unsupported file format</p>');
                    }
                };

                // Display each document
                displayDocument('aadhar-viewer', aadharPath);
                displayDocument('order-viewer', orderPath);
                displayDocument('evidence-viewer', evidencePath);
                displayDocument('challan-viewer', challanPath);
            });




            $('.btn-danger.view-application').on('click', function() {
                var appealId = $(this).data('id');
                $('#reject_appeal_id').val(appealId);
                $('#rejectModal').modal('show');
            });

            // Handle form submission
            $('#rejectForm').on('submit', function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                console.log(formData)

                $.ajax({
                    url: "{{ route('appeal.reject') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('#rejectModal').find('button[type="submit"]').prop('disabled', true)
                            .html(
                                '<span class="spinner-border spinner-border-sm" role="status"></span> Processing...'
                            );
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#rejectModal').modal('hide');
                            location.reload(); // Refresh to show updated status
                        } else {
                            alert(response.message || 'Error processing rejection');
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            var errorMsg = Object.values(errors).join('\n');
                            alert('Validation errors:\n' + errorMsg);
                        } else {
                            alert('Server error. Please try again.');
                        }
                    },
                    complete: function() {
                        $('#rejectModal').find('button[type="submit"]').prop('disabled', false)
                            .text('Confirm Rejection');
                    }
                });
            });



            $('.view-docs-btn').on('click', function() {
                var appealId = $(this).closest('tr').find('[data-id]').data('id') || $(this).data('id');
                $('#appealId').val(appealId);
            });

            // Handle form submission
            


            $(document).on('click', '.finalDecision', function() {
                var appealId = $(this).data('id');
                $('#finalappealId').val(appealId);
            });


            $('#finalDecisionForm').on('submit', function(e) {
                e.preventDefault();

                let formData = new FormData(this);

                $.ajax({
                    url: '{{ route('appeal.final-decision.store') }}',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('#finalDecisionModal').find('button[type="submit"]').prop('disabled',
                                true)
                            .html(
                                '<span class="spinner-border spinner-border-sm" role="status"></span> Processing...'
                            );
                    },
                    success: function(response) {
                        $('#finalDecisionModal').modal('hide');
                        location.reload(); // Optional: reload to reflect changes
                    },
                    error: function(xhr) {
                        alert('Error: ' + xhr.responseJSON.message);
                    }
                });
            });


            

            $(document).on('click', '.approve-appeal', function() {
                var appealId = $(this).data('id');
                $('#approve_appeal_id').val(appealId);
            });




            

            $('#approveForm').on('submit', function(e) {
                e.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    url: "{{ route('appeal.approve') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('#approveModal').find('button[type="submit"]').prop('disabled', true)
                            .html(
                                '<span class="spinner-border spinner-border-sm" role="status"></span> Processing...'
                            );
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#approveModal').modal('hide');
                            location.reload();
                        } else {
                            alert(response.message || 'Error processing approval');
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            var errorMsg = Object.values(errors).join('\n');
                            alert('Validation errors:\n' + errorMsg);
                        } else {
                            alert('Server error. Please try again.');
                        }
                    },
                    complete: function() {
                        $('#approveModal').find('button[type="submit"]').prop('disabled', false)
                            .text('Confirm Approval');
                    }
                });
            });



            
        
            $(document).on('click', '.request-documents', function() {
                var appealId = $(this).data('id');
                $('#request_documents_appeal_id').val(appealId);
            });

            $('#requestDocumentsForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: "{{ route('appeal.request-documents') }}",
                    type: "POST",
                    data: $(this).serialize(),
                    beforeSend: function() {
                        $('#requestDocumentsModal').find('button[type="submit"]').prop(
                                'disabled', true)
                            .html(
                                '<span class="spinner-border spinner-border-sm" role="status"></span> Sending...'
                            );
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#requestDocumentsModal').modal('hide');
                            location.reload();
                        } else {
                            alert(response.message || 'Error sending document request');
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                 alert(value[0]);
                            });
                        } else {
                            alert('Server error. Please try again.');
                        }
                    },
                    complete: function() {
                        $('#requestDocumentsModal').find('button[type="submit"]').prop(
                                'disabled', false)
                            .text('Send Request');
                    }
                });
            });





            $(document).on('click', '.request-hiring', function() {
                var appealId = $(this).data('id');
                $('#hiring_appeal_id').val(appealId);
            });

            // Handle form submission
            $('#assignHiringForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: "{{ route('appeal.assign-hiring') }}",
                    type: "POST",
                    data: $(this).serialize(),
                    beforeSend: function() {
                        $('#requestHiringModal').find('button[type="submit"]').prop('disabled',
                                true)
                            .html(
                                '<span class="spinner-border spinner-border-sm" role="status"></span> Processing...'
                            );
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#requestHiringModal').modal('hide');
                            alert(response.message);
                            location.reload();
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                alert(value[0]);
                            });
                        } else {
                            alert('An error occurred. Please try again.');

                        }
                    },
                    complete: function() {
                        $('#requestHiringModal').find('button[type="submit"]').prop('disabled',
                                false)
                            .text('Assign Hiring');
                    }
                });
            });
        });
    </script>
@endsection
