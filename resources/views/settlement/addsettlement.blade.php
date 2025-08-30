@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">{{ __('messages.app-Settlement') }}</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a
                                    href="javascript: void(0);">{{ __('messages.cooperatives_department') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('messages.new_settlement') }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-0 dash-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body p-0">
                                        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active disabled" id="nav-link-1" data-bs-toggle="tab"
                                                    href="javascript:void(0);" role="tab">
                                                    <span class="d-none d-sm-block">{{ __('messages.step_01') }}</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link disabled" id="nav-link-2" data-bs-toggle="tab"
                                                    href="javascript:void(0);" role="tab">
                                                    <span class="d-none d-sm-block">{{ __('messages.step_02') }}</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link disabled" id="nav-link-3" data-bs-toggle="tab"
                                                    href="javascript:void(0);" role="tab">
                                                    <span class="d-none d-sm-block">{{ __('messages.step_03') }}</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link disabled" id="nav-link-4" data-bs-toggle="tab"
                                                    href="javascript:void(0);" role="tab">
                                                    <span class="d-none d-sm-block">{{ __('messages.step_04') }}</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link disabled" id="nav-link-5" data-bs-toggle="tab"
                                                    href="javascript:void(0);" role="tab">
                                                    <span class="d-none d-sm-block">{{ __('messages.step_05') }}</span>
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="tab-content p-0 text-muted">
                                            <!-- Step 1 -->
                                            <div class="tab-pane active" id="step1" role="tabpanel">
                                                <br>
                                                <p class="fw-bold">({{ __('messages.Applicant-Details-&-Contact-Info') }})
                                                </p>

                                                <form id="step_form1">
                                                    @csrf
                                                    <!-- Applicant Details -->
                                                    <fieldset class="border p-3 mb-3">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.Applicant-Name') }}
                                                                    :</label>
                                                                <span class="text-danger">*</span>
                                                                <input class="form-control form-control-sm" name="step"
                                                                    type="hidden" id="step1" value="1" />
                                                                <input class="form-control form-control-sm" type="text"
                                                                    onkeyup="validateData(this,'applicant_name')"
                                                                    id="applicant_name"
                                                                    placeholder="{{ __('messages.Applicant-Name') }}"
                                                                    name="applicant_name"
                                                                    value="{{ $societyDetails->applicant_name ?? '' }}" />
                                                                <input class="form-control form-control-sm"
                                                                    id="settlement_id" name="settlement_id" type="hidden"
                                                                    value="{{ $societyDetails->id ?? '' }}" />
                                                                <span class="error" id="applicant_name_err"></span>
                                                            </div>

                                                            <div class="col-md-6 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.fname') }}
                                                                    :</label>
                                                                <span class="text-danger">*</span>
                                                                <input class="form-control form-control-sm" name="step"
                                                                    type="hidden" id="step1" value="1" />
                                                                <input class="form-control form-control-sm" type="text"
                                                                    onkeyup="validateData(this,'father_name')"
                                                                    id="father_name"
                                                                    placeholder="{{ __('messages.fname') }}"
                                                                    name="father_name" value="" />
                                                                <span class="error" id="father_name_err"></span>
                                                            </div>

                                                            <div class="col-md-6 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.mobile_number') }}
                                                                    :</label>
                                                                <span class="text-danger">*</span>
                                                                <input class="form-control form-control-sm" name="step"
                                                                    type="hidden" id="step1" value="1" />
                                                                <input class="form-control form-control-sm" type="text"
                                                                    onkeyup="validateData(this,'mobile_number')"
                                                                    id="mobile_number"
                                                                    placeholder="{{ __('messages.mobile_number') }}"
                                                                    name="mobile_number" value="" />
                                                                <span class="error" id="mobile_no_err"></span>
                                                            </div>

                                                            <div class="col-md-6 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.email_title') }}<small
                                                                        class="text-muted">(optional)</small>
                                                                    :</label>
                                                                <input class="form-control form-control-sm" name="step"
                                                                    type="hidden" id="step1" value="1" />
                                                                <input class="form-control form-control-sm" type="text"
                                                                    onkeyup="validateData(this,'email')" id="email"
                                                                    placeholder="{{ __('messages.email_placeholder') }}"
                                                                    name="email" value="" />
                                                                <span class="error" id="email_err"></span>
                                                            </div>

                                                            <div class="col-md-12 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.fulladdress') }}
                                                                    :</label>
                                                                <span class="text-danger">*</span>
                                                                <input class="form-control form-control-sm" name="step"
                                                                    type="hidden" id="step1" value="1" />
                                                                <textarea class="form-control form-control-sm" type="text" onkeyup="validateData(this,'full_address')"
                                                                    id="full_address" placeholder="{{ __('messages.fulladdress') }}" name="full_address" value=""></textarea>
                                                                <span class="error" id="full_address_err"></span>
                                                            </div>
                                                        </div>
                                                    </fieldset>

                                                    <div>
                                                        <button class="btn btn-primary float-end" type="button"
                                                            id="submit_btn1"
                                                            onclick="nextStep(1)">{{ __('messages.save&submit') }}</button>
                                                    </div>

                                                </form>
                                            </div>

                                            <!-- Step 2 -->
                                            <div class="tab-pane" id="step2" role="tabpanel">
                                                <br>
                                                <p class="fw-bold">({{ __('messages.Parties') }})</p>
                                                <form id="step_form2" enctype="multipart/form-data">
                                                    @csrf
                                                    <!-- Parties Involved -->
                                                    <label
                                                        class="col-form-label fw-bold">{{ __('messages.Petitioner') }}</label>
                                                    <fieldset class="border p-3 mb-3">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <input type="hidden" name="step" value="2"
                                                                    id="step2">
                                                                <input type="hidden" name="parties_detailsId"
                                                                    id="partiesId" value="">
                                                                {{-- <input class="form-control form-control-sm" id="partiesId"
                                                                    name="parties_detailsId" type="text"
                                                                    value="" /> --}}


                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.name') }}
                                                                    :</label><span class="text-danger">*</span>
                                                                <input class="form-control form-control-sm" name="step"
                                                                    type="hidden" id="step1" value="1" />
                                                                <input class="form-control form-control-sm" type="text"
                                                                    onkeyup="validateData(this,'name1')" id="name1"
                                                                    placeholder="{{ __('messages.name') }}"
                                                                    name="name1" value="" />
                                                                <span class="error" id="name1_err"></span>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.Address') }}
                                                                    :</label>
                                                                <span class="text-danger">*</span>
                                                                <textarea class="form-control form-control-sm" type="text" onkeyup="validateData(this,'address1')" id="address1"
                                                                    placeholder="{{ __('messages.Address') }}" name="address1" value=""></textarea>
                                                                <span class="error" id="address1_err"></span>
                                                            </div>

                                                            <div class="col-md-6 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.name') }}
                                                                    :</label>
                                                                <input class="form-control form-control-sm" type="text"
                                                                    onkeyup="validateData(this,'name2')" id="name2"
                                                                    placeholder="{{ __('messages.name') }}"
                                                                    name="name2" value="" />
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.Address') }}
                                                                    :</label>
                                                                <textarea class="form-control form-control-sm" type="text" onkeyup="validateData(this,'address2')" id="address2"
                                                                    placeholder="{{ __('messages.Address') }}" name="address2" value=""></textarea>

                                                            </div>

                                                            <div class="col-md-6 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.name') }}
                                                                    :</label>
                                                                <input class="form-control form-control-sm" type="text"
                                                                    onkeyup="validateData(this,'name3')" id="name3"
                                                                    placeholder="{{ __('messages.name') }}"
                                                                    name="name3" value="" />
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.Address') }}
                                                                    :</label>
                                                                <textarea class="form-control form-control-sm" type="text" onkeyup="validateData(this,'address3')" id="address3"
                                                                    placeholder="{{ __('messages.Address') }}" name="address3" value=""></textarea>

                                                            </div>
                                                        </div>
                                                    </fieldset>

                                                    <label
                                                        class="col-form-label fw-bold">{{ __('messages.Defendant') }}</label>
                                                    <!-- Operational Area -->
                                                    <fieldset class="border p-3 mb-3">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.name') }}
                                                                    :</label><span class="text-danger">*</span>
                                                                <input class="form-control form-control-sm" type="text"
                                                                    onkeyup="validateData(this,'dname1')" id="dname1"
                                                                    placeholder="{{ __('messages.name') }}"
                                                                    name="dname1" value="" />
                                                                <span class="error" id="dname1_err"></span>
                                                            </div>

                                                            <div class="col-md-6 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.Address') }}
                                                                    :</label>
                                                                <span class="text-danger">*</span>
                                                                <textarea class="form-control form-control-sm" type="text" onkeyup="validateData(this,'daddress1')"
                                                                    id="daddress1" placeholder="{{ __('messages.Address') }}" name="daddress1" value=""></textarea>
                                                                <span class="error" id="daddress1_err"></span>
                                                            </div>

                                                            <div class="col-md-6 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.name') }}
                                                                    :</label>

                                                                <input class="form-control form-control-sm" type="text"
                                                                    onkeyup="validateData(this,'dname2')" id="dname2"
                                                                    placeholder="{{ __('messages.name') }}"
                                                                    name="dname2" value="" />
                                                            </div>

                                                            <div class="col-md-6 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.Address') }}
                                                                    :</label>
                                                                <textarea class="form-control form-control-sm" type="text" onkeyup="validateData(this,'daddress2')"
                                                                    id="daddress2" placeholder="{{ __('messages.Address') }}" name="daddress2" value=""></textarea>

                                                            </div>

                                                            <div class="col-md-6 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.name') }}
                                                                    :</label>
                                                                <input class="form-control form-control-sm" type="text"
                                                                    onkeyup="validateData(this,'dname3')" id="dname3"
                                                                    placeholder="{{ __('messages.name') }}"
                                                                    name="dname3" value="" />
                                                            </div>

                                                            <div class="col-md-6 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.Address') }}
                                                                    :</label>
                                                                <textarea class="form-control form-control-sm" type="text" onkeyup="validateData(this,'daddress3')"
                                                                    id="daddress3" placeholder="{{ __('messages.Address') }}" name="daddress3" value=""></textarea>

                                                            </div>
                                                        </div>
                                                    </fieldset>

                                                    <div class="d-flex justify-content-between">
                                                        <button class="btn btn-secondary" type="button"
                                                            onclick="showPreviousStep(1)"
                                                            style="width: 12%;">{{ __('messages.back') }}</button>
                                                        <button class="btn btn-primary" type="button" id="submit_btn2"
                                                            onclick="nextStep(2)">{{ __('messages.save&submit') }}</button>
                                                    </div>

                                                </form>
                                            </div>

                                            <!-- Step 3 -->
                                            <div class="tab-pane" id="step3" role="tabpanel">
                                                <br>
                                                <p class="fw-bold">({{ __('messages.Dispute-Details') }})</p>
                                                <form id="step_form3" enctype="multipart/form-data">
                                                    @csrf
                                                    <!-- Dispute Details -->
                                                    <fieldset class="border p-3 mb-3">
                                                        <div class="row">
                                                            <div class="col-md-12 mb-3">
                                                                <input class="form-control form-control-sm"
                                                                    id="dispute_detailsId" name="disputeId"
                                                                    type="hidden" value="" />
                                                                <input type="hidden" value="3" id="step3"
                                                                    name="step" />
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.against-the-defendant') }}
                                                                    :</label><span class="text-danger">*</span>
                                                                <textarea class="form-control form-control-sm" type="text" onkeyup="validateData(this,'against_the_defendant')"
                                                                    id="against_the_defendant" placeholder="{{ __('messages.Answer') }}.." name="against_the_defendant"
                                                                    value=""></textarea>
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.plaintiff-seek-arbitration') }}
                                                                    :</label>
                                                                <span class="text-danger">*</span>
                                                                <textarea class="form-control form-control-sm" type="text"
                                                                    onkeyup="validateData(this,'plaintiff_seek_arbitration')" id="plaintiff_seek_arbitration"
                                                                    placeholder="{{ __('messages.Answer') }}" name="plaintiff_seek_arbitration" value=""></textarea>
                                                            </div>

                                                            <div class="col-md-12 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.cause-of-action-arose') }}
                                                                    :</label>
                                                                <span class="text-danger">*</span>
                                                                <textarea class="form-control form-control-sm" type="text" onkeyup="validateData(this,'cause_of_action_arose')"
                                                                    id="cause_of_action_arose" placeholder="{{ __('messages.Answer') }}" name="cause_of_action_arose"
                                                                    value=""></textarea>
                                                            </div>


                                                            <div class="col-md-9 mb-3">
                                                                <label class="form-label fw-bold">
                                                                    {{ __('messages.Valuation-of-the-case') }} <span
                                                                        class="text-danger">*</span> :
                                                                </label>
                                                                <textarea class="form-control form-control-sm" onkeyup="validateData(this,'valuation_case')" id="valuation_case"
                                                                    placeholder="{{ __('messages.Answer') }}" name="valuation_case" cols="30" rows="10"></textarea>
                                                            </div>

                                                            <div class="col-md-3 mb-3">
                                                                <label class="form-label fw-bold">
                                                                    {{ __('messages.Amount') }} :
                                                                </label>
                                                                <input class="form-control form-control-sm"
                                                                    onkeyup="validateData(this,'valuation_case_amount')"
                                                                    id="valuation_case_amount"
                                                                    placeholder="{{ __('messages.Amount') }}"
                                                                    value="0" name="valuation_case_amount" />
                                                            </div>

                                                            <div class="col-md-12 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.Desired-relief') }}
                                                                    :</label>
                                                                <span class="text-danger">*</span>
                                                                <textarea class="form-control form-control-sm" type="text" onkeyup="validateData(this,'desired_relief')"
                                                                    id="desired_relief" placeholder="{{ __('messages.Answer') }}" name="desired_relief" value=""></textarea>
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.witnesses-and-documents') }}
                                                                    :</label>
                                                                <span class="text-danger">*</span>
                                                                <textarea class="form-control form-control-sm" type="text" onkeyup="validateData(this,'witnesses_and_documents')"
                                                                    id="witnesses_and_documents" placeholder="{{ __('messages.Answer') }}" name="witnesses_and_documents"
                                                                    value=""></textarea>
                                                            </div>
                                                        </div>
                                                    </fieldset>

                                                    <div class="d-flex justify-content-between">
                                                        <button class="btn btn-secondary" type="button"
                                                            onclick="showPreviousStep(2)"
                                                            style="width: 12%;">{{ __('messages.back') }}</button>
                                                        <button class="btn btn-primary" type="button" id="submit_btn2"
                                                            onclick="nextStep(3)">{{ __('messages.save&submit') }}</button>
                                                    </div>
                                            </div>

                                            <!-- Step 4 -->
                                            {{-- <div class="tab-pane" id="step4" role="tabpanel">
                                                <br>
                                                <p class="fw-bold">({{ __('messages.Declaration-&-Verification') }})</p>
                                                <form id="step_form4" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" id="step4" value="4"
                                                        name="step" />
                                                    <input type="hidden" value="" id="declaration_id"
                                                        name="declarationId" />

                                                    <fieldset class="border p-3 mb-3">
                                                        <div class="row">
                                                            <div class="col-md-12 mb-3">
                                                                <div>
                                                                    <input type="checkbox" name="is_confirmed"
                                                                        id="is_confirmed" value="1" />
                                                                    <label
                                                                        class="form-label fw-bold">{{ __('messages.information-provided') }}</label>
                                                                </div>
                                                                <span class="error" id="is_confirmed_err"></span>
                                                            </div>
                                                        </div>
                                                    </fieldset>

                                                    <!-- Signatures -->
                                                    <fieldset class="border p-3 mb-3">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label>{{ __('messages.Upload-signature') }}:<span
                                                                        class="text-danger">*</span></label>
                                                                <input class="form-control form-control-sm" type="file"
                                                                    name="Upload_signature" id="Upload_signature"
                                                                    value="" />
                                                                @if (!empty($feasibilityReports->Upload_signature))
                                                                    <div class="mt-2">
                                                                        <a href="javascript:void(0);"
                                                                            onclick="viewAttachment('{{ asset('storage/' . $feasibilityReports->Upload_signature) }}')">View</a>
                                                                    </div>
                                                                @endif
                                                                <span class="error" id="Upload_signature_err"></span>
                                                            </div>
                                                        </div>
                                                    </fieldset>

                                                    <fieldset class="border p-3 mb-3">
                                                        <div class="row">
                                                            <div class="col-md-12 mb-3">

                                                                <div class="row">

                                                                    <div class="col-md-6">
                                                                        <div class="d-flex flex-column">
                                                                            <label class="mr-10">
                                                                                <input class="form-check-input mr-10"
                                                                                    name="is_individual" type="radio"
                                                                                    onclick="showDiv('show','individual')"
                                                                                    value="1"
                                                                                    {{ isset($feasibilityReports) && $feasibilityReports->is_individual == '1' ? 'checked' : '' }} />
                                                                                {{ __('messages.Individual') }}
                                                                            </label>
                                                                            <label class="mr-10">
                                                                                <input class="form-check-input mr-10"
                                                                                    name="is_individual" type="radio"
                                                                                    onclick="showDiv('hide','authorized')"
                                                                                    value="2"
                                                                                    {{ isset($feasibilityReports) && $feasibilityReports->is_individual == '2' ? 'checked' : '' }} />
                                                                                {{ __('messages.Authorized-Representative') }}
                                                                            </label>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-6">
                                                                        <label>{{ __('messages.Upload-Resolution') }}<span
                                                                                class="text-danger">*</span></label>
                                                                        <input class="form-control form-control-sm"
                                                                            type="file" name="upload_resolution"
                                                                            id="upload_resolution" value="" />
                                                                        @if (!empty($feasibilityReports->upload_resolution))
                                                                            <div class="mt-2">
                                                                                <a href="javascript:void(0);"
                                                                                    onclick="viewAttachment('{{ asset('storage/' . $feasibilityReports->upload_resolution) }}')">View</a>
                                                                            </div>
                                                                        @endif
                                                                        <span class="error"
                                                                            id="upload_resolution_err"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </fieldset>

                                                    <fieldset class="border p-3 mb-3">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label>{{ __('messages.AadhaarUpload') }}:<span
                                                                        class="text-danger">*</span></label>
                                                                <input class="form-control form-control-sm" type="file"
                                                                    name="aadhar_upload" id="aadhar_upload"
                                                                    value="" />
                                                                @if (!empty($feasibilityReports->aadhar_upload))
                                                                    <div class="mt-2">
                                                                        <a href="javascript:void(0);"
                                                                            onclick="viewAttachment('{{ asset('storage/' . $feasibilityReports->aadhar_upload) }}')">View</a>
                                                                    </div>
                                                                @endif
                                                                <span class="error" id="aadhar_upload_err"></span>
                                                            </div>
                                                        </div>
                                                    </fieldset>

                                                    <div class="d-flex justify-content-between">
                                                        <button class="btn btn-secondary" type="button"
                                                            style="width: 12%;"
                                                            onclick="showPreviousStep(3)">{{ __('messages.back') }}</button>
                                                        <button class="btn btn-primary" type="button" id="submit_btn4"
                                                            onclick="nextStep(4)">{{ __('messages.save&submit') }}</button>
                                                    </div>

                                                </form>
                                            </div> --}}
                                            <div class="tab-pane" id="step4" role="tabpanel">
                                                <br>
                                                <p class="fw-bold">({{ __('messages.Declaration-&-Verification') }})</p>
                                                <form id="step_form4" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" id="step4" name="step"
                                                        value="4" />
                                                    <input type="hidden" id="declaration_id" name="declarationId"
                                                        value="{{ old('declarationId', '') }}" />

                                                    <fieldset class="border p-3 mb-3">
                                                        <div>
                                                            <input type="checkbox" name="is_confirmed" id="is_confirmed"
                                                                value="1" />
                                                            <label
                                                                class="form-label fw-bold">{{ __('messages.information-provided') }}</label>
                                                            <span class="error" id="is_confirmed_err"></span>
                                                        </div>
                                                    </fieldset>

                                                    <fieldset class="border p-3 mb-3">
                                                        <label>{{ __('messages.Upload-signature') }}:<span
                                                                class="text-danger">*</span></label>
                                                        <input type="file" name="Upload_signature"
                                                            id="Upload_signature" class="form-control form-control-sm" />
                                                        <span class="error" id="Upload_signature_err"></span>
                                                    </fieldset>

                                                    <fieldset class="border p-3 mb-3">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>
                                                                    <input type="radio" name="is_individual"
                                                                        value="1" /> {{ __('messages.Individual') }}
                                                                </label>
                                                                <label>
                                                                    <input type="radio" name="is_individual"
                                                                        value="2" />
                                                                    {{ __('messages.Authorized-Representative') }}
                                                                </label>
                                                                <span class="error" id="is_individual_err"></span>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <label>{{ __('messages.Upload-Resolution') }}:<span
                                                                        class="text-danger">*</span></label>
                                                                <input type="file" name="upload_resolution"
                                                                    id="upload_resolution"
                                                                    class="form-control form-control-sm" />
                                                                <span class="error" id="upload_resolution_err"></span>
                                                            </div>
                                                        </div>
                                                    </fieldset>

                                                    <fieldset class="border p-3 mb-3">
                                                        <label>{{ __('messages.AadhaarUpload') }}:<span
                                                                class="text-danger">*</span></label>
                                                        <input type="file" name="aadhar_upload" id="aadhar_upload"
                                                            class="form-control form-control-sm" />
                                                        <span class="error" id="aadhar_upload_err"></span>
                                                    </fieldset>

                                                    <div class="d-flex justify-content-between">
                                                        <button type="button" class="btn btn-secondary"
                                                            style="width: 12%;"
                                                            onclick="showPreviousStep(3)">{{ __('messages.back') }}</button>
                                                        <button type="button" id="submit_btn4" class="btn btn-primary"
                                                            style="width: 12%;"
                                                            onclick="nextStep(4)">{{ __('messages.save&submit') }}</button>
                                                    </div>
                                                </form>
                                            </div>


                                            <!-- Step 5 -->
                                            <div class="tab-pane" id="step5" role="tabpanel">
                                                <br>
                                                <p class="fw-bold">({{ __('messages.Proof-of-Evidence-Upload') }})</p>
                                                <form id="step_form5" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" id="step5" value="5"
                                                        name="step" />
                                                    <input type="hidden" value="{{ $finalSubmission->id ?? '' }}"
                                                        id="evidence_id" name="evidence_id" />
                                                    <!-- Proposal Documents -->
                                                    <label
                                                        class="col-form-label fw-bold">{{ __('messages.Challan Details') }}
                                                    </label>
                                                    <fieldset class="border p-3 mb-3">
                                                        <div class="row">
                                                            <div class="col-md-4 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.Amount-Paid') }}
                                                                    :<span class="text-danger">*</span></label>
                                                                <input type="text" id="amount_paid"
                                                                    class="form-control form-control-sm"
                                                                    name="amount_paid"
                                                                    value="{{ $finalSubmission->amount_paid ?? '' }}"
                                                                    onkeyup="validateData(this,'amount_paid')" />
                                                                <span class="error" id="amount_paid_err"></span>
                                                            </div>
                                                            <div class="col-md-4 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.Challan-No') }}
                                                                    :<span class="text-danger">*</span></label>
                                                                <input type="text" id="challan_no"
                                                                    class="form-control form-control-sm" name="challan_no"
                                                                    value="{{ $finalSubmission->challan_no ?? '' }}"
                                                                    onkeyup="validateData(this,'challan_no')" />
                                                                <span class="error" id="challan_no_err"></span>
                                                            </div>
                                                            <div class="col-md-4 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.Upload-Challan-Reciept') }}
                                                                    :<span class="text-danger">*</span></label>
                                                                <input type="file" id="upload_challan_reciept"
                                                                    class="form-control form-control-sm"
                                                                    name="upload_challan_reciept"
                                                                    accept="image/*,application/pdf"
                                                                    value="{{ $finalSubmission->upload_challan_reciept ?? '' }}"
                                                                    onkeyup="validateData(this,'upload_challan_reciept')" />
                                                                @if (@$finalSubmission->upload_challan_reciept)
                                                                    <a href="javascript:void(0);"
                                                                        onclick="viewAttachment('{{ asset('storage/' . $finalSubmission->upload_challan_reciept) }}')">View</a>
                                                                @endif
                                                                <span class="error"
                                                                    id="upload_challan_reciept_err"></span>
                                                            </div>
                                                        </div>
                                                    </fieldset>

                                                    <!-- Other Documents -->
                                                    <label
                                                        class="col-form-label fw-bold">{{ __('messages.Upload-Evidence') }}
                                                        :</label>
                                                    <fieldset class="border p-3 mb-3">
                                                        <div class="row">
                                                            <div class="col-md-4 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.Upload-Documentary-Evidence') }}
                                                                    :<span class="text-danger">*</span></label>
                                                                <input type="file" id="upload_documentary_evidence"
                                                                    class="form-control form-control-sm"
                                                                    name="upload_documentary_evidence"
                                                                    accept="image/*,application/pdf"
                                                                    value="{{ $finalSubmission->upload_documentary_evidence ?? '' }}"
                                                                    onkeyup="validateData(this,'upload_documentary_evidence')" />
                                                                @if (@$finalSubmission->upload_documentary_evidence)
                                                                    <a href="javascript:void(0);"
                                                                        onclick="viewAttachment('{{ asset('storage/' . $finalSubmission->upload_documentary_evidence) }}')">View</a>
                                                                @endif
                                                                <span class="error"
                                                                    id="upload_documentary_evidence_err"></span>
                                                            </div>
                                                            <div class="col-md-4 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.Upload-Witness-Affidavit/Statements') }}
                                                                    :<span class="text-danger">*</span></label>
                                                                <input type="file" id="upload_witness"
                                                                    class="form-control form-control-sm"
                                                                    accept="image/*,application/pdf" name="upload_witness"
                                                                    value="{{ $finalSubmission->upload_witness ?? '' }}"
                                                                    onkeyup="validateData(this,'upload_witness')" />
                                                                @if (@$finalSubmission->upload_witness)
                                                                    <a href="javascript:void(0);"
                                                                        onclick="viewAttachment('{{ asset('storage/' . $finalSubmission->upload_witness) }}')">View</a>
                                                                @endif
                                                                <span class="error" id="upload_witness_err"></span>
                                                            </div>
                                                            <div class="col-md-4 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.Upload-any-other-supporting-files') }}
                                                                    :<span class="text-danger">*</span></label>
                                                                <input type="file" id="upload_any_other_supporting"
                                                                    class="form-control form-control-sm"
                                                                    accept="image/*,application/pdf"
                                                                    name="upload_any_other_supporting"
                                                                    value="{{ $finalSubmission->upload_any_other_supporting ?? '' }}"
                                                                    onkeyup="validateData(this,'upload_any_other_supporting')" />
                                                                @if (@$finalSubmission->upload_any_other_supporting)
                                                                    <a href="javascript:void(0);"
                                                                        onclick="viewAttachment('{{ asset('storage/' . $finalSubmission->upload_any_other_supporting) }}')">View</a>
                                                                @endif
                                                                <span class="error"
                                                                    id="upload_any_other_supporting_err"></span>
                                                            </div>
                                                        </div>
                                                    </fieldset>

                                                    <div class="d-flex justify-content-between">
                                                        <button class="btn btn-secondary" type="button"
                                                            style="width: 12%;"
                                                            onclick="showPreviousStep(4)">{{ __('messages.back') }}</button>
                                                        <button class="btn btn-primary" type="button" id="submit_btn5"
                                                            onclick="nextStep(5)">{{ __('messages.finalsubmit') }}</button>
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
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function showPreviousStep(previousStep) {
            var currentStep = previousStep + 1;
            $("#nav-link-" + currentStep).removeClass("active");
            $("#nav-link-" + previousStep).addClass("active");
            $("#step" + currentStep).removeClass("active");
            $("#step" + previousStep).addClass("active");
            $(".error").text("");
        }

        function showDiv(show_type, div_id) {
            if (show_type == "show") {
                $("#" + div_id).show();
            } else {
                $("#" + div_id).hide();
            }
        }

        function validateData(inputElement, field_id) {
            var field_val = inputElement.value;
            if (field_val != "") {
                $("#" + field_id + "_err").text("");
            }
        }

        function validateStep(step) {
            let isValid = true;
            $('.error').text(''); // Clear all errors first

            if (step == 1) {
                let applicant_name = $("#applicant_name").val();
                let father_name = $("#father_name").val();
                let mobile_number = $("#mobile_number").val();
                let full_address = $("#full_address").val();
                let email = $("#email").val();

                if (!applicant_name) {
                    $("#applicant_name_err").text("Enter Applicant name.");
                    isValid = false;
                }
                if (!father_name) {
                    $("#father_name_err").text("Enter Father name");
                    isValid = false;
                }
                if (!mobile_number) {
                    $("#mobile_no_err").text("Enter Mobile number");
                    isValid = false;
                }
                if (email) {
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(email)) {
                        $("#email_err").text("Enter a valid email address");
                        isValid = false;
                    }
                }
                if (!full_address) {
                    $("#full_address_err").text("Enter Full address");
                    isValid = false;
                }

            } else if (step == 2) {
                let name1 = $("#name1").val();
                let address1 = $("#address1").val();
                let dname1 = $("#dname1").val();
                let daddress1 = $("#daddress1").val();
                let name2 = $("#name2").val();
                let address2 = $("#address2").val();
                let name3 = $("#name3").val();
                let address3 = $("#address3").val();
                let dname2 = $("#dname2").val();
                let daddress2 = $("#daddress2").val();
                let dname3 = $("#dname3").val();
                let daddress3 = $("#daddress3").val();

                if (!name1) {
                    $("#name1_err").text("Enter petitioner name.");
                    isValid = false;
                }

                if (!address1) {
                    $("#address1_err").text("Enter Petitioner address.");
                    isValid = false;
                }

                if (!dname1) {
                    $("#dname1_err").text("Enter Defendant name.");
                    isValid = false;
                }

                if (!daddress1) {
                    $("#daddress1_err").text("Enter Defendant address.");
                    isValid = false;
                }

                if (name2 && !address2) {
                    $("#address2_err").text("Enter address for petitioner 2.");
                    isValid = false;
                }

                if (name3 && !address3) {
                    $("#address3_err").text("Enter address for petitioner 3.");
                    isValid = false;
                }

                if (dname2 && !daddress2) {
                    $("#daddress2_err").text("Enter address for defendant 2.");
                    isValid = false;
                }

                if (dname3 && !daddress3) {
                    $("#daddress3_err").text("Enter address for defendant 3.");
                    isValid = false;
                }

            } else if (step == 3) {
                let against_the_defendant = $("#against_the_defendant").val();
                let plaintiff_seek_arbitration = $("#plaintiff_seek_arbitration").val();
                let cause_of_action_arose = $("#cause_of_action_arose").val();
                let valuation_case = $("#valuation_case").val();
                let valuation_case_amount = $("#valuation_case_amount").val();
                let desired_relief = $("#desired_relief").val();
                let witnesses_and_documents = $("#witnesses_and_documents").val();

                if (!against_the_defendant) {
                    $("#against_the_defendant_err").text("Enter Society Name.");
                    isValid = false;
                }
                if (!plaintiff_seek_arbitration) {
                    $("#plaintiff_seek_arbitration_err").text("Enter Society Formation Reason.");
                    isValid = false;
                }
                if (!cause_of_action_arose) {
                    $("#cause_of_action_arose_err").text("Choose Society Type.");
                    isValid = false;
                }
                if (!valuation_case) {
                    $("#valuation_case_err").text("Enter Bank Name.");
                    isValid = false;
                }
                if (!valuation_case_amount) {
                    $("#valuation_case_amount_err").text("Enter Distance from bank.");
                    isValid = false;
                }
                if (!desired_relief) {
                    $("#desired_relief_err").text("Enter Membership Limit.");
                    isValid = false;
                }
                if (!witnesses_and_documents) {
                    $("#witnesses_and_documents_err").text("Enter Total Members Ready To Join.");
                    isValid = false;
                }

            } else if (step == 4) {

                let isConfirmed = $("#is_confirmed").is(":checked");
                if (!isConfirmed) {
                    $("#is_confirmed_err").text("Choose Confirmation.");
                    isValid = false;
                }

                let isIndividual = $('input[name="is_individual"]:checked').val();
                if (!isIndividual) {
                    $("#is_individual_err").text("Select Individual or Authorized Representative.");
                    isValid = false;
                }

                // If Authorized Representative (2), upload resolution is mandatory
                if (isIndividual === "2") {
                    if ($("#upload_resolution")[0].files.length === 0) {
                        $("#upload_resolution_err").text("Please upload resolution document.");
                        isValid = false;
                    }
                }

                if ($("#Upload_signature")[0].files.length === 0 && !$("#declaration_id").val()) {
                    // No new file and no existing file (declaration_id empty means new record)
                    $("#Upload_signature_err").text("Upload authority signature.");
                    isValid = false;
                }

                if ($("#aadhar_upload")[0].files.length === 0 && !$("#declaration_id").val()) {
                    $("#aadhar_upload_err").text("Upload Aadhaar.");
                    isValid = false;
                }

                /* let is_confirmed = $("#is_confirmed").is(":checked");

                if (!is_confirmed) {
                    $("#is_confirmed_err").text("Choose Conformation.");
                    isValid = false;
                } else {
                    $("#is_confirmed_err").text("");
                }

                let applicantType = $('input[name="is_individual"]:checked').val();

                if (applicantType === "2") {
                    let upload_resolution = $("#upload_resolution").val();

                    if (!upload_resolution) {
                        $("#upload_resolution_err").text("Please upload resolution document.");
                        isValid = false;
                    } else {
                        $("#upload_resolution_err").text("");
                    }
                }

                let Upload_signature = $("#Upload_signature").val();
                let exist_Upload_signature = {{ @$feasibilityReports->Upload_signature ? 'true' : 'false' }};
                if (!Upload_signature && !exist_Upload_signature) {
                    $("#Upload_signature_err").text("Upload authority signature");
                    isValid = false;
                } else {
                    $("#Upload_signature_err").text("");
                }


                let aadhar_upload = $("#aadhar_upload").val();
                let exist_aadhar_upload = {{ @$feasibilityReports->aadhar_upload ? 'true' : 'false' }};
                if (!aadhar_upload && !exist_aadhar_upload) {
                    $("#aadhar_upload_err").text("Upload Aadhar");
                    isValid = false;
                } else {
                    $("#aadhar_upload_err").text("");
                } */


            } else if (step == 5) {
                let amount_paid = $("#amount_paid").val();
                let challan_no = $("#challan_no").val();

                if (!amount_paid) {
                    $("#amount_paid_err").text("Enter Amount paid.");
                    isValid = false;
                }
                if (!challan_no) {
                    $("#challan_no_err").text("Enter Challan number.");
                    isValid = false;
                }

                let upload_challan_reciept = $("#upload_challan_reciept").val();
                let exist_upload_challan_reciept = {{ @$finalSubmission->upload_challan_reciept ? 'true' : 'false' }};
                if (!upload_challan_reciept && !exist_upload_challan_reciept) {
                    $("#upload_challan_reciept_err").text("Please upload Challan receipt");
                    isValid = false;
                }

                let upload_documentary_evidence = $("#upload_documentary_evidence").val();
                let exist_upload_documentary_evidence =
                    {{ @$finalSubmission->upload_documentary_evidence ? 'true' : 'false' }};
                if (!upload_documentary_evidence && !exist_upload_documentary_evidence) {
                    $("#upload_documentary_evidence_err").text("Please upload Documentary evidence");
                    isValid = false;
                }

                let upload_witness = $("#upload_witness").val();
                let exist_upload_witness = {{ @$finalSubmission->upload_witness ? 'true' : 'false' }};
                if (!upload_witness && !exist_upload_witness) {
                    $("#upload_witness_err").text("Please upload Witness affidavit");
                    isValid = false;
                }

                let upload_any_other_supporting = $("#upload_any_other_supporting").val();
                let exist_upload_any_other_supporting =
                    {{ @$finalSubmission->upload_any_other_supporting ? 'true' : 'false' }};
                if (!upload_any_other_supporting && !exist_upload_any_other_supporting) {
                    $("#upload_any_other_supporting_err").text("Please upload Supporting documents");
                    isValid = false;
                }
            }

            return isValid;
        }

        function nextStep(stepVal) {
            var step = stepVal;
            var currentStep = stepVal;
            var $submitBtn = $("#submit_btn" + step);

            if (step) {
                $submitBtn.prop('disabled', true);

                if (!validateStep(step)) {
                    $submitBtn.prop('disabled', false);
                    return;
                }

                var form_data = new FormData($("#step_form" + step)[0]);
                form_data.append('_token', $('meta[name="csrf-token"]').attr('content'));
                // console.log("fgh", form_data);


                if (step > 1) {
                    let settlement_id = $("#settlement_id").val();
                    // alert(settlement_id);
                    if (!settlement_id) {
                        alert("Settlement ID is missing. Please complete Step 1 first.");
                        $submitBtn.prop('disabled', false);
                        return;
                    }
                    form_data.append('settlement_id', settlement_id);
                    form_data.append('step', step);
                }

                $.ajax({
                    url: "{{ route('save.arbitration.application') }}",
                    method: 'POST',
                    data: form_data,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (step < 5) {
                            $("#nav-link-" + step).removeClass("active");
                            $("#nav-link-" + response.nextStep).addClass("active");
                            $("#step" + step).removeClass("active");
                            $("#step" + response.nextStep).addClass("active");

                            // Store IDs for different steps
                            if (step == 1) {
                                $("#settlement_id").val(response.settlementDetailsId);
                            } else if (step == 2) {
                                $("#partiesId").val(response.parties_detailsId);
                            } else if (step == 3) {
                                $("#dispute_detailsId").val(response.disputeId);
                            } else if (step == 4) {
                                // console.log("hy", response.declarationId);
                                $("#declaration_id").val(response.declarationId);
                            }
                        } else {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Settlement of Dispute Successfully!',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = "{{ route('socialregdapp.list') }}";
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error:", error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred while saving. Please try again.',
                        });
                    },
                    complete: function() {
                        $submitBtn.prop('disabled', false);
                    }
                });
            }
        }
    </script>





    {{-- <script>
        function nextStep(currentStep) {
            const nextStep = currentStep + 1;

            // Enable next tab
            const nextTab = document.getElementById(`nav-link-${nextStep}`);
            nextTab.classList.remove('disabled');
            nextTab.classList.add('active');

            // Deactivate current tab
            document.getElementById(`nav-link-${currentStep}`).classList.remove('active');

            // Show next tab pane
            document.querySelector(`#step${currentStep}`).classList.remove('active');
            document.querySelector(`#step${nextStep}`).classList.add('active');
            document.querySelector(`#step${nextStep}`).classList.add('show');

            // Scroll to top
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        function showPreviousStep(currentStep) {
            const prevStep = currentStep;

            // Activate previous tab
            document.getElementById(`nav-link-${prevStep}`).classList.add('active');
            document.getElementById(`nav-link-${prevStep + 1}`).classList.remove('active');

            // Show previous tab pane
            document.querySelector(`#step${prevStep + 1}`).classList.remove('active', 'show');
            document.querySelector(`#step${prevStep}`).classList.add('active', 'show');

            // Scroll to top
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
    </script> --}}
@endsection
