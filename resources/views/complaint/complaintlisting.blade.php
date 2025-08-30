@php
    use Spatie\Permission\Models\Role;
@endphp

@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="page-content">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">{{ __('messages.Complaint-List') }}</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a
                                        href="javascript: void(0);">{{ __('messages.CooperativesDepartment') }}</a>
                                </li>
                                <li class="breadcrumb-item active">{{ __('messages.Complaint-List') }}</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body p-0 dash-body">

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body p-0">
                                            <table id="datatable-buttons" class="table table-striped table-hover"
                                                style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>{{ __('messages.SINo') }}</th>
                                                        <th>{{ __('messages.Date-of-Complaint') }}</th>
                                                        <th style="width:125px">{{ __('messages.Complaint-Type') }}</th>
                                                        <th style="width:160px">{{ __('messages.Complaint-Title') }}</th>
                                                        <th style="width:220px">{{ __('messages.Forward-Complaint-to') }}
                                                        </th>
                                                        <th>{{ __('messages.Priority') }}</th>
                                                        <th>{{ __('messages.status') }}</th>
                                                        {{-- <th>{{ __('messages.District') }}</th> --}}
                                                        <th style="width: 188px;">{{ __('messages.Action') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
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

            <div class="modal fade" id="actionModal" tabindex="-1" aria-labelledby="actionModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form id="actionForm" method="POST" action="{{ route('applications.compTakeAction') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="complaint_id" id="comIdInput">
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
                                        {{-- <option value="resolve">{{ __('messages.Resolve') }}</option> --}}
                                        <option value="forward">{{ __('messages.Forward') }}</option>
                                        {{-- @if (auth()->user()->getRoleNames()->first() != 'arcs')
                                            <option value="resend_for_recheck">
                                                {{ __('messages.Send-for-Re-Check') }}</option>
                                        @endif --}}

                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="remarks" class="form-label">{{ __('messages.Remarks') }}</label>
                                    <span class="text-danger">*</span>
                                    <textarea name="remarks" id="remarks" class="form-control" rows="3"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="files" class="form-label">{{ __('messages.Attach-Files') }}</label>
                                    {{-- <span class="text-danger">*</span> --}}
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

            <div class="modal fade" id="historyModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="historyModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ __('messages.Complaint-History') }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="historyModalBody">
                            <div class="text-center py-4">Loading...</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="viewModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="ModalLabel" aria-hidden="true">
                <div class="modal-dialog  modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ __('messages.View-Complaint-Details') }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td style="width: 25%"><strong>{{ __('messages.Complaint-Title') }}:</strong></td>
                                        <td style="width: 25%" id="complainttitle"></td>
                                        <td style="width: 25%"><strong>{{ __('messages.Complaint-Type') }}:</strong></td>
                                        <td style="width: 25%" id="complainttype"></td>
                                    </tr>

                                    <tr>
                                        <td style="width: 25%"><strong>{{ __('messages.Forward-Complaint-to') }}:</strong>
                                        </td>
                                        <td style="width: 25%" id="submitted_to_role"></td>
                                        <td style="width: 25%"><strong>{{ __('messages.Priority') }}:</strong></td>
                                        <td style="width: 25%" id="priority"></td>
                                    </tr>

                                    <tr>
                                        <td style="width: 25%"><strong>{{ __('messages.Complaint-by') }}:</strong>
                                        </td>
                                        <td style="width: 25%" id="combySociety"></td>
                                        <td style="width: 25%"><strong>{{ __('messages.contact_number_title') }}:</strong>
                                        </td>
                                        <td style="width: 25%" id="contactnumber"></td>
                                    </tr>

                                    <tr>
                                        <td style="width: 25%"><strong>{{ __('messages.email_title') }}:</strong></td>
                                        <td style="width: 25%" id="email"></td>
                                        <td style="width: 25%"><strong>{{ __('messages.district') }}:</strong></td>
                                        <td style="width: 25%" id="district"></td>
                                    </tr>

                                    <tr>
                                        <td style="width: 25%"><strong>{{ __('messages.Aadhar') }}:</strong></td>
                                        <td style="width: 25%" id="aadharDoc"></td>
                                        <td style="width: 25%"><strong>{{ __('messages.Attachment') }}:</strong></td>
                                        <td style="width: 25%" id="attachment"></td>
                                    </tr>

                                    <tr>
                                        <td style="width: 25%"><strong>{{ __('messages.Description') }}:</strong></td>
                                        <td style="width: 25%" id="description"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="assignModal" tabindex="-1" aria-labelledby="assignModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <form id="assignCommitteeForm" method="POST" action="{{ route('create-committee-member') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="complaintid" id="compIdInput">
                        <input type="hidden" name="currentrole" id="cRoleInput">
                        <input type="hidden" name="district_id" id="districtInput">
                        <input type="hidden" name="block_id" id="blockInput">

                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">{{ __('messages.Create-Committee-to-Examine-the-Complaint') }}
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                <div id="formErrors" class="alert alert-danger d-none"></div>
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-12">
                                            <div id="committeeMembers">
                                                <div class="row mb-2 member-row">
                                                    <div class="col-md-1 pt-2">
                                                        <strong>Member 1</strong>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <select name="designation[]" class="form-control designation"
                                                            required>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <select name="member_name[]" class="form-control member_name"
                                                            required>
                                                            <option value="">Select Member</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-1 pt-2 text-end">
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm remove-member d-none">×</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="text-start mt-2">
                                                <button type="button" class="btn btn-link" id="addMemberBtn">+Add
                                                    member</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">{{ __('messages.cancel') }}</button>
                                <button type="submit" class="btn btn-primary">{{ __('messages.create') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="modal fade" id="assignviewModal" data-bs-backdrop="static" data-bs-keyboard="false"
                tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
                <div class="modal-dialog  modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ __('messages.View-Complaint-Details') }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td style="width: 25%"><strong>{{ __('messages.Complaint-Title') }}:</strong></td>
                                        <td style="width: 25%" id="designation"></td>
                                        <td style="width: 25%"><strong>{{ __('messages.Complaint-Type') }}:</strong></td>
                                        <td style="width: 25%" id="member_id"></td>
                                    </tr>

                                    {{-- <tr>
                                        <td style="width: 25%"><strong>{{ __('messages.Forward-Complaint-to') }}:</strong>
                                        </td>
                                        <td style="width: 25%" id="submitted_to_role"></td>
                                        <td style="width: 25%"><strong>{{ __('messages.Priority') }}:</strong></td>
                                        <td style="width: 25%" id="priority"></td>
                                    </tr>

                                    <tr>
                                        <td style="width: 25%"><strong>{{ __('messages.Complaint-by') }}:</strong>
                                        </td>
                                        <td style="width: 25%" id="combySociety"></td>
                                        <td style="width: 25%"><strong>{{ __('messages.contact_number_title') }}:</strong>
                                        </td>
                                        <td style="width: 25%" id="contactnumber"></td>
                                    </tr>

                                    <tr>
                                        <td style="width: 25%"><strong>{{ __('messages.email_title') }}:</strong></td>
                                        <td style="width: 25%" id="email"></td>
                                        <td style="width: 25%"><strong>{{ __('messages.district') }}:</strong></td>
                                        <td style="width: 25%" id="district"></td>
                                    </tr>

                                    <tr>
                                        <td style="width: 25%"><strong>{{ __('messages.Aadhar') }}:</strong></td>
                                        <td style="width: 25%" id="aadharDoc"></td>
                                        <td style="width: 25%"><strong>{{ __('messages.Attachment') }}:</strong></td>
                                        <td style="width: 25%" id="attachment"></td>
                                    </tr>

                                    <tr>
                                        <td style="width: 25%"><strong>{{ __('messages.Description') }}:</strong></td>
                                        <td style="width: 25%" id="description"></td>
                                    </tr> --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="assignActionModal" tabindex="-1" aria-labelledby="assignActionModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <form id="actionForm1" method="POST" action="{{ route('committee-take-action') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="commIdInput">
                        <input type="hidden" name="current_role" id="commcurrentRoleInput">
                        <input type="hidden" name="designation" id="designationInput">

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
                                    <select name="commaction" id="commactionSelect" class="form-select">
                                        {{-- <option value="resolve">{{ __('messages.Resolve') }}</option> --}}
                                        <option value="committeeforward">{{ __('messages.Forward') }}</option>
                                        {{-- @if (auth()->user()->getRoleNames()->first() != 'arcs')
                                            <option value="resend_for_recheck">
                                                {{ __('messages.Send-for-Re-Check') }}</option>
                                        @endif --}}

                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="commremarks" class="form-label">{{ __('messages.Remarks') }}</label>
                                    <span class="text-danger">*</span>
                                    <textarea name="commremarks" id="commremarks" class="form-control" rows="3"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="commfiles" class="form-label">{{ __('messages.Attach-Files') }}</label>
                                    {{-- <span class="text-danger">*</span> --}}
                                    <input type="file" name="commfiles[]" id="commfiles" class="form-control"
                                        multiple>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">{{ __('messages.submit') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="modal fade" id="forwardModal" tabindex="-1" aria-labelledby="forwardModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <form id="actionForm" method="POST" action="{{ route('forward-action-store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="frcomplaint_id" id="frcomIdInput">
                        <input type="hidden" name="frcurrent_role" id="frcurrentRoleInput">

                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">{{ __('messages.Take-Action') }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                <div id="formErrors" class="alert alert-danger d-none"></div>

                                <div class="mb-3">
                                    <label for="forwartdSelect"
                                        class="form-label">{{ __('messages.action') }}</label><span
                                        class="text-danger">*</span>
                                    <select name="forwartdSelect" id="forwartdSelect" class="form-select">
                                        <option value="">--Forward to--</option>
                                        <option value="registrar">RCS</option>
                                        <option value="additionalrcs">Additional RCS</option>
                                        <option value="jrcs">JRCS</option>
                                        <option value="drcs">DRCS</option>
                                        <option value="arcs">ARCS</option>
                                    </select>
                                </div>

                                {{-- <div class="mb-3">
                                    <label for="remarks" class="form-label">{{ __('messages.Remarks') }}</label>
                                    <span class="text-danger">*</span>
                                    <textarea name="remarks" id="remarks" class="form-control" rows="3"></textarea>
                                </div> --}}
                                {{-- <div class="mb-3">
                                    <label for="files" class="form-label">{{ __('messages.Attach-Files') }}</label>
                                    <input type="file" name="files[]" id="files" class="form-control" multiple>
                                </div> --}}
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">{{ __('messages.submit') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @php
                $userRoleId = auth()->user()->role_id;
                $userRole = Role::find($userRoleId);
                $userRoleName = $userRole ? strtolower($userRole->name) : '';
                // dd($userRoleName);
            @endphp

            <div class="modal fade" id="resolationforwardActionModal" tabindex="-1" data-bs-backdrop="static"
                aria-labelledby="resolationforwardActionModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">

                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ __('messages.Take-Action') }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">

                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="resolution-tab" data-bs-toggle="tab"
                                        data-bs-target="#resolution" type="button" role="tab"
                                        aria-controls="resolution"
                                        aria-selected="true">{{ __('messages.Resolution') }}</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link"
                                        id="forward-tab{{ $userRoleName === 'registrar' ? 'disabled' : '' }}"
                                        data-bs-toggle="tab" data-bs-target="#forward" type="button" role="tab"
                                        aria-controls="forward" aria-selected="false"
                                        {{ $userRoleName === 'registrar' ? 'disabled' : '' }}>{{ __('messages.Forward') }}</button>
                                </li>

                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="resolution" role="tabpanel"
                                    aria-labelledby="resolution-tab">
                                    <br>
                                    <h5 class="text-center">{{ __('messages.Resolution') }}</h5>
                                    <form id="resolutionForm" action="{{ route('resolution.store') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="com_id" id="rescommIdInput">
                                        <input type="hidden" name="res_current_role" id="rescurrentRoleInput">
                                        <input type="hidden" name="designation" id="designationInput">

                                        <div id="formErrors" class="alert alert-danger d-none"></div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="resremarks"
                                                    class="form-label">{{ __('messages.Remarks') }}</label>
                                                <span class="text-danger">*</span>
                                                <textarea name="resremarks" id="resremarks" class="form-control" rows="3"></textarea>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="resfiles"
                                                    class="form-label">{{ __('messages.Attach-Files') }}</label><span
                                                    class="text-danger">*</span>
                                                <input type="file" name="resfiles[]" id="resfiles"
                                                    class="form-control" multiple>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="authorized_person_name"
                                                    class="form-label">{{ __('messages.Authorized-Person-Name') }}</label><span
                                                    class="text-danger">*</span>
                                                <input type="text" name="authorized_person_name"
                                                    id="authorized_person_name" class="form-control"
                                                    placeholder="{{ __('messages.Authorized-Person-Name') }}"
                                                    value="{{ Auth::user()->name }}" readonly>
                                                <input type="hidden" name="authorized_person_id"
                                                    value="{{ Auth::id() }}">
                                            </div>

                                            <div class="col-md-6">
                                                <label for="signature"
                                                    class="form-label">{{ __('messages.Upload-signature') }}</label><span
                                                    class="text-danger">*</span>
                                                <input type="file" name="signature" id="signature"
                                                    class="form-control">
                                            </div>
                                        </div>

                                        <div class="text-end">
                                            <button type="submit"
                                                class="btn btn-primary">{{ __('messages.Resolve') }}</button>
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">{{ __('messages.cancel') }}</button>
                                        </div>
                                    </form>

                                </div>

                                <div class="tab-pane fade" id="forward" role="tabpanel" aria-labelledby="forward-tab">
                                    <br>
                                    <h5 class="text-center">{{ __('messages.Forward-Complaint-to') }}</h5>
                                    <form id="forwardComplaintForm" action="{{ route('forwardcomplaint.store') }}"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf

                                        <input type="hidden" name="com_id" id="fwdcommIdInput">
                                        <input type="hidden" name="res_current_role" id="fwdcurrentRoleInput">
                                        {{-- <input type="hidden" name="designation" id="designationInput"> --}}

                                        <div id="formErrors" class="alert alert-danger d-none"></div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="fwdremarks"
                                                    class="form-label">{{ __('messages.Remarks') }}</label>
                                                <span class="text-danger">*</span>
                                                <textarea name="fwdremarks" id="fwdremarks" class="form-control" rows="3"></textarea>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="fwdfiles"
                                                    class="form-label">{{ __('messages.Attach-Files') }}</label><span
                                                    class="text-danger">*</span>
                                                <input type="file" name="fwdfiles[]" id="fwdfiles"
                                                    class="form-control" multiple>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="forward_to_designation"
                                                    class="form-label">{{ __('messages.Designation') }}</label><span
                                                    class="text-danger">*</span>
                                                <select name="forward_to_designation" id="forward_to_designation"
                                                    class="form-control" required>
                                                    <option value="">Select Designation</option>
                                                    @switch($userRoleName)
                                                        @case('jrcs')
                                                            <option value="arcs">ARCS</option>
                                                        @break

                                                        @case('arcs')
                                                            <option value="drcs">DRCS</option>
                                                        @break

                                                        @case('drcs')
                                                            <option value="additionalrcs">Additional RCS</option>
                                                        @break

                                                        @case('additionalrcs')
                                                            <option value="registrar">RCS</option>
                                                        @break
                                                    @endswitch
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="forward_to_authorized_Person_id"
                                                    class="form-label">{{ __('messages.Authorized-Person-Name') }}</label><span
                                                    class="text-danger">*</span>
                                                <input type="text" id="authorized_person_name_display"
                                                    class="form-control"
                                                    placeholder="{{ __('messages.Authorized-Person-Name') }}" readonly>
                                                <input type="hidden" name="forward_to_authorized_Person_id"
                                                    id="forward_to_authorized_Person_id">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="forward_by_designation"
                                                    class="form-label">{{ __('messages.your-Designation') }}</label><span
                                                    class="text-danger">*</span>
                                                <select class="form-control" disabled>
                                                    <option value="">Select Your Designation</option>
                                                    <option value="arcs"
                                                        {{ $userRoleName === 'arcs' ? 'selected' : '' }}>ARCS</option>
                                                    <option value="drcs"
                                                        {{ $userRoleName === 'drcs' ? 'selected' : '' }}>DRCS</option>
                                                    <option value="additionalrcs"
                                                        {{ $userRoleName === 'additionalrcs' ? 'selected' : '' }}>
                                                        Additional
                                                        RCS</option>
                                                    <option value="registrar"
                                                        {{ $userRoleName === 'registrar' ? 'selected' : '' }}>RCS</option>
                                                    <option value="jrcs"
                                                        {{ $userRoleName === 'jrcs' ? 'selected' : '' }}>JRCS</option>
                                                </select>
                                                <input type="hidden" name="forward_by_designation"
                                                    value="{{ $userRoleName }}">
                                            </div>

                                            <div class="col-md-6">
                                                <label for="by_authorized_Person_id"
                                                    class="form-label">{{ __('messages.your-Name') }}</label><span
                                                    class="text-danger">*</span>
                                                <input type="text" id="by_authorized_Person_id" class="form-control"
                                                    placeholder="{{ __('messages.your-Name') }}"
                                                    value="{{ Auth::user()->name }}" readonly>
                                                <input type="hidden" name="by_authorized_Person_id"
                                                    value="{{ Auth::id() }}">
                                            </div>
                                        </div>

                                        <div class="text-end">
                                            <button type="submit"
                                                class="btn btn-primary">{{ __('messages.Forward') }}</button>
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">{{ __('messages.cancel') }}</button>
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
                $(function() {
                    @if (Auth::user()->role_id == 4 || Auth::user()->role_id == 13)
                        var table = $('#datatable-buttons').DataTable({
                            processing: true,
                            serverSide: true,
                            destroy: true,
                            "columnDefs": [{
                                "defaultContent": "",
                                "targets": "_all",
                            }],

                            ajax: {
                                url: "{{ route('complaint-assigned-to-committee') }}",

                            },

                            columns: [{
                                    data: 'DT_RowIndex',
                                    name: 'DT_RowIndex',
                                    orderable: false,
                                    searchable: false
                                },
                                {
                                    data: 'complaint_date',
                                    name: 'complaint_date',
                                },
                                {
                                    data: 'complaint_type',
                                    name: 'complaint_type'
                                },
                                {
                                    data: 'complaint_title',
                                    name: 'complaint_title',
                                },
                                {
                                    data: 'forward_complaint_to',
                                    name: 'forward_complaint_to',
                                },
                                {
                                    data: 'priority',
                                    name: 'priority',
                                },
                                {
                                    data: 'status',
                                    name: 'status',
                                },
                                {
                                    data: 'action',
                                    name: 'action',
                                }

                            ]
                        });
                    @else
                        var table = $('#datatable-buttons').DataTable({
                            processing: true,
                            serverSide: true,
                            destroy: true,
                            "columnDefs": [{
                                "defaultContent": "",
                                "targets": "_all",
                            }],

                            ajax: {
                                url: "{{ route('get.complaint.list') }}",

                            },

                            columns: [{
                                    data: 'DT_RowIndex',
                                    name: 'DT_RowIndex',
                                    orderable: false,
                                    searchable: false
                                },
                                {
                                    data: 'complaint_date',
                                    name: 'complaint_date',
                                },
                                {
                                    data: 'complaint_type',
                                    name: 'complaint_type'
                                },
                                {
                                    data: 'complaint_title',
                                    name: 'complaint_title',
                                },
                                {
                                    data: 'forward_complaint_to',
                                    name: 'forward_complaint_to',
                                },
                                {
                                    data: 'priority',
                                    name: 'priority',
                                },
                                {
                                    data: 'status',
                                    name: 'status',
                                },
                                {
                                    data: 'action',
                                    name: 'action',
                                }

                            ]
                        });
                    @endif
                });
            </script>

            <script>
                function RemarkModal(value, currentRoleInput) {
                    console.log('Complaint ID:', value);
                    console.log('Current Role:', currentRoleInput);

                    $('#actionModal').modal('show');
                    $('#comIdInput').val(value);
                    $('#currentRoleInput').val(currentRoleInput);
                }
            </script>

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
                            // 'files[]': {
                            //     required: false,
                            //     extension: "pdf|doc|docx|jpg|jpeg|png"
                            // }
                        },
                        messages: {
                            action: {
                                required: "Please select an action."
                            },
                            remarks: {
                                required: "Please enter remarks.",
                                minlength: "Remarks must be at least 5 characters long."
                            },
                            // 'files[]': {
                            //     // required: "Please attach at least one file.",
                            //     extension: "Only pdf, doc, docx, jpg, jpeg, or png files are allowed."
                            // }
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
                        input.valid(); // Trigger validation for the file input

                        // Check if the file is valid and clear the error
                        if (input.valid()) {
                            input.closest('.mb-3').find('.invalid-feedback').remove(); // Remove the error message
                            input.removeClass('is-invalid'); // Remove the invalid class
                        }
                    });
                });
            </script>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    document.body.addEventListener('click', function(e) {
                        if (e.target.closest('.view-history-btn')) {
                            const button = e.target.closest('.view-history-btn');
                            const appId = button.getAttribute('data-id');
                            // alert(appId);
                            const modalBody = document.getElementById('historyModalBody');

                            modalBody.innerHTML = '<div class="text-center py-4">Loading...</div>';

                            const baseUrl =
                                "{{ route('complaint-applications.history', ['complaint' => 'APP_ID']) }}";
                            const finalUrl = baseUrl.replace('APP_ID', appId);

                            fetch(finalUrl)
                                .then(response => response.text())
                                .then(html => {
                                    modalBody.innerHTML = html;
                                })
                                .catch(() => {
                                    modalBody.innerHTML =
                                        '<div class="text-danger text-center">Failed to load history.</div>';
                                });
                        }
                    });
                });
            </script>

            <script>
                const url = "{{ asset('storage/complaints/attachment') }}/";
                const aadharurl = "{{ asset('storage/complaints/aadhar') }}/";

                $(document).on('click', '.ViewComplaintDetails', function() {

                    $("#viewModal").modal('show');

                    let comnoVal = $(this).data('com_no');
                    let combysocietyVal = $(this).data('complaint_by_society_id');
                    let complainttitleVal = $(this).data('complaint_title');
                    let contactnumberVal = $(this).data('contact_number');
                    let emailval = $(this).data('email');
                    let complainttypeVal = $(this).data('complaint_type');
                    let priorityVal = $(this).data('priority');
                    let attachmentVal = $(this).data('attachment');
                    let districtVal = $(this).data('district');
                    let descriptionVal = $(this).data('description');
                    let submittedtoroleval = $(this).data('submitted_to_role');
                    let aadharVal = $(this).data('aadhar_doc');

                    $('#comno').text(comnoVal);
                    $('#combySociety').html(combysocietyVal);
                    $('#complainttitle').html(complainttitleVal);
                    $('#contactnumber').html(contactnumberVal);
                    $('#email').html(emailval);
                    $('#complainttype').html(complainttypeVal);
                    $('#priority').html(priorityVal);
                    $('#district').html(districtVal);
                    $('#description').html(descriptionVal);
                    $('#submitted_to_role').html(submittedtoroleval);

                    const $attachmentCell = $('#attachment');
                    $attachmentCell.empty();

                    if (attachmentVal) {
                        $attachmentCell.html(`
                            <a href="javascript:void(0);" target="_blank" class="d-inline-block" onclick="viewAttachment('${url + attachmentVal}')"><i class="fa fa-eye"></i> View
                            </a>
                        `);
                    } else {
                        $attachmentCell.text('No file available');
                    }

                    const $aadharcell = $('#aadharDoc');
                    $aadharcell.empty();
                    if (aadharVal) {
                        $aadharcell.html(`
                            <a href="javascript:void(0);" target="_blank" class="d-inline-block" onclick="viewAttachment('${aadharurl + aadharVal}')"><i class="fa fa-eye"></i> View
                            </a>
                        `);
                    } else {
                        $aadharcell.text('No file available');
                    }
                });
            </script>

            <script>
                // Function to return designation options based on current role
                function getDesignationOptions(cRoleInput) {
                    let options = `
                        <option value="">Select Designation</option>
                        <option value="ado">ADO</option>
                        <option value="adco">ADCO</option>
                        <option value="arcs">ARCS</option>`;

                    /* if (cRoleInput != 'arcs') {
                        options += `<option value="arcs">ARCS</option>`;
                    } */

                    return options;
                }

                // Show modal and initialize values
                function AssignCommitteeModal(cId, cRoleInput, districtInput, blockInput) {

                    console.log('Complaint ID:', cId);
                    console.log('Current Role:', cRoleInput);
                    console.log('district:', districtInput);
                    console.log('block:', blockInput);

                    $('#assignModal').modal('show');
                    $('#compIdInput').val(cId);
                    $('#cRoleInput').val(cRoleInput);
                    $('#districtInput').val(districtInput);
                    $('#blockInput').val(JSON.stringify(blockInput));

                    const designationHTML = getDesignationOptions(cRoleInput);
                    $('#committeeMembers select[name="designation[]"]').first().html(designationHTML);
                }

                // jQuery logic for dynamic rows
                $(document).ready(function() {
                    let memberCount = $('.member-row').length || 1;

                    // Validate the form
                    const validator = $('#assignCommitteeForm').validate({
                        rules: {
                            'designation[]': {
                                required: true
                            },
                            'member_name[]': {
                                required: true
                            }
                        },
                        messages: {
                            'designation[]': {
                                required: 'Please select a designation'
                            },
                            'member_name[]': {
                                required: 'Please select a member'
                            }
                        },
                        errorPlacement: function(error, element) {
                            error.insertAfter(element);
                        },
                        submitHandler: function(form) {
                            const totalMembers = $('.member-row').length;

                            if (totalMembers < 2) {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Minimum 2 Members Required',
                                    text: 'Please add at least 2 committee members.'
                                });
                                return false;
                            }

                            form.submit(); // Submit form if valid
                        }
                    });

                    // Add Member Button
                    $('#addMemberBtn').on('click', function() {
                        memberCount++;
                        const currentRole = $('#cRoleInput').val();
                        const designationOptions = getDesignationOptions(currentRole);

                        let newRow = `
                                <div class="row mb-2 member-row">
                                    <div class="col-md-1 pt-2">
                                        <strong>Member ${memberCount}</strong>
                                    </div>
                                    <div class="col-md-5">
                                        <select name="designation[${memberCount}]" class="form-control designation" required>
                                            ${designationOptions}
                                        </select>
                                    </div>
                                    <div class="col-md-5">
                                        <select name="member_name[${memberCount}]" class="form-control member_name" required>
                                            <option value="">Select Member</option>
                                        </select>
                                    </div>
                                    <div class="col-md-1 pt-2 text-end">
                                        <button type="button" class="btn btn-danger btn-sm remove-member">×</button>
                                    </div>
                                </div>`;

                        $('#committeeMembers').append(newRow);
                        updateMemberLabels();

                        // Tell jQuery validate to re-check these new fields
                        $(`select[name="designation[${memberCount}]"]`).rules('add', {
                            required: true,
                            messages: {
                                required: 'Please select a designation'
                            }
                        });

                        $(`select[name="member_name[${memberCount}]"]`).rules('add', {
                            required: true,
                            messages: {
                                required: 'Please select a member'
                            }
                        });
                        $("#assignCommitteeForm").valid();
                    });

                    // Remove Member Row
                    $(document).on('click', '.remove-member', function() {
                        if ($('.member-row').length > 2) {
                            $(this).closest('.member-row').remove();
                            updateMemberLabels();
                        } else {
                            Swal.fire({
                                icon: 'warning',
                                title: 'At Least 2 Members Required',
                                text: 'You must have at least 2 committee members.'
                            });
                        }
                    });

                    // Update Member Label
                    function updateMemberLabels() {
                        memberCount = 0;
                        $('.member-row').each(function(index) {
                            $(this).find('strong').text(`Member ${index + 1}`);
                            memberCount++;
                        });

                        $('.remove-member').each(function() {
                            $(this).toggleClass('d-none', memberCount <= 2);
                        });
                    }

                    updateMemberLabels();
                });

                $(document).on('change', 'select[name^="designation["]', function() {
                    const $row = $(this).closest('.member-row');
                    const selectedDesignation = $(this).val();

                    const district = $('#districtInput').val();


                    const block = $('#blockInput').val();
                    console.log("wndkwd", block);




                    if (selectedDesignation) {
                        $.ajax({
                            url: "{{ route('get-users-by-role') }}",
                            type: 'GET',
                            data: {
                                role: selectedDesignation,
                                district: district,
                                block: block
                            },
                            success: function(response) {
                                let options = '<option value="">Select Member</option>';
                                response.forEach(user => {
                                    // options += `<option value="${user.id}">${user.name}</option>`;
                                    options +=
                                        `<option value="${user.id}">${user.name}</option>`;

                                });

                                // Update the corresponding member_name select in the same row
                                $row.find('select[name^="member_name["]').html(options);
                            }
                        });
                    } else {
                        $row.find('select[name^="member_name["]').html('<option value="">Select Member</option>');
                    }
                });
            </script>

            <script>
                function AssignRemarkModal(value, commcurrentRoleInput, designationInput) {
                    console.log('Complaint ID:', value);
                    console.log('Current Role:', commcurrentRoleInput);
                    console.log('Designation:', designationInput);

                    $('#assignActionModal').modal('show');
                    $('#commIdInput').val(value);
                    $('#commcurrentRoleInput').val(commcurrentRoleInput);
                    $('#designationInput').val(designationInput);
                }
            </script>



            <script>
                $(document).on('click', '.AssignModal', function() {

                    $("#assignviewModal").modal('show');

                    let designationVal = $(this).data('designation');
                    let memberVal = $(this).data('member_id');

                    $('#designation').text(designationVal);
                    $('#member_id').html(memberVal);
                });
            </script>

            {{--  <script>
                function FRModal(value, commcurrentRoleInput, designationInput) {
                    console.log('Complaint ID:', value);
                    console.log('Current Role:', commcurrentRoleInput);
                    console.log('Designation:', designationInput);

                    $('#resolationforwardActionModal').modal('show');
                    $('#commIdInput').val(value);
                    $('#commcurrentRoleInput').val(commcurrentRoleInput);
                    $('#designationInput').val(designationInput);
                }
            </script> --}}
            <script>
                function FRModal(complaintId, currentRole, designation) {
                    // Set the hidden input values
                    document.getElementById('rescommIdInput').value = complaintId;
                    document.getElementById('fwdcommIdInput').value = complaintId;
                    // alert(complaintId);
                    document.getElementById('rescurrentRoleInput').value = currentRole;
                    document.getElementById('fwdcurrentRoleInput').value = currentRole;
                    // alert(currentRole);
                    document.getElementById('designationInput').value = designation;

                    // Show the modal
                    const modal = new bootstrap.Modal(document.getElementById('resolationforwardActionModal'));
                    modal.show();
                }
            </script>

            <script>
                document.getElementById('forward_to_designation').addEventListener('change', function() {
                    const selectedDesignation = this.value;

                    if (selectedDesignation) {
                        fetch("{{ route('get.authorized.name') }}", {
                                method: "POST",
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    forward_to_designation: selectedDesignation
                                })
                            })
                            .then(res => res.json())
                            .then(data => {
                                const nameInput = document.getElementById('authorized_person_name_display');
                                const idInput = document.getElementById('forward_to_authorized_Person_id');
                                if (data.success) {
                                    nameInput.value = data.authorized_person_name;
                                    idInput.value = data.id;
                                } else {
                                    nameInput.value = '';
                                    idInput.value = '';
                                    alert(data.message);
                                }
                            });
                    }
                });
            </script>

            <script>
                $(document).ready(function() {
                    $('#forwardComplaintForm').validate({
                        rules: {
                            fwdremarks: {
                                required: true,
                                minlength: 3
                            },
                            'fwdfiles[]': {
                                required: true,
                                extension: "pdf|jpg|jpeg|png|doc|docx"
                            },
                            forward_to_designation: {
                                required: true
                            },
                            forward_to_authorized_Person_id: {
                                required: true
                            },
                            forward_by_designation: {
                                required: true
                            },
                            by_authorized_Person_id: {
                                required: true
                            },
                            com_id: {
                                required: true
                            },
                            res_current_role: {
                                required: true
                            }
                        },
                        messages: {
                            fwdremarks: {
                                required: "Please enter remarks.",
                                minlength: "Remarks must be at least 3 characters."
                            },
                            'fwdfiles[]': {
                                required: "Please attach at least one file.",
                                extension: "Only pdf, jpg, jpeg, png, doc, docx formats are allowed."
                            },
                            forward_to_designation: "Please select a designation.",
                            forward_to_authorized_Person_id: "Please select an authorized person.",
                            forward_by_designation: "Your designation is required.",
                            by_authorized_Person_id: "Your name is required.",
                            com_id: "Complaint ID is missing.",
                            res_current_role: "Current role is missing."
                        },
                        errorElement: 'div',
                        errorPlacement: function(error, element) {
                            error.addClass('text-danger');
                            error.insertAfter(element);
                        },
                        highlight: function(element) {
                            $(element).addClass('is-invalid');
                        },
                        unhighlight: function(element) {
                            $(element).removeClass('is-invalid');
                        }
                    });
                });
            </script>

            <script>
                $(document).ready(function() {
                    $('#resolutionForm').validate({
                        rules: {
                            resremarks: {
                                required: true,
                                minlength: 3
                            },
                            'resfiles[]': {
                                required: true,
                                extension: "pdf,jpg,jpeg,png,doc,docx"
                            },
                            signature: {
                                required: true,
                                extension: "jpg,jpeg,png"
                            }
                        },
                        messages: {
                            resremarks: {
                                required: "Remarks are required",
                                minlength: "Remarks must be at least 3 characters long"
                            },
                            'resfiles[]': {
                                required: "Please attach at least one file",
                                extension: "Allowed file types: pdf, jpg, jpeg, png, doc, docx"
                            },
                            signature: {
                                required: "Please upload your signature",
                                extension: "Allowed formats: jpg, jpeg, png"
                            }
                        },
                        errorElement: 'div',
                        errorPlacement: function(error, element) {
                            error.addClass('invalid-feedback');
                            element.closest('.form-group, .col-md-6').append(error);
                        },
                        highlight: function(element) {
                            $(element).addClass('is-invalid');
                        },
                        unhighlight: function(element) {
                            $(element).removeClass('is-invalid');
                        }
                    });
                });
            </script>
            <script>
                function ForwardModal(value, frcurrentRoleInput) {
                    console.log('Complaint ID:', value);
                    console.log('Current Role:', frcurrentRoleInput);

                    $('#forwardModal').modal('show');
                    $('#frcomIdInput').val(value);
                    $('#frcurrentRoleInput').val(frcurrentRoleInput);
                }
            </script>
        @endsection
