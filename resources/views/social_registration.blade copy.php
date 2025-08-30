@extends('layouts.app')


@section('content')
    <div class="page-content">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">{{ __('messages.app_rcs') }}</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a
                                    href="javascript: void(0);">{{ __('messages.cooperatives_department') }}</a>
                            </li>
                            <li class="breadcrumb-item active">{{ __('messages.new_registration') }}</li>
                        </ol>
                    </div>

                </div>
                <p>({{ __('messages.section_06_up_act_2003') }})</p>
            </div>
        </div>
        <!-- end page title -->

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
                                                <a class="nav-link " id="nav-link-4" data-bs-toggle="tab"
                                                    href="#step4" role="tab">
                                                    <span class="d-none d-sm-block">{{ __('messages.step_04') }}</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link disabled" id="nav-link-5" data-bs-toggle="tab"
                                                    href="javascript:void(0);" role="tab">
                                                    <span class="d-none d-sm-block">{{ __('messages.step_05') }}</span>
                                                </a>
                                            </li>
                                            <!-- <li class="nav-item">
                                                        <a class="nav-link" id="nav-link-6" data-bs-toggle="tab" 
                                                            href="javascript:void(0);" role="tab">
                                                            <span class="d-none d-sm-block">{{ __('messages.step_06') }}</span>
                                                        </a>
                                                    </li> -->
                                        </ul>

                                        <!-- Tab panes -->

                                        <div class="tab-content p-3 text-muted">
                                            <div class="tab-pane active" id="step1" role="tabpanel">
                                                <form id="step_form1">
                                                    @csrf
                                                    <!-- Society Details -->
                                                    <div class="mb-3 row">
                                                        <label for="example-text-input"
                                                            class="col-md-4 col-form-label fw-bold">{{ __('messages.societyname') }}
                                                            : <span class="text-danger">*</span>
                                                        </label>
                                                        <div class="col-md-8">
                                                            <input class="form-control form-control-sm" name="step"
                                                                type="hidden" id="step1" value="1" />
                                                            <input class="form-control form-control-sm" id="society_id"
                                                                name="society_id" type="hidden"
                                                                value="{{ $societyDetails->id ?? '' }}" />
                                                            <input class="form-control form-control-sm" type="text"
                                                                onkeyup="validateData(this,'society_name')"
                                                                id="society_name"
                                                                placeholder="{{ __('messages.enter_societyname') }}"
                                                                name="society_name"
                                                                value="{{ $societyDetails->society_name ?? '' }}" />
                                                            <span class="error" id="society_name_err"></span>
                                                        </div>
                                                    </div>

                                                    <!-- Address Section -->
                                                    <label for="example-text-input"
                                                        class="col-form-label fw-bold">{{ __('messages.societyheadquarters') }}
                                                        :</label>
                                                    <fieldset class="border p-3 mb-3">
                                                        <div class="row g-3">
                                                            <div class="col-md-6">
                                                                <label for="district"
                                                                    class="form-label">{{ __('messages.district') }}:<span
                                                                        class="text-danger">*</span></label>
                                                                <!-- <input type="text" class="form-control"
                                                                                                                                    onkeyup="validateData(this,'district')"
                                                                                                                                    placeholder="{{ __('messages.enterdistrictname') }}"
                                                                                                                                    name="district" id="district" value="" /> -->
                                                                <select class="form-select form-control" name="district"
                                                                    id="district">
                                                                    <option value="">-- Select --</option>
                                                                    @foreach ($districts as $district)
                                                                        <option value="{{ $district->id }}" {{ isset($societyDetails) && $societyDetails->district == $district->id ? 'selected' : '' }}>
                                                                            {{ $district->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>

                                                                <span class="error" id="district_err"></span>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="developmentArea"
                                                                    class="form-label">{{ __('messages.development_area') }}:
                                                                    <span class="text-danger">*</span></label>
                                                                <select class="form-select form-control"
                                                                    name="developement_area" id="developement_area">
                                                                    <option value="">-- Select --</option>
                                                                    @foreach ($blocks as $block)
                                                                        <option value="{{ $block->id }}" {{ isset($societyDetails) && $societyDetails->developement_area == $block->id ? 'selected' : '' }}>
                                                                            {{ $block->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                <span class="error" id="developement_area_err"></span>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="postOffice"
                                                                    class="form-label">{{ __('messages.post_office') }} :
                                                                    <span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $societyDetails->post_office ?? '' }}"
                                                                    onkeyup="validateData(this,'post_office')"
                                                                    placeholder="{{ __('messages.enternearestpostOfficename') }}"
                                                                    name="post_office" id="post_office" value="" />
                                                                <span class="error" id="post_office_err"></span>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="tehsil"
                                                                    class="form-label">{{ __('messages.tehsil') }} : <span
                                                                        class="text-danger">*</span></label>
                                                                <input type="text" class="form-control" id="tehsil"
                                                                    onkeyup="validateData(this,'tehsil')"
                                                                    placeholder="{{ __('messages.enterthetehsilname') }}"
                                                                    name="tehsil"
                                                                    value="{{ $societyDetails->tehsil ?? '' }}" />
                                                                <span class="error" id="tehsil_err"></span>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="village"
                                                                    class="form-label">{{ __('messages.enteryourlocality') }}
                                                                    : <span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control"
                                                                    onkeyup="validateData(this,'locality')"
                                                                    placeholder="{{ __('messages.entervillageorlocalityname') }}"
                                                                    id="locality" name="locality"
                                                                    value="{{ $societyDetails->locality ?? '' }}">
                                                                <span class="error" id="locality_err"></span>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="nearest_station"
                                                                    class="form-label">{{ __('messages.nearestrailwaystationbusstation') }}
                                                                    : <span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control"
                                                                    onkeyup="validateData(this,'nearest_station')"
                                                                    placeholder="{{ __('messages.enternearestbusrailwaystation') }}"
                                                                    name="nearest_station" id="nearest_station"
                                                                    value="{{ $societyDetails->nearest_station ?? '' }}" />
                                                                <span class="error" id="nearest_station_err"></span>
                                                            </div>
                                                        </div>

                                                    </fieldset>
                                                    <!-- Category of the Society -->
                                                    <div class="mb-3">
                                                        <label
                                                            class="form-label fw-bold">{{ __('messages.categoryofthesociety') }}
                                                            : <span class="text-danger">*</span></label>
                                                        <div class="d-flex justify-content-evenly">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    onchange="validateData(this,'society_category')"
                                                                    name="society_category" id="primary" value="1" {{ isset($societyDetails) && $societyDetails->society_category == 'Primary' ? 'checked' : '' }} />
                                                                <label class="form-check-label ms-2" for="primary">
                                                                    {{ __('messages.primary') }}
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    onchange="validateData(this,'society_category')"
                                                                    name="society_category" id="centralApex" value="2" {{ isset($societyDetails) && $societyDetails->society_category == 'Central' ? 'checked' : '' }} />
                                                                <label class="form-check-label ms-2" for="centralApex">
                                                                    {{ __('messages.central') }}
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    onchange="validateData(this,'society_category')"
                                                                    name="society_category" id="agricultural" value="3" {{ isset($societyDetails) && $societyDetails->society_category == 'Apex' ? 'checked' : '' }} />
                                                                <label class="form-check-label ms-2" for="agricultural">
                                                                    {{ __('messages.apex') }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <span class="error" id="society_category_err"></span>
                                                    </div>

                                                    <div>
                                                        <button class="btn btn-primary float-end" type="button"
                                                            id="submit_btn1"
                                                            onclick="nextStep(1)">{{ __('messages.save&submit') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="tab-pane" id="step2" role="tabpanel">
                                                <form id="step_form2" enctype="multipart/form-data">
                                                    @csrf
                                                    <!-- Responsibilities -->
                                                    <label for="example-text-input"
                                                        class="col-form-label fw-bold">{{ __('messages.responsibilitiesofsocietymembers') }}:</label>
                                                    <fieldset class="border p-3 mb-3 row">
                                                        <!-- <legend class="w-auto px-2"></legend> -->
                                                        <div class="col-md-7">
                                                            <input class="form-control form-control-sm"
                                                                id="mobject_detailsId" name="mobject_detailsId"
                                                                type="hidden" value="{{ $membersObjectives->id ?? '' }}" />
                                                            <input type="hidden" value="2" id="step2" name="step" />
                                                            <input class="form-check-input" type="radio"
                                                                onclick="showDiv('show','responsibility_type')"
                                                                name="member_responsibility_type" id="responsibilityType"
                                                                value="1" required>
                                                            <label for="responsibilityType"
                                                                class="form-label fw-bold">{{ __('messages.societyscapitaluptothefinalvaluation') }}</label>
                                                            <div id="responsibility_type" style="display: none;">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="capital_valuation_type" id="withoutShares"
                                                                        onclick="showDiv('hide','share_val')" value="1"
                                                                        required>
                                                                    <label class="form-check-label ms-2"
                                                                        for="withoutShares">{{ __('messages.Withoutshares') }}</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="capital_valuation_type" id="withShares"
                                                                        onclick="showDiv('show','share_val')" value="2">
                                                                    <label class="form-check-label ms-2"
                                                                        for="withShares">{{ __('messages.Withdefinitesharecapital') }}</label>
                                                                </div>
                                                                <div id="share_val" style="display:none;">
                                                                    <input class="form-control form-control-sm"
                                                                        type="number" name="capital_amount"
                                                                        placeholder="Enter the number of share capital"
                                                                        value="" step="0.01" min="0"
                                                                        oninput="validateDecimal(this)">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <input class="form-check-input" type="radio"
                                                                onclick="showDiv('hide','responsibility_type')"
                                                                name="member_responsibility_type" id="indefinite" value="2"
                                                                checked>
                                                            <label for="indefinite"
                                                                class="form-label fw-bold">{{ __('messages.indefinite society capital') }}</label>
                                                        </div>
                                                        <span class="error" id="member_responsibility_type_err"></span>
                                                    </fieldset>

                                                    <!-- Operational Area -->
                                                    <div class="mb-3 row">
                                                        <label for="example-text-input"
                                                            class="col-md-6 col-form-label fw-bold">{{ __('messages.operationalareaoftheproposedsociety') }}
                                                            :<span class="text-danger">*</span></label>
                                                        <div class="col-md-6">
                                                            <input class="form-control form-control-sm" type="text"
                                                                onkeyup="validateData(this,'society_operational_area')"
                                                                id="society_operational_area"
                                                                placeholder="{{ __('messages.enteroperationalarea') }}"
                                                                name="society_operational_area"
                                                                value="{{ $membersObjectives->society_operational_area ?? '' }}" />
                                                            <span class="error" id="society_operational_area_err"></span>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <label for="example-text-input"
                                                            class="col-md-6 col-form-label fw-bold">{{ __('messages.mainobjectivesoftheproposedsociety') }}
                                                            :<span class="text-danger">*</span></label>
                                                        <div class="col-md-6">
                                                            <input class="form-control form-control-sm" type="text"
                                                                onkeyup="validateData(this,'society_objective')"
                                                                id="society_objective" name="society_objective"
                                                                placeholder="{{ __('messages.enterobjectivesofproposedsociety') }}"
                                                                value="{{ $membersObjectives->society_objective ?? '' }}"
                                                                onkeyup="validateData(this,'society_objective')" />
                                                            <span class="error" id="society_objective_err"></span>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <label for="example-text-input"
                                                            class="col-md-6 col-form-label fw-bold">{{ __('messages.numberandvalueofsharestobeissuedasperprovisions') }}</label>
                                                        <div class="col-md-6">
                                                            <input class="form-control form-control-sm"
                                                                id="society_share_value" type="number"
                                                                placeholder="{{ __('messages.entersocietyshare') }}"
                                                                name="society_share_value"
                                                                value="{{ $membersObjectives->society_share_value ?? '' }}" />
                                                            <span class="error" id="society_share_value_err"></span>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3 row">
                                                        <label for="example-text-input"
                                                            class="col-md-6 col-form-label fw-bold">{{ __('messages.valueandrateofeachshareforsubscriptionpayment') }}
                                                            : <span class="text-danger">*</span></label>
                                                        <div class="col-md-6">
                                                            <input class="form-control form-control-sm"
                                                                id="subscription_rate" type="number"
                                                                name="subscription_rate"
                                                                value="{{ $membersObjectives->subscription_rate ?? '' }}"
                                                                onkeyup="validateData(this,'subscription_rate')" />
                                                            <span class="error" id="subscription_rate_err"></span>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3 row">
                                                        <label for="example-text-input"
                                                            class="col-md-6 col-form-label fw-bold">{{ __('messages.liabilitiesofmembers') }}
                                                            : <span class="text-danger">*</span></label>
                                                        <div class="col-md-6">
                                                            <input class="form-control form-control-sm" type="text"
                                                                id="member_liability" name="member_liability"
                                                                value="{{ $membersObjectives->member_liability ?? '' }}"
                                                                onkeyup="validateData(this,'member_liability')" />
                                                            <span class="error" id="member_liability_err"></span>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <label for="example-text-input"
                                                            class="col-md-6 col-form-label fw-bold">{{ __('messages.numberofindividualswhohaveagreedtobecomegeneralmembersoftheproposedsociety') }}
                                                            : <span class="text-danger">*</span>
                                                        </label>
                                                        <div class="col-md-6">
                                                            <input class="form-control form-control-sm"
                                                                id="general_member_count" type="number"
                                                                name="general_member_count"
                                                                value="{{ $membersObjectives->general_member_count ?? '' }}"
                                                                onkeyup="validateData(this,'general_member_count')" />
                                                            <span class="error" id="general_member_count_err"></span>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3 row">
                                                        <label for="example-text-input"
                                                            class="col-md-6 col-form-label fw-bold">
                                                            {{ __('messages.languageinwhichtheproposedsocietyrecordswillbemaintained') }}
                                                            : <span class="text-danger">*</span>
                                                        </label>
                                                        <div class="col-md-6">
                                                            <select class="form-select form-control"
                                                                onchange="validateData(this,'society_record_language')"
                                                                id="society_record_language" name="society_record_language">
                                                                <option value="">{{ __('messages.selectlanguage') }}
                                                                </option>
                                                                <option value="1" {{ isset($membersObjectives) && $membersObjectives->society_record_language == 1 ? 'selected' : '' }}>
                                                                    English
                                                                </option>
                                                                <option value="2" {{ isset($membersObjectives) && $membersObjectives->society_record_language == 2 ? 'selected' : '' }}>
                                                                    Hindi
                                                                </option>
                                                                <option value="3" {{ isset($membersObjectives) && $membersObjectives->society_record_language == 3 ? 'selected' : '' }}>
                                                                    Both
                                                                </option>
                                                            </select>
                                                            <span class="error" id="society_record_language_err"></span>
                                                        </div>
                                                    </div>

                                                    <label for="example-text-input"
                                                        class="col-form-label fw-bold">{{ __('messages.fullnameandaddressandsignature') }}</label>
                                                    <fieldset class="border p-3 mb-3">
                                                        <legend class="w-auto px-2"></legend>
                                                        <div class="mb-3 col-md-6">
                                                            <label
                                                                class="form-label fw-bold">{{ __('messages.ProposedMainRepresentativeFirstSignature') }}
                                                                : <span class="text-danger">*</span></label>
                                                        </div>
                                                        <div class="mb-3 row">
                                                            <div class="col-md-4">
                                                                <input type="text" id="society_representative_name"
                                                                    class="form-control col-md-4 form-control-sm"
                                                                    name="society_representative_name"
                                                                    onkeyup="validateData(this,'society_representative_name')"
                                                                    placeholder="{{ __('messages.representativename') }}"
                                                                    value="{{ $membersObjectives->society_representative_name ?? '' }}" />
                                                                <span class="error"
                                                                    id="society_representative_name_err"></span>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="text" id="society_representative_address"
                                                                    class="form-control col-md-4 form-control-sm"
                                                                    placeholder="{{ __('messages.representativeaddress') }}"
                                                                    name="society_representative_address"
                                                                    value="{{ $membersObjectives->society_representative_address ?? '' }}"
                                                                    onkeyup="validateData(this,'society_representative_address')" />
                                                                <span class="error"
                                                                    id="society_representative_address_err"></span>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="file" id="society_representative_signature"
                                                                    class="form-control col-md-4 form-control-sm"
                                                                    placeholder="Representative's Signature"
                                                                    name="society_representative_signature"
                                                                    value="{{ $membersObjectives->society_representative_signature ?? '' }}"
                                                                    onkeyup="validateData(this,'society_representative_signature')" />
                                                                @if (@$membersObjectives->society_representative_signature)
                                                                    <a href="javascript:void(0);"
                                                                        onclick="viewAttachment('{{ asset('storage/' . $membersObjectives->society_representative_signature) }}')">View</a>
                                                                @endif
                                                                <span class="error"
                                                                    id="society_representative_signature_err"></span>
                                                            </div>

                                                        </div>
                                                        <div class="mb-3 row">
                                                            <label
                                                                class="form-label fw-bold">{{ __('messages.proposedsocietysecretary') }}
                                                                : <span class="text-danger">*</span></label>
                                                            <div class="col-md-4">
                                                                <input type="text" id="society_secretary_name"
                                                                    class="form-control form-control-sm"
                                                                    placeholder="{{ __('messages.secretaryname') }}"
                                                                    name="society_secretary_name"
                                                                    value="{{ $membersObjectives->society_secretary_name ?? '' }}"
                                                                    onkeyup="validateData(this,'society_secretary_name')" />
                                                                <span class="error" id="society_secretary_name_err"></span>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="text" id="society_secretary_address"
                                                                    class="form-control form-control-sm"
                                                                    placeholder="{{ __('messages.secretaryaddress') }}"
                                                                    name="society_secretary_address"
                                                                    value="{{ $membersObjectives->society_secretary_address ?? '' }}"
                                                                    onkeyup="validateData(this,'society_secretary_address')" />
                                                                <span class="error"
                                                                    id="society_secretary_address_err"></span>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="file" id="society_secretary_signature"
                                                                    class="form-control col-md-4 form-control-sm"
                                                                    placeholder="Secretary's Signature"
                                                                    name="society_secretary_signature"
                                                                    value="{{ $membersObjectives->society_secretary_signature ?? '' }}"
                                                                    onkeyup="validateData(this,'society_secretary_signature')" />
                                                                @if (@$membersObjectives->society_secretary_signature)
                                                                    <a href="javascript:void(0);"
                                                                        onclick="viewAttachment('{{ asset('storage/' . $membersObjectives->society_secretary_signature) }}')">View</a>
                                                                @endif
                                                                <span class="error"
                                                                    id="society_secretary_signature_err"></span>
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
                                            <div class="tab-pane" id="step3" role="tabpanel">
                                                <form id="step_form3" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="mb-3 row">
                                                        <label for="example-text-input"
                                                            class="col-md-12 col-form-label fw-bold">{{ __('messages.OrderoftheRegistrar') }}</label>
                                                    </div>
                                                    <div class="row mb-3 form-group">
                                                        <input type="hidden" id="step3" name="step" value="3" />
                                                        <input class="form-control form-control-sm"
                                                            id="member_declarationId" name="member_declarationId"
                                                            type="hidden" value="{{ $members_data->id ?? '' }}" />
                                                        <label
                                                            class="form-label fw-bold">{{ __('messages.listofmembers') }}</label>
                                                        <div class="member-note">
                                                            Note: The member you are adding should not belong to the same
                                                            family or family of any other member.
                                                        </div>
                                                        <div id="more_member">


                                                            @if (@$members_data->id && isset($members_data->members) && !empty($members_data->members))
                                                                @foreach ($members_data->members as $index => $member)
                                                                    <div class="row additionalMember mt-3 member-row"
                                                                        data-row-number="{{ $index + 1 }}">
                                                                        <div class="member-header">
                                                                            <span class="member-number">Member
                                                                                #{{ $index + 1 }}</span>
                                                                            <button class="formremoveBtn"
                                                                                onclick="confirmRemoveMember({{ $index + 1 }}, {{ $member['id'] ?? 'null' }})">
                                                                                <i class="uil-times"></i>
                                                                            </button>
                                                                        </div>


                                                                        <input type="hidden" id="member_id{{ $index }}"
                                                                            name="member_id[]" value="{{ $member['id'] }}" />

                                                                        <!-- Name -->
                                                                        <div class="mb-3 col-md-3 form-group">
                                                                            <label
                                                                                class="form-label fw-bold">{{ __('messages.name') }}</label>
                                                                            <input type="text" class="form-control form-control-sm"
                                                                                name="name[]"
                                                                                placeholder="{{ __('messages.membername') }}"
                                                                                value="{{ $member['name'] }}"
                                                                                onkeyup="validateData(this,'name{{ $index }}')" />
                                                                            <span id="name{{ $index }}"
                                                                                class="error error-name"></span>
                                                                        </div>

                                                                        <!-- Address -->
                                                                        <div class="col-md-3 form-group">
                                                                            <label
                                                                                class="form-label fw-bold">{{ __('messages.fulladdress') }}</label>
                                                                            <input type="text"
                                                                                onkeyup="validateData(this,'address{{ $index }}')"
                                                                                class="form-control form-control-sm"
                                                                                name="address[]"
                                                                                placeholder="{{ __('messages.memberaddress') }}"
                                                                                value="{{ $member['address'] }}" />
                                                                            <span id="address{{ $index }}"
                                                                                class="error error-address"></span>
                                                                        </div>

                                                                        <!-- Gender -->
                                                                        <div class="col-md-3 form-group">
                                                                            <label
                                                                                class="form-label fw-bold">{{ __('messages.gender') }}</label>
                                                                            <select
                                                                                onchange="validateData(this,'gender{{ $index }}')"
                                                                                class="form-select form-control-sm" name="gender[]">
                                                                                <option value="">{{ __('messages.select') }}
                                                                                </option>
                                                                                <option value="1" {{ $member['gender'] == 1 ? 'selected' : '' }}>
                                                                                    {{ __('messages.male') }}
                                                                                </option>
                                                                                <option value="2" {{ $member['gender'] == 2 ? 'selected' : '' }}>
                                                                                    {{ __('messages.female') }}
                                                                                </option>
                                                                                <option value="3" {{ $member['gender'] == 3 ? 'selected' : '' }}>
                                                                                    {{ __('messages.transgender') }}
                                                                                </option>
                                                                            </select>
                                                                            <span id="gender{{ $index }}"
                                                                                class="error error-gender"></span>
                                                                        </div>

                                                                        <!-- Membership Form (FR-76) -->
                                                                        <div class="col-md-3 form-group">
                                                                            <label class="form-label fw-bold">
                                                                                Membership Form &nbsp;
                                                                                <a href="{{ asset('demo-files/New_Application_Format.pdf') }}"
                                                                                    class="btn btn-sm btn-success">Download Form</a>
                                                                            </label>
                                                                            <div class="input-group">
                                                                                <input type="file"
                                                                                    class="form-control form-control-sm"
                                                                                    name="membership_form[]"
                                                                                    accept="image/*,application/pdf" required
                                                                                    onchange="validateData(this,'membership_form{{ $index }}')" />
                                                                                @if (!empty($member['membership_form']))
                                                                                    <div class="mt-2">
                                                                                        <a href="javascript:void(0);"
                                                                                            onclick="viewAttachment('{{ asset('storage/' . $member['membership_form']) }}')">
                                                                                            View
                                                                                        </a>
                                                                                    </div>
                                                                                @endif
                                                                            </div>
                                                                            <span id="membership_form{{ $index }}"
                                                                                class="error error-membership_form"></span>
                                                                        </div>


                                                                        <!-- Marital Status -->
                                                                        <div class="col-md-3 form-group">
                                                                            <label
                                                                                class="form-label fw-bold">{{ __('messages.ismarried') }}</label>
                                                                            <select
                                                                                onchange="validateData(this,'is_married{{ $index }}')"
                                                                                class="form-select form-control-sm"
                                                                                name="is_married[]">
                                                                                <option value="">{{ __('messages.select') }}
                                                                                </option>
                                                                                <option value="1" {{ $member['is_married'] == 1 ? 'selected' : '' }}>
                                                                                    {{ __('messages.yes') }}
                                                                                </option>
                                                                                <option value="2" {{ $member['is_married'] == 2 ? 'selected' : '' }}>
                                                                                    {{ __('messages.no') }}
                                                                                </option>
                                                                            </select>
                                                                            <span id="is_married{{ $index }}"
                                                                                class="error error-is_married"></span>
                                                                        </div>

                                                                        <!-- Father/Spouse Name -->
                                                                        <div class="col-md-3 form-group">
                                                                            <label
                                                                                class="form-label fw-bold">{{ __('messages.FatherName') }}</label>
                                                                            <input type="text"
                                                                                onkeyup="validateData(this,'father_spouse_name{{ $index }}')"
                                                                                class="form-control form-control-sm"
                                                                                name="father_spouse_name[]"
                                                                                placeholder="{{ __('messages.FatherName') }}"
                                                                                value="{{ $member['father_spouse_name'] }}" />
                                                                            <span id="father_spouse_name{{ $index }}"
                                                                                class="error error-father_spouse_name"></span>
                                                                        </div>

                                                                        <!-- Designation -->
                                                                        <div class="col-md-3 form-group">
                                                                            <label
                                                                                class="form-label fw-bold">{{ __('messages.designation') }}</label>
                                                                            <input type="text"
                                                                                onkeyup="validateData(this,'designation{{ $index }}')"
                                                                                class="form-control form-control-sm"
                                                                                name="designation[]"
                                                                                placeholder="{{ __('messages.designation') }}"
                                                                                value="{{ $member['designation'] }}" />
                                                                            <span id="designation{{ $index }}"
                                                                                class="error error-designation"></span>
                                                                        </div>

                                                                        <!-- Business -->
                                                                        <div class="col-md-3 form-group">
                                                                            <label
                                                                                class="form-label fw-bold">{{ __('messages.buisness') }}</label>
                                                                            <input type="text" class="form-control form-control-sm"
                                                                                name="buisness_name[]"
                                                                                placeholder="{{ __('messages.buisnessname') }}"
                                                                                value="{{ $member['buisness_name'] }}" />
                                                                        </div>

                                                                        <!-- Aadhaar No -->
                                                                        <div class="col-md-3 form-group">
                                                                            <label
                                                                                class="form-label fw-bold">{{ __('messages.AadhaarUpload') }}</label>
                                                                            <input type="file" class="form-control form-control-sm"
                                                                                name="aadhar_no[]" accept="image/*,application/pdf"
                                                                                required
                                                                                onchange="validateData(this,'aadhar_no{{ $index }}')" />
                                                                                @if (!empty($member['aadhar_no']))
                                                                                <div class="mt-2">
                                                                                    <a href="javascript:void(0);"
                                                                                        onclick="viewAttachment('{{ asset('storage/' . $member['aadhar_no']) }}')">
                                                                                        View
                                                                                    </a>
                                                                                </div>
                                                                            @endif
                                                                            <span id="aadhar_no{{ $index }}"
                                                                                class="error error-aadhar_no"></span>
                                                                        </div>

                                                                        <!-- Signature -->
                                                                        <div class="col-md-3 form-group">
                                                                            <label
                                                                                class="form-label fw-bold">{{ __('messages.signature') }}</label>
                                                                            <input type="file"
                                                                                onchange="validateData(this,'signature{{ $index }}')"
                                                                                class="form-control form-control-sm"
                                                                                name="signature[]"
                                                                                accept="image/*,application/pdf" />
                                                                            @if (!empty($member['signature']))
                                                                                <div class="mt-2">
                                                                                    <a href="javascript:void(0);"
                                                                                        onclick="viewAttachment('{{ asset('storage/' . $member['signature']) }}')">
                                                                                        View
                                                                                    </a>
                                                                                </div>
                                                                            @endif
                                                                            <span id="signature{{ $index }}"
                                                                                class="error error-signature"></span>
                                                                        </div>
                                                                        <!-- Declaration -->
                                                                        <div class="col-md-3 form-group">
                                                                            <label class="form-label fw-bold">Declaration1 &nbsp; <a
                                                                                    href="{{ asset('demo-files/Declaration_1.pdf') }}"
                                                                                    download title="Download Demo Declaration Form"
                                                                                    class="btn btn-sm btn-success mt-1">
                                                                                    Download Declaration
                                                                                </a></label>
                                                                            <input type="file" class="form-control form-control-sm"
                                                                                name="declaration1[]"
                                                                                accept="image/*,application/pdf" required
                                                                                onchange="validateData(this,'declaration1{{ $index }}')" />
                                                                            @if (!empty($member['declaration1']))
                                                                                <div class="mt-2">
                                                                                    <a href="javascript:void(0);"
                                                                                        onclick="viewAttachment('{{ asset('storage/' . $member['declaration1']) }}')">
                                                                                        View
                                                                                    </a>
                                                                                </div>
                                                                            @endif
                                                                            <span id="declaration1{{ $index }}"
                                                                                class="error error-declaration1"></span>
                                                                        </div>
                                                                        <div class="col-md-3 form-group">
                                                                            <label class="form-label fw-bold">Declaration2 &nbsp; <a
                                                                                    href="{{ asset('demo-files/Declaration_2.pdf') }}"
                                                                                    download title="Download Demo Declaration Form"
                                                                                    class="btn btn-sm btn-success mt-1">
                                                                                    Download Declaration
                                                                                </a></label>
                                                                            <input type="file" class="form-control form-control-sm"
                                                                                name="declaration2[]"
                                                                                accept="image/*,application/pdf" required
                                                                                onchange="validateData(this,'declaration2{{ $index }}')" />
                                                                            @if (!empty($member['declaration2']))
                                                                                <div class="mt-2">
                                                                                    <a href="javascript:void(0);"
                                                                                        onclick="viewAttachment('{{ asset('storage/' . $member['declaration2']) }}')">
                                                                                        View
                                                                                    </a>
                                                                                </div>
                                                                            @endif
                                                                            <span id="declaration2{{ $index }}"
                                                                                class="error error-declaration2"></span>
                                                                        </div>

                                                                    </div>
                                                                @endforeach
                                                            @else
                                                                @for ($i = 0; $i < 7; $i++)
                                                                    <div class="row additionalMember mt-3 member-row"
                                                                        data-row-number="{{ $i + 1 }}">
                                                                        <div class="member-header">
                                                                            <span class="member-number">Member #{{ $i + 1 }}</span>
                                                                            @if($i > 0)
                                                                                <button class="formremoveBtn"
                                                                                    onclick="confirmRemoveMember({{ $i + 1 }})">
                                                                                    <i class="uil-times"></i>
                                                                                </button>
                                                                            @endif
                                                                        </div>

                                                                        <input type="hidden" id="member_id{{ $i }}"
                                                                            name="member_id[]" value="" />

                                                                        <!-- Name -->
                                                                        <div class="mb-3 col-md-3 form-group">
                                                                            <label
                                                                                class="form-label fw-bold">{{ __('messages.name') }}</label>
                                                                            <input type="text" class="form-control form-control-sm"
                                                                                name="name[]"
                                                                                placeholder="{{ __('messages.membername') }}"
                                                                                value=""
                                                                                onkeyup="validateData(this,'name{{ $i }}')" />
                                                                            <span id="name{{ $i }}" class="error error-name"></span>
                                                                        </div>

                                                                        <!-- Address -->
                                                                        <div class="col-md-3 form-group">
                                                                            <label
                                                                                class="form-label fw-bold">{{ __('messages.fulladdress') }}</label>
                                                                            <input type="text"
                                                                                onkeyup="validateData(this,'address{{ $i }}')"
                                                                                class="form-control form-control-sm"
                                                                                name="address[]"
                                                                                placeholder="{{ __('messages.memberaddress') }}"
                                                                                value="" />
                                                                            <span id="address{{ $i }}"
                                                                                class="error error-address"></span>
                                                                        </div>

                                                                        <!-- Gender -->
                                                                        <div class="col-md-3 form-group">
                                                                            <label
                                                                                class="form-label fw-bold">{{ __('messages.gender') }}</label>
                                                                            <select onchange="validateData(this,'gender{{ $i }}')"
                                                                                class="form-select form-control-sm" name="gender[]">
                                                                                <option value="">{{ __('messages.select') }}
                                                                                </option>
                                                                                <option value="1">{{ __('messages.male') }}</option>
                                                                                <option value="2">{{ __('messages.female') }}
                                                                                </option>
                                                                                <option value="3">{{ __('messages.transgender') }}
                                                                                </option>
                                                                            </select>
                                                                            <span id="gender{{ $i }}"
                                                                                class="error error-gender"></span>
                                                                        </div>

                                                                        <!-- Membership Form (FR-76) -->
                                                                        <div class="col-md-3 form-group">
                                                                            <label class="form-label fw-bold">Membership Form
                                                                                &nbsp;<a
                                                                                    href="{{ asset('demo-files/New_Application_Format.pdf') }}"
                                                                                    download title="Download Demo Membership Form"
                                                                                    class="btn btn-sm btn-success">
                                                                                    Download Form
                                                                                </a></label>
                                                                            <div class="input-group">
                                                                                <input type="file"
                                                                                    class="form-control form-control-sm"
                                                                                    name="membership_form[]"
                                                                                    accept="image/*,application/pdf" required
                                                                                    onchange="validateData(this,'membership_form{{ $i }}')" />

                                                                            </div>
                                                                            <span id="membership_form{{ $i }}"
                                                                                class="error error-membership_form"></span>
                                                                        </div>

                                                                        <!-- Marital Status -->
                                                                        <div class="col-md-3 form-group">
                                                                            <label
                                                                                class="form-label fw-bold">{{ __('messages.ismarried') }}</label>
                                                                            <select
                                                                                onchange="validateData(this,'is_married{{ $i }}')"
                                                                                class="form-select form-control-sm"
                                                                                name="is_married[]">
                                                                                <option value="">{{ __('messages.select') }}
                                                                                </option>
                                                                                <option value="1">{{ __('messages.yes') }}</option>
                                                                                <option value="2">{{ __('messages.no') }}</option>
                                                                            </select>
                                                                            <span id="is_married{{ $i }}"
                                                                                class="error error-is_married"></span>
                                                                        </div>

                                                                        <!-- Father/Spouse Name -->
                                                                        <div class="col-md-3 form-group">
                                                                            <label
                                                                                class="form-label fw-bold">{{ __('messages.FatherName') }}</label>
                                                                            <input type="text"
                                                                                onkeyup="validateData(this,'father_spouse_name{{ $i }}')"
                                                                                class="form-control form-control-sm"
                                                                                name="father_spouse_name[]"
                                                                                placeholder="{{ __('messages.FFatherName') }}"
                                                                                value="" />
                                                                            <span id="father_spouse_name{{ $i }}"
                                                                                class="error error-father_spouse_name"></span>
                                                                        </div>

                                                                        <!-- Designation -->
                                                                        <div class="col-md-3 form-group">
                                                                            <label
                                                                                class="form-label fw-bold">{{ __('messages.designation') }}</label>
                                                                            <input type="text"
                                                                                onkeyup="validateData(this,'designation{{ $i }}')"
                                                                                class="form-control form-control-sm"
                                                                                name="designation[]"
                                                                                placeholder="{{ __('messages.designation') }}"
                                                                                value="" />
                                                                            <span id="designation{{ $i }}"
                                                                                class="error error-designation"></span>
                                                                        </div>

                                                                        <!-- Business -->
                                                                        <div class="col-md-3 form-group">
                                                                            <label
                                                                                class="form-label fw-bold">{{ __('messages.buisness') }}</label>
                                                                            <input type="text" class="form-control form-control-sm"
                                                                                name="buisness_name[]"
                                                                                placeholder="{{ __('messages.buisnessname') }}"
                                                                                value="" />
                                                                        </div>

                                                                        <!-- Aadhaar No -->
                                                                        <div class="col-md-3 form-group">
                                                                            <label
                                                                                class="form-label fw-bold">{{ __('messages.AadhaarUpload') }}</label>
                                                                            <input type="file" class="form-control form-control-sm"
                                                                                name="aadhar_no[]" accept="image/*,application/pdf"
                                                                                required
                                                                                onchange="validateData(this,'aadhar_no{{ $i }}')" />
                                                                            <span id="aadhar_no{{ $i }}"
                                                                                class="error error-aadhar_no"></span>
                                                                        </div>

                                                                        <!-- Signature -->
                                                                        <div class="col-md-3 form-group">
                                                                            <label
                                                                                class="form-label fw-bold">{{ __('messages.signature') }}</label>
                                                                            <input type="file"
                                                                                onchange="validateData(this,'signature{{ $i }}')"
                                                                                class="form-control form-control-sm"
                                                                                name="signature[]"
                                                                                accept="image/*,application/pdf" />
                                                                            <span id="signature{{ $i }}"
                                                                                class="error error-signature"></span>
                                                                        </div>

                                                                        <!-- Declaration (FR-77) -->
                                                                        <div class="col-md-6 form-group">
                                                                            <label class="form-label fw-bold">Declaration</label>
                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <div class="input-group">
                                                                                        <input type="file"
                                                                                            class="form-control form-control-sm"
                                                                                            name="declaration1[]"
                                                                                            accept="image/*,application/pdf"
                                                                                            required
                                                                                            onchange="validateData(this,'declaration1{{ $i }}')" />

                                                                                    </div>
                                                                                    <span>Declaration 1 &nbsp;<a
                                                                                            href="{{ asset('demo-files/Declaration_1.pdf') }}"
                                                                                            download
                                                                                            title="Download Demo Declaration 1"
                                                                                            class="btn btn-sm btn-success mt-1">
                                                                                            Download Declaration
                                                                                        </a></span>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <div class="input-group">
                                                                                        <input type="file"
                                                                                            class="form-control form-control-sm"
                                                                                            name="declaration2[]"
                                                                                            accept="image/*,application/pdf"
                                                                                            required
                                                                                            onchange="validateData(this,'declaration2{{ $i }}')" />
                                                                                    </div>
                                                                                    <span>Declaration 2 &nbsp;<a
                                                                                            href="{{ asset('demo-files/Declaration_2.pdf') }}"
                                                                                            download
                                                                                            title="Download Demo Declaration 1"
                                                                                            class="btn btn-sm btn-success mt-1">
                                                                                            Download Declaration
                                                                                        </a></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endfor
                                                            @endif
                                                        </div>

                                                        <button type="button" class="btn btn-primary"
                                                            onclick="addMoreMember()">
                                                            + Add Member
                                                        </button>
                                                        <!-- Confirmation Modal -->
                                                        <div class="modal fade" id="removeMemberModal" tabindex="-1"
                                                            role="dialog" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Confirm Removal</h5>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p id="removeMemberMessage">Do you want to remove
                                                                            member #<span id="memberSerialNumber"></span>?
                                                                        </p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">No</button>
                                                                        <button type="button" class="btn btn-primary"
                                                                            id="confirmRemoveBtn">Yes</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="form-check">
                                                            <label class="form-label fw-bold">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="is_declared" checked={{ @$members_data->is_declared ? 'checked' : '' }}
                                                                    onkeyup="validateData(this,'is_declared')" />{{ __('messages.DeclarationforRegistration') }}
                                                            </label>
                                                        </div>
                                                        <span class="error" id="is_declared_err"></span>
                                                        <p>{{ __('messages.We') }}</p>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <button class="btn btn-secondary" type="button" style="width: 12%;"
                                                            onclick="showPreviousStep(2)">{{ __('messages.back') }}</button>
                                                        <button class="btn btn-primary" type="button" id="submit_btn3"
                                                            onclick="nextStep(3)">{{ __('messages.save&submit') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="tab-pane" id="step4" role="tabpanel">
                                                <form id="step_form4">
                                                    @csrf
                                                    <input type="hidden" id="step4" value="4" name="step" />
                                                    <input type="hidden" value="{{ $feasibilityReports->id ?? '' }}"
                                                        id="feasibility_reportId" name="feasibility_reportId" />
                                                    <h6 class="fw-bold">
                                                        {{ __('messages.FeasibilityReportforRegistration') }}
                                                    </h6>
                                                    <div class="mb-3 row">
                                                        <label for="example-text-input"
                                                            class="col-md-6 col-form-label fw-bold">{{ __('messages.societyname') }}&nbsp;<span class="text-danger">*</span>
                                                        </label>
                                                        <div class="col-md-6">
                                                            <input class="form-control form-control-sm" type="text"
                                                                placeholder="{{ __('messages.EnterSocietyName') }}"
                                                                id="fsociety_name" name="society_name"
                                                                value="{{ $feasibilityReports->society_name ?? '' }}"
                                                                onkeyup="validateData(this,'fsociety_name')" />
                                                            <span id="fsociety_name_err" class="error"></span>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <label for="example-text-input"
                                                            class="col-md-6 col-form-label fw-bold">{{ __('messages.HowWastheProposalfortheSocietyFormed') }}
                                                            <span class="text-danger">*</span></label>
                                                        <div class="col-md-6">
                                                            <input class="form-control form-control-sm" type="text"
                                                                id="society_formation_reason"
                                                                onkeyup="validateData(this,'society_formation_reason')"
                                                                name="society_formation_reason"
                                                                value="{{ $feasibilityReports->society_formation_reason ?? '' }}" />
                                                            <span id="society_formation_reason_err" class="error"></span>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <label for="example-text-input"
                                                            class="col-md-6 col-form-label fw-bold">{{ __('messages.IfItIsaVillageSocietyIsItBasedonaMutualInterestorCooperativeModel') }}
                                                            <span class="text-danger">*</span></label>
                                                        <div class="col-md-2 RadioBtnCol">
                                                            <label>
                                                                <input class="form-check-input" name="society_type"
                                                                    type="radio" value="1" />{{ __('messages.yes') }}
                                                            </label>
                                                            <label>
                                                                <input class="form-check-input" name="society_type"
                                                                    type="radio" value="0" checked />
                                                                {{ __('messages.no') }}
                                                            </label>
                                                            <span id="society_type_err" class="error"></span>
                                                        </div>
                                                        <!-- <div class="col-md-4 RadioBtnCol" id="society_based_on"
                                                                    style="display:none">
                                                                    <label><input class="form-check-input" type="radio"
                                                                            name="society_based_on"
                                                                            value="1">{{ __('messages.MutualInterest') }}</label>
                                                                    <label><input class="form-check-input" type="radio"
                                                                            name="society_based_on"
                                                                            value="2">{{ __('messages.CooperativeModel') }}</label>
                                                                    <span id="society_based_on_err" class="error"></span>
                                                                </div> -->

                                                    </div>
                                                    <div class="mb-3 row">
                                                        <label for="example-text-input"
                                                            class="col-md-6 col-form-label fw-bold">{{ __('messages.WhichBankorCentralBankWilltheSocietyBeAssociatedWithandWhatIstheDistanceBetweenThem') }}
                                                        </label>
                                                        
                                                        <div class="col-md-3">
                                                            <label>{{ __('messages.enterbank') }}<span class="text-danger">*</span></label>
                                                            <input class="form-control form-control-sm"
                                                                placeholder="{{ __('messages.enterbank') }}" type="text"
                                                                id="bank_name" name="bank_name"
                                                                value="{{ $feasibilityReports->bank_name ?? '' }}"
                                                                onkeyup="validateData(this,'bank_name')" />
                                                            <span id="bank_name_err" class="error"></span>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label>{{ __('messages.enterdistance') }}<span class="text-danger">*</span></label>
                                                            <input class="form-control form-control-sm"
                                                                id="society_bank_distance"
                                                                placeholder="{{ __('messages.enterdistance') }}" type="text"
                                                                name="society_bank_distance"
                                                                value="{{ $feasibilityReports->society_bank_distance ?? '' }}"
                                                                onkeyup="validateData(this,'society_bank_distance')" />
                                                            <span id="society_bank_distance_err" class="error"></span>
                                                        </div>
                                                    </div>

                                                    <label for="example-text-input"
                                                        class="col-form-label fw-bold">{{ __('messages.MembershipCriteria') }}</label>
                                                    <fieldset class="border p-3 mb-3">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.Howmanyindividualsareeligibleformembership') }}&nbsp;<span
                                                                    class="text-danger">*</span></label>
                                                                <input class="form-control" name="membership_limit" min="0"
                                                                    id="membership_limit" type="number"
                                                                    value="{{ $feasibilityReports->membership_limit ?? '' }}"
                                                                    onkeyup="validateData(this,'membership_limit')" />
                                                                <span id="membership_limit_err" class="error"></span>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.Howmanyindividualsarereadytojoin') }}&nbsp;<span
                                                                    class="text-danger">*</span></label>
                                                                <input class="form-control" min="0"
                                                                    id="total_members_ready_to_join"
                                                                    name="total_members_ready_to_join" type="number"
                                                                    value="{{ $feasibilityReports->total_members_ready_to_join ?? '' }}"
                                                                    onkeyup="validateData(this,'total_members_ready_to_join')" />
                                                                <span id="total_members_ready_to_join_err"
                                                                    class="error"></span>
                                                            </div>
                                                            <div class="col-md-6 mb-3 RadioBtnCol">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.Aremostmembersactiveandinvolved') }}</label><span
                                                                    class="text-danger">*</span>
                                                                <label><input class="form-check-input" type="radio"
                                                                        name="is_member_active" value="1" {{ isset($feasibilityReports) && $feasibilityReports->is_member_active == '1' ? 'checked' : '' }}>{{ __('messages.yes') }}
                                                                </label>
                                                                <label><input class="form-check-input" type="radio"
                                                                        name="is_member_active" value="2" {{ isset($feasibilityReports) && $feasibilityReports->is_member_active == '2' ? 'checked' : '' }}>{{ __('messages.no') }}
                                                                </label>
                                                                <span id="is_member_active_err" class="error"></span>
                                                            </div>
                                                        </div>
                                                    </fieldset>

                                                    <label for="example-text-input"
                                                        class="col-form-label fw-bold">{{ __('messages.ArePanchayatOfficialsSupportiveoftheSocietyandKeepingInfluenceOverIt') }}</label>
                                                    <fieldset class="border p-3 mb-3">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.NamesofProposedChairman') }}</label>
                                                                <span class="text-danger">*</span>
                                                                <input class="form-control" name="chairman_name"
                                                                    placeholder="{{ __('messages.enterchairmanname') }}"
                                                                    type="text"
                                                                    value="{{ $feasibilityReports->chairman_name ?? '' }}"
                                                                    id="chairman_name"
                                                                    onkeyup="validateData(this,'chairman_name')" />
                                                                <span id="chairman_name_err" class="error"></span>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.NamesofProposedSecretary') }}</label>
                                                                <span class="text-danger">*</span>
                                                                <input class="form-control" name="secretary_name"
                                                                    placeholder="{{ __('messages.enterscecreteryname') }}"
                                                                    type="text"
                                                                    value="{{ $feasibilityReports->secretary_name ?? '' }}"
                                                                    id="secretary_name"
                                                                    onkeyup="validateData(this,'secretary_name')" />
                                                                <span id="secretary_name_err" class="error"></span>
                                                            </div>
                                                            <div class="col-md-12 mb-3 RadioBtnCol">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.HavetheSocietyMembersUnderstoodTheirRightsandResponsibilities') }}</label>
                                                                <span class="text-danger">*</span>
                                                                <label><input class="form-check-input"
                                                                        name="is_member_understood_rights" type="radio"
                                                                        value="1" {{ isset($feasibilityReports) && $feasibilityReports->is_member_understood_rights == '1' ? 'checked' : '' }} />{{ __('messages.yes') }}</label>
                                                                <label><input class="form-check-input"
                                                                        name="is_member_understood_rights" type="radio"
                                                                        value="0" {{ isset($feasibilityReports) && $feasibilityReports->is_member_understood_rights == '1' ? 'checked' : '' }} />{{ __('messages.no') }}</label>
                                                                <span id="is_member_understood_rights_err"
                                                                    class="error"></span>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                    <div class="mb-3 row">
                                                        <label for="example-text-input"
                                                            class="col-md-6 col-form-label fw-bold">{{ __('messages.AreMembersAwareoftheSocietyObjectivestheImportanceoftheMeetingandTheirResponsibilities') }}<span class="text-danger">*</span></label>
                                                        
                                                        <div class="col-md-6 RadioBtnCol">
                                                            <label><input class="form-check-input"
                                                                    name="is_member_awared_objectives" type="radio"
                                                                    value="1" {{ isset($feasibilityReports) && $feasibilityReports->is_member_awared_objectives == '1' ? 'checked' : '' }} />{{ __('messages.yes') }}</label>
                                                            <label><input class="form-check-input"
                                                                    name="is_member_awared_objectives" type="radio"
                                                                    value="0" {{ isset($feasibilityReports) && $feasibilityReports->is_member_awared_objectives == '1' ? 'checked' : '' }} />{{ __('messages.no') }}</label>
                                                            <span id="is_member_awared_objectives_err" class="error"></span>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <label for="example-text-input"
                                                            class="col-md-6 col-form-label fw-bold">{{ __('messages.IsThereAnyExistingCooperativeSocietyintheAreaIfYesProvideDetails') }}</label>
                                                        <div class="col-md-1 RadioBtnCol">
                                                            <label><input class="form-check-input"
                                                                    name="is_existing_society" type="radio"
                                                                    onclick="showDiv('show','society_details')" value="1" {{ isset($feasibilityReports) && $feasibilityReports->is_existing_society == '1' ? 'checked' : '' }} />{{ __('messages.yes') }}</label>
                                                            <label><input class="form-check-input"
                                                                    name="is_existing_society" type="radio"
                                                                    onclick="showDiv('hide','society_details')" value="0" {{ isset($feasibilityReports) && $feasibilityReports->is_existing_society == '0' ? 'checked' : '' }} />{{ __('messages.no') }}</label>
                                                            <span id="is_existing_society_err" class="error"></span>
                                                        </div>

                                                        <div class="col-md-5" id="society_details"
                                                            style="display:{{ isset($feasibilityReports) && $feasibilityReports->is_existing_society == '1' ? 'block' : 'none' }}">
                                                            <div class="gap-2 co-operative-society">
                                                                <div>
                                                                    <input class="form-control"
                                                                        id="existing_society_details"
                                                                        placeholder="{{ __('messages.EnterSocietyDetails') }}"
                                                                        name="existing_society_details" type="textarea"
                                                                        value="{{ $feasibilityReports->existing_society_details ?? '' }}" />
                                                                    <span id="existing_society_details_err"
                                                                        class="error"></span>
                                                                </div>
                                                                <div>
                                                                    <input class="form-control" id="area_operation"
                                                                        placeholder="{{ __('messages.Areaofoperation') }}"
                                                                        name="area_operation" type="textarea"
                                                                        value="{{ $feasibilityReports->area_operation ?? '' }}" />
                                                                    <span id="area_operation_err" class="error"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <label for="example-text-input"
                                                            class="col-md-6 col-form-label fw-bold">{{ __('messages.TimeTakenforFormingtheSocietyandProposedDateofRegistration') }}</label>
                                                        <div class="col-md-3">
                                                            <input class="form-control form-control-sm" type="number"
                                                                id="society_completion_time"
                                                                placeholder="{{ __('messages.Entersocietycompletiontime') }}"
                                                                name="society_completion_time"
                                                                value="{{ $feasibilityReports->society_completion_time ?? '' }}"
                                                                onkeyup="validateData(this,'society_completion_time')" />
                                                            <span id="society_completion_time_err" class="error"></span>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <input class="form-control form-control-sm" type="date"
                                                                placeholder="{{ __('messages.proposed_registration_date') }}"
                                                                id="society_registration_date"
                                                                name="society_registration_date"
                                                                value="{{ $feasibilityReports->society_registration_date ?? '' }}"
                                                                onkeyup="validateData(this,'society_registration_date')" />
                                                            <span id="society_registration_date_err" class="error"></span>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <label for="example-text-input"
                                                            class="col-md-6 col-form-label fw-bold">
                                                            {{ __('messages.AdditionalInformation') }}</label>
                                                        <div class="col-md-6">
                                                            <input class="form-control form-control-sm" type="text"
                                                                id="additional_info" name="additional_info"
                                                                value="{{ $feasibilityReports->additional_info ?? '' }}"
                                                                onkeyup="validateData(this,'additional_info')" />
                                                            <span id="additional_info_err" class="error"></span>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <label for="example-text-input"
                                                            class="col-md-3 col-form-label fw-bold">{{ __('messages.SignaturesforRegistrationProposal') }}</label>
                                                        <div class="col-md-3">
                                                            <input class="form-control form-control-sm" type="text"
                                                                name="authority_name" id="authority_name"
                                                                placeholder="{{ __('messages.EnterAuthorityPersonName') }}"
                                                                value="{{ $feasibilityReports->authority_name ?? '' }}"
                                                                onkeyup="validateData(this,'authority_name')" />
                                                            <span class="error" id="authority_name_err"></span>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <input class="form-control form-control-sm" type="text"
                                                                name="authority_designation" id="authority_designation"
                                                                placeholder="{{ __('messages.EnterAuthorityPersondesignation') }}"
                                                                value="{{ $feasibilityReports->authority_designation ?? '' }}"
                                                                onkeyup="validateData(this,'authority_designation')" />
                                                            <span class="error" id="authority_designation_err"></span>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <input class="form-control form-control-sm" type="file"
                                                                name="authority_signature" id="authority_signature"
                                                                placeholder="Upload the Signature" value="" />
                                                            <!-- Show existing file -->
                                                            @if (!empty($feasibilityReports->authority_signature))
                                                                <div class="mt-2">
                                                                    <a href="javascript:void(0);"
                                                                        onclick="viewAttachment('{{ asset('storage/' . $feasibilityReports->authority_signature) }}')">
                                                                        View
                                                                    </a>
                                                                </div>
                                                            @endif
                                                            <span class="error" id="authority_signature_err"></span>
                                                        </div>
                                                        <div class="mb-3 row">
                                                            <label for="example-text-input"
                                                                class="fw-bold">{{ __('messages.DistrictCooperativeSocietyOfficerReport') }}</label>
                                                            <p>"{{ __('messages.IamsatisfiedwiththemanagementandfeasibilitystudyofthesocietyTheregistrationofthesocietyisrecommended') }}"
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <button class="btn btn-secondary" type="button" style="width: 12%;"
                                                            onclick="showPreviousStep(3)">{{ __('messages.back') }}</button>
                                                        <button class="btn btn-primary" type="button" id="submit_btn4"
                                                            onclick="nextStep(4)">{{ __('messages.save&submit') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- <div class="tab-pane" id="step5" role="tabpanel">
                                                        <h6 class="fw-bold">
                                                            {{ __('messages.Inspectors_Report_(For ADO)') }}
                                                        </h6>
                                                        <form id="step_form5" enctype="multipart/form-data">
                                                            @csrf
                                                            <input type="hidden" id="step5" value="5" name="step" />
                                                            <input type="hidden" value="{{ $signatureDetails->id ?? '' }}"
                                                                id="inspector_reportId" name="inspector_reportId" />
                                                            <div class="mb-2 row">
                                                                <label class="col-md-9 col-form-label fw-bold">
                                                                    {{ __('messages.On_what_date_did_the_inspector_conduct_the_permanent_inspection') }}
                                                                </label>
                                                                <div class="col-md-3">
                                                                    <input type="date" class="form-control form-control-sm"
                                                                        name="permanent_inspection_date"
                                                                        value="{{ $signatureDetails->permanent_inspection_date ?? '' }}"
                                                                        onkeyup="validateData(this,'permanent_inspection_date')"
                                                                        required>
                                                                    <span class="error" id="permanent_inspection_date_err"></span>
                                                                </div>
                                                            </div>

                                                            <div class="mb-2 row">
                                                                <label class="col-md-6 col-form-label fw-bold">
                                                                    {{ __('messages.Is_the_inspector_satisfied_with_the_members_knowledge_and_enthusiasm_about_the_committee') }}
                                                                </label>
                                                                <div class="col-md-3">
                                                                    <label class="me-2"><input class="form-check-input" type="radio"
                                                                            name="member_knowledge" value="1" {{ @$signatureDetails->member_knowledge == 1 ? 'checked' : '' }} required>
                                                                        {{ __('messages.yes') }}</label>
                                                                    <label><input class="form-check-input" type="radio"
                                                                            name="member_knowledge" value="0" {{ @$signatureDetails->member_knowledge === 0 ? 'checked' : '' }} required>
                                                                        {{ __('messages.no') }}</label>
                                                                    <span class="error" id="member_knowledge_err"></span>
                                                                </div>
                                                            </div>

                                                            <div class="mb-2 row">
                                                                <label class="col-md-6 col-form-label fw-bold">
                                                                    {{ __('messages.Is_the_inspector_satisfied_that_the_proposed_Panchayat_is_suitable_for_the_operation_of_the_committee') }}
                                                                </label>
                                                                <div class="col-md-3">
                                                                    <label class="me-2"><input class="form-check-input" type="radio"
                                                                            name="panchayat_suitability" value="1" {{ @$signatureDetails->panchayat_suitability === 1 ? 'checked' : '' }} required>
                                                                        {{ __('messages.yes') }}</label>
                                                                    <label><input class="form-check-input" type="radio"
                                                                            name="panchayat_suitability" value="0" {{ @$signatureDetails->panchayat_suitability === 0 ? 'checked' : '' }} required>
                                                                        {{ __('messages.no') }}</label>
                                                                    <span class="error" id="panchayat_suitability_err"></span>
                                                                </div>
                                                            </div>

                                                            <div class="mb-2 row">
                                                                <label class="col-md-6 col-form-label fw-bold">
                                                                    {{ __('messages.Are_more_than_80%_of_the_families_in_the_committee_willing_to_join') }}
                                                                </label>
                                                                <div class="col-md-3">
                                                                    <label class="me-2">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="family_wilingness" value="1" {{ @$signatureDetails->family_wilingness === 1 ? 'checked' : '' }} onchange="toggleReason(false)" required>
                                                                        {{ __('messages.yes') }}
                                                                    </label>
                                                                    <label>
                                                                        <input class="form-check-input" type="radio"
                                                                            name="family_wilingness" value="0" {{ @$signatureDetails->family_wilingness === 0 ? 'checked' : '' }} onchange="toggleReason(true)" required>
                                                                        {{ __('messages.no') }}
                                                                    </label>
                                                                    <span class="error" id="family_wilingness_err"></span>
                                                                </div>

                                                                <div class="col-md-3" id="reason_section" style="display:none;">
                                                                    <textarea name="family_wilingness_reason" class="form-control"
                                                                        rows="4"
                                                                        placeholder="{{ __('messages.If_not_state_the_reason') }}"
                                                                        onkeyup="validateData(this,'family_wilingness_reason')">{{ $signatureDetails->family_wilingness_reason ?? '' }}</textarea>
                                                                    <span class="error" id="family_wilingness_reason_err"></span>
                                                                </div>
                                                            </div>

                                                            <div class="mb-2 row">
                                                                <label class="col-md-6 col-form-label fw-bold">
                                                                    {{ __('messages.Will_the_committee_get_the_necessary_capital_from_the_bank_to_run_its_operations') }}
                                                                </label>
                                                                <div class="col-md-3">
                                                                    <label class="me-2"><input class="form-check-input" type="radio"
                                                                            name="is_bank_capital_available" value="1" {{ @$signatureDetails->is_bank_capital_available === 1 ? 'checked' : '' }} required>
                                                                        {{ __('messages.yes') }}</label>
                                                                    <label><input class="form-check-input" type="radio"
                                                                            name="is_bank_capital_available" value="0" {{ @$signatureDetails->is_bank_capital_available === 0 ? 'checked' : '' }} required>
                                                                        {{ __('messages.no') }}</label>
                                                                    <span class="error" id="is_bank_capital_available_err"></span>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label for="example-text-input"
                                                                    class="col-md-3 col-form-label fw-bold">{{ __('messages.SignaturesforRegistrationProposal') }}</label>
                                                                <div class="col-md-3">
                                                                    <input class="form-control form-control-sm" type="text"
                                                                        name="authority_name" id="authority_name"
                                                                        placeholder="{{ __('messages.EnterAuthorityPersonName') }}"
                                                                        value="{{ $signatureDetails->authority_name ?? '' }}"
                                                                        onkeyup="validateData(this,'authority_name')" />
                                                                    <span class="error" id="authority_name_err"></span>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <input class="form-control form-control-sm" type="text"
                                                                        name="authority_designation" id="authority_designation"
                                                                        placeholder="{{ __('messages.EnterAuthorityPersondesignation') }}"
                                                                        value="{{ $signatureDetails->authority_designation ?? '' }}"
                                                                        onkeyup="validateData(this,'authority_designation')" />
                                                                    <span class="error" id="authority_designation_err"></span>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <input class="form-control form-control-sm" type="file"
                                                                        name="authority_signature" id="authority_signature"
                                                                        placeholder="Upload the Signature" value="" />

                                                                    @if (!empty($signatureDetails->authority_signature))
                                                                        <div class="mt-2">
                                                                            <a href="javascript:void(0);"
                                                                                onclick="viewAttachment('{{ asset('storage/' . $signatureDetails->authority_signature) }}')">
                                                                                View
                                                                            </a>
                                                                        </div>
                                                                    @endif
                                                                    <span class="error" id="authority_signature_err"></span>
                                                                </div>
                                                            </div>

                                                            <div class="mb-3 row">
                                                                <label for="example-text-input"
                                                                    class="fw-bold">{{ __('messages.DistrictCooperativeSocietyOfficerReport') }}</label>
                                                                <p>"{{ __('messages.IamsatisfiedwiththemanagementandfeasibilitystudyofthesocietyTheregistrationofthesocietyisrecommended') }}"
                                                                </p>
                                                            </div>

                                                            <div class="d-flex justify-content-between">
                                                                <button class="btn btn-secondary" type="button" style="width: 12%;"
                                                                    onclick="showPreviousStep(4)">{{ __('messages.back') }}</button>
                                                                <button class="btn btn-primary" type="button" id="submit_btn5"
                                                                    onclick="nextStep(5)">{{ __('messages.SaveSubmit') }}</button>
                                                            </div>
                                                        </form>
                                                    </div> -->
                                            <div class="tab-pane" id="step5" role="tabpanel">
                                                <h6 class="fw-bold">
                                                    Final Document Submission
                                                </h6>
                                                <form id="step_form5" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" id="step5" value="5" name="step" />
                                                    <input type="hidden" value="{{ $finalSubmission->id ?? '' }}"
                                                        id="doc_detailsId" name="doc_detailsId" />
                                                    <fieldset class="border p-3 mb-3">
                                                        <legend class="w-auto px-2"></legend>
                                                        <div class="mb-3 col-md-6">
                                                            <label class="form-label fw-bold"> Proposal Documents :</label>
                                                        </div>
                                                        <div class="mb-3 row">
                                                            <div class="col-md-4">
                                                                <label>Meeting1</label>
                                                                <input type="file" id="meeting1"
                                                                    class="form-control col-md-4 form-control-sm"
                                                                    name="meeting1"
                                                                    value="{{ $finalSubmission->meeting1 ?? '' }}"
                                                                    onkeyup="validateData(this,'meeting1')" />
                                                                @if (@$finalSubmission->meeting1)
                                                                    <a href="javascript:void(0);"
                                                                        onclick="viewAttachment('{{ asset('storage/' . $finalSubmission->meeting1) }}')">View</a>
                                                                @endif
                                                                <span class="error" id="meeting1_err"></span>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label>Meeting2</label>
                                                                <input type="file" id="meeting2"
                                                                    class="form-control col-md-4 form-control-sm"
                                                                    name="meeting2"
                                                                    value="{{ $finalSubmission->meeting2 ?? '' }}"
                                                                    onkeyup="validateData(this,'meeting2')" />
                                                                @if (@$finalSubmission->meeting2)
                                                                    <a href="javascript:void(0);"
                                                                        onclick="viewAttachment('{{ asset('storage/' . $finalSubmission->meeting2) }}')">View</a>
                                                                @endif
                                                                <span class="error" id="meeting2_err"></span>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label>Meeting3</label>
                                                                <input type="file" id="meeting3"
                                                                    class="form-control col-md-4 form-control-sm"
                                                                    name="meeting3"
                                                                    value="{{ $finalSubmission->meeting3 ?? '' }}"
                                                                    onkeyup="validateData(this,'meeting3')" />
                                                                @if (@$finalSubmission->meeting3)
                                                                    <a href="javascript:void(0);"
                                                                        onclick="viewAttachment('{{ asset('storage/' . $finalSubmission->meeting3) }}')">View</a>
                                                                @endif
                                                                <span class="error" id="meeting3_err"></span>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                    <fieldset class="border p-3 mb-3">
                                                        <legend class="w-auto px-2"></legend>
                                                        <div class="mb-3 col-md-6">
                                                            <label class="form-label fw-bold"> Other Documents :</label>
                                                        </div>
                                                        <div class="mb-3 row">
                                                            <div class="col-md-4">
                                                                <label>Upload ID proofs of all members</label>
                                                                <input type="file" id="all_id_proof"
                                                                    class="form-control col-md-4 form-control-sm"
                                                                    name="all_id_proof"
                                                                    value="{{ $finalSubmission->all_id_proof ?? '' }}"
                                                                    onkeyup="validateData(this,'all_id_proof')" />
                                                                @if (@$finalSubmission->all_id_proof)
                                                                    <a href="javascript:void(0);"
                                                                        onclick="viewAttachment('{{ asset('storage/' . $finalSubmission->all_id_proof) }}')">View</a>
                                                                @endif
                                                                <span class="error" id="all_id_proof_err"></span>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label>Upload application forms of all members</label>
                                                                <input type="file" id="all_application_form"
                                                                    class="form-control col-md-4 form-control-sm"
                                                                    name="all_application_form"
                                                                    value="{{ $finalSubmission->all_application_form ?? '' }}"
                                                                    onkeyup="validateData(this,'all_application_form')" />
                                                                @if (@$finalSubmission->all_application_form)
                                                                    <a href="javascript:void(0);"
                                                                        onclick="viewAttachment('{{ asset('storage/' . $finalSubmission->all_application_form) }}')">View</a>
                                                                @endif
                                                                <span class="error" id="all_application_form_err"></span>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label>Upload declaration forms of all members</label>
                                                                <input type="file" id="all_declaration_form"
                                                                    class="form-control col-md-4 form-control-sm"
                                                                    name="all_declaration_form"
                                                                    value="{{ $finalSubmission->all_declaration_form ?? '' }}"
                                                                    onkeyup="validateData(this,'all_declaration_form')" />
                                                                @if (@$finalSubmission->all_declaration_form)
                                                                    <a href="javascript:void(0);"
                                                                        onclick="viewAttachment('{{ asset('storage/' . $finalSubmission->all_declaration_form) }}')">View</a>
                                                                @endif
                                                                <span class="error" id="all_declaration_form_err"></span>
                                                            </div>
                                                        </div>
                                                    </fieldset>

                                                    <fieldset class="border p-3 mb-3">
                                                        <div class="mb-3 col-md-6">
                                                            <label class="form-label fw-bold"> Upload society By Laws
                                                                :</label>
                                                        </div>
                                                        <div class="mb-3 row">
                                                            <div class="col-md-4">
                                                                <input type="file" id="society_by_laws"
                                                                    class="form-control col-md-4 form-control-sm"
                                                                    name="society_by_laws"
                                                                    value="{{ $finalSubmission->society_by_laws ?? '' }}"
                                                                    onkeyup="validateData(this,'society_by_laws')" />
                                                                @if (@$finalSubmission->society_by_laws)
                                                                    <a href="javascript:void(0);"
                                                                        onclick="viewAttachment('{{ asset('storage/' . $finalSubmission->society_by_laws) }}')">View</a>
                                                                @endif
                                                                <span class="error" id="society_by_laws_err"></span>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 col-md-6">
                                                            <label class="form-label fw-bold"> Proof of challan :</label>
                                                        </div>
                                                        <div class="mb-3 row">
                                                            <div class="col-md-4">
                                                                <input type="file" id="challan_proof"
                                                                    class="form-control col-md-4 form-control-sm"
                                                                    name="challan_proof"
                                                                    onkeyup="validateData(this,'challan_proof')">
                                                                <span class="error" id="challan_proof_err"></span>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                    <div class="d-flex justify-content-between">
                                                        <button class="btn btn-secondary" type="button" style="width: 12%;"
                                                            onclick="showPreviousStep(4)">{{ __('messages.back') }}</button>
                                                        <button class="btn btn-primary" type="button" id="submit_btn5"
                                                            onclick="nextStep(5)">{{ __('messages.finalsubmit') }}Final
                                                            Submit</button>
                                                    </div>
                                                </form>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                        </div>

                        <div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Application Details</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- You can beautify as needed -->
                                        <div id="modalContent">
                                            Loading...
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
        let currentStep = 1;
        $(document).ready(function () {
            // Add more input fields dynamically
            $('#addMoreBtn').click(function () {
                let rowIndex = $('#more_member .additionalMember').length;
                $('#more_member').append(
                    `<div class="row additionalMember mt-3">
                                        <button class="formremoveBtn" onclick="removeDiv(this)"><i class="uil-times"></i></button>
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label fw-bold">{{ __('messages.name') }}</label>
                                                <input type="hidden" id="member_id${rowIndex}" name="member_id[]" value="" />
                                                <input type="text"
                                                    class="form-control col-md-4 form-control-sm"
                                                    name="name[]"
                                                    placeholder="{{ __('messages.MemberName') }}"
                                                    value="" />
                                                <span id="name${rowIndex}" class="error error-name"></span>
                                            </div>
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label fw-bold">{{ __('messages.AadhaarNo') }}</label>
                                                <input type="text"
                                                    class="form-control col-md-4 form-control-sm"
                                                    name="aadhar_no[]"
                                                    placeholder="{{ __('messages.AadhaarNo') }}"
                                                    value="" onblur="checkAadhaarExist(this)" />
                                                <span id="aadhar_no${rowIndex}" class="error error-aadhar_no"></span>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label fw-bold">{{ __('messages.fulladdress') }}</label>
                                                <input type="text"
                                                    class="form-control col-md-4 form-control-sm"
                                                    name="address[]"
                                                    placeholder="{{ __('messages.memberaddress') }}"
                                                    value="" />
                                                <span id="address${rowIndex}" class="error error-address"></span>
                                            </div>

                                            <div class="col-md-3 form-group">
                                    <label class="form-label fw-bold">{{ __('messages.gender') }}</label>
                                    <select onchange="validateData(this,'gender1')"
                                            class="form-select form-control col-md-4 form-control-sm"
                                            name="gender[]">
                                        <option value="">{{ __('messages.select') }}</option>
                                        <option value="1" >
                                            {{ __('messages.male') }}
                                        </option>
                                        <option value="2">
                                            {{ __('messages.female') }}
                                        </option>
                                        <option value="3">
                                            {{ __('messages.transgender') }}
                                        </option>
                                    </select>
                                    <span id="gender${rowIndex}" class="error error-gender"></span>
                                </div>

                                                                                                                                                                <div class="col-md-3 form-group">
                                    <label class="form-label fw-bold">{{ __('messages.ismarried') }}</label>
                                    <select onchange="validateData(this,'is_married1')"
                                            class="form-select form-control col-md-4 form-control-sm"
                                            name="is_married[]">
                                        <option value="">{{ __('messages.select') }}</option>
                                        <option value="1">
                                            {{ __('messages.yes') }}
                                        </option>
                                        <option value="2">
                                            {{ __('messages.no') }}
                                        </option>
                                    </select>
                                    <span id="is_married${rowIndex}" class="error errord-is_married"></span>
                                </div>
                                <div class="col-md-3">
                                    <label
                                        class="form-label fw-bold">{{ __('messages.FatherName') }}</label>
                                    <input type="text"
                                        class="form-control col-md-4 form-control-sm"
                                        name="father_spouse_name[]"
                                        placeholder="{{ __('messages.FatherName') }}"
                                        value="" />
                                    <span id="father_spouse_name${rowIndex}" class="error error-father_spouse_name"></span>
                                </div>
                                <div class="col-md-3">
                                    <label
                                        class="form-label fw-bold">{{ __('messages.designation') }}</label>
                                    <input type="text"
                                        class="form-control col-md-4 form-control-sm"
                                        name="designation[]"
                                        placeholder="{{ __('messages.designation') }}" value="{{ $members->designation ?? '' }}" />
                                    <span id="designation${rowIndex}" class="error error-designation"></span>
                                </div>
                                <div class="col-md-3">
                                    <label
                                        class="form-label fw-bold">{{ __('messages.buisness') }}</label>
                                    <input type="text"
                                        class="form-control col-md-4 form-control-sm"
                                        name="buisness_name[]"
                                        placeholder="{{ __('messages.buisnessname') }}" value="{{ $members->buisness_name ?? '' }}" />
                                    <span id="buisness_name${rowIndex}" class="error error-buisness_name"></span>
                                </div>
                                <div class="col-md-3">
                                    <label
                                        class="form-label fw-bold">{{ __('messages.signature') }}</label>
                                    <input type="file"
                                        class="form-control col-md-4 form-control-sm"
                                        name="signature[]"
                                        accept="image/*,application/pdf" value="{{ $members->signature ?? '' }}" />
                                    <span id="signature${rowIndex}" class="error error-signature"></span>
                                </div>
                            </div>
                                                                                                                                                    `
                );
            });

        });
        function validateDecimal(input) {
            let value = input.value;
            value = value.replace(/[^0-9.]/g, '');
            const parts = value.split('.');
            if (parts.length > 2) {
                value = parts[0] + '.' + parts[1];
            }
            input.value = value;
        }

        function removeDiv(obj, memberId) {
            if (memberId) {
                // obj.preventDefault();
                if (confirm("Are you sure to remove this member ?")) {
                    $.ajax({
                        url: "{{ route('member.delete') }}",
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            memberId: memberId,
                        },
                        beforeSend: function () { },
                        success: function (response) {
                            if (response.success) {
                                $("#nav-link-3").addClass("active");
                                $("#step3").addClass("active");
                            }
                        },
                        error: function (xhr, status, error) {

                        },
                        complete: function () {

                        }
                    });
                    $(obj).closest('.additionalMember').remove();
                }
            } else {
                $(obj).closest('.additionalMember').remove();
            }
        }

        function showPreviousStep(previousStep) {
            var currentStep = previousStep + 1;
            $("#nav-link-" + currentStep).removeClass("active");
            $("#nav-link-" + previousStep).addClass("active");
            $("#step" + currentStep).removeClass("active");
            $("#step" + previousStep).addClass("active");
            $(".error").text("");
        }

        function showDiv(show_type, div_id) {
            // alert(show_type+"=="+div_id)
            if (show_type == "show") {
                $("#" + div_id).show();
            } else {
                $("#" + div_id).hide();
            }
        }

        function validateData(inputElement, field_id) {
            console.log(997, inputElement)
            var field_val = inputElement.value;
            if (field_val != "") {
                $("#" + field_id + "_err").text("");
            }
        }

        function checkAadhaarExist(inputElement, memberId) {
            var aadharNo = inputElement.value;
            if (!aadharNo) {
                return;
            }
            $.ajax({
                url: "{{ route('aadhar.exists') }}",
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    aadhar_no: aadharNo,
                    member_id: memberId ? memberId : ""
                },
                beforeSend: function () { },
                success: function (response) {
                    if (response.exists) {
                        $(inputElement).val("");
                        // Display error if Aadhaar exists
                        $(inputElement).next('.error').text(aadharNo + ' already exists.');
                    } else {
                        // Clear any previous error messages
                        $(inputElement).next('.error').text('');
                    }
                },
                error: function (xhr, status, error) {
                    // Handle error response
                    console.log(11, error);
                    // $('#response-message').html('<strong>Error:</strong> Something went wrong.');
                    $("#submit_btn" + step).prop('disabled', false);
                },
                complete: function () {

                }
            });
        }

        function validateStep(step) {
            let isValid = true;
            if (step == 1) {
                let society_name = $("#society_name").val();
                let locality = $("#locality").val();
                let post_office = $("#post_office").val();
                let developement_area = $("#developement_area").val();
                let tehsil = $("#tehsil").val();
                let district = $("#district").val();
                let nearest_station = $("#nearest_station").val();
                let society_category = document.querySelector("input[name=society_category]:checked");
                if (!society_name) {
                    $("#society_name_err").text("This field is required.");
                    isValid = false;
                }
                if (!locality) {
                    $("#locality_err").text("This field is required");
                    isValid = false;
                }
                if (!post_office) {
                    $("#post_office_err").text("This field is required");
                    isValid = false;
                }
                if (!developement_area) {
                    $("#developement_area_err").text("This field is required");
                    isValid = false;
                }
                if (!tehsil) {
                    $("#tehsil_err").text("This field is required");
                    isValid = false;
                }
                if (!district) {
                    $("#district_err").text("This field is required");
                    isValid = false;
                }
                if (!nearest_station) {
                    $("#nearest_station_err").text("This field is required");
                    isValid = false;
                }
                if (!society_category) {
                    $("#society_category_err").text("This field is required");
                    isValid = false;
                }
            } else if (step == 2) {
                let member_responsibility_type = document.querySelector("input[name=member_responsibility_type]:checked");
                let society_operational_area = $("#society_operational_area").val();
                let society_objective = $("#society_objective").val();
                // let society_share_value = $("#society_share_value").val();
                let subscription_rate = $("#subscription_rate").val();
                let member_liability = $("#member_liability").val();
                let general_member_count = $("#general_member_count").val();
                let society_record_language = $("#society_record_language").val();
                let society_representative_name = $("#society_representative_name").val();
                let society_representative_address = $("#society_representative_address").val();
                let society_representative_signature = $("#society_representative_signature").val();
                let society_secretary_name = $("#society_secretary_name").val();
                let society_secretary_address = $("#society_secretary_address").val();
                let society_secretary_signature = $("#society_secretary_signature").val();

                let exist_secreatary_signature =
                                        {{ @$membersObjectives->society_secretary_signature ? 'true' : 'false' }};
                let exist_representative_signature =
                                        {{ @$membersObjectives->society_representative_signature ? 'true' : 'false' }};

                if (!member_responsibility_type) {
                    $("#member_responsibility_type_err").text("This field is required.");
                    isValid = false;
                }
                if (!society_operational_area) {
                    $("#society_operational_area_err").text("This field is required.");
                    isValid = false;
                }
                if (!society_objective) {
                    $("#society_objective_err").text("This field is required.");
                    isValid = false;
                }
                // if (!society_share_value) {
                //     $("#society_share_value_err").text("This field is required.");
                //     isValid = false;
                // }
                if (!subscription_rate) {
                    $("#subscription_rate_err").text("This field is required.");
                    isValid = false;
                }
                if (!member_liability) {
                    $("#member_liability_err").text("This field is required.");
                    isValid = false;
                }
                if (!general_member_count) {
                    $("#general_member_count_err").text("This field is required.");
                    isValid = false;
                }
                if (!society_record_language) {
                    $("#society_record_language_err").text("This field is required.");
                    isValid = false;
                }
                if (!society_representative_name) {
                    $("#society_representative_name_err").text("This field is required.");
                    isValid = false;
                }
                if (!society_representative_address) {
                    $("#society_representative_address_err").text("This field is required.");
                    isValid = false;
                }
                if (!society_representative_signature && !exist_representative_signature) {
                    $("#society_representative_signature_err").text("This field is required.");
                    isValid = false;
                }
                if (!society_secretary_name) {
                    $("#society_secretary_name_err").text("This field is required.");
                    isValid = false;
                }
                if (!society_secretary_address) {
                    $("#society_secretary_address_err").text("This field is required.");
                    isValid = false;
                }
                if (!society_secretary_signature && !exist_secreatary_signature) {
                    $("#society_secretary_signature_err").text("This field is required.");
                    isValid = false;
                }
            } else if (step == 3) {
                // Clear previous errors
                $('.error-name').text('');
                $('.error-aadhar_no').text('');
                $('.error-address').text('');
                $('.error-gender').text('');
                $('.error-membership_form').text('');
                $('.error-declaration1').text('');
                $('.error-declaration2').text('');

                // Check minimum 7 members
                const memberCount = $('.member-row').length;
                if (memberCount < 7) {
                    alert("Minimum 7 members are required for submission.");
                    isValid = false;
                }

                if ($("input[name='is_declared']").prop('checked') == false) {
                    $("#is_declared_err").text("This field is required.");
                    isValid = false;
                }

                // Validate each member's fields
                $(".member-row").each(function (index) {
                    // Name validation
                    const nameInput = $(this).find("input[name='name[]']");
                    if (nameInput.val().trim() === "") {
                        isValid = false;
                        nameInput.next('.error-name').text("Name is required.");
                    }

                    // Address validation
                    const addressInput = $(this).find("input[name='address[]']");
                    if (addressInput.val().trim() === "") {
                        isValid = false;
                        addressInput.next('.error-address').text("Address is required.");
                    }

                    // Gender validation
                    const genderSelect = $(this).find("select[name='gender[]']");
                    if (genderSelect.val() === "") {
                        isValid = false;
                        genderSelect.next('.error-gender').text("Gender is required.");
                    }

                    // Membership Form validation
                    const membershipFormInput = $(this).find("input[name='membership_form[]']");
                    
                    if (membershipFormInput[0].files.length === 0 && !$(this).find('a[onclick*="membership_form"]').length) {
                        isValid = false;
                        membershipFormInput.closest('.form-group').find('.error-membership_form').text("Membership Form is required.");
                    }

                    // Declaration 1 validation
                    const declaration1Input = $(this).find("input[name='declaration1[]']");
                    if (declaration1Input[0].files.length === 0 && !$(this).find('a[onclick*="declaration1"]').length) {
                        isValid = false;
                        declaration1Input.closest('.form-group').find('.error-declaration1').text("Declaration 1 is required.");
                    }

                    // Declaration 2 validation
                    const declaration2Input = $(this).find("input[name='declaration2[]']");
                    if (declaration2Input[0].files.length === 0 && !$(this).find('a[onclick*="declaration2"]').length) {
                        isValid = false;
                        declaration2Input.closest('.form-group').find('.error-declaration2').text("Declaration 2 is required.");
                    }
                });
            } else if (step == 4) {
                let society_name = $("#fsociety_name").val();
                let society_formation_reason = $("#society_formation_reason").val();
                let society_type = document.querySelector("input[name=society_type]:checked");
                let bank_name = $("#bank_name").val();
                let society_bank_distance = $("#society_bank_distance").val();
                let membership_limit = $("#membership_limit").val();
                let total_members_ready_to_join = $("#total_members_ready_to_join").val();
                let is_member_active = document.querySelector("input[name=is_member_active]:checked");
                let chairman_name = $("#chairman_name").val();
                let secretary_name = $("#secretary_name").val();
                let is_member_understood_rights = document.querySelector("input[name=is_member_understood_rights]:checked");
                let is_member_awared_objectives = document.querySelector("input[name=is_member_awared_objectives]:checked");
                let is_existing_society = document.querySelector("input[name=is_existing_society]:checked");
                let is_existing_society_val = $('input[name="is_existing_society"]:checked').val();
                // alert(is_existing_society_val)
                if (is_existing_society_val == 1) {
                    let existing_society_details = $("#existing_society_details").val();
                    let area_operation = $("#area_operation").val();
                    if (!existing_society_details) {
                        $("#existing_society_details_err").text("Enter society name with objective");
                        isValid = false;
                    }
                    if (!area_operation) {
                        $("#area_operation_err").text("Enter area of operation");
                        isValid = false;
                    }
                }
                let society_completion_time = $("#society_completion_time").val();
                let society_registration_date = $("#society_registration_date").val();
                let additional_info = $("#additional_info").val();
                let authority_name = $("#authority_name").val();
                let authority_designation = $("#authority_designation").val();
                let authority_signature = $("#authority_signature").val();
                let exist_authority_signature = {{ @$feasibilityReports->authority_signature ? 'true' : 'false' }};
                if (!society_name) {
                    $("#fsociety_name_err").text("This field is required.");
                    isValid = false;
                }
                if (!society_formation_reason) {
                    $("#society_formation_reason_err").text("This field is required.");
                    isValid = false;
                }
                if (!society_type) {
                    $("#society_type_err").text("This field is required.");
                    isValid = false;
                }
                if (!bank_name) {
                    $("#bank_name_err").text("This field is required.");
                    isValid = false;
                }
                if (!society_bank_distance) {
                    $("#society_bank_distance_err").text("This field is required.");
                    isValid = false;
                }
                if (!membership_limit) {
                    $("#membership_limit_err").text("This field is required.");
                    isValid = false;
                }
                if (!total_members_ready_to_join) {
                    $("#total_members_ready_to_join_err").text("This field is required.");
                    isValid = false;
                }
                if (!is_member_active) {
                    $("#is_member_active_err").text("This field is required.");
                    isValid = false;
                }
                if (!chairman_name) {
                    $("#chairman_name_err").text("This field is required.");
                    isValid = false;
                }
                if (!secretary_name) {
                    $("#secretary_name_err").text("This field is required.");
                    isValid = false;
                }
                if (!is_member_understood_rights) {
                    $("#is_member_understood_rights_err").text("This field is required.");
                    isValid = false;
                }
                if (!is_member_awared_objectives) {
                    $("#is_member_awared_objectives_err").text("This field is required.");
                    isValid = false;
                }
                if (!is_existing_society) {
                    $("#is_existing_society_err").text("This field is required.");
                    isValid = false;
                }
                if (!society_completion_time) {
                    $("#society_completion_time_err").text("This field is required.");
                    isValid = false;
                }
                if (!society_registration_date) {
                    $("#society_registration_date_err").text("This field is required.");
                    isValid = false;
                }
                if (!additional_info) {
                    $("#additional_info_err").text("This field is required.");
                    isValid = false;
                }
                if (!authority_name) {
                    $("#authority_name_err").text("Enter authority person name");
                    isValid = false;
                }
                if (!authority_designation) {
                    $("#authority_designation_err").text("Enter authority person designation");
                    isValid = false;
                }
                if (!authority_signature && !exist_authority_signature) {
                    $("#authority_signature_err").text("Upload authority signature");
                    isValid = false;
                }

            } else if (step == 5) {
                let authority_name = $("#authority_name").val();
                let authority_designation = $("#authority_designation").val();
                let authority_signature = $("#authority_signature").val();
                let exist_authority_signature = {{ @$signatureDetails->authority_signature ? 'true' : 'false' }};

                let permanent_inspection_date = $("input[name='permanent_inspection_date']").val();
                let member_knowledge = $("input[name='member_knowledge']:checked").val();
                let panchayat_suitability = $("input[name='panchayat_suitability']:checked").val();
                let family_wilingness = $("input[name='family_wilingness']:checked").val();
                let is_bank_capital_available = $("input[name='is_bank_capital_available']:checked").val();
                let family_wilingness_reason = $("textarea[name='family_wilingness_reason']").val().trim();

                if (!permanent_inspection_date) {
                    $("#permanent_inspection_date_err").text("This field is required.");
                    isValid = false;
                }

                if (!member_knowledge) {
                    $("#member_knowledge_err").text("This field is required.");
                    isValid = false;
                }

                if (!panchayat_suitability) {
                    $("#panchayat_suitability_err").text("This field is required.");
                    isValid = false;
                }

                if (!family_wilingness) {
                    $("#family_wilingness_err").text("This field is required.");
                    isValid = false;
                }

                // If 'no' is selected (value = "0"), reason is required
                if (family_wilingness === "0" && family_wilingness_reason === "") {
                    $("#family_wilingness_reason_err").text("This field is required.");
                    isValid = false;
                }

                if (!is_bank_capital_available) {
                    $("#is_bank_capital_available_err").text("This field is required.");
                    isValid = false;
                }

                if (!authority_name) {
                    $("#authority_name_err").text("This field is required.");
                    isValid = false;
                }
                if (!authority_designation) {
                    $("#authority_designation_err").text("This field is required.");
                    isValid = false;
                }
                if (!authority_signature && !exist_authority_signature) {
                    $("#authority_signature_err").text("This field is required.");
                    isValid = false;
                }

                $("#authority_name, #authority_designation, #authority_signature, textarea[name='family_wilingness_reason'], input[name='permanent_inspection_date']")
                    .on("input change", function () {
                        const id = $(this).attr("id") || $(this).attr("name");
                        $("#" + id + "_err").text("");
                    });

                // Radio buttons
                $("input[name='member_knowledge'], input[name='panchayat_suitability'], input[name='family_wilingness'], input[name='is_bank_capital_available']")
                    .on("change", function () {
                        const name = $(this).attr("name");
                        $("#" + name + "_err").text("");
                    });

            } else if (step == 6) {
                let meeting1 = $("#meeting1").val();
                let exist_meeting1 = {{ @$finalSubmission->meeting1 ? 'true' : 'false' }};
                if (!meeting1 && !exist_meeting1) {
                    $("#meeting1_err").text("Please upload document for meeting1");
                    isValid = false;
                }
                let meeting2 = $("#meeting2").val();
                let exist_meeting2 = {{ @$finalSubmission->meeting2 ? 'true' : 'false' }};
                if (!meeting2 && !exist_meeting2) {
                    $("#meeting2_err").text("Please upload document for meeting2");
                    isValid = false;
                }
                let meeting3 = $("#meeting3").val();
                let exist_meeting3 = {{ @$finalSubmission->meeting3 ? 'true' : 'false' }};
                if (!meeting3 && !exist_meeting3) {
                    $("#meeting3_err").text("Please upload document for meeting3");
                    isValid = false;
                }
                let all_id_proof = $("#all_id_proof").val();
                let exist_all_id_proof = {{ @$finalSubmission->all_id_proof ? 'true' : 'false' }};
                if (!all_id_proof && !exist_all_id_proof) {
                    $("#all_id_proof_err").text("Please upload id proof for all members");
                    isValid = false;
                }
                let all_application_form = $("#all_application_form").val();
                let exist_all_application_form = {{ @$finalSubmission->all_application_form ? 'true' : 'false' }};
                if (!all_application_form && !exist_all_application_form) {
                    $("#all_application_form_err").text("Please upload application form for all members");
                    isValid = false;
                }
                let all_declaration_form = $("#all_declaration_form").val();
                let exist_all_declaration_form = {{ @$finalSubmission->all_declaration_form ? 'true' : 'false' }};
                if (!all_declaration_form && !exist_all_declaration_form) {
                    $("#all_declaration_form_err").text("Please upload declaration form for all members");
                    isValid = false;
                }
                let society_by_laws = $("#society_by_laws").val();
                let exist_society_by_laws = {{ @$finalSubmission->society_by_laws ? 'true' : 'false' }};
                if (!society_by_laws && !exist_society_by_laws) {
                    $("#society_by_laws_err").text("Please upload law document of society");
                    isValid = false;
                }
                let challan_proof = $("#challan_proof").val();
                let exist_challan_proof = {{ @$finalSubmission->challan_proof ? 'true' : 'false' }};
                if (!challan_proof && !challan_proof) {
                    $("#challan_proof_err").text("Please upload challan");
                    isValid = false;
                }

            }

            return isValid;
        }


        function nextStep(stepVal) {
            var step = stepVal;
            currentStep = stepVal;
            if (step) {
                $("#submit_btn" + step).prop('disabled', true);
                let formValidate = validateStep(step); alert(formValidate)
                if (!validateStep(step)) {
                    $("#submit_btn" + step).prop('disabled', false);
                    return;
                }
                var form_data = new FormData($("#step_form" + step)[0]);
                if (step > 1) {
                    let societyId = $("#society_id").val();
                    if (societyId) {
                        form_data.append('society_id', societyId);
                    } else {
                        alert("Society ID is missing. Please complete Step 1 first.");
                        $("#submit_btn" + step).prop('disabled', false);
                        return;
                    }
                }
                $.ajax({
                    url: '{{ route('society.registration') }}',
                    method: 'POST',
                    data: form_data,
                    contentType: false,
                    processData: false,
                    beforeSend: function () { },
                    success: function (response) {
                        if (step < 5) {
                            console.log(11, response);
                            $("#nav-link-" + step).removeClass("active");
                            $("#nav-link-" + response.nextStep).addClass("active");
                            $("#step" + step).removeClass("active");
                            $("#step" + response.nextStep).addClass("active");
                            if (step == 1) {
                                $("#society_id").val(response.societyDetailsId);
                            } else if (step == 2) {
                                $("#mobject_detailsId").val(response.mobject_detailsId);
                            } else if (step == 3) {
                                $("#member_declarationId").val(response.member_declarationId);
                                if (response.member_id_arr && response.member_id_arr.length > 0) {
                                    console.log(11, response.member_id_arr);
                                    for (var i = 0; i < response.member_id_arr.length; i++) {
                                        $("#member_id" + i).val(response.member_id_arr[i]);
                                    }
                                }
                            } else if (step == 4) {
                                $("#feasibility_reportId").val(response.feasibility_reportId);
                                // } else if (step == 5) {
                                //     $("#inspector_reportId").val(response.inspector_reportId);
                            }

                            $("#submit_btn" + step).prop('disabled', false);
                        } else {
                            //location.reload();
                            window.location.href = "{{ route('socialregdapp.list') }}";
                        }
                    },
                    error: function (xhr, status, error) {

                        console.log(11, error);

                        $("#submit_btn" + step).prop('disabled', false);
                    },
                    complete: function () {

                    }
                });

            }
        }

        $('#district').on('change', function () {
            let districtId = this.value;
            $('#developement_area').html('<option value="">Loading...</option>');
            if (districtId) {
                $("#district_err").text("");
                fetch(`/get-blocks/${districtId}`)
                    .then(response => response.json())
                    .then(data => {
                        let options = '<option value="">-- Select --</option>';
                        data.forEach(block => {
                            options += `<option value="${block.id}">${block.name}</option>`;
                        });
                        $('#developement_area').html(options);
                    });
            } else {
                $('#developement_area').html('<option value="">-- Select --</option>');
            }
        });

        function viewAttachment(url) {
            window.open(url, '_blank', 'width=1000,height=800,noopener,noreferrer');
        }
        let currentMemberIdToRemove = null;
        let currentRowToRemove = null;

        function confirmRemoveMember(rowNumber, memberId = null) {
            currentMemberIdToRemove = memberId;
            currentRowToRemove = rowNumber;
            document.getElementById('memberSerialNumber').textContent = rowNumber;
            $('#removeMemberModal').modal('show');
        }

        document.getElementById('confirmRemoveBtn').addEventListener('click', function () {
            if (currentRowToRemove) {
                const rowToRemove = document.querySelector(`.member-row[data-row-number="${currentRowToRemove}"]`);
                if (rowToRemove) {
                    if (currentMemberIdToRemove) {
                        const deleteInput = document.createElement('input');
                        deleteInput.type = 'hidden';
                        deleteInput.name = 'deleted_members[]';
                        deleteInput.value = currentMemberIdToRemove;
                        document.getElementById('more_member').appendChild(deleteInput);
                    }
                    rowToRemove.remove();
                    renumberMemberRows();
                }
            }
            $('#removeMemberModal').modal('hide');
        });

        function renumberMemberRows() {
            const rows = document.querySelectorAll('.member-row');
            rows.forEach((row, index) => {
                const rowNumber = index + 1;
                row.setAttribute('data-row-number', rowNumber);
                const numberSpan = row.querySelector('.member-number');
                if (numberSpan) {
                    numberSpan.textContent = `Member #${rowNumber}`;
                }
                const removeBtn = row.querySelector('.formremoveBtn');
                if (removeBtn) {
                    const memberId = row.querySelector('input[name="member_id[]"]')?.value || null;
                    removeBtn.setAttribute('onclick', `confirmRemoveMember(${rowNumber}, ${memberId || 'null'})`);
                }
                updateFieldIds(row, index);
            });
        }

        function updateFieldIds(row, newIndex) {
            const fields = [
                'name', 'address', 'gender', 'membership_form', 'is_married',
                'father_spouse_name', 'designation', 'aadhar_no', 'signature',
                'declaration1', 'declaration2'
            ];
            fields.forEach(field => {
                const inputs = row.querySelectorAll(`input[name="${field}[]"]`);
                inputs.forEach(input => {
                    input.id = `${field}${newIndex}`;
                    input.setAttribute('onkeyup', `validateData(this,'${field}${newIndex}')`);
                    if (field === 'aadhar_no') {
                        input.setAttribute('onblur', `checkAadhaarExist(this,${input.value || 'null'})`);
                    }
                });
                const selects = row.querySelectorAll(`select[name="${field}[]"]`);
                selects.forEach(select => {
                    select.id = `${field}${newIndex}`;
                    select.setAttribute('onchange', `validateData(this,'${field}${newIndex}')`);
                });
                const errorSpan = row.querySelector(`span[id^="${field}"]`);
                if (errorSpan) {
                    errorSpan.id = `${field}${newIndex}`;
                }
            });
            const memberIdInput = row.querySelector('input[name="member_id[]"]');
            if (memberIdInput) {
                memberIdInput.id = `member_id${newIndex}`;
            }
        }

        function addMoreMember() {
            const memberRows = document.querySelectorAll('.member-row');
            const newIndex = memberRows.length;
            const newRowNumber = newIndex + 1;

            // Clone the first row (or use a template)
            const firstRow = memberRows[0].cloneNode(true);
            // Clear values
            const inputs = firstRow.querySelectorAll('input:not([type="hidden"]), select');
            inputs.forEach(input => {
                if (input.type !== 'file') {
                    input.value = '';
                } else {
                    input.value = '';
                }
            });
            // Remove any file previews
            const filePreviews = firstRow.querySelectorAll('.mt-2');
            filePreviews.forEach(el => el.remove());
            // Update IDs and on* handlers
            firstRow.setAttribute('data-row-number', newRowNumber);
            firstRow.querySelector('.member-number').textContent = `Member #${newRowNumber}`;
            const removeBtn = firstRow.querySelector('.formremoveBtn');
            if (removeBtn) {
                removeBtn.setAttribute('onclick', `confirmRemoveMember(${newRowNumber})`);
            }
            updateFieldIds(firstRow, newIndex);
            // Append to container
            document.getElementById('more_member').appendChild(firstRow);
            // Renumber all rows (to fix any gaps)
            renumberMemberRows();
        }

    </script>
    <script>
        function toggleReason(show) {
            const reasonSection = document.getElementById('reason_section');
            const reasonField = reasonSection.querySelector('textarea');
            if (show) {
                reasonSection.style.display = 'block';
                reasonField.setAttribute('required', 'required');
            } else {
                reasonSection.style.display = 'none';
                reasonField.removeAttribute('required');
                reasonField.value = '';
            }
        }
    </script>
@endsection