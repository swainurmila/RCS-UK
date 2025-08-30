@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">{{ __('messages.SocietyRegistrationReports') }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="javascript: void(0);">{{ __('messages.CooperativesDepartment') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('messages.SocietyRegistrationReports') }}</li>
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
                    <div class="table-responsive">
                        <div id="datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <!-- <table id="datatable" class="table table-bordered nowrap dataTable no-footer" style="border-collapse: collapse; border-spacing: 0; width: 100%;" role="grid" aria-describedby="datatable_info"> -->
                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr role="row">
                                        <th class="sorting_asc" tabindex="0" aria-controls="datatable" rowspan="1"
                                            colspan="1" aria-sort="ascending"
                                            aria-label="s No: activate to sort column descending" style="width: 29.55px;">s
                                            No</th>
                                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1"
                                            colspan="1" aria-label="Society Ref Code: activate to sort column ascending"
                                            style="width: 117.887px;">Society Ref Code</th>
                                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1"
                                            colspan="1" aria-label="Form Name : activate to sort column ascending"
                                            style="width: 313.812px;">Form Name </th>
                                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1"
                                            colspan="1" aria-label="Status: activate to sort column ascending"
                                            style="width: 168.15px;">Status</th>
                                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1"
                                            colspan="1" aria-label="Apply Date : activate to sort column ascending"
                                            style="width: 74.05px;">Apply Date </th>
                                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1"
                                            colspan="1" aria-label="Left Days: activate to sort column ascending"
                                            style="width: 63.7875px;">Left Days</th>
                                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1"
                                            colspan="1" aria-label="Progress: activate to sort column ascending"
                                            style="width: 61.4375px;">Progress</th>
                                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1"
                                            colspan="1" aria-label="View: activate to sort column ascending"
                                            style="width: 87.575px;">View</th>
                                    </tr>
                                </thead>
                                <tbody>











                                    <tr role="row" class="odd">
                                        <td class="sorting_1">1</td>
                                        <td>REF-432427</td>
                                        <td>Bihar Self-Reliant Co-operative Societies Act 1996</td>

                                        <td>
                                            <span class="badge bg-secondary">Pending</span>
                                        </td>
                                        <td>2025-Feb-28</td>
                                        <td>
                                            <span class="badge bg-info">74 days left</span>
                                        </td>
                                        <td class="position-relative" id="REF-432427"
                                            onclick="showStickyNote(this,'REF-432427')" style="cursor: pointer;">
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar bg-info" role="progressbar" style="width: 10%;"
                                                    aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
                                                    10%
                                                </div>
                                            </div>
                                            <!-- Futuristic Sticky Note -->
                                            <div class="sticky-note futuristic d-none">
                                                <div class="note-header">
                                                    <span>Expired</span>
                                                </div>
                                                <div class="note-body">
                                                    <div class="role-status">
                                                        <div class="role">Admin </div>
                                                        <div class="status">Assigned</div>
                                                    </div>
                                                    <div class="role-status">
                                                        <div class="role">JRCS</div>
                                                        <div class="status">Forwarded to DCO </div>
                                                    </div>
                                                    <div class="role-status">
                                                        <div class="role">DCO</div>
                                                        <div class="status">Approved</div>
                                                    </div>
                                                    <div class="role-status">
                                                        <div class="role">Admin</div>
                                                        <div class="status">Approved</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <button class="btn btn-outline-primary view-details" data-bs-toggle="modal"
                                                data-bs-target="#detailsModal" value="REF-432427">
                                                View Details
                                            </button>
                                        </td>
                                    </tr>
                                    <tr role="row" class="even">
                                        <td class="sorting_1">2</td>
                                        <td>REF-594793</td>
                                        <td>Bihar Co-operative Societies Act 1935</td>

                                        <td>
                                            <span class="badge bg-secondary">Pending</span>
                                        </td>
                                        <td>2025-Feb-28</td>
                                        <td>
                                            <span class="badge bg-info">74 days left</span>
                                        </td>
                                        <td class="position-relative" id="REF-594793"
                                            onclick="showStickyNote(this,'REF-594793')" style="cursor: pointer;">
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar bg-info" role="progressbar" style="width: 10%;"
                                                    aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
                                                    10%
                                                </div>
                                            </div>
                                            <!-- Futuristic Sticky Note -->
                                            <div class="sticky-note futuristic d-none">
                                                <div class="note-header">
                                                    <span>Expired</span>
                                                </div>
                                                <div class="note-body">
                                                    <div class="role-status">
                                                        <div class="role">Admin </div>
                                                        <div class="status">Assigned</div>
                                                    </div>
                                                    <div class="role-status">
                                                        <div class="role">JRCS</div>
                                                        <div class="status">Forwarded to DCO </div>
                                                    </div>
                                                    <div class="role-status">
                                                        <div class="role">DCO</div>
                                                        <div class="status">Approved</div>
                                                    </div>
                                                    <div class="role-status">
                                                        <div class="role">Admin</div>
                                                        <div class="status">Approved</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <button class="btn btn-outline-primary view-details" data-bs-toggle="modal"
                                                data-bs-target="#detailsModal" value="REF-594793">
                                                View Details
                                            </button>
                                        </td>
                                    </tr>
                                    <tr role="row" class="odd">
                                        <td class="sorting_1">3</td>
                                        <td>REF-378530</td>
                                        <td>Bihar Self-Reliant Co-operative Societies Act 1996</td>

                                        <td>
                                            <span class="badge bg-secondary">Pending Status</span>
                                        </td>
                                        <td>2025-Feb-27</td>
                                        <td>
                                            <span class="badge bg-info">73 days left</span>
                                        </td>
                                        <td class="position-relative" id="REF-378530"
                                            onclick="showStickyNote(this,'REF-378530')" style="cursor: pointer;">
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar bg-info" role="progressbar" style="width: 10%;"
                                                    aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
                                                    10%
                                                </div>
                                            </div>
                                            <!-- Futuristic Sticky Note -->
                                            <div class="sticky-note futuristic d-none">
                                                <div class="note-header">
                                                    <span>Expired</span>
                                                </div>
                                                <div class="note-body">
                                                    <div class="role-status">
                                                        <div class="role">Admin </div>
                                                        <div class="status">Assigned</div>
                                                    </div>
                                                    <div class="role-status">
                                                        <div class="role">JRCS</div>
                                                        <div class="status">Forwarded to DCO </div>
                                                    </div>
                                                    <div class="role-status">
                                                        <div class="role">DCO</div>
                                                        <div class="status">Approved</div>
                                                    </div>
                                                    <div class="role-status">
                                                        <div class="role">Admin</div>
                                                        <div class="status">Approved</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <button class="btn btn-outline-primary view-details" data-bs-toggle="modal"
                                                data-bs-target="#detailsModal" value="REF-378530">
                                                View Details
                                            </button>
                                        </td>
                                    </tr>
                                    <tr role="row" class="even">
                                        <td class="sorting_1">4</td>
                                        <td>REF-528031</td>
                                        <td>Bihar Self-Reliant Co-operative Societies Act 1996</td>

                                        <td>
                                            <span class="badge bg-secondary">Pending</span>
                                        </td>
                                        <td>2025-Feb-24</td>
                                        <td>
                                            <span class="badge bg-info">70 days left</span>
                                        </td>
                                        <td class="position-relative" id="REF-528031"
                                            onclick="showStickyNote(this,'REF-528031')" style="cursor: pointer;">
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar bg-info" role="progressbar" style="width: 10%;"
                                                    aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
                                                    10%
                                                </div>
                                            </div>
                                            <!-- Futuristic Sticky Note -->
                                            <div class="sticky-note futuristic d-none">
                                                <div class="note-header">
                                                    <span>Expired</span>
                                                </div>
                                                <div class="note-body">
                                                    <div class="role-status">
                                                        <div class="role">Admin </div>
                                                        <div class="status">Assigned</div>
                                                    </div>
                                                    <div class="role-status">
                                                        <div class="role">JRCS</div>
                                                        <div class="status">Forwarded to DCO </div>
                                                    </div>
                                                    <div class="role-status">
                                                        <div class="role">DCO</div>
                                                        <div class="status">Approved</div>
                                                    </div>
                                                    <div class="role-status">
                                                        <div class="role">Admin</div>
                                                        <div class="status">Approved</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <button class="btn btn-outline-primary view-details" data-bs-toggle="modal"
                                                data-bs-target="#detailsModal" value="REF-528031">
                                                View Details
                                            </button>
                                        </td>
                                    </tr>
                                    <tr role="row" class="odd">
                                        <td class="sorting_1">5</td>
                                        <td>REF-887526</td>
                                        <td>Bihar Self-Reliant Co-operative Societies Act 1996</td>

                                        <td>
                                            <span class="badge bg-secondary">Pending</span>
                                        </td>
                                        <td>2025-Feb-24</td>
                                        <td>
                                            <span class="badge bg-info">70 days left</span>
                                        </td>
                                        <td class="position-relative" id="REF-887526"
                                            onclick="showStickyNote(this,'REF-887526')" style="cursor: pointer;">
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar bg-info" role="progressbar" style="width: 10%;"
                                                    aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
                                                    10%
                                                </div>
                                            </div>
                                            <!-- Futuristic Sticky Note -->
                                            <div class="sticky-note futuristic d-none">
                                                <div class="note-header">
                                                    <span>Expired</span>
                                                </div>
                                                <div class="note-body">
                                                    <div class="role-status">
                                                        <div class="role">Admin </div>
                                                        <div class="status">Assigned</div>
                                                    </div>
                                                    <div class="role-status">
                                                        <div class="role">JRCS</div>
                                                        <div class="status">Forwarded to DCO </div>
                                                    </div>
                                                    <div class="role-status">
                                                        <div class="role">DCO</div>
                                                        <div class="status">Approved</div>
                                                    </div>
                                                    <div class="role-status">
                                                        <div class="role">Admin</div>
                                                        <div class="status">Approved</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <button class="btn btn-outline-primary view-details" data-bs-toggle="modal"
                                                data-bs-target="#detailsModal" value="REF-887526">
                                                View Details
                                            </button>
                                        </td>
                                    </tr>
                                    <tr role="row" class="even">
                                        <td class="sorting_1">6</td>
                                        <td>REF-923345</td>
                                        <td>Bihar Self-Reliant Co-operative Societies Act 1996</td>

                                        <td>
                                            <span class="badge bg-secondary">Society Updated Revert
                                                Application</span>
                                        </td>
                                        <td>2025-Feb-21</td>
                                        <td>
                                            <span class="badge bg-info">67 days left</span>
                                        </td>
                                        <td class="position-relative" id="REF-923345"
                                            onclick="showStickyNote(this,'REF-923345')" style="cursor: pointer;">
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar bg-info" role="progressbar" style="width: 10%;"
                                                    aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
                                                    10%
                                                </div>
                                            </div>
                                            <!-- Futuristic Sticky Note -->
                                            <div class="sticky-note futuristic d-none">
                                                <div class="note-header">
                                                    <span>Expired</span>
                                                </div>
                                                <div class="note-body">
                                                    <div class="role-status">
                                                        <div class="role">Admin </div>
                                                        <div class="status">Assigned</div>
                                                    </div>
                                                    <div class="role-status">
                                                        <div class="role">JRCS</div>
                                                        <div class="status">Forwarded to DCO </div>
                                                    </div>
                                                    <div class="role-status">
                                                        <div class="role">DCO</div>
                                                        <div class="status">Approved</div>
                                                    </div>
                                                    <div class="role-status">
                                                        <div class="role">Admin</div>
                                                        <div class="status">Approved</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <button class="btn btn-outline-primary view-details" data-bs-toggle="modal"
                                                data-bs-target="#detailsModal" value="REF-923345">
                                                View Details
                                            </button>
                                        </td>
                                    </tr>
                                    <tr role="row" class="odd">
                                        <td class="sorting_1">7</td>
                                        <td>REF-384715</td>
                                        <td>Bihar Co-operative Societies Act 1935</td>

                                        <td>
                                            <span class="badge bg-secondary">Pending Status</span>
                                        </td>
                                        <td>2025-Feb-20</td>
                                        <td>
                                            <span class="badge bg-info">66 days left</span>
                                        </td>
                                        <td class="position-relative" id="REF-384715"
                                            onclick="showStickyNote(this,'REF-384715')" style="cursor: pointer;">
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar bg-info" role="progressbar" style="width: 10%;"
                                                    aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
                                                    10%
                                                </div>
                                            </div>
                                            <!-- Futuristic Sticky Note -->
                                            <div class="sticky-note futuristic d-none">
                                                <div class="note-header">
                                                    <span>Expired</span>
                                                </div>
                                                <div class="note-body">
                                                    <div class="role-status">
                                                        <div class="role">Admin </div>
                                                        <div class="status">Assigned</div>
                                                    </div>
                                                    <div class="role-status">
                                                        <div class="role">JRCS</div>
                                                        <div class="status">Forwarded to DCO </div>
                                                    </div>
                                                    <div class="role-status">
                                                        <div class="role">DCO</div>
                                                        <div class="status">Approved</div>
                                                    </div>
                                                    <div class="role-status">
                                                        <div class="role">Admin</div>
                                                        <div class="status">Approved</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <button class="btn btn-outline-primary view-details" data-bs-toggle="modal"
                                                data-bs-target="#detailsModal" value="REF-384715">
                                                View Details
                                            </button>
                                        </td>
                                    </tr>
                                    <tr role="row" class="even">
                                        <td class="sorting_1">8</td>
                                        <td>REF-978793</td>
                                        <td>Bihar Co-operative Societies Act 1935</td>

                                        <td>
                                            <span class="badge bg-success">Approved By Admin</span>
                                        </td>
                                        <td>2025-Feb-20</td>
                                        <td>
                                            <span class="badge bg-info">66 days left</span>
                                        </td>
                                        <td class="position-relative" id="REF-978793"
                                            onclick="showStickyNote(this,'REF-978793')" style="cursor: pointer;">
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar bg-success" role="progressbar"
                                                    style="width: 100%;" aria-valuenow="100" aria-valuemin="0"
                                                    aria-valuemax="100">
                                                    100%
                                                </div>
                                            </div>
                                            <!-- Futuristic Sticky Note -->
                                            <div class="sticky-note futuristic d-none">
                                                <div class="note-header">
                                                    <span>Expired</span>
                                                </div>
                                                <div class="note-body">
                                                    <div class="role-status">
                                                        <div class="role">Admin </div>
                                                        <div class="status">Assigned</div>
                                                    </div>
                                                    <div class="role-status">
                                                        <div class="role">JRCS</div>
                                                        <div class="status">Forwarded to DCO </div>
                                                    </div>
                                                    <div class="role-status">
                                                        <div class="role">DCO</div>
                                                        <div class="status">Approved</div>
                                                    </div>
                                                    <div class="role-status">
                                                        <div class="role">Admin</div>
                                                        <div class="status">Approved</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <button class="btn btn-outline-primary view-details" data-bs-toggle="modal"
                                                data-bs-target="#detailsModal" value="REF-978793">
                                                View Details
                                            </button>
                                        </td>
                                    </tr>
                                    <tr role="row" class="odd">
                                        <td class="sorting_1">9</td>
                                        <td>REF-444302</td>
                                        <td>Bihar Co-operative Societies Act 1935</td>

                                        <td>
                                            <span class="badge bg-secondary">Pending Status</span>
                                        </td>
                                        <td>2025-Feb-18</td>
                                        <td>
                                            <span class="badge bg-info">64 days left</span>
                                        </td>
                                        <td class="position-relative" id="REF-444302"
                                            onclick="showStickyNote(this,'REF-444302')" style="cursor: pointer;">
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar bg-info" role="progressbar" style="width: 10%;"
                                                    aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
                                                    10%
                                                </div>
                                            </div>
                                            <!-- Futuristic Sticky Note -->
                                            <div class="sticky-note futuristic d-none">
                                                <div class="note-header">
                                                    <span>Expired</span>
                                                </div>
                                                <div class="note-body">
                                                    <div class="role-status">
                                                        <div class="role">Admin </div>
                                                        <div class="status">Assigned</div>
                                                    </div>
                                                    <div class="role-status">
                                                        <div class="role">JRCS</div>
                                                        <div class="status">Forwarded to DCO </div>
                                                    </div>
                                                    <div class="role-status">
                                                        <div class="role">DCO</div>
                                                        <div class="status">Approved</div>
                                                    </div>
                                                    <div class="role-status">
                                                        <div class="role">Admin</div>
                                                        <div class="status">Approved</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <button class="btn btn-outline-primary view-details" data-bs-toggle="modal"
                                                data-bs-target="#detailsModal" value="REF-444302">
                                                View Details
                                            </button>
                                        </td>
                                    </tr>
                                    <tr role="row" class="even">
                                        <td class="sorting_1">10</td>
                                        <td>REF-912752</td>
                                        <td>Bihar Self-Reliant Co-operative Societies Act 1996</td>

                                        <td>
                                            <span class="badge bg-primary">Approved By JRCS</span>
                                        </td>
                                        <td>2025-Feb-17</td>
                                        <td>
                                            <span class="badge bg-info">63 days left</span>
                                        </td>
                                        <td class="position-relative" id="REF-912752"
                                            onclick="showStickyNote(this,'REF-912752')" style="cursor: pointer;">
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar bg-warning" role="progressbar"
                                                    style="width: 80%;" aria-valuenow="80" aria-valuemin="0"
                                                    aria-valuemax="100">
                                                    80%
                                                </div>
                                            </div>
                                            <!-- Futuristic Sticky Note -->
                                            <div class="sticky-note futuristic d-none">
                                                <div class="note-header">
                                                    <span>Expired</span>
                                                </div>
                                                <div class="note-body">
                                                    <div class="role-status">
                                                        <div class="role">Admin </div>
                                                        <div class="status">Assigned</div>
                                                    </div>
                                                    <div class="role-status">
                                                        <div class="role">JRCS</div>
                                                        <div class="status">Forwarded to DCO </div>
                                                    </div>
                                                    <div class="role-status">
                                                        <div class="role">DCO</div>
                                                        <div class="status">Approved</div>
                                                    </div>
                                                    <div class="role-status">
                                                        <div class="role">Admin</div>
                                                        <div class="status">Approved</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <button class="btn btn-outline-primary view-details" data-bs-toggle="modal"
                                                data-bs-target="#detailsModal" value="REF-912752">
                                                View Details
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
