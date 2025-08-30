@extends('layouts.app')
@section('content')
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
                            <th>{{ __('messages.SINo') }}</th>
                            <th>{{ __('messages.AppNo') }}</th>
                            <th>{{ __('messages.SocietyName') }}</th>
                            <th>{{ __('messages.SocietyCategory') }}</th>
                            <th>{{ __('messages.Locality') }}</th>
                            <th>{{ __('messages.District') }}</th>
                            <th>{{ __('messages.Status') }}</th>
                            <th>{{ __('messages.Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($society_details as $key => $value)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $value->app_no }}</td>
                            <td>{{ $value->society_details->society_name ?? 'N/A' }}</td>
                            <td>
                                @if ($value->society_details->society_category == 1)
                                Primary
                                @elseif($value->society_details->society_category == 2)
                                Central or Apex
                                @elseif($value->society_details->society_category == 3)
                                Agricultural
                                @else
                                'N/A'
                                @endif
                            </td>
                            <td>{{ $value->society_details->locality ?? 'N/A' }}</td>
                            <td>{{ $value->society_details->district ? $all_districts[$value->society_details->district] : 'N/A' }}
                            </td>
                            {{-- <td>
                                        @if ($value->status == 1)
                                            <span class="badge bg-soft-primary text-info font-size-12">Applied</span>
                                        @elseif($value->status == 2)
                                            <span class="badge bg-soft-danger text-danger font-size-12">Reverted/span>
                                            @elseif($value->status == 3)
                                                <span class="badge bg-soft-success text-success font-size-12">Approved
                                                    by admin</span>
                                            @elseif($value->status == 4)
                                                <span class="badge bg-soft-primary text-primary font-size-12">Approved
                                                    by JRCS</span>
                                            @else
                                                <span
                                                    class="badge bg-soft-secondary text-secondary font-size-12">Draft</span>
                                        @endif
                                    </td> --}}
                            <td>
                                <span class="badge bg-{{ $value->status_label['class'] }}">
                                    {{ $value->status_label['text'] }}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-info view-btn" data-id="{{ $value->id }}"><i
                                        class="fas fa-eye"></i></button>

                                @if($value->status == 0)

                                <a href="{{ route('society.edit', $value->id) }}" class="btn btn-sm btn-primary"><i
                                        class="fas fa-edit"></i></a>
                                @endif

                                @can('act', $value)
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#actionModal" data-app-id="{{ $value->id }}"
                                    data-current-role="{{ $value->current_role }}">
                                    Take Action
                                </button>
                                @endcan

                                <button class="btn btn-outline-info btn-sm view-history-btn" data-bs-toggle="modal"
                                    data-bs-target="#historyModal" data-id="{{ $value->id }}">
                                    <i class="fas fa-history"></i>
                                </button>

                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div> <!-- End Card Body -->

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
                    <h5 class="modal-title">Take Action</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="actionSelect" class="form-label">Action</label>
                        <select name="action" id="actionSelect" class="form-select" required>
                            <option value="approve">Approve</option>
                            <option value="reject">Reject</option>
                            <option value="revert">Revert</option>
                            @if (auth()->user()->getRoleNames()->first() != 'arcs')
                            <option value="resend_for_recheck">Send for Re-Check</option>
                            @endif

                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="remarks" class="form-label">Remarks</label>
                        <textarea name="remarks" id="remarks" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="files" class="form-label">Attach Files</label>
                        <input type="file" name="files[]" id="files" class="form-control" multiple>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
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
                <h5 class="modal-title">Society Registration Application History</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="historyModalBody">
                <div class="text-center py-4">Loading...</div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="viewSocietyModal" tabindex="-1" aria-labelledby="viewSocietyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewSocietyModalLabel">{{__('messages.SocietyDetails')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="societyDetailsContent">
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
    $('#actionModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var appId = button.data('app-id');
        var currentRole = button.data('current-role');

        $('#appIdInput').val(appId);
        $('#currentRoleInput').val(currentRole);
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.view-history-btn').forEach(button => {
        button.addEventListener('click', function() {
            const appId = this.getAttribute('data-id');
            const modalBody = document.getElementById('historyModalBody');
            modalBody.innerHTML = '<div class="text-center py-4">Loading...</div>';
            const historyBaseUrl = @json(route('society-regd-applications.history', [
                'application' => 'APP_ID'
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

function viewAttachment(url) {
    window.open(url, '_blank');
}
</script>

<script>
$(document).ready(function() {
    $(document).on('click', '.view-btn', function() {
        var societyId = $(this).data('id');
        var modal = new bootstrap.Modal(document.getElementById('viewSocietyModal'));
        modal.show();

        $('#societyDetailsContent').html(`
            <div class="text-center">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        `);

        $.ajax({
            url: '/societies/' + societyId,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var html = `
                    <div class="accordion" id="societyAccordion">
                        <!-- Society Registration Details -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Society Registration Details
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#societyAccordion">
                                <div class="accordion-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>Society Name:</strong> ${data.society_registration?.society_name || 'N/A'}</p>
                                            <p><strong>Locality:</strong> ${data.society_registration?.locality || 'N/A'}</p>
                                            <p><strong>Post Office:</strong> ${data.society_registration?.post_office || 'N/A'}</p>

                                            <p><strong>Category:</strong> ${getSocietyCategory(data.society_registration?.society_category)}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Tehsil:</strong> ${data.society_registration?.tehsil || 'N/A'}</p>
                                            <p><strong>District:</strong> ${data.society_registration?.district || 'N/A'}</p>
                                            <p><strong>Block:</strong> ${data.society_registration?.developement_area || 'N/A'}</p>
                                            <p><strong>Nearest Station:</strong> ${data.society_registration?.nearest_station || 'N/A'}</p>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Feasibility Report -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Feasibility Report
                                </button>
                            </h2>
<div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#societyAccordion">
    <div class="accordion-body">
        ${data.feasibility_report ? `
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Society Name:</strong> ${data.feasibility_report.society_name || 'N/A'}</p>
                    <p><strong>Society Formation Reason:</strong> ${data.feasibility_report.society_formation_reason || 'N/A'}</p>
                    <p><strong>Bank Name:</strong> ${data.feasibility_report.bank_name || 'N/A'}</p>
                    <p><strong>Society Bank Distance:</strong> ${data.feasibility_report.society_bank_distance || 'N/A'}</p>
                    <p><strong>Chairman Name:</strong> ${data.feasibility_report.chairman_name || 'N/A'}</p>
                    <p><strong>Secretary Name:</strong> ${data.feasibility_report.secretary_name || 'N/A'}</p>
                    <p><strong>Total Members Limits:</strong> ${data.feasibility_report.membership_limit || 'N/A'}</p>
                    <p><strong>Total Members Ready To Join:</strong> ${data.feasibility_report.total_members_ready_to_join || 'N/A'}</p>
                </div>
                <div class="col-md-6">

                    <p><strong>Member Active:</strong> ${data.feasibility_report.is_member_active ? 'Yes' : 'No'}</p>
                    <p><strong>Member Aware of Objectives:</strong> ${data.feasibility_report.is_member_awared_objectives ? 'Yes' : 'No'}</p>
                    <p><strong>Existing Society:</strong> ${data.feasibility_report.is_existing_society ? 'Yes' : 'No'}</p>
                    <p><strong>Society Registration Date:</strong> ${data.feasibility_report.society_registration_date || 'N/A'}</p>
                    <p><strong>Society Completion Time:</strong> ${data.feasibility_report.society_completion_time || 'N/A'}</p>
                    <p><strong>Additional Info:</strong> ${data.feasibility_report.additional_info || 'N/A'}</p>
                </div>
            </div>
        ` : '<p class="text-muted">No feasibility report data available</p>'}
    </div>
</div>
                        </div>

                        <!-- Members -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Members (${data.members?.length || 0})
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#societyAccordion">
                                <div class="accordion-body">
                                    ${data.members?.length > 0 ? `
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Name</th>
                                                        <th>Aadhar Number</th>
                                                        <th>Full Address</th>
                                                        <th>Gender</th>
                                                        <th>Is Married</th>
                                                        <th>Father Name</th>
                                                        <th>Designation</th>
                                                        <th>Business</th>
                                                        <th>Signature</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    ${data.members.map((member, index) => `
                                                        <tr>
                                                            <td>${index + 1}</td>
                                                            <td>${member.name || 'N/A'}</td>
                                                            <td>${member.aadhar_no || 'N/A'}</td>
                                                            <td>${member.address || 'N/A'}</td>
                                                          <td>
    ${member.gender == 1 ? 'Male' : (member.gender == 2 ? 'Female' : (member.gender == 3 ? 'Transgender' : 'N/A'))}
</td>

<td>
    ${member.is_married == 1 ? 'Yes' : (member.is_married == 0 ? 'No' : 'N/A')}
</td>

                                                            <td>${member.father_spouse_name || 'N/A'}</td>
                                                            <td>${member.designation || 'N/A'}</td>
                                                            <td>${member.buisness_name || 'N/A'}</td>
                                                           <td>
    ${member.signature 
        ? `<img src="/storage/${member.signature}" alt="Signature" style="max-height: 60px;">`
        : 'N/A'}
</td>
  

                                                            
                                                        </tr>
                                                    `).join('')}
                                                </tbody>
                                            </table>
                                        </div>
                                    ` : '<p class="text-muted">No members data available</p>'}
                                </div>
                            </div>
                        </div>

                        <!-- Members Objective -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    Members Objective
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#societyAccordion">
                                <div class="accordion-body">
                                    ${data.members_objective ? `
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p><strong>Member Responsibility Type:</strong> ${data.members_objective.member_responsibility_type || 'N/A'}</p>
                                                <p><strong>Operational Area:</strong> ${data.members_objective.society_operational_area || 'N/A'}</p>
                                                <p><strong>Society Objective:</strong> ${data.members_objective.society_objective || 'N/A'}</p>
                                                <p><strong>Share Value:</strong> ${data.members_objective.society_share_value || 'N/A'}</p>
                                                <p><strong>Subscription Rate:</strong> ${data.members_objective.subscription_rate || 'N/A'}</p>
                                                <p><strong>Member Liability:</strong> ${data.members_objective.member_liability || 'N/A'}</p>
                                                <p><strong>General Member Count:</strong> ${data.members_objective.general_member_count || 'N/A'}</p>

                                            </div>
                                            <div class="col-md-6">
                                                <p><strong>Society Record Language:</strong> 
                        ${data.members_objective.society_record_language == 1 ? 'English' : 
                         data.members_objective.society_record_language == 2 ? 'Hindi' : 'N/A'}
                    </p>
                                                <p><strong>Representative Name:</strong> ${data.members_objective.society_representative_name || 'N/A'}</p>
                                                <p><strong>Representative Address:</strong> ${data.members_objective.society_representative_address || 'N/A'}</p>
                                                <p><strong>Representative Signature:</strong>
                                                                                              ${data.members_objective.society_representative_signature 
    ? `<img src="/storage/${data.members_objective.society_representative_signature}" alt="Authority Signature" style="max-height: 60px;">`
    : 'N/A'}</p>
                                                <p><strong>Secretary Name:</strong> ${data.members_objective.society_secretary_name || 'N/A'}</p>
                                                <p><strong>Secretary Address:</strong> ${data.members_objective.society_secretary_address || 'N/A'}</p>
                                                <p><strong>Secretary Signature:</strong>
                                                ${data.members_objective.society_secretary_signature 
    ? `<img src="/storage/${data.members_objective.society_secretary_signature}" alt="Authority Signature" style="max-height: 60px;">`
    : 'N/A'}</p>

                                            </div>
                                        </div>
                                    ` : '<p class="text-muted">No members objective data available</p>'}
                                </div>
                            </div>
                        </div>

                        <!-- Signature Details -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFive">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                    Signature Details
                                </button>
                            </h2>
                            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#societyAccordion">
                            <div class="accordion-body">
                                    ${data.signature_details ? `
                                        <div class="row">
                                            <div class="col-md-6">
                                                       <p><strong>Authority Name:</strong> ${data.signature_details.authority_name || 'N/A'}</p>
                                                            <p><strong>Designation:</strong> ${data.signature_details.authority_designation || 'N/A'}</p>
                                                            <p><strong>Signature:</strong>
${data.signature_details.authority_signature 
    ? `<img src="/storage/${data.signature_details.authority_signature}" alt="Authority Signature" style="max-height: 60px;">`
    : 'N/A'}</p>


                                            </div>
                                         
                                        </div>
                                    ` : '<p class="text-muted">No members objective data available</p>'}
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                $('#societyDetailsContent').html(html);
            },
            error: function(xhr, status, error) {
                console.error(error);
                $('#societyDetailsContent').html(`
                    <div class="alert alert-danger">
                        Failed to load data. Please try again.
                        ${xhr.responseJSON?.message ? '<br>' + xhr.responseJSON.message : ''}
                    </div>
                `);
            }
        });
    });



    function getSocietyCategory(category) {
        switch (category) {
            case 1:
                return 'Primary';
            case 2:
                return 'Central or Apex';
            case 3:
                return 'Agricultural';
            default:
                return 'N/A';
        }
    }
});
</script>

@endsection