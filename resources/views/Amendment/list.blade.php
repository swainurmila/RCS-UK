@extends('layouts.app')
@section('content')
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">{{ __('messages.By-Law Amendment List') }}</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">{{ __('messages.CooperativesDepartment') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('messages.By-Law Amendment List') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body p-0 dash-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body p-0">
                                    <table id="amendment-datatable" class="table table-striped table-hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>{{ __('messages.SINo') }}</th>
                                                <th>{{ __('messages.Name of the Society') }}</th>
                                                <th>{{ __('messages.Amendment Ref No') }}</th>
                                                <th>{{ __('messages.Original By-Law') }}</th>
                                                 <th>{{ __('messages.SocietyCategory') }}</th>
                                                <th>{{ __('messages.Amended Clause') }}</th>
                                                <th>{{ __('messages.Address') }}</th>
                                                <th>{{ __('messages.Amendment Date') }}</th>
                                                <th>{{ __('messages.Status') }}</th>
                                                <th>{{ __('messages.History') }}</th>
                                                <th>{{ __('messages.Action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- DataTables will populate this -->
                                        </tbody>
                                    </table>
                                
                                    <!-- modal -->
                                    <!-- Take Action Modal -->
                                    <div class="modal fade" id="amendmentActionModal" tabindex="-1" aria-labelledby="amendmentActionModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form id="amendmentActionForm" method="POST" action="{{ route('amendment.takeAction') }}" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="amendment_id" id="amendmentIdInput">

                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">{{ __('messages.Take-Action') }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <div id="formErrors" class="alert alert-danger d-none"></div>
                                                        <div class="mb-3">
                                                            <label for="actionSelect" class="form-label">{{ __('messages.action') }}<span class="text-danger">*</span></label>
                                                                @php
                                                                 $role = auth()->user()->getRoleNames()->first();
                                                                @endphp
                                                            <select name="action" id="actionSelect" class="form-select" required>
                                                             @if ($role == 'arcs')
                                                                <option value="approve">Forward to DRCS</option>
                                                                <option value="revert">Revert to Society</option>
                                                                <option value="reject">Reject</option>
                                                             @else
                                                                <option value="approve">{{ __('messages.Approve') }}</option>
                                                                <option value="reject">{{ __('messages.Reject') }}</option>
                                                                <option value="revert">{{ __('messages.Revert') }}</option>
                                                                @if (auth()->user()->getRoleNames()->first() != 'arcs')
                                                                <option value="resend_for_recheck">{{ __('messages.Send-for-Re-Check') }}</option>
                                                                @endif
                                                                @endif
                                                            </select>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="remarks" class="form-label">{{ __('messages.Remarks') }}<span class="text-danger">*</span></label>
                                                            <textarea name="remarks" id="remarks" class="form-control" rows="3" required></textarea>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="files" class="form-label">{{ __('messages.Attach-Files') }}<span class="text-danger">*</span></label>
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
                                    <!-- History modal -->
                                    <div class="modal fade" id="historyModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                        aria-labelledby="historyModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">{{ __('messages.Amendment-History') }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body" id="historyModalBody">
                                                    <div class="text-center py-4">Loading...</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- View modal -->

                                    <div class="modal fade" id="viewSocietyModal" tabindex="-1" aria-labelledby="viewSocietyModalLabel"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="viewSocietyModalLabel">{{ __('messages.AmendmentDetails') }}</h5>
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

                                </div>
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

    </div>
    @endsection

    @section('js')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.take-action-btn', function() {
                const amendmentId = $(this).data('id');
                $('#amendmentIdInput').val(amendmentId);
                console.log("Set amendment_id:", amendmentId); // Debug log
            });

            $('#amendmentActionForm').on('submit', function(e) {
                e.preventDefault();
                var form = this;
                var formData = new FormData(form);

                $.ajax({
                    url: $(form).attr('action'),
                    method: $(form).attr('method'),
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#amendmentActionModal').modal('hide');
                        $('#amendment-datatable').DataTable().ajax.reload(null, false);
                        Swal.fire('Success', response.message || 'Action completed.',
                            'success');
                    },
                    error: function(xhr) {
                        let msg = 'Something went wrong!';
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            msg = Object.values(xhr.responseJSON.errors).join('<br>');
                        }
                        // Swal.fire('Error', msg, 'error');
                    }
                });
            });
        });

        $(function() {
            var table = $('#amendment-datatable').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                dom: 'Bfrtip', // Enable buttons
                buttons: [
                    // {
                    //     extend: 'copyHtml5',
                    //     className: 'btn btn-info', 
                    //     text: 'Copy'
                    // },
                    {
                        extend: 'excelHtml5',
                        className: 'btn btn-success',
                        text: 'Excel'
                    },
                    {
                        extend: 'csvHtml5',
                        className: 'btn btn-warning',
                        text: 'CSV'
                    },
                    {
                        extend: 'pdfHtml5',
                        className: 'btn btn-danger',
                        text: 'PDF'
                    },
                    {
                        extend: 'print',
                        className: 'btn btn-secondary',
                        text: 'Print'
                    }
                ],
                "columnDefs": [{
                    "defaultContent": "",
                    "targets": "_all",
                }],
                ajax: {
                    url: "{{ route('get.amendment.list') }}",
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'society_name',
                        name: 'society_name'
                    },
                    {
                        data: 'amendment_ref_no',
                        name: 'amendment_ref_no'
                    },
                    {
                        data: 'original_bylaw',
                        name: 'original_bylaw'
                    },
                      {
                        data: 'society_category',
                        name: 'society_category'
                    },
                    {
                        data: 'amended_clause',
                        name: 'amended_clause'
                    },
                    {
                        data: 'address',
                        name: 'address'
                    },
                    {
                        data: 'amendment_date',
                        name: 'amendment_date'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'history',
                        name: 'history',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        });
        $(document).on('click', '.view-history-btn', function() {
            const amendmentId = $(this).data('id');
            const modalBody = $('#historyModalBody');
            modalBody.html('<div class="text-center py-4">Loading...</div>');

            const historyBaseUrl = @json(route('amendment.history', ['amendment' => 'AMENDMENT_ID']));
            const url = historyBaseUrl.replace('AMENDMENT_ID', amendmentId);

            fetch(url)
                .then(response => response.text())
                .then(html => {
                    modalBody.html(html);
                })
                .catch(() => {
                    modalBody.html('<div class="text-danger text-center">Failed to load history.</div>');
                });

            $('#historyModal').modal('show');
        });

        $(document).on('click', '.view-application', function() {
            const appId = $(this).data('id');
            const modalBody = $('#viewModalBody');
            modalBody.html(`
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            `);

            // Properly generate the route using Laravel Blade
            const baseUrl = @json(route('show.ablm_details', ['id' => '__ID__']));
            const url = baseUrl.replace('__ID__', appId);

            fetch(url)
                .then(response => {
                    if (!response.ok) throw new Error("Failed to load");
                    return response.text();
                })
                .then(html => {
                    modalBody.html(html);
                })
                .catch(() => {
                    modalBody.html(`
                <div class="text-danger text-center py-4">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Failed to load application.
                </div>
            `);
                });

            $('#viewSocietyModal').modal('show');
        });
    </script>
    <script>
        $(document).ready(function() {
            $("#amendmentActionForm").validate({
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

            // Trigger validation for the file input on change
            $('#files').on('change', function() {
                var input = $(this);
                input.valid(); // Trigger validation for the file input

                // Check if the file is valid and clear the error
                if (input.valid()) {
                    input.closest('.mb-3').find('.invalid-feedback').remove();
                    input.removeClass('is-invalid');
                }
            });
        });
    </script>
    @endsection