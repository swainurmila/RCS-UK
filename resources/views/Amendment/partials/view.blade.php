<div class="accordion" id="societyAccordion">
    <!-- Society Registration Details -->
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingOne">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                aria-expanded="true" aria-controls="collapseOne">
                {{ __('messages.SocietyInformation') }}
            </button>
        </h2>
        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
            data-bs-parent="#societyAccordion">
            <div class="accordion-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>{{ __('messages.Nameofthesociety') }}:</strong> {{$amendment->society_detail->society_name ?? 'NA' }}</p>
                        <p><strong>{{ __('messages.Typeofthesociety') }}:</strong> {{$amendment->society_detail->society_category ?? 'NA' }}</p>
                        <p><strong>{{ __('messages.TotalNoofMembers') }}:</strong>{{ $amendment->total_members }}</p>
                        <p><strong>{{ __('messages.TotalNoOfElectedBoardMembers') }}:</strong>{{ $amendment->total_board_members }}</p>
                        <p><strong>{{ __('messages.NoofMembersRequiredforQuorum') }}:</strong>{{ $amendment->quorum_members }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>{{ __('messages.SocietyAddress') }}:</strong>{{ $amendment->address }}</p>
                        <p><strong>{{ __('messages.UploadE-18Certificate') }}:</strong>
                            @if ($amendment->e18_certificate)
                            @php
                            $file = $amendment->e18_certificate;
                            $url = asset('storage/' . $file);
                            $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                            $iconClass = $extension === 'pdf' ? 'fa-file-pdf text-danger' : 'fa-file-image text-info';
                            $title = $extension === 'pdf' ? 'View PDF Attachment' : 'View Image Attachment';
                            @endphp

                            <a href="javascript:void(0);" title="{{ $title }}" onclick="viewAttachment('{{ $url }}')" style="font-size: 1.5rem;">
                                <i class="fas {{ $iconClass }}"></i>
                            </a>
                            @else
                            <span>NA</span>
                            @endif
                        </p>

                        <p><strong>{{ __('messages.ApplyDate') }}:</strong>{{ \Carbon\Carbon::parse($amendment->created_at)->format('d/m/Y') }}</p>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <!-- managing Commitee -->
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingTwo">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                {{ __('messages.ManagingCommittee') }}
            </button>
        </h2>
        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
            data-bs-parent="#societyAccordion">
            <div class="accordion-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>{{ __('messages.UploadExistingBy-Law') }}</strong>
                            @if ($amendment->managing_committee->existing_bylaw)
                            @php
                            $file = $amendment->managing_committee->existing_bylaw;
                            $url = asset('storage/' . $file);
                            $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                            $iconClass = $extension === 'pdf' ? 'fa-file-pdf text-danger' : 'fa-file-image text-info';
                            $title = $extension === 'pdf' ? 'View PDF Attachment' : 'View Image Attachment';
                            @endphp
                            <a href="javascript:void(0);" title="{{ $title }}" onclick="viewAttachment('{{ $url }}')" style="font-size: 1.5rem;">
                                <i class="fas {{ $iconClass }}"></i>
                            </a>
                            @else
                            <span>N/A</span>
                            @endif
                        </p>
                        <p><strong>{{ __('messages.UploadRelevantSectionofBy-LawtobeAmended') }}:</strong>
                            @if ($amendment->managing_committee->bylaw_section)
                            @php
                            $file = $amendment->managing_committee->bylaw_section;
                            $url = asset('storage/' . $file);
                            $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                            $iconClass = $extension === 'pdf' ? 'fa-file-pdf text-danger' : 'fa-file-image text-info';
                            $title = $extension === 'pdf' ? 'View PDF Attachment' : 'View Image Attachment';
                            @endphp
                            <a href="javascript:void(0);" title="{{ $title }}" onclick="viewAttachment('{{ $url }}')" style="font-size: 1.5rem;">
                                <i class="fas {{ $iconClass }}"></i>
                            </a>
                            @else
                            <span>N/A</span>
                            @endif
                        </p>


                        <p><strong>{{ __('messages.ProposedAmendment') }}:</strong>{{ $amendment->managing_committee->proposed_amendment }}
                        </p>
                        <p><strong>{{ __('messages.PurposeofAmendment') }}:</strong>
                            {{ $amendment->managing_committee->purpose_of_amendment }}
                        </p>

                        <p><strong>{{ __('messages.UploadDocumentApprovedbyManagingCommitteeBoard') }}:</strong>
                            @if ($amendment->managing_committee->committee_approval_doc)
                            @php
                            $file = $amendment->managing_committee->committee_approval_doc;
                            $url = asset('storage/' . $file);
                            $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                            $iconClass = $extension === 'pdf' ? 'fa-file-pdf text-danger' : 'fa-file-image text-info';
                            $title = $extension === 'pdf' ? 'View PDF Attachment' : 'View Image Attachment';
                            @endphp
                            <a href="javascript:void(0);" title="{{ $title }}" onclick="viewAttachment('{{ $url }}')" style="font-size: 1.5rem;">
                                <i class="fas {{ $iconClass }}"></i>
                            </a>
                            @else
                            <span>N/A</span>
                            @endif
                        </p>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Aam sabha  -->
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingThree">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                {{ __('messages.AamSabhaMeeting') }}
            </button>
        </h2>
        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
            data-bs-parent="#societyAccordion">
            <div class="accordion-body">
                <div class="row">
                    @if($amendment->aam_sabha_meeting)
                    <div class="col-md-6">
                        <p><strong>{{ __('messages.IsAamSabha') }}:</strong>
                            <span>{{ $amendment->aam_sabha_meeting->noticeOfAamSabha ? 'Yes' : 'No' }}</span>
                        </p>
                        <p><strong>{{ __('messages.ModeofCommunicationtoMembers') }}:</strong>
                            {{ $amendment->aam_sabha_meeting->communication_method }}
                        </p>
                        <p><strong>{{ __('messages.OtherModeofCommunicationtoMembers') }}:</strong>
                            {{ $amendment->aam_sabha_meeting->other_communication ?? 'N/A' }}
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>{{ __('messages.ScheduleDateOfAGMeeting') }}:</strong>
                            {{ \Carbon\Carbon::parse($amendment->aam_sabha_meeting->ag_meeting_date)->format('d/m/Y') }}
                        </p>
                        <p><strong>{{ __('messages.MeetingNotice') }}:</strong>
                            @if ($amendment->aam_sabha_meeting->meeting_notice)
                                @php
                                    $file = $amendment->aam_sabha_meeting->meeting_notice;
                                    $url = asset('storage/' . $file);
                                    $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                    $iconClass = $extension === 'pdf' ? 'fa-file-pdf text-danger' : 'fa-file-image text-info';
                                    $title = $extension === 'pdf' ? 'View PDF Attachment' : 'View Image Attachment';
                                @endphp
                                <a href="javascript:void(0);" title="{{ $title }}" onclick="viewAttachment('{{ $url }}')" style="font-size: 1.5rem;">
                                    <i class="fas {{ $iconClass }}"></i>
                                </a>
                            @else
                                <span>N/A</span>
                            @endif
                        </p>
                    </div>
                    @else
                    <div class="col-md-12">
                        <p>No Aam Sabha Meeting Data Found.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Voting  -->
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingFour">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                {{ __('messages.VotingonAmendments') }}
            </button>
        </h2>
        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
            data-bs-parent="#societyAccordion">
            <div class="accordion-body">
                @if($amendment->voting_on_amendments)
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>{{ __('messages.TotalNoofMembers') }}:</strong>
                            {{ $amendment->voting_on_amendments->total_members }}
                        </p>
                        <p><strong>{{ __('messages.NoofMembersPresent') }}:</strong>
                            {{ $amendment->voting_on_amendments->members_present }}
                        </p>
                        <p><strong>{{ __('messages.IsQuorum') }}:</strong>
                            {{ $amendment->voting_on_amendments->quorum_completed ? 'Yes' : 'No' }}
                        </p>
                        <p><strong>{{ __('messages.VotedInfavourofAmendment') }}:</strong>
                            {{ $amendment->voting_on_amendments->votes_favor }}
                        </p>
                        <p><strong>{{ __('messages.VotedAgainstAmendment') }}:</strong>
                            {{ $amendment->voting_on_amendments->votes_against }}
                        </p>
                        <p><strong>{{ __('messages.NoOfMembersVoted') }}:</strong>
                            {{ $amendment->voting_on_amendments->total_voted }}
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>{{ __('messages.NoOfMembersAbstain') }}:</strong>
                            {{ $amendment->voting_on_amendments->abstain_members }}
                        </p>
                        <p><strong>{{ __('messages.ManagingCommitteeResolutionforAmendment') }}:</strong>
                            {{ $amendment->voting_on_amendments->resolution_amendment }}
                        </p>
                        <p><strong>{{ __('messages.Resolution') }}:</strong>
                            @if ($amendment->voting_on_amendments->resolution_file)
                                @php
                                    $file = $amendment->voting_on_amendments->resolution_file;
                                    $url = asset('storage/' . $file);
                                    $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                    $iconClass = $extension === 'pdf' ? 'fa-file-pdf text-danger' : 'fa-file-image text-info';
                                    $title = $extension === 'pdf' ? 'View PDF Attachment' : 'View Image Attachment';
                                @endphp
                                <a href="javascript:void(0);" title="{{ $title }}" onclick="viewAttachment('{{ $url }}')" style="font-size: 1.5rem;">
                                    <i class="fas {{ $iconClass }}"></i>
                                </a>
                            @else
                                <span>N/A</span>
                            @endif
                        </p>
                    </div>
                </div>
                @else
                <p>No Voting Data Found.</p>
                @endif
            </div>
        </div>
    </div>

</div>