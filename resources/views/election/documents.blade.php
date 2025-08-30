@php
$nomination = $doc->nomination;
$user = auth()->user();
$canTakeAction = (
($user->role_id == 6 && $nomination->society_category == 3) ||
($user->role_id == 5 && $nomination->society_category == 2) ||
($user->role_id == 3 && $nomination->society_category == 1)
);
@endphp

<div class="container mt-4">

    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Form Details</h5>
            <button onclick="window.history.back()" class="btn btn-sm btn-light">Close</button>
        </div>

        <div class="card-body">

            <!-- Society Details -->
            <h6 class="mb-3 text-decoration-underline">Society Details</h6>
            <div class="row">
                <div class="col-md-4 mb-2"><strong>Society Name:</strong> {{ $nomination->society_name }}
                    @if($doc->is_new_society)
                    <span class="badge bg-success ms-1">NEW</span>
                    @endif
                </div>
                <div class="col-md-4 mb-2"><strong>Category of Society:</strong>
                    @if($nomination->society_category == 1) Primary
                    @elseif($nomination->society_category == 2) Central
                    @else Apex
                    @endif
                </div>
                <div class="col-md-4 mb-2"><strong>Registration Number:</strong> {{ $nomination->registration_number }}</div>
                <div class="col-md-4 mb-2"><strong>Total Members:</strong> {{ $nomination->total_members }}</div>
                <div class="col-md-4 mb-2"><strong>Newly Formed:</strong> {{ $doc->is_new_society ? 'Yes' : 'No' }}</div>
                <div class="col-md-4 mb-2"><strong>Sector:</strong> {{ $nomination->sector ?? 'N/A' }}</div>
                <div class="col-md-4 mb-2"><strong>District:</strong> {{ $nomination->district->name ?? 'N/A' }}</div>
                <div class="col-md-4 mb-2"><strong>Block:</strong> {{ $nomination->block->name ?? 'N/A' }}</div>
            </div>

            <hr>

            <!-- Date of Formation / Last Elections -->
            <div class="mb-3">
                @if($doc->is_new_society)
                <strong>Date of Formation:</strong> {{ $doc->formation_date }}
                @else
                <strong>Date of Last Elections:</strong> {{ $doc->last_election_date }}
                @endif
            </div>

            <!-- Society Documents -->
            <h6 class="mb-3 text-decoration-underline">Society Documents</h6>
            <div class="row">
                <div class="col-md-4 mb-2"><strong>Last Election Certificate:</strong> {!! fileLink($doc->election_certificate) !!}</div>
                <div class="col-md-4 mb-2"><strong>Balance Sheet:</strong> {!! fileLink($doc->balance_sheet) !!}</div>
                <div class="col-md-4 mb-2"><strong>Audit Report:</strong> {!! fileLink($doc->audit_report) !!}</div>
                <div class="col-md-4 mb-2"><strong>Proposal Document:</strong> {!! fileLink($doc->proposal) !!}</div>
                <div class="col-md-4 mb-2"><strong>Members List:</strong> {!! fileLink($doc->members_list) !!}</div>
                <div class="col-md-4 mb-2"><strong>Ward Wise Allocation:</strong> {!! fileLink($doc->ward_allocation) !!}</div>
                <div class="col-md-4 mb-2"><strong>Challan Receipt:</strong> {!! fileLink($doc->challan_receipt) !!}</div>
            </div>

            <hr>

            <!-- Representative Details -->
            <h6 class="mb-3 text-decoration-underline">Representatives Name & Signature</h6>
            <div class="row">
                <div class="col-md-4 mb-2"><strong>Chairman Name:</strong> {{ $doc->chairman_name }}</div>
                <div class="col-md-4 mb-2"><strong>Chairman Signature:</strong> {!! fileLink($doc->chairman_signature) !!}</div>
                <div class="col-md-4 mb-2"><strong>Secretary Name:</strong> {{ $doc->secretary_name }}</div>
                <div class="col-md-4 mb-2"><strong>Secretary Signature:</strong> {!! fileLink($doc->secretary_signature) !!}</div>
            </div>

            @if($doc->remark)
            <div class="alert alert-warning">
                <strong>Remark:</strong> {{ $doc->remark }}
                @if($doc->remark_file)
                <br><a href="{{ asset('storage/'.$doc->remark_file) }}" target="_blank">View Remark File</a>
                @endif
            </div>
            @endif

            <!-- Action Buttons -->
            @if($canTakeAction)
            <div class="mt-4 d-flex justify-content-end gap-2">
                <button class="btn btn-warning" id="openRemarkBox" data-id="{{ $doc->id }}">Remark</button>
                <button class="btn btn-success" id="approveDocBtn" name="approved" data-id="{{ $doc->id }}">Approve</button>
            </div>

            <!-- Inline remark input (toggle on click) -->
            <div id="remarkSection" class="mt-3 d-none">
                <form id="remarkForm" enctype="multipart/form-data">
                     <input type="hidden" name="doc_id" id="remark_doc_id">
                    <textarea id="inlineRemarkText" name="remarks"class="form-control mb-2" placeholder="Enter your remark..."></textarea>
                    <input type="file" class="form-control mb-2" name="remark_file" id="remark_file" />
                    <button id="submitRemarkBtn" class="btn btn-warning btn-sm">Submit Remark</button>
                </form>
            </div>
            @endif
            
@if($canTakeAction && !$nomination->election_completed && $nomination->status == 4)
    <form action="{{ url('/election-list/upload-certificate/'.$nomination->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="election_completion_certificate" required>
        <button type="submit" class="btn btn-success btn-sm">Upload Certificate</button>
    </form>
@endif
@if($nomination->election_completion_certificate)
    <a href="{{ asset('storage/'.$nomination->election_completion_certificate) }}" target="_blank">View Completion Certificate</a>
@endif
        </div>
    </div>
</div>


@php
// Blade helper to generate document view link
function fileLink($filePath) {
return $filePath ? '<a href="'.asset('storage/'.$filePath).'" target="_blank">View</a>' : 'N/A';
}
@endphp