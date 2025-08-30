@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <h2 class="mb-4">{{ __('messages.By-LawDetails') }}</h2>

    <div class="accordion" id="accordionExample">
        {{-- Society Information --}}
        <div class="card">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        {{ __('messages.SocietyInformation') }}
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><b>{{ __('messages.Nameofthesociety') }}:</b></label>
                                            <p>{{ optional($amendment->society_detail)->society_name ?? '-' }}</p>
                                        </div>
                                        <div class="form-group">
                                            <label><b>{{ __('messages.TotalNoofMembers') }}:</b></label>
                                            <p>{{ $amendment->total_members }}</p>
                                        </div>
                                        <div class="form-group">
                                            <label><b>{{ __('messages.TotalNoOfElectedBoardMembers') }}:</b></label>
                                            <p>{{ $amendment->total_board_members }}</p>
                                        </div>
                                        <div class="form-group">
                                            <label><b>{{ __('messages.status') }}:</b></label>
                                            <p>Approve</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><b>{{ __('messages.SocietyAddress') }}:</b></label>
                                            <p>{{ $amendment->address }}</p>
                                        </div>
                                        <div class="form-group">
                                            <label><b>{{ __('messages.UploadE-18Certificate') }}:</b></label>
                                            <p>
                                                <a href="{{ asset('storage/' . $amendment->e18_certificate) }}" target="_blank">
                                                    <i class="fa fa-eye"></i> View
                                                </a>
                                            </p>
                                        </div>
                                        <div class="form-group">
                                            <label><b>{{ __('messages.NoofMembersRequiredforQuorum') }}:</b></label>
                                            <p>{{ $amendment->quorum_members }}</p>
                                        </div>
                                        <div class="form-group">
                                            <label><b>{{ __('messages.ApplyDate') }}:</b></label>
                                            <p>{{ \Carbon\Carbon::parse($amendment->created_at)->format('d/m/Y') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Managing Committee --}}
        <div class="card">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        {{ __('messages.ManagingCommittee') }}
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="card">
                            <div class="card-body">
                                @if($amendment->managing_committee)
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><b>{{ __('messages.UploadExistingBy-Law') }}:</b></label>
                                            <p>
                                                <a href="{{ asset('storage/' . $amendment->managing_committee->existing_bylaw) }}" target="_blank">
                                                    <i class="fa fa-eye"></i> View
                                                </a>
                                            </p>
                                        </div>
                                        <div class="form-group">
                                            <label><b>{{ __('messages.UploadRelevantSectionofBy-LawtobeAmended') }}:</b></label>
                                            <p>
                                                <a href="{{ asset('storage/' . $amendment->managing_committee->bylaw_section) }}" target="_blank">
                                                    <i class="fa fa-eye"></i> View
                                                </a>
                                            </p>
                                        </div>
                                        <div class="form-group">
                                            <label><b>{{ __('messages.ProposedAmendment') }}:</b></label>
                                            <p>{{ $amendment->managing_committee->proposed_amendment }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><b>{{ __('messages.PurposeofAmendment') }}:</b></label>
                                            <p>{{ $amendment->managing_committee->purpose_of_amendment }}</p>
                                        </div>
                                        <div class="form-group">
                                            <label><b>{{ __('messages.UploadDocumentApprovedbyManagingCommitteeBoard') }}:</b></label>
                                            @if($amendment->managing_committee->committee_approval_doc)
                                            <p>
                                                <a href="{{ asset('storage/' . $amendment->managing_committee->committee_approval_doc) }}" target="_blank">
                                                    <i class="fa fa-eye"></i> View
                                                </a>
                                            </p>
                                            @else
                                            <span>N/A</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @else
                                <p>No Managing Committee Data Found.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Aam Sabha Meeting --}}
        <div class="card">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        {{ __('messages.AamSabhaMeeting') }}
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="card">
                            <div class="card-body">
                                @if($amendment->aam_sabha_meeting)
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><b>{{ __('messages.IsAamSabha') }}:</b></label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" {{ $amendment->aam_sabha_meeting->noticeOfAamSabha ? 'checked' : '' }} disabled>
                                                <label class="form-check-label">Yes</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label><b>{{ __('messages.ModeofCommunicationtoMembers') }}:</b></label>
                                            <p>{{ $amendment->aam_sabha_meeting->communication_method }}</p>
                                        </div>
                                        <div class="form-group">
                                            <label><b>{{ __('messages.OtherModeofCommunicationtoMembers') }}:</b></label>
                                            <p>{{ $amendment->aam_sabha_meeting->other_communication ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><b>{{ __('messages.ScheduleDateOfAGMeeting') }}:</b></label>
                                            <p>{{ \Carbon\Carbon::parse($amendment->aam_sabha_meeting->ag_meeting_date)->format('d/m/Y') }}</p>
                                        </div>
                                        <div class="form-group">
                                            <label><b>{{ __('messages.MeetingNotice') }}:</b></label>
                                            <p>
                                                <a href="{{ asset('storage/' . $amendment->aam_sabha_meeting->meeting_notice) }}" target="_blank">
                                                    <i class="fa fa-eye"></i> View
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                @else
                                <p>No Aam Sabha Meeting Data Found.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Voting on Amendments --}}
        <div class="card">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                        {{ __('messages.VotingonAmendments') }}
                    </button>
                </h2>
                <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="card">
                            <div class="card-body">
                                @if($amendment->voting_on_amendments)
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><b>{{ __('messages.TotalNoofMembers') }}:</b></label>
                                            <p>{{ $amendment->voting_on_amendments->total_members }}</p>
                                        </div>
                                        <div class="form-group">
                                            <label><b>{{ __('messages.NoofMembersPresent') }}:</b></label>
                                            <p>{{ $amendment->voting_on_amendments->members_present }}</p>
                                        </div>
                                        <div class="form-group">
                                            <label><b>{{ __('messages.IsQuorum') }}:</b></label>
                                            <p>{{ $amendment->voting_on_amendments->quorum_completed ? 'Yes' : 'No' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><b>{{ __('messages.VotedInfavourofAmendment') }}:</b></label>
                                            <p>{{ $amendment->voting_on_amendments->votes_favor }}</p>
                                        </div>
                                        <div class="form-group">
                                            <label><b>{{ __('messages.VotedAgainstAmendment') }}:</b></label>
                                            <p>{{ $amendment->voting_on_amendments->votes_against }}</p>
                                        </div>
                                        <div class="form-group">
                                            <label><b>{{ __('messages.NoOfMembersVoted') }}:</b></label>
                                            <p>{{ $amendment->voting_on_amendments->total_voted }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><b>{{ __('messages.NoOfMembersAbstain') }}:</b></label>
                                            <p>{{ $amendment->voting_on_amendments->abstain_members }}</p>
                                        </div>
                                        <div class="form-group">
                                            <label><b>{{ __('messages.ManagingCommitteeResolutionforAmendment') }}:</b></label>
                                            <p>{{ $amendment->voting_on_amendments->resolution_amendment }}</p>
                                        </div>
                                        <div class="form-group">
                                            <label><b>{{ __('messages.Resolution') }}:</b></label>
                                            @if($amendment->voting_on_amendments->resolution_file)
                                            <p>
                                                <a href="{{ asset('storage/' . $amendment->voting_on_amendments->resolution_file) }}" target="_blank">
                                                    <i class="fa fa-eye"></i> View
                                                </a>
                                            </p>
                                            @else
                                            <span>N/A</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @else
                                <p>No Voting Data Found.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="d-flex justify-content-center gap-2 mt-4 p-3 bg-light border-top action-div"
        style="margin-bottom: 60px;">
        <a class="btn btn-info" href="{{ route('show.ablm_listing') }}">
            <i class="fas fa-list"></i> {{ __('messages.BackToList') }}
        </a>
    </div>
</div>
@endsection
