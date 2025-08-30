<div class="row">
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Society Details</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <th>Society Name:</th>
                        <td>{{ $nomination->society_name }}</td>
                    </tr>
                    <tr>
                        <th>Society Category:</th>
                        <td>
                            @if($nomination->society_category == 1)
                                Primary
                            @elseif($nomination->society_category == 2)
                                Central
                            @else
                                Apex
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>District:</th>
                        <td>{{ $nomination->district->name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Block:</th>
                        <td>{{ $nomination->block->name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Registration Number:</th>
                        <td>{{ $nomination->registration_number }}</td>
                    </tr>
                    <tr>
                        <th>Total Members:</th>
                        <td>{{ $nomination->total_members }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Election Details</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <th>New Society:</th>
                        <td>{{ $nomination->documents->is_new_society ? 'Yes' : 'No' }}</td>
                    </tr>
                    @if($nomination->documents->is_new_society)
                        <tr>
                            <th>Formation Date:</th>
                            <td>{{ $nomination->documents->formation_date ? date('d-m-Y', strtotime($nomination->documents->formation_date)) : 'N/A' }}</td>
                        </tr>
                    @else
                        <tr>
                            <th>Last Election Date:</th>
                            <td>{{ $nomination->documents->last_election_date ? date('d-m-Y', strtotime($nomination->documents->last_election_date)) : 'N/A' }}</td>
                        </tr>
                    @endif
                    <tr>
                        <th>Secretary Name:</th>
                        <td>{{ $nomination->documents->secretary_name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Chairman Name:</th>
                        <td>{{ $nomination->documents->chairman_name ?? 'N/A' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Documents</h5>
    </div>
    <div class="card-body">
        @include('election.documents-list')
    </div>
</div>