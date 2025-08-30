@extends('layouts.app')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <h4 class="mb-4">Audit Allotment List</h4>
        <div class="card">
            <div class="card-body">
                <table id="audit-datatable">
                    <thead>
                        <tr>
                            <th>Sl#</th>
                            <th>District</th>
                            <th>Type</th>
                            <th>Block</th>
                            <th>Financial Year</th>
                            <th>Audit Start Date (Auditor)</th>
                            <th>Audit End Date (Auditor)</th>
                            <th>Audit Start Date (Society)</th>
                            <th>Audit End Date (Society)</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
                <!-- Audit Allotment Modal -->
                <div class="modal fade" id="auditAllotmentModal" tabindex="-1" aria-labelledby="auditAllotmentModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form id="auditAllotmentForm">
                            @csrf
                            <input type="hidden" name="allotment_id" id="modalAllotmentId">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Audit Allotment</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label>Society Name</label>
                                        <input type="text" class="form-control" id="modalSocietyName" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label>Society Type</label>
                                        <input type="text" class="form-control" id="modalSocietyType" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label>Audit Start Date (Auditor)</label>
                                        <input type="date" class="form-control" name="audit_start_date_auditor" id="modalAuditStartAuditor">
                                    </div>
                                    <div class="mb-3">
                                        <label>Audit End Date (Auditor)</label>
                                        <input type="date" class="form-control" name="audit_end_date_auditor" id="modalAuditEndAuditor">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Submit</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
    $(document).ready(function() {

        var table = $('#audit-datatable').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            scrollX: true,
            responsive: false,
            ajax: "{{ route('get.auditAllotment.list') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'district',
                    name: 'district'
                },
                {
                    data: 'society_type',
                    name: 'society_type'
                },
                {
                    data: 'block',
                    name: 'block'
                },
                {
                    data: 'financial_year',
                    name: 'financial_year'
                },
                {
                    data: 'audit_start_auditor',
                    name: 'audit_start_auditor'
                },
                {
                    data: 'audit_end_auditor',
                    name: 'audit_end_auditor'
                },
                {
                    data: 'audit_start_society',
                    name: 'audit_start_society'
                },
                {
                    data: 'audit_end_society',
                    name: 'audit_end_society'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],


        });
    });
    $(document).on('click', '.allotment-btn', function() {
        $('#modalAllotmentId').val($(this).data('id'));
        $('#modalSocietyName').val($(this).data('society_name'));
        $('#modalSocietyType').val($(this).data('society_type'));
        $('#modalAuditStartAuditor').val($(this).data('audit_start_auditor'));
        $('#modalAuditEndAuditor').val($(this).data('audit_end_auditor'));
        $('#auditAllotmentModal').modal('show');
    });

    $('#auditAllotmentForm').on('submit', function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: "{{ route('auditAllotment.updateDates') }}",
            method: "POST",
            data: formData,
            success: function(response) {
                if (response.success) {
                    $('#auditAllotmentModal').modal('hide');
                    $('#audit-datatable').DataTable().ajax.reload(null, false);
                    Swal.fire('Success', response.message, 'success');
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            },
            error: function(xhr) {
                Swal.fire('Error', 'Something went wrong!', 'error');
            }
        });
    });
</script>
@endsection