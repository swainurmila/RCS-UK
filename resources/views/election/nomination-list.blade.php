@extends('layouts.app')
@section('content')
@php
use Carbon\Carbon;
$user = auth()->user();
@endphp

<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Election List</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="#">Election Department</a></li>
                        <li class="breadcrumb-item active">Election List</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body" style="overflow-x:auto;">
                    <table id="election-list-datatable" class="table table-striped table-bordered dt-responsive nowrap" style="min-width:1800px;">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Society Name</th>
                                <th>Registration Number</th>
                                <th>Society Type</th>
                                <th>Total Members</th>
                                <th>District</th>
                                <th>Block</th>
                                <th>Last Election Date</th>
                                <th>Next Election Date</th>
                                <th>Days Left</th>
                                <th>Proposal Date</th>
                                <th>Election Status</th>
                                <th>Documents</th>
                                <th>New Election Date</th>
                                <th>Administrator</th>
                                @if($user->role_id==7)
                                <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($nominations as $key => $nomination)

                            @php
                            $isNew = $nomination->documents && $nomination->documents->is_new_society;
                            $lastElectionDate = $nomination->documents->last_election_date ?? null;
                            $formationDate = $nomination->documents->formation_date ?? null;
                            $proposalDate = $nomination->created_at ? Carbon::parse($nomination->created_at)->format('d-m-Y') : '';
                            $nextElectionDate = $isNew
                            ? ($formationDate ? Carbon::parse($formationDate)->addDays(90) : null)
                            : ($lastElectionDate ? Carbon::parse($lastElectionDate)->addYears(5) : null);
                            $nextElectionDateStr = $nextElectionDate ? $nextElectionDate->format('Y-m-d') : 'N/A';
                            $daysLeft = $nextElectionDate ? Carbon::now()->startOfDay()->diffInDays($nextElectionDate->startOfDay(), false) : 'N/A';
                            $adminAssigned = $nomination->administrator_name;
                            $canTakeAction = (
                            ($user->role_id==6 && $nomination->society_category == 3) ||
                            ($user->role_id==5 && $nomination->society_category == 2) ||
                            ($user->role_id==3 && $nomination->society_category == 1)
                            );
                            $statusOptions = [
                            'Proposal Pending',
                            'Proposal In Progress',
                            'Proposal Accepted',
                            'New Election Date Assigned',
                            'Election in Progress',
                            'Election Completed'
                            ];
                            @endphp
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>
                                    {{ $nomination->society_name }}
                                    @if($isNew)
                                    <span class="badge bg-success ms-1">NEW</span>
                                    @endif
                                </td>
                                <td>{{ $nomination->registration_number }}</td>
                                <td>
                                    @if($nomination->society_category == 1)
                                    Primary
                                    @elseif($nomination->society_category == 2)
                                    Central
                                    @else
                                    Apex
                                    @endif
                                </td>
                                <td>{{ $nomination->total_members }}</td>
                                <td>
                                    @if($nomination->society_category == 3)
                                    N/A
                                    @else
                                    {{ $nomination->district->name ?? 'N/A' }}
                                    @endif
                                </td>
                                <td>
                                    @if($nomination->society_category == 1)
                                    {{ $nomination->block->name ?? 'N/A' }}
                                    @else
                                    N/A
                                    @endif
                                </td>
                                <td>{{ $lastElectionDate ? Carbon::parse($lastElectionDate)->format('d-m-Y') : 'N/A' }}</td>
                                <td>{{ $nextElectionDateStr }}</td>

                                <td>
                                    @if($daysLeft !== 'N/A')
                                    <span class="badge bg-{{ $daysLeft < 0 ? 'danger' : ($daysLeft < 10 ? 'warning' : 'info') }}">{{ $daysLeft }}</span>
                                    @else
                                    N/A
                                    @endif
                                </td>
                                <td>{{ $proposalDate }}</td>
                                <td>
                                    <span class="badge {{ $nomination->getStatusLabel()['class'] }}">
                                        {{ $nomination->getStatusLabel()['text'] }}
                                    </span>
                                </td>

                                <td>
                                    @if($nomination->documents)
                                    <button class="btn btn-sm btn-info view-docs" data-id="{{ $nomination->documents->id }}">View</button>
                                    @else
                                    <span class="badge bg-danger">Not Uploaded</span>
                                    @endif
                                </td>
                                <td>
                                    @if($nomination->status == 2 && $canTakeAction)
                                    <input type="date" class="form-control form-control-sm assign-date"
                                        value="{{ $nomination->new_election_date }}"
                                        data-id="{{ $nomination->id }}"
                                        min="{{ now()->addDay()->format('Y-m-d') }}">
                                    @else
                                    {{ $nomination->new_election_date ?? 'N/A' }}
                                    @endif
                                </td>
                                <td>
                                    @if($nomination->days_left === null || $nomination->days_left >= 10)
                                    N/A
                                    @elseif(!$nomination->is_admin_assigned)
                                    @if($canTakeAction)
                                    <button class="btn btn-sm btn-primary assign-admin" data-id="{{ $nomination->id }}">Assign</button>
                                    @else
                                    N/A
                                    @endif
                                    @else
                                    <button class="btn btn-sm btn-secondary view-admin" data-id="{{ $nomination->id }}">View</button>
                                    <div>
                                        <small>Assigned: {{ $nomination->administrator_name }}<br>
                                            Days Working: {{ $nomination->admin_days_of_working }}</small>
                                    </div>
                                    @endif
                                </td>
                                <td>
                                    @if($nomination->status == 0 && $user->role_id==7)
                                    <a href="{{ route('nominations.edit', $nomination->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @endif
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

<!-- Documents Modal -->
<div class="modal fade" id="docModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Documents</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="docModalBody">Loading...</div>
        </div>
    </div>
</div>
<!-- Remark Modal -->
<div class="modal fade" id="remarkModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Remark</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="remarkForm">
                    <input type="hidden" name="doc_id" id="remark_doc_id">
                    <div class="mb-2">
                        <label>Remark</label>
                        <textarea class="form-control" name="remarks" id="remarks"></textarea>
                    </div>
                    <button type="submit" class="btn btn-warning">Add Remark</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Admin Modal -->
<div class="modal fade" id="adminModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign Administrator</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="adminForm">
                    <input type="hidden" name="nom_id" id="admin_nom_id">
                    <div class="mb-2"><label>Name</label><input type="text" class="form-control" name="administrator_name" required></div>
                    <div class="mb-2"><label>Designation</label><input type="text" class="form-control" name="administrator_designation" required></div>
                    <div class="mb-2"><label>Area Allocated</label><input type="text" class="form-control" name="administrator_area" required></div>
                    <button type="submit" class="btn btn-primary">Assign</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        // Toggle remark section
        $(document).on('click', '#openRemarkBox', function() {
            $('#remarkSection').removeClass('d-none');
            $('#remark_doc_id').val($(this).data('id')); // Set doc_id here
        });

        // Approve document
        $(document).on('click', '#approveDocBtn', function() {
            const docId = $(this).data('id');
            if (!confirm('Are you sure you want to approve this document?')) return;

            $.post('election-list/document-status/' + docId, {
                approved: 1,
                _token: '{{ csrf_token() }}'
            }, function(resp) {
                if (!resp.success) {
                    alert('Approval failed.');
                } else {
                    alert('Approved successfully.');
                    $('#docModal').modal('hide');
                    location.reload();
                }
            });
        });

        // Handle remark form submission (both modal & inline)
        $(document).on('submit', '#remarkForm', function(e) {
            e.preventDefault();

            const docId = $('#remark_doc_id').val();
            const remark = $('#inlineRemarkText').val().trim() || $('#remarks').val().trim();

            if (!docId) return alert("Document ID not found.");
            if (!remark) return alert("Please enter a remark.");

            let formData = new FormData(this);
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('approved', 0);

            $.ajax({
                url: 'election-list/document-status/' + docId,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(resp) {
                    if (!resp.success) {
                        alert('Remark failed');
                    } else {
                        alert('Remark added successfully');
                        $('#remarkModal, #docModal').modal('hide');
                        $('#remarkSection').addClass('d-none');
                        $('#inlineRemarkText, #remark_file, #remarks').val('');
                        location.reload();
                    }
                },
                error: function() {
                    alert('An error occurred while submitting the remark.');
                }
            });
        });

        // View documents
        $('.view-docs').click(function() {
            const id = $(this).data('id');
            $('#docModal').modal('show');
            $('#docModalBody').html('Loading...');
            $.get('/election/election-list/documents/' + id, function(html) {
                $('#docModalBody').html(html);
            }).fail(function() {
                $('#docModalBody').html('<div class="alert alert-danger">Unable to load documents. Please retry.</div>');
            });
        });

        // Assign new election date
        $('.assign-date').change(function() {
            const id = $(this).data('id');
            const date = $(this).val();
            $.post('/election-list/date/' + id, {
                new_election_date: date,
                _token: '{{ csrf_token() }}'
            }, function(resp) {
                if (!resp.success) alert('Date assignment failed');
            });
        });

        // Assign admin
        $('.assign-admin').click(function() {
            const id = $(this).data('id');
            $('#admin_nom_id').val(id);
            $('#adminModal').modal('show');
        });

        $('#adminForm').submit(function(e) {
            e.preventDefault();
            const id = $('#admin_nom_id').val();
            const data = $(this).serialize();
            $.post('election-list/assign-admin/' + id, data + '&_token={{ csrf_token() }}', function(resp) {
                if (!resp.success) alert('Assignment failed');
                $('#adminModal').modal('hide');
            });
        });
    });
</script>
@endsection