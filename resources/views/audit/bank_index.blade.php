@extends('layouts.app')
@section('content')
@php
$roleId = auth()->user()->role_id;
@endphp
<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">{{ __('messages.SocietyRegistrationApplicationsList') }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="javascript: void(0);">{{ __('messages.CooperativesDepartment') }}</a></li>
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
                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>SI No</th>
                                <th>Audit Ref No</th>
                                <th>Bank Name</th>
                                <th>Branch</th>
                                <th>District</th>
                                <th>CA Firm</th>
                                <th>Status</th>
                                <th>Submission Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bankAudits as $key => $audit)
                            <tr>
                                <td>{{ $bankAudits->firstItem() + $key }}</td>
                                <td>{{ $audit->audit_ref_no ?? 'N/A' }}</td>
                                <td>{{ $audit->bankDetails->bank->name ?? 'N/A' }}</td>
                                <td>{{ $audit->bankDetails->branch_name ?? 'N/A' }}</td>
                                <td>{{ $audit->bankDetails->districtRelation->name ?? 'N/A' }}</td>
                                <td>{{ $audit->ca_firm_name ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge bg-{{ $audit->status == 'approved' ? 'success' : ($audit->status == 'rejected' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($audit->status) }}
                                    </span>
                                </td>
                                <td>{{ $audit->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <a href="" class="btn btn-sm btn-info" title="View">
                                        <i class="mdi mdi-eye-outline"></i>
                                    </a>

                                    @if($roleId == 7 && in_array($audit->status, ['pending', 'rejected']))
                                    <a href="" class="btn btn-sm btn-primary" title="Edit">
                                        <i class="mdi mdi-pencil-outline"></i>
                                    </a>
                                    @endif

                                    @can('take_action', $audit)
                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#actionModal" data-audit-id="{{ $audit->id }}">
                                        Take Action
                                    </button>
                                    @endcan
                                </td>
                            </tr>
                            @endforeach

                            @if($bankAudits->isEmpty())
                            <tr>
                                <td colspan="9" class="text-center">No bank audits found.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div> <!-- End Card Body -->

            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="actionModal" tabindex="-1" aria-labelledby="actionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="actionForm" method="POST" action="{{ route('applications.takeAction') }}"
            enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="application_id" id="appIdInput">
            <input type="hidden" name="current_role" id="currentRoleInput">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('messages.Take-Action') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div id="formErrors" class="alert alert-danger d-none"></div>

                    <div class="mb-3">
                        <label for="actionSelect" class="form-label">{{ __('messages.action') }}</label><span
                            class="text-danger">*</span>
                        <select name="action" id="actionSelect" class="form-select">
                            <option value="approve">{{ __('messages.Approve') }}</option>
                            <option value="reject">{{ __('messages.Reject') }}</option>
                            <option value="revert">{{ __('messages.Revert') }}</option>
                            @if (auth()->user()->getRoleNames()->first() != 'arcs')
                            <option value="resend_for_recheck">{{ __('messages.Send-for-Re-Check') }}</option>
                            @endif

                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="remarks" class="form-label">{{ __('messages.Remarks') }}</label><span
                            class="text-danger">*</span>
                        <textarea name="remarks" id="remarks" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="files" class="form-label">{{ __('messages.Attach-Files') }}</label><span
                            class="text-danger">*</span>
                        <input type="file" name="files[]" id="files" class="form-control" multiple>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">{{ __('messages.submit') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="historyModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="historyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('messages.Society-Registration-Application-History') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="historyModalBody">
                <div class="text-center py-4">Loading...</div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="viewSocietyModal" tabindex="-1" aria-labelledby="viewSocietyModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewSocietyModalLabel">{{ __('messages.SocietyDetails') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="viewModalBody">
                <div class="text-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<!-- Minimal required set -->
<script>
    $(document).ready(function() {
        // Action modal initialization
        $('#actionModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var appId = button.data('app-id');
            var currentRole = button.data('current-role');

            $('#appIdInput').val(appId);
            $('#currentRoleInput').val(currentRole);
        });

        // Inspection report validation logic
        $(document).on('change', 'input[name="family_wilingness"]', function() {
            if ($(this).val() === '0') {
                $('#willingness_reason_div').show();
            } else {
                $('#willingness_reason_div').hide();
                $('#willingness_reason').val('');
                $('#family_wilingness_reason_err').text('');
            }
        });

        // Real-time validation for all fields
        $(document).on('change', 'input[name="permanent_inspection_date"]', function() {
            if ($(this).val()) {
                $('#permanent_inspection_date_err').text('');
            }
        });

        $(document).on('change', 'input[name="member_knowledge"]', function() {
            $('#member_knowledge_err').text('');
        });

        $(document).on('change', 'input[name="panchayat_suitability"]', function() {
            $('#panchayat_suitability_err').text('');
        });

        $(document).on('change', 'input[name="family_wilingness"]', function() {
            $('#family_wilingness_err').text('');
            if ($(this).val() === '1') {
                $('#family_wilingness_reason_err').text('');
            }
        });

        $(document).on('input', '#willingness_reason', function() {
            if ($(this).val().trim()) {
                $('#family_wilingness_reason_err').text('');
            }
        });

        $(document).on('change', 'input[name="is_bank_capital_available"]', function() {
            $('#is_bank_capital_available_err').text('');
        });

        $(document).on('input', '#authority_name', function() {
            if ($(this).val().trim()) {
                $('#authority_name_err').text('');
            }
        });

        $(document).on('input', '#authority_designation', function() {
            if ($(this).val().trim()) {
                $('#authority_designation_err').text('');
            }
        });

        $(document).on('change', '#authority_signature', function() {
            if (this.files.length > 0) {
                $('#authority_signature_err').text('');
            }
        });


        // Inspection report submission
        $(document).on('click', '#saveInspectionReport', function(e) {
            e.preventDefault();
            let isValid = true;

            // Reset error messages
            $('.error').text('');

            // Validate date of permanent inspection
            const inspectionDate = $('#inspection_date').val();
            if (!inspectionDate) {
                $('#permanent_inspection_date_err').text('Date of Permanent Inspection is required.');
                isValid = false;
            }

            // Validate member knowledge
            if (!$('input[name="member_knowledge"]:checked').length) {
                $('#member_knowledge_err').text('Member Knowledge and Enthusiasm is required.');
                isValid = false;
            }

            // Validate panchayat suitability
            if (!$('input[name="panchayat_suitability"]:checked').length) {
                $('#panchayat_suitability_err').text('Panchayat Suitability is required.');
                isValid = false;
            }

            // Validate family willingness
            if (!$('input[name="family_wilingness"]:checked').length) {
                $('#family_wilingness_err').text('80% Member Willingness is required.');
                isValid = false;
            } else if ($('input[name="family_wilingness"]:checked').val() === '0' && !$('#willingness_reason').val().trim()) {
                $('#family_wilingness_reason_err').text('Reason is required if willingness is No.');
                isValid = false;
            }

            // Validate bank capital availability
            if (!$('input[name="is_bank_capital_available"]:checked').length) {
                $('#is_bank_capital_available_err').text('Capital from Bank Availability is required.');
                isValid = false;
            }

            // Validate authority person name
            const authorityName = $('#authority_name').val();
            if (!authorityName) {
                $('#authority_name_err').text('Authority Person Name is required.');
                isValid = false;
            }

            // Validate authority designation
            const authorityDesignation = $('#authority_designation').val();
            if (!authorityDesignation) {
                $('#authority_designation_err').text('Designation is required.');
                isValid = false;
            }

            // Validate authority signature file
            const authoritySignature = $('#authority_signature')[0].files[0];
            if (!authoritySignature) {
                $('#authority_signature_err').text('Upload Signature is required.');
                isValid = false;
            }

            if (isValid) {
                const form = $('#inspectionReportForm')[0];
                const formData = new FormData(form);

                $.ajax({
                    url: "{{ route('society.inspectionReport.store') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Success',
                            text: 'Inspection report saved successfully',
                            icon: 'success'
                        }).then(() => {
                            // Optional: Redirect or refresh the page
                            window.location.reload();
                        });
                    },
                    error: function(xhr) {
                        let errorMessage = 'Error saving inspection report';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                            errorMessage = Object.values(xhr.responseJSON.errors).join('<br>');
                        }

                        Swal.fire({
                            title: 'Error',
                            html: errorMessage,
                            icon: 'error'
                        });
                    }
                });
            } else {
                // Scroll to the first error
                $('html, body').animate({
                    scrollTop: $('.error:visible:first').offset().top - 100
                }, 500);
            }
        });


        $(document).on('click', '.verify-document-btn', function() {
            const field = $(this).data('field');
            const appId = $(this).data('application-id');
            const action = $(`#action_${field}`).val();
            const remarks = $(`#remarks_${field}`).val().trim();

            if (action === 'pending') {
                Swal.fire('Error', 'Please select either Approve or Reject', 'error');
                return;
            }

            if (action === 'rejected' && !remarks) {
                Swal.fire('Error', 'Please enter remarks when rejecting a document', 'error');
                return;
            }

            Swal.fire({
                title: 'Confirm Verification',
                text: `Are you sure you want to ${action} this document?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: `Yes, ${action}`,
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route("document.verify") }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            application_id: appId,
                            field: field,
                            status: action,
                            remarks: remarks
                        },
                        success: function(response) {
                            // Update the status badge
                            const statusBadge = $(`#statusBadge_${field}`);
                            statusBadge.removeClass('bg-warning bg-danger bg-success')
                                .addClass(action === 'approved' ? 'bg-success' : 'bg-danger')
                                .text(action.charAt(0).toUpperCase() + action.slice(1));

                            // Update remarks display
                            $(`#remarksText_${field}`).text(remarks || 'N/A');

                            // Disable the verification controls
                            $(`#docRow_${field} .verification-action, #docRow_${field} .verify-document-btn`).prop('disabled', true);
                            $(`#docRow_${field} .verification-remarks`).prop('readonly', true);

                            // Show revised upload section if rejected
                            if (action === 'rejected') {
                                $(`#docRow_${field} .revised-file, #docRow_${field} .upload-revised-btn`).removeClass('d-none');
                            }

                            // Update the verification count
                            updateVerificationCount();

                            Swal.fire('Success', `Document ${action} successfully`, 'success');
                        },
                        error: function(xhr) {
                            Swal.fire('Error', xhr.responseJSON.message || 'Verification failed', 'error');
                        }
                    });
                }
            });
        });

        // Function to update verification count
        function updateVerificationCount() {
            let verifiedCount = 0;
            const totalDocuments = 8;

            // Count all approved or rejected documents
            $('.status-badge').each(function() {
                const status = $(this).text().toLowerCase();
                if (status === 'approved' || status === 'rejected') {
                    verifiedCount++;
                }
            });

            // Update the verification badge
            const verificationBadge = $('#verificationBadge');
            verificationBadge.removeClass('bg-success bg-warning bg-danger')
                .addClass(verifiedCount === totalDocuments ? 'bg-success' :
                    (verifiedCount > 0 ? 'bg-warning' : 'bg-danger'))
                .text(`${verifiedCount}/${totalDocuments} Verified`);


            if (verifiedCount === totalDocuments) {
                $('#inspection-report-tab').removeClass('disabled');
                $('#proceedToInspectionBtn').prop('disabled', false)
                    .html('<i class="fas fa-clipboard-check"></i> Proceed to Inspection');

                var triggerEl = document.querySelector('#inspection-report-tab');
                if (triggerEl) {
                    var tab = new bootstrap.Tab(triggerEl);
                    tab.show();
                }
            } else {
                $('#inspection-report-tab').addClass('disabled');
                $('#proceedToInspectionBtn').prop('disabled', true)
                    .html('<i class="fas fa-clipboard-check"></i> Proceed to Inspection');
            }

        }



        // Revised Document Upload
        $(document).on('click', '.upload-revised-btn', function() {
            const field = $(this).data('field');
            const appId = $(this).data('application-id');
            const fileInput = $(`#revised_${field}`)[0];

            if (!fileInput.files.length) {
                // Trigger file input click if no file selected
                fileInput.click();
                return;
            }

            const formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('application_id', appId);
            formData.append('field', field);
            formData.append('file', fileInput.files[0]);

            Swal.fire({
                title: 'Uploading Revised Document',
                html: 'Please wait while we upload the file...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: '{{ route("document.upload-revised") }}',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.fire('Success', 'Revised document uploaded successfully', 'success');
                    location.reload();
                },
                error: function(xhr) {
                    Swal.fire('Error', xhr.responseJSON.message || 'Upload failed', 'error');
                }
            });
        });

        // Complete Verification Process
        $(document).on('click', '.complete-verification-btn', function() {
            const appId = $(this).data('application-id');

            Swal.fire({
                title: 'Complete Document Verification?',
                text: 'This will mark all documents as verified and allow inspection to proceed',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, Complete Verification',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route("document.complete-verification") }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            application_id: appId
                        },
                        success: function(response) {
                            Swal.fire('Success', 'Document verification completed!', 'success');
                            location.reload();
                        },
                        error: function(xhr) {
                            Swal.fire('Error', xhr.responseJSON.message || 'Completion failed', 'error');
                        }
                    });
                }
            });
        });

        // Handle file selection for revised documents
        $(document).on('change', '.revised-file', function() {
            const field = $(this).data('field');
            const fileName = $(this).val().split('\\').pop();
            $(this).siblings('.upload-revised-btn').html(
                `<i class="fas fa-upload me-1"></i> Upload: ${fileName}`
            );
        });


    });


    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.view-history-btn').forEach(button => {
            button.addEventListener('click', function() {
                const appId = this.getAttribute('data-id');
                const modalBody = document.getElementById('historyModalBody');
                modalBody.innerHTML = '<div class="text-center py-4">Loading...</div>';
                const historyBaseUrl = @json(route('society-regd-applications.history', [
                    'application' => 'APP_ID',
                ]));
                const url = historyBaseUrl.replace('APP_ID', appId);
                fetch(url)
                    .then(response => response.text())
                    .then(html => {
                        modalBody.innerHTML = html;
                    })
                    .catch(() => {
                        modalBody.innerHTML =
                            '<div class="text-danger text-center">Failed to load history.</div>';
                    });
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.view-application').forEach(button => {
            button.addEventListener('click', function() {
                const appId = this.getAttribute('data-id');
                const modalBody = document.getElementById('viewModalBody');
                modalBody.innerHTML = '<div class="text-center py-4">Loading...</div>';
                const url = "{{ route('society-regd-applications.view', ':id') }}".replace(
                    ':id',
                    appId);
                fetch(url)
                    .then(response => response.text())
                    .then(html => {
                        modalBody.innerHTML = html;
                    })
                    .catch(() => {
                        modalBody.innerHTML =
                            '<div class="text-danger text-center">Failed to load application.</div>';
                    });
            });
        });
    });

    function viewAttachment(url) {
        window.open(url, '_blank', 'width=1000,height=800,noopener,noreferrer');
    }

    $(document).ready(function() {
        $("#actionForm").validate({
            rules: {
                action: {
                    required: true,
                },
                remarks: {
                    required: true,
                    minlength: 5
                },
                'files[]': {
                    required: true,
                    extension: "pdf|doc|docx|jpg|jpeg|png"
                }
            },
            messages: {
                action: {
                    required: "Please select an action."
                },
                remarks: {
                    required: "Please enter remarks.",
                    minlength: "Remarks must be at least 5 characters long."
                },
                'files[]': {
                    required: "Please attach at least one file.",
                    extension: "Only pdf, doc, docx, jpg, jpeg, or png files are allowed."
                }
            },
            errorElement: 'div',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.mb-3').append(error);
            },
            highlight: function(element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element) {
                $(element).removeClass('is-invalid');
            }
        });
        $('#files').on('change', function() {
            var input = $(this);
            input.valid();

            if (input.valid()) {
                input.closest('.mb-3').find('.invalid-feedback').remove();
                input.removeClass('is-invalid');
            }
        });
    });


    /* View Application */

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.view-application').forEach(button => {
            button.addEventListener('click', function() {
                const appId = this.getAttribute('data-id');
                const modalBody = document.getElementById('viewModalBody');
                modalBody.innerHTML = '<div class="text-center py-4">Loading...</div>';
                const url = "{{ route('society-regd-applications.view', ':id') }}".replace(
                    ':id',
                    appId);
                fetch(url)
                    .then(response => response.text())
                    .then(html => {
                        modalBody.innerHTML = html;
                    })
                    .catch(() => {
                        modalBody.innerHTML =
                            '<div class="text-danger text-center">Failed to load application.</div>';
                    });
            });
        });
    });
    /* End View Application */
</script>
@endsection