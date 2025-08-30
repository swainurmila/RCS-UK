@extends('layouts.app')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <!-- <h4><span>{{ __('messages.By-lawamendment') }}</span></h4> -->
                    <h4 class="mb-0">{{ __('messages.By-lawamendment') }}</h4>
                </div>
            </div>
        </div>  

        {{-- Tabs Header --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="bylawTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="society-tab" data-bs-toggle="tab" data-bs-target="#society" type="button" role="tab">{{ __('messages.society_placeholder') }}</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="committee-tab" data-bs-toggle="tab" data-bs-target="#committee" type="button" role="tab">{{ __('messages.ManagingCommittee') }}</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="aamshabha-tab" data-bs-toggle="tab" data-bs-target="#aamshabha" type="button" role="tab">{{ __('messages.Aam Sabha Meeting') }}</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="voting-tab" data-bs-toggle="tab" data-bs-target="#voting" type="button" role="tab">{{ __('messages.VotingonAmendments') }}</button>
                            </li>
                        </ul>

                        {{-- Tabs Content --}}
                        <div class="tab-content" id="bylawTabsContent">
                            {{-- Society Tab --}}
                            <div class="tab-pane fade show active border p-4" id="society" role="tabpanel"
                                aria-labelledby="society-tab">
                                <form id="step_form1" action="{{route('societyRegister')}}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <div class="row">
                                        <input type="hidden" name="edit_id" id="edit_id" value="{{ $amendment->id ?? '' }}">
                                        <!-- <div class="col-md-12 mb-3">
    <fieldset class="border p-3">
        <label class="form-label fw-bold">{{ __('messages.categoryofthesociety') }}</label>
        <span class="text-danger">*</span>
        <div class="d-flex justify-content-evenly">
            <div class="form-check">
    <input class="form-check-input" type="radio"
        onchange="validateData(this,'society_category')"
        name="society_category" id="primary" value="1"
        {{ old('society_category', $amendment->society_category ?? '') == 1 ? 'checked' : '' }} />
    <label class="form-check-label ms-2" for="primary">{{ __('messages.primary') }}</label>
</div>

<div class="form-check">
    <input class="form-check-input" type="radio"
        onchange="validateData(this,'society_category')"
        name="society_category" id="centralApex" value="2"
        {{ old('society_category', $amendment->society_category ?? '') == 2 ? 'checked' : '' }} />
    <label class="form-check-label ms-2" for="centralApex">{{ __('messages.central') }}</label>
</div>

<div class="form-check">
    <input class="form-check-input" type="radio"
        onchange="validateData(this,'society_category')"
        name="society_category" id="agricultural" value="3"
        {{ old('society_category', $amendment->society_category ?? '') == 3 ? 'checked' : '' }} />
    <label class="form-check-label ms-2" for="agricultural">{{ __('messages.apex') }}</label>
</div>

        </div>
        <span class="text-danger1" id="society_category_err"></span>
    </fieldset>
</div> -->
<div class="col-md-12 mb-3">
                <fieldset class="border p-3">
                    <label class="form-label fw-bold">{{ __('messages.categoryofthesociety') }}</label>
                    <span class="text-danger">*</span>
                    <div class="d-flex justify-content-evenly">
                        @foreach ([1 => 'primary', 2 => 'central', 3 => 'apex'] as $value => $id)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="society_category" id="{{ $id }}" value="{{ $value }}"
                                {{ old('society_category', $amendment->society_category ?? '') == $value ? 'checked' : '' }}>
                            <label class="form-check-label ms-2" for="{{ $id }}">{{ __('messages.' . $id) }}</label>
                        </div>
                        @endforeach
                    </div>
                    <span class="text-danger1" id="society_category_err"></span>
                </fieldset>
            </div>

                                       <div class="col-md-6 mb-3">
                <label class="form-label">{{ __('messages.Nameofthesociety') }}<span class="text-danger">*</span></label>
                <select class="form-select form-control" name="society_name" id="society_name" required>
                    <option value="">{{ __('messages.select') }}</option>
                    @foreach($socity_details as $society)
                        <option value="{{ $society->id }}" {{ isset($societyDetails) && $societyDetails->id == $society->id ? 'selected' : '' }}>
                            {{ $society->society_name }}
                        </option>
                    @endforeach
                </select>
                <span id="society_name_error" class="text-danger1"></span>
            </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">{{ __('messages.TotalNoofMembers') }}<span class="text-danger">*</span></label>
                                            <input type="number" class="form-control" name="total_members" oninput="myFunction()" required value="{{ old('total_members', $amendment->total_members ?? '') }}">
                                            <span id="total_members_error" class="text-danger1"></span>
                                        </div>
                                        <div class="col-md-6 mb-3">
                <label class="form-label">{{ __('messages.district') }}<span class="text-danger">*</span></label>
                <select class="form-select form-control" name="district" id="district">
                    <option value="">-- Select --</option>
                    @foreach ($districts as $district)
                        <option value="{{ $district->id }}" {{ isset($amendment) && $amendment->district == $district->id ? 'selected' : '' }}>
                            {{ $district->name }}
                        </option>
                    @endforeach
                </select>
                <span id="district_error" class="text-danger1"></span>
            </div>

            {{-- Block --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">{{ __('messages.Block') }}<span class="text-danger">*</span></label>
                <select class="form-select form-control" name="block" id="block">
                    <option value="">-- Select --</option>
                    @if (!empty($amendment->block) && isset($blocks))
                        @foreach ($blocks as $block)
                            <option value="{{ $block->id }}" {{ isset($amendment) && $amendment->block == $block->id ? 'selected' : '' }}>
                                {{ $block->name }}
                            </option>
                        @endforeach
                    @endif
                </select>
                <span id="block_error" class="text-danger1"></span>
            </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">{{ __('messages.SocietyAddress') }}<span class="text-danger">*</span></label>
                                            <textarea class="form-control" oninput="myFunction()" name="address" rows="1" required>{{ old('address', $amendment->address ?? '') }}</textarea>
                                            <span id="address_error" class="text-danger1"></span>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">{{ __('messages.UploadE-18Certificate') }}<span class="text-danger">*</span></label>
                                            <input type="file" class="form-control" oninput="myFunction()" name="e18_certificate" required>
                                            @if (!empty($amendment->e18_certificate))
                                            @php
                                            $url = asset('storage/' . $amendment->e18_certificate);
                                            $ext = pathinfo($amendment->e18_certificate, PATHINFO_EXTENSION);
                                            $icon = $ext === 'pdf' ? 'fa-file-pdf text-danger' : 'fa-file-image text-info';
                                            $title = $ext === 'pdf' ? 'View PDF Attachment' : 'View Image Attachment';
                                            @endphp
                                            <div class="mt-2 d-flex align-items-center gap-2">
                                                <i class="fas {{ $icon }}" style="font-size: 1.2rem;"></i>
                                                <a href="javascript:void(0);" onclick="viewAttachment('{{ $url }}')" title="{{ $title }}">
                                                    View
                                                </a>
                                            </div>
                                            @endif

                                            <span id="e18_certificate_error" class="text-danger1"></span>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" hidden>{{ __('messages.Society Act') }}<span class="text-danger">*</span></label>
                                            <select class="form-select" name="society_act" hidden>
                                                <option value="">Select Act</option>
                                                <option value="Act 1">Act 1</option>
                                                <option value="Act 2">Act 2</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" hidden>Area of Operation<span class="text-danger">*</span></label>
                                            <select class="form-select" name="area" hidden>
                                                <option value="">Select</option>
                                                <option value="Urban">Urban</option>
                                                <option value="Rural">Rural</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">{{ __('messages.TotalNoOfElectedBoardMembers') }}<span class="text-danger">*</span></label>
                                            <input type="number" class="form-control" oninput="myFunction()" name="board_members" required value="{{ old('board_members', $amendment->total_board_members ?? '') }}">
                                            <span id="board_members_error" class="text-danger1"></span>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">{{ __('messages.NoofMembersRequiredforQuorum') }}<span class="text-danger">*</span></label>
                                            <input type="number" class="form-control" oninput="myFunction()" name="quorum" required value="{{ old('quorum', $amendment->quorum_members ?? '') }}">
                                            <span id="quorum_error" class="text-danger1"></span>
                                        </div>
                                        
                                    </div>
                                    <!-- <div class="text-end">
                                        <button type="button" class="btn btn-sf-green" id="btnSave1" onclick="societyform()">Save &amp; Continue</button>
                                    </div> -->
                                    <div class="text-end">
                                        <button type="button" class="btn btn-sf-green" id="submit_btn1" data-nexttab="committee-tab-btn" onclick="nextStep(1)"> {{ isset($amendment) && $amendment->id ? __('messages.Update & Continue') : __('messages.Save & Continue') }}</button>
                                    </div>
                                </form>
                            </div>

                            {{-- Managing Committee Tab --}}
                            <div class="tab-pane fade border p-4" id="committee" role="tabpanel" aria-labelledby="committee-tab">
                                <form id="step_form2" action="{{route('societyRegister')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">{{ __('messages.UploadExistingBy-Law') }}<span class="text-danger">*</span></label>
                                            <input type="file" id="momfile1" name="existing_bylaw" class="form-control" onchange="validateFile(this)" oninput="myFunction()" required>
                                            @if(optional($managingCommittee)->existing_bylaw)
                                            @php
                                            $file = $managingCommittee->existing_bylaw;
                                            $url = asset('storage/' . $file);
                                            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                            $icon = $ext === 'pdf' ? 'fa-file-pdf text-danger' : 'fa-file-image text-info';
                                            $title = $ext === 'pdf' ? 'View PDF Attachment' : 'View Image Attachment';
                                            @endphp
                                            <div class="mt-2 d-flex align-items-center gap-2">
                                                <i class="fas {{ $icon }}" style="font-size: 1.2rem;"></i>
                                                <a href="javascript:void(0);" onclick="viewAttachment('{{ $url }}')" title="{{ $title }}">
                                                    View
                                                </a>
                                            </div>
                                            @endif
                                            <span id="existing_bylaw_error" class="text-danger1"></span>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">{{ __('messages.UploadRelevantSectionofBy-LawtobeAmended') }}<span class="text-danger">*</span></label>
                                            <input type="file" id="momfile2" name="bylaw_section" class="form-control" onchange="validateFile(this)" oninput="myFunction()" required>
                                            @if(optional($managingCommittee)->bylaw_section)
                                            @php
                                            $file = $managingCommittee->bylaw_section;
                                            $url = asset('storage/' . $file);
                                            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                            $icon = $ext === 'pdf' ? 'fa-file-pdf text-danger' : 'fa-file-image text-info';
                                            $title = $ext === 'pdf' ? 'View PDF Attachment' : 'View Image Attachment';
                                            @endphp
                                            <div class="mt-2 d-flex align-items-center gap-2">
                                                <i class="fas {{ $icon }}" style="font-size: 1.2rem;"></i>
                                                <a href="javascript:void(0);" onclick="viewAttachment('{{ $url }}')" title="{{ $title }}">
                                                    View
                                                </a>
                                            </div>
                                            @endif

                                            <span id="bylaw_section_error" class="text-danger1"></span>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">{{ __('messages.ProposedAmendment') }}<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="releventsection" name="proposed_amendment" oninput="myFunction()" value="{{ old('proposed_amendment', optional($managingCommittee)->proposed_amendment) }}" required>
                                            <span id="proposed_amendment_error" class="text-danger1"></span>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">{{ __('messages.PurposeofAmendment') }}<span class="text-danger">*</span></label>
                                            <textarea class="form-control" id="reasonofamendment" name="purpose_of_amendment" rows="4" oninput="myFunction()" required>{{ old('purpose_of_amendment', optional($managingCommittee)->purpose_of_amendment) }}</textarea>
                                            <span id="purpose_of_amendment_error" class="text-danger1"></span>
                                        </div>
                                        <div class="col-md-6 mb-3">
    <label class="form-label">
        {{ __('messages.UploadRegistrationCertificate') }}
        <span class="text-danger">*</span>
    </label>
    <input
        type="file"
        id="registration_certificate"
        name="registration_certificate"
        class="form-control"
        onchange="validateFile(this)"
        oninput="myFunction()"
        required
        accept=".pdf,.jpg,.jpeg,.png"
    >

    @if(optional($managingCommittee)->registration_certificate)
        @php
            $file = $managingCommittee->registration_certificate;
            $url = asset('storage/' . $file);
            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            $icon = $ext === 'pdf' ? 'fa-file-pdf text-danger' : 'fa-file-image text-info';
            $title = $ext === 'pdf' ? 'View PDF Attachment' : 'View Image Attachment';
        @endphp
        <div class="mt-2 d-flex align-items-center gap-2">
            <i class="fas {{ $icon }}" style="font-size: 1.2rem;"></i>
            <a href="javascript:void(0);" onclick="viewAttachment('{{ $url }}')" title="{{ $title }}">
                View
            </a>
        </div>
    @endif
    <span id="registration_certificate_error" class="text-danger1"></span>
</div>

                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label">{{ __('messages.UploadDocumentApprovedbyManagingCommitteeBoard') }}<span class="text-danger">*</span></label>
                                                <div>
                                                    <input class="form-check-input" type="radio" id="approvalYes" name="approval" value="yes" onchange="toggleFileUpload()" {{ old('approval', optional($managingCommittee)->approval) == 'yes' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="approvalYes">{{ __('messages.yes') }}</label>

                                                    <input class="form-check-input" type="radio" id="approvalNo" name="approval" value="no" onchange="toggleFileUpload()" {{ old('approval', optional($managingCommittee)->approval) == 'no' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="approvalNo">{{ __('messages.no') }}</label>
                                                </div>
                                                <span id="approval_error" class="text-danger"></span>
                                                <div id="fileUploadContainer" class="mt-2" style="{{ old('approval', optional($managingCommittee)->approval) == 'yes' ? 'display:block;' : 'display:none;' }}">
                                                    <input type="file" id="momfile3" name="committee_approval_doc" class="form-control" onchange="validateFile(this)">
                                                    @if(optional($managingCommittee)->committee_approval_doc)
                                                    @php
                                                    $file = $managingCommittee->committee_approval_doc;
                                                    $url = asset('storage/' . $file);
                                                    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                                    $icon = $ext === 'pdf' ? 'fa-file-pdf text-danger' : 'fa-file-image text-info';
                                                    $title = $ext === 'pdf' ? 'View PDF Attachment' : 'View Image Attachment';
                                                    @endphp
                                                    <div class="mt-2 d-flex align-items-center gap-2">
                                                        <i class="fas {{ $icon }}" style="font-size: 1.2rem;"></i>
                                                        <a href="javascript:void(0);" onclick="viewAttachment('{{ $url }}')" title="{{ $title }}">
                                                            View
                                                        </a>
                                                    </div>
                                                    @endif

                                                    <span id="committee_approval_doc_error" class="text-danger1"></span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- <div class="text-end">
                                            <button type="button" class="btn btn-sf-green" id="btnSave2" onclick="managingcommittee()">Save &amp; Continue</button>
                                        </div> -->

                                    <div class="text-end">
                                        <button type="button" class="btn btn-secondary"
                                            onclick="navigateToTab('society-tab')">
                                            Previous
                                        </button>
                                        <button type="button" class="btn btn-sf-green" id="submit_btn2"
                                            onclick="nextStep(2)">{{ isset($amendment) && $amendment->id ? __('messages.Update & Continue') : __('messages.Save & Continue') }}</button>
                                    </div>
                                </form>
                            </div>

                            {{-- Aam Sabha Meeting Tab --}}

                            <div class="tab-pane fade border p-4" id="aamshabha" role="tabpanel" aria-labelledby="aamshabha-tab">
                                <form id="step_form3" action="{{ route('societyRegister') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="mb-3">
                                            <label class="form-label">{{ __('messages.Notice of Aam Sabha') }}<span class="text-danger1">*</span></label>
                                            <div>
                                                <input type="radio" id="noticeOfAamSabhaYes" name="noticeOfAamSabha" value="1"
                                                    onclick="toggleCommunicationMethod(true)"
                                                    {{ old('noticeOfAamSabha', optional($aamSabhaMeeting)->noticeOfAamSabha) == '1' ? 'checked' : '' }}>
                                                <label for="noticeOfAamSabhaYes" class="me-3">{{ __('messages.yes') }}</label>

                                                <input type="radio" id="noticeOfAamSabhaNo" name="noticeOfAamSabha" value="0"
                                                    onclick="toggleCommunicationMethod(false)"
                                                    {{ old('noticeOfAamSabha', optional($aamSabhaMeeting)->noticeOfAamSabha) == '0' ? 'checked' : '' }}>
                                                <label for="noticeOfAamSabhaNo">{{ __('messages.no') }}</label>
                                                <span id="noticeOfAamSabha_error" class="text-danger1"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" id="communicationAndUploadRow"
                                        style="{{ old('noticeOfAamSabha', optional($aamSabhaMeeting)->notice) == '1' ? 'display:flex;' : 'display:none;' }}">
                                        <div class="col-lg-3">
                                            <label class="form-label">{{ __('messages.ModeofCommunicationtoMembers') }}<span class="text-danger">*</span></label>
                                            <select class="form-select" id="communicationMethod" name="communication_method"
                                                oninput="myFunction()" onchange="toggleOtherMethodField()">
                                                <option value="">{{ __('messages.select') }}</option>
                                                <option value="Registered Post"
                                                    {{ old('communication_method', optional($aamSabhaMeeting)->communication_method) == 'Registered Post' ? 'selected' : '' }}>
                                                    {{ __('messages.Registered Post') }}
                                                </option>
                                                <option value="Other"
                                                    {{ old('communication_method', optional($aamSabhaMeeting)->communication_method) == 'Other' ? 'selected' : '' }}>
                                                    {{ __('messages.Other') }}
                                                </option>
                                            </select>
                                            <span id="communication_method_error" class="text-danger1"></span>
                                        </div>

                                        <div class="col-lg-3" id="otherMethodField"
                                            style="{{ old('communication_method', optional($aamSabhaMeeting)->communication_method) == 'Other' ? 'display:block;' : 'display:none;' }}">
                                            <label class="form-label">{{ __('messages.OtherModeofCommunicationtoMembers') }}<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="otherMethodInput" name="other_communication"
                                                value="{{ old('other_communication', optional($aamSabhaMeeting)->other_communication) }}"
                                                placeholder="Enter other communication method" oninput="myFunction()">
                                            <span id="other_communication_error" class="text-danger1"></span>
                                        </div>

                                        <div class="col-lg-3">
                                            <label class="form-label">Schedule Date of AG Meeting <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" id="scheduledMeetingDate" name="ag_meeting_date"
                                                value="{{ old('ag_meeting_date', optional($aamSabhaMeeting)->ag_meeting_date) }}"
                                                oninput="myFunction()">
                                            <span id="ag_meeting_date_error" class="text-danger1"></span>
                                        </div>

                                        <div class="col-lg-3 mb-3">
                                            <label class="form-label">{{ __('messages.Upload Meeting Notice (PDF only)') }}<span class="text-danger">*</span></label>
                                            <input type="file" class="form-control" id="momfile4" name="meeting_notice" oninput="myFunction()"
                                                onchange="validateFile(this)" accept=".pdf">
                                            @if (!empty($aamSabhaMeeting->meeting_notice))
                                            @php
                                            $file = $aamSabhaMeeting->meeting_notice;
                                            $url = asset('storage/' . $file);
                                            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                            $icon = $ext === 'pdf' ? 'fa-file-pdf text-danger' : 'fa-file-image text-info';
                                            $title = $ext === 'pdf' ? 'View PDF Attachment' : 'View Image Attachment';
                                            @endphp
                                            <div class="mt-2 d-flex align-items-center gap-2">
                                                <i class="fas {{ $icon }}" style="font-size: 1.2rem;"></i>
                                                <a href="javascript:void(0);" onclick="viewAttachment('{{ $url }}')" title="{{ $title }}">
                                                    View Uploaded Notice
                                                </a>
                                            </div>
                                            @endif

                                            <span id="meeting_notice_error" class="text-danger1"></span>
                                        </div>
                                    </div>

                                    <div class="text-end">
                                        <button type="button" class="btn btn-secondary" onclick="navigateToTab('committee-tab')">Previous</button>
                                        <button type="button" class="btn btn-sf-green" id="submit_btn3" onclick="nextStep(3)">{{ isset($amendment) && $amendment->id ? __('messages.Update & Continue') : __('messages.Save & Continue') }}</button>
                                    </div>
                                </form>
                            </div>


                            {{-- Voting on Amendments Tab --}}
                            <div class="tab-pane fade border p-4" id="voting" role="tabpanel" aria-labelledby="voting-tab">
                                <form id="step_form4" action="{{route('societyRegister')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label class="form-label">{{ __('messages.TotalNoofMembers') }}<span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" onkeyup="myFunction()" oninput="calculateVotingDetails()" id="totalMembersVoting" name="total_members" value="{{ old('total_members', optional($votingOnAmendments)->total_members) }}">
                                                <span id="totalMembersError" class="text-danger1"></span>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label class="form-label">{{ __('messages.NoofMembersPresent') }}<span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" onkeyup="myFunction()" oninput="calculateVotingDetails()" id="membersPresent" name="members_present" value="{{ old('members_present', optional($votingOnAmendments)->members_present) }}">
                                                <span id="membersPresentError" class="text-danger1"></span>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label class="form-label">Is Quorum Completed?<span class="text-danger">*</span></label>
                                                <div>

                                                    <input type="radio" name="quorum_completed" value="1" onclick="toggleVotingFields(true)"
                                                        {{ old('quorum_completed', optional($votingOnAmendments)->quorum_completed) == '1' ? 'checked' : '' }}>
                                                    {{ __('messages.yes') }}

                                                    <input type="radio" name="quorum_completed" value="0" onclick="toggleVotingFields(false)"
                                                        {{ old('quorum_completed', optional($votingOnAmendments)->quorum_completed) == '0' ? 'checked' : '' }}>
                                                    {{ __('messages.no') }}
                                                </div>
                                                <span id="quorum_completed_error" class="text-danger1"></span>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row" id="votingFields" style="display: none;">
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label class="form-label">{{ __('messages.VotedInfavourofAmendment') }}<span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" onkeyup="myFunction()" oninput="calculateVotingDetails()" id="infavno" name="votes_favor" value="{{ old('votes_favor', optional($votingOnAmendments)->votes_favor) }}">
                                                <span id="infavonoError" class="text-danger1"></span>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label class="form-label">{{ __('messages.VotedAgainstAmendment') }}<span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" onkeyup="myFunction()" oninput="calculateVotingDetails()" id="disfavno" name="votes_against" value="{{ old('votes_against', optional($votingOnAmendments)->votes_against) }}">
                                                <span id="disfavonoError" class="text-danger1"></span>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label class="form-label">{{ __('messages.NoOfMembersVoted') }}</label>
                                                <input type="number" class="form-control" id="totalVoted" name="total_voted" value="{{ old('total_voted', optional($votingOnAmendments)->total_voted) }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label class="form-label">{{ __('messages.NoOfMembersAbstain') }}</label>
                                                <input type="number" class="form-control" id="abstainMembers" name="abstain_members" value="{{ old('abstain_members', optional($votingOnAmendments)->abstain_members) }}" readonly>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label">{{ __('messages.ManagingCommitteeResolutionforAmendment') }}<span class="text-danger">*</span></label>
                                                <textarea class="form-control" oninput="myFunction()" id="resolutionAmendment" name="resolution_amendment">{{ old('resolution_amendment', optional($votingOnAmendments)->resolution_amendment) }}</textarea>
                                            </div>
                                            <span id="resolution_amendmentError" class="text-danger1"></span>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label class="form-label">{{ __('messages.Upload Resolution (PDF)') }}<span class="text-danger">*</span></label>
                                                <input type="file" id="momfile6" name="resolution_file" oninput="myFunction()" class="form-control"
                                                    onchange="validateFile(this)" accept=".pdf">
                                                @if (!empty($votingOnAmendments->resolution_file))
                                                @php
                                                $file = $votingOnAmendments->resolution_file;
                                                $url = asset('storage/' . $file);
                                                $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                                $icon = $ext === 'pdf' ? 'fa-file-pdf text-danger' : 'fa-file-image text-info';
                                                $title = $ext === 'pdf' ? 'View PDF Attachment' : 'View Image Attachment';
                                                @endphp
                                                <div class="mt-2 d-flex align-items-center gap-2">
                                                    <i class="fas {{ $icon }}" style="font-size: 1.2rem;"></i>
                                                    <a href="javascript:void(0);" onclick="viewAttachment('{{ $url }}')" title="{{ $title }}">
                                                        View Uploaded Resolution
                                                    </a>
                                                </div>
                                                @endif

                                            </div>
                                            <span id="resolution_fileError" class="text-danger1"></span>
                                        </div>
                                    </div>

                                    <div class="text-end">
                                        <button
                                            type="button"
                                            class="btn btn-secondary"
                                            onclick="navigateToTab('aamshabha-tab')">
                                            {{ __('messages.previous') }}
                                        </button>
                                        <!-- <button type="button" class="btn btn-sf-green" id="btnSaveVote" onclick="votingamendment()">Final Submit</button> -->
                                        <button type="button" class="btn btn-sf-green" id="submit_btn4" onclick="nextStep(4)">{{ isset($amendment) && $amendment->id ? __('messages.Final Update') : __('messages.Final Submit') }}</button>
                                    </div>
                                </form>
                            </div>

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
    $('#district').on('change', function() {
            let districtId = this.value;
            $('#block').html('<option value="">Loading...</option>');
            if (districtId) {
                $("#district_err").text("");
                fetch(`/get-blocks/${districtId}`)
                    .then(response => response.json())
                    .then(data => {
                        let options = '<option value="">-- Select --</option>';
                        data.forEach(block => {
                            options += `<option value="${block.id}">${block.name}</option>`;
                        });
                        $('#block').html(options);
                    });
            } else {
                $('#block').html('<option value="">-- Select --</option>');
            }
    });
     document.addEventListener('DOMContentLoaded', function () {
        const fetchSocietiesUrl = "{{ route('ajax.societies.by.category') }}";
        const fetchDetailsUrl = "{{ route('ajax.society.details') }}";

        document.querySelectorAll('input[name="society_category"]').forEach(radio => {
            radio.addEventListener('change', function () {
                const category = this.value;
                fetch(`${fetchSocietiesUrl}?category=${category}`)
                    .then(response => response.json())
                    .then(data => {
                        const select = document.getElementById('society_name');
                        select.innerHTML = `<option value="">Select</option>`;
                        data.forEach(item => {
                            select.innerHTML += `<option value="${item.id}">${item.society_name}</option>`;
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching societies:', error);
                    });
            });
        });

        document.getElementById('society_name').addEventListener('change', function () {
            const societyId = this.value;
            if (!societyId) return;

            fetch(`${fetchDetailsUrl}?id=${societyId}`)
                .then(res => res.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                        return;
                    }

                    const district = document.getElementById('district');
                    district.innerHTML = `<option value="${data.district_id}" selected>${data.district_name}</option>`;

                    const block = document.getElementById('block');
                    block.innerHTML = `<option value="${data.block_id}" selected>${data.block_name}</option>`;
                })
                .catch(error => {
                    console.error('Error fetching society details:', error);
                });
        });

        const today = new Date();
        const yyyy = today.getFullYear();
        const mm = String(today.getMonth() + 1).padStart(2, '0');
        const dd = String(today.getDate()).padStart(2, '0');
        const minDate = `${yyyy}-${mm}-${dd}`;

        document.getElementById('scheduledMeetingDate').setAttribute('min', minDate);
    });
    $('input, select, textarea').on('input', function() {
        let fieldId = $(this).attr('name') + '_error';
        $('#' + fieldId).text('');
    });

    function validateStep(step) {
        let isValid = true;

        // Clear all previous error messages
        $('.text-danger1').text('');

        switch (step) {
            case 1: // Society Tab Validation
                let exist_e18_certificate = {{ @$amendment->e18_certificate ? 'true' : 'false' }};
                 const fileInput = $('input[name="e18_certificate"]')[0];
    const maxFileSize = 5 * 1024 * 1024;
                // alert(exist_e18_certificate)
                if ($('select[name="society_name"]').val() === '') {
                    isValid = false;
                    $('#society_name_error').text('Please select the Name of the Society.');
                }
                if ($('input[name="total_members"]').val() === '') {
                    isValid = false;
                    $('#total_members_error').text('Please enter the Total No. of Members.');
                }
                if ($('input[name="district"]').val() === '') {
                    isValid = false;
                    $('#district_error').text('Please select the district');
                }
                if ($('input[name="block"]').val() === '') {
                    isValid = false;
                    $('#block_error').text('Please select the block');
                }
                if ($('textarea[name="address"]').val() === '') {
                    isValid = false;
                    $('#address_error').text('Please enter the Society Address.');
                }
                if (fileInput && fileInput.files.length > 0) {
        const fileSize = fileInput.files[0].size;
        if (fileSize > maxFileSize) {
            isValid = false;
            $('#e18_certificate_error').text('File size must be less than 5MB.');
        } else {
            $('#e18_certificate_error').text('');
        }
    } else if (!exist_e18_certificate) {
        isValid = false;
        $('#e18_certificate_error').text('Please upload the E-18 Certificate.');
    } else {
        $('#e18_certificate_error').text('');
    }

    if ($('input[name="board_members"]').val() === '') {
        isValid = false;
        $('#board_members_error').text('Please enter the Total No. Of Elected Board Members.');
    } else {
        $('#board_members_error').text('');
    }

                if ($('input[name="board_members"]').val() === '') {
                    isValid = false;
                    $('#board_members_error').text('Please enter the Total No. Of Elected Board Members.');
                }
                if ($('input[name="quorum"]').val() === '') {
                    isValid = false;
                    $('#quorum_error').text('Please enter the No. of Members Required for Quorum.');
                }
                $('input[name="society_category"]').on('change', function() {
    $('#society_category_err').text('');
});
                if (!$('input[name="society_category"]:checked').val()) {
    isValid = false;
    $('#society_category_err').text('Please select the Category of the Society.');
} else {
    $('#society_category_err').text('');
}

                break;

                case 2: // Managing Committee Tab Validation
    let exist_bylaw = {{ @$managingCommittee->existing_bylaw ? 'true' : 'false' }};
    let exist_bylaw_section = {{ @$managingCommittee->bylaw_section ? 'true' : 'false' }};
    let exist_committee_approval_doc = {{ @$managingCommittee->committee_approval_doc ? 'true' : 'false' }};
    let exist_registration_certificate = {{ @$managingCommittee->registration_certificate ? 'true' : 'false' }};

    // Validate Existing By-Law (max 25MB)
    const bylawInput = $('input[name="existing_bylaw"]')[0];
    if ((!bylawInput || bylawInput.value === "") && !exist_bylaw) {
        isValid = false;
        $('#existing_bylaw_error').text('Please upload the Existing By-Law.');
    } else if (bylawInput && bylawInput.files.length > 0) {
        if (bylawInput.files[0].size > 25 * 1024 * 1024) {
            isValid = false;
            $('#existing_bylaw_error').text('File size must be less than 25MB.');
        }
    }

    // Validate Relevant Section of By-Law to be Amended (max 25MB)
    const sectionInput = $('input[name="bylaw_section"]')[0];
    if ((!sectionInput || sectionInput.value === "") && !exist_bylaw_section) {
        isValid = false;
        $('#bylaw_section_error').text('Please upload the Relevant Section of By-Law to be Amended.');
    } else if (sectionInput && sectionInput.files.length > 0) {
        if (sectionInput.files[0].size > 25 * 1024 * 1024) {
            isValid = false;
            $('#bylaw_section_error').text('File size must be less than 25MB.');
        }
    }

    // Validate Registration Certificate (required, max 2MB)
    const regCertInput = $('input[name="registration_certificate"]')[0];
    if ((!regCertInput || regCertInput.value === "") && !exist_registration_certificate) {
        isValid = false;
        $('#registration_certificate_error').text('Please upload the Registration Certificate.');
    } else if (regCertInput && regCertInput.files.length > 0) {
        if (regCertInput.files[0].size > 2 * 1024 * 1024) {
            isValid = false;
            $('#registration_certificate_error').text('File size must be less than 2MB.');
        }
    }

    // Proposed Amendment
    if ($('input[name="proposed_amendment"]').val() === '') {
        isValid = false;
        $('#proposed_amendment_error').text('Please enter the Proposed Amendment.');
    }

    // Purpose of Amendment
    if ($('textarea[name="purpose_of_amendment"]').val() === '') {
        isValid = false;
        $('#purpose_of_amendment_error').text('Please enter the Purpose of Amendment.');
    }

    // Approval and Committee Approval Doc (max 25MB)
    if (!$('input[name="approval"]:checked').val()) {
        isValid = false;
        $('#approval_error').text('Please select.');
    } else {
        if ($('input[name="approval"]:checked').val() == "yes") {
            const approvalDocInput = $('input[name="committee_approval_doc"]')[0];
            if ((!approvalDocInput || approvalDocInput.value === "") && !exist_committee_approval_doc) {
                isValid = false;
                $('#committee_approval_doc_error').text('Please upload the document approved by Managing Committee Board.');
            } else if (approvalDocInput && approvalDocInput.files.length > 0) {
                if (approvalDocInput.files[0].size > 25 * 1024 * 1024) {
                    isValid = false;
                    $('#committee_approval_doc_error').text('File size must be less than 25MB.');
                }
            }
        }
    }
    break;


            case 3: // Aam Sabha Meeting Tab Validation
                if (!$('input[name="noticeOfAamSabha"]:checked').val()) {
                    isValid = false;
                    $('#noticeOfAamSabha_error').text('Please select whether a Notice of Aam Sabha was given.');
                } else {
                    if ($('input[name="noticeOfAamSabha"]:checked').val() == '1') {
                        if ($('select[name="communication_method"]').val() === '') {
                            isValid = false;
                            $('#communication_method_error').text('Please select the Mode of Communication to Members.');
                        } else if ($('input[name="ag_meeting_date"]').val() === '') {
                            isValid = false;
                            $('#ag_meeting_date_error').text('Please select the Schedule Date of AG Meeting.');
                        } else if ($('input[name="meeting_notice"]').val() === '') {
    isValid = false;
    $('#meeting_notice_error').text('Please upload the Meeting Notice.');
} else if ($('input[name="meeting_notice"]')[0].files[0].size > 5 * 1024 * 1024) {
    isValid = false;
    $('#meeting_notice_error').text('File size must be less than or equal to 5MB.');
}

                    }
                }
                break;

            case 4:
                if ($('input[name="total_members"]').val() === '') {
                    isValid = false;
                    $('#totalMembersError').text('Please enter the Total No. Of Members.');
                }
                if ($('input[name="members_present"]').val() === '') {
                    isValid = false;
                    $('#membersPresentError').text('Please enter the No. of Members Present.');
                }
                if (!$('input[name="quorum_completed"]:checked').val()) {
                    isValid = false;
                    $('#quorum_completed_error').text('Please select whether the Quorum was Completed.');
                } else {
                    if ($('input[name="quorum_completed"]:checked').val() == "1") {
                        if ($('input[name="votes_favor"]').val() === '') {
                            isValid = false;
                            $('#infavonoError').text('Please enter the Voted favor.');
                        }
                        if ($('input[name="votes_against"]').val() === '') {
                            isValid = false;
                            $('#disfavonoError').text('Please enter the Voted against.');
                        }
                        if ($('textarea[name="resolution_amendment"]').val() === '') {
                            isValid = false;
                            $('#resolution_amendmentError').text('Please enter Resolution amendment.');
                        }
                        if ($('input[name="resolution_file"]').val() === '') {
                            isValid = false;
                            $('#resolution_fileError').text('Please Upload file.');
                        }
                    }
                }
                break;
        }

        return isValid;
    }

    function navigateToTab(targetTabId) {
        const tabButton = document.getElementById(targetTabId);


        if (tabButton) {
            const tab = new bootstrap.Tab(tabButton);
            tab.show();
        }
    }


    function nextStep(stepVal) {
        var step = stepVal;
        currentStep = stepVal;

        if (step) {
            $("#submit_btn" + step).prop('disabled', true);
            let formValidate = validateStep(step);
            console.log("459", formValidate);

            if (!validateStep(step)) {
                $("#submit_btn" + step).prop('disabled', false);
                return;
            }

            var form_data = new FormData($("#step_form" + step)[0]);
            form_data.append('step', step); // Include the step number in the form data
            let editId = $('#edit_id').val();
            console.log("editId", editId);
            if (editId) {
                form_data.append('edit_id', editId);
            }
            $.ajax({
                url: "{{ route('societyRegister') }}",
                method: 'POST',
                data: form_data,
                contentType: false,
                processData: false,
                beforeSend: function() {},
                success: function(response) {
                    console.log(675,response)
                    if (response.errors) {
                        // Handle validation errors
                        var errorMessages = '';
                        $.each(response.errors, function(key, value) {
                            errorMessages += value[0] + '<br>';
                        });
                        alert(errorMessages);
                        $("#submit_btn" + step).prop('disabled', false);
                    } else {
                        if (response.nextStep < 5) {

                            var nextTab = response.nextStep;
                            $('.nav-tabs button[data-bs-target="#' + getTabId(nextTab) + '"]').tab('show');
                            $("#submit_btn" + step).prop('disabled', false);
                        } else {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                text: response.message,
                                showConfirmButton: false,
                                timer: 2000,
                                timerProgressBar: true,
                                customClass: {
                                    popup: 'swal2-medium-text'
                                }
                            });
                            setTimeout(() => {
                                window.location.href = "{{ route('show.ablm_listing') }}";
                            }, 2000);
                        }
                    }
                },
                error: function(xhr, status, error) {
                    $('.text-danger').text(''); // Clear all errors
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(field, messages) {
                            $('#' + field + '_error').text(messages[0]);
                        });
                    } else {
                        alert('An error occurred. Please try again.');
                    }
                    $("#submit_btn" + step).prop('disabled', false);
                },

                complete: function() {}
            });

        }
    }

    function getTabId(step) {
        switch (step) {
            case 1:
                return 'society';
            case 2:
                return 'committee';
            case 3:
                return 'aamshabha';
            case 4:
                return 'voting';
            default:
                return '';
        }
    }

    function calculateVotingDetails() {
        let totalMembersInput = document.getElementById("totalMembersVoting");
        let membersPresentInput = document.getElementById("membersPresent");
        let infavnoInput = document.getElementById("infavno");
        let disfavnoInput = document.getElementById("disfavno");

        let totalMembers = parseInt(totalMembersInput.value) || 0;
        let membersPresent = parseInt(membersPresentInput.value) || 0;
        let infavno = parseInt(infavnoInput.value) || 0;
        let disfavno = parseInt(disfavnoInput.value) || 0;

        let presentError = document.getElementById("membersPresentError");
        let infavnoError = document.getElementById("infavonoError");
        let disfavnoError = document.getElementById("disfavonoError");

        // Clear previous errors
        presentError.textContent = "";
        infavnoError.textContent = "";
        disfavnoError.textContent = "";

        // Validation checks
        if (membersPresent > totalMembers) {
            presentError.textContent = "No. of members present cannot be greater than total members.";
            membersPresentInput.value = ""; // Reset the field
            return;
        }
        if (infavno > membersPresent) {
            infavnoError.textContent = "Infavour No cannot be greater than No. of Members Present.";
            infavnoInput.value = ""; // Reset the field
            return;
        }
        if (disfavno > membersPresent) {
            disfavnoError.textContent = "Disfavour No cannot be greater than No. of Members Present.";
            disfavnoInput.value = ""; // Reset the field
            return;
        }

        // Define totalVoted before checking its validation
        let totalVoted = infavno + disfavno;

        if (totalVoted > membersPresent) {
            disfavnoError.textContent = "Sum of Infavour No and Disfavour No cannot be greater than No. of Members Present.";
            disfavnoInput.value = ""; // Reset the field
            return;
        }

        let abstainMembers = membersPresent - totalVoted;

        document.getElementById("totalVoted").value = totalVoted;
        document.getElementById("abstainMembers").value = abstainMembers;
    }
    //try a submit...//
    $(document).ready(function() {
        // Disable all tabs except the first one on page load
        $('#committee-tab').prop('disabled', true);
        $('#aamshabha-tab').prop('disabled', true);
        $('#voting-tab').prop('disabled', true);
        $('#btnSave2').click(function() {
            // Enable aamshabha-tab after successful managing committee form submission
            $('#aamshabha-tab-btn').prop('disabled', false);
        });

        $('#btnSave3').click(function() {
            // Enable voting-tab after successful aam sabha form submission
            $('#voting-tab-btn').prop('disabled', false);
        });
    });

    function myFunction() {

        $('#societyactid').next("label").remove();
        $('#totalMembers').next("label").remove();
        $('#address').next("label").remove();
        $('#areaofoperation').next("label").remove();
        $('#momfile').next("label").remove();
        $('#totalnoofboardmembers').next("label").remove();
        $('#totalQuorumMembers').next("label").remove();

        $('#momfile1').next("label").remove();
        $('#releventsection').next("label").remove();
        $('#reasonofamendment').next("label").remove();
        $('#momfile2').next("label").remove();
        $('#momfile3').next("label").remove();

        $('#communicationAndUploadRows').next("label").remove();
        $('#otherMethodInput').next("label").remove();
        $('#scheduledMeetingDate').next("label").remove();
        $('#momfile4').next("label").remove();


        $('#totalMembersVoting').next("label").remove();
        $('#membersPresent').next("label").remove();
        $('#infavno').next("label").remove();
        $('#disfavno').next("label").remove();
        $('#resolutionAmendment').next("label").remove();
        $('#momfile6').next("label").remove();

    }

    function toggleFileUpload() {
        const approvalYes = document.getElementById('approvalYes').checked;
        const fileUpload = document.getElementById('fileUploadContainer');
        fileUpload.style.display = approvalYes ? 'block' : 'none';
        // Toggle required attribute
        document.getElementById('momfile3').required = approvalYes;
    }
    document.addEventListener('DOMContentLoaded', function() {
        toggleFileUpload(); // Set initial state
    });

    function toggleCommunicationMethod(show) {
        var communicationAndUploadRow = document.getElementById('communicationAndUploadRow');
        communicationAndUploadRow.style.display = show ? 'flex' : 'none';
        // Set the required attribute for relevant elements
        var communicationMethod = document.getElementById('communicationMethod');
        var scheduledMeetingDate = document.getElementById('scheduledMeetingDate');
        var meetingNotice = document.getElementById('momfile4');

        communicationMethod.required = show;
        scheduledMeetingDate.required = show;
        meetingNotice.required = show;
        var otherMethodInput = document.getElementById('otherMethodInput');
    }

    function toggleOtherMethodField() {
        var communicationMethod = document.getElementById('communicationMethod').value;
        var otherMethodField = document.getElementById('otherMethodField');
        otherMethodField.style.display = (communicationMethod === 'Other') ? 'block' : 'none';
    }
    document.addEventListener('DOMContentLoaded', function() {
        // Set initial visibility based on the default state of the radio buttons
        var noticeOfAamSabhaYes = document.getElementById('noticeOfAamSabhaYes');
        toggleCommunicationMethod(noticeOfAamSabhaYes.checked);
    });

    function toggleVotingFields(show) {
        const votingSection = document.getElementById('votingFields');
        if (show) {
            votingSection.style.display = 'flex'; // Use flex to keep grid layout
        } else {
            votingSection.style.display = 'none';

            // Clear inputs when hidden (optional but good UX)
            document.getElementById('infavno').value = '';
            document.getElementById('disfavno').value = '';
            document.getElementById('totalVoted').value = '';
            document.getElementById('abstainMembers').value = '';
            document.getElementById('resolutionAmendment').value = '';
            document.getElementById('momfile6').value = '';
        }
    }

    function viewAttachment(url) {
        window.open(url, '_blank', 'width=1000,height=800,noopener,noreferrer');
    }
</script>
@endsection