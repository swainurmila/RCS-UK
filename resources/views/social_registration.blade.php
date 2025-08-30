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
                                    href="javascript: void(0);">{{ __('messages.cooperatives_department') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('messages.new_registration') }}</li>
                        </ol>
                    </div>
                </div>
                <p>({{ __('messages.section_06_up_act_2003') }})</p>
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
                                                <form id="step_form1">
                                                    @csrf
                                                    <!-- Society Details -->
                                                    <fieldset class="border p-3 mb-3">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.societyname') }}
                                                                    :</label>
                                                                <span class="text-danger">*</span>
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
                                                             <div class="col-md-6 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.societyemail') }}
                                                                    :</label>
                                                                <span class="text-danger">*</span>
                                                                <input type="email" class="form-control" id="society_email"
                                                                    onkeyup="validateData(this,'society_email')"
                                                                    placeholder="{{ __('messages.enter_societyemail') }}"
                                                                    name="society_email"
                                                                    value="{{ $societyDetails->society_email ?? '' }}" />
                                                                <span class="error" id="society_email_err"></span>
                                                            </div>
                                                        </div>
                                                    </fieldset>

                                                    <!-- Address Section -->
                                                    <label
                                                        class="col-form-label fw-bold">{{ __('messages.societyheadquarters') }}
                                                        :</label>
                                                    <fieldset class="border p-3 mb-3">
                                                        <div class="row g-3">
                                                            <div class="col-md-6 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.district') }}
                                                                    :</label>
                                                                <span class="text-danger">*</span>
                                                                <select class="form-select form-control" name="district"
                                                                    id="district">
                                                                    <option value="">-- Select --</option>
                                                                    @foreach ($districts as $district)
                                                                        <option value="{{ $district->id }}"
                                                                            {{ isset($societyDetails) && $societyDetails->district == $district->id ? 'selected' : '' }}>
                                                                            {{ $district->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                <span class="error" id="district_err"></span>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.development_area') }}
                                                                    :</label>
                                                                <span class="text-danger">*</span>
                                                                <select class="form-select form-control"
                                                                    name="developement_area" id="developement_area">
                                                                    <option value="">-- Select --</option>
                                                                    @foreach ($blocks as $block)
                                                                        <option value="{{ $block->id }}"
                                                                            {{ isset($societyDetails) && $societyDetails->developement_area == $block->id ? 'selected' : '' }}>
                                                                            {{ $block->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                <span class="error" id="developement_area_err"></span>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.post_office') }}
                                                                    :</label>
                                                                <span class="text-danger">*</span>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $societyDetails->post_office ?? '' }}"
                                                                    onkeyup="validateData(this,'post_office')"
                                                                    placeholder="{{ __('messages.enternearestpostOfficename') }}"
                                                                    name="post_office" id="post_office" />
                                                                <span class="error" id="post_office_err"></span>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.tehsil') }}
                                                                    :</label>
                                                                <span class="text-danger">*</span>
                                                                <select class="form-select form-control" name="tehsil" id="tehsil"
        onchange="validateData(this,'tehsil')">
    <option value="">{{ __('messages.selecttehsil') }}</option>
    @foreach (@$tehsil as $item)
        <option value="{{ $item->id }}"
            {{ isset($societyDetails->tehsil) && $societyDetails->tehsil == $item->id ? 'selected' : '' }}>
            {{ $item->name }}
        </option>
    @endforeach
</select>
                                                                <span class="error" id="tehsil_err"></span>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.enteryourlocality') }}
                                                                    :</label>
                                                                <span class="text-danger">*</span>
                                                                <input type="text" class="form-control"
                                                                    onkeyup="validateData(this,'locality')"
                                                                    placeholder="{{ __('messages.entervillageorlocalityname') }}"
                                                                    id="locality" name="locality"
                                                                    value="{{ $societyDetails->locality ?? '' }}" />
                                                                <span class="error" id="locality_err"></span>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.nearestrailwaystationbusstation') }}
                                                                    :</label>
                                                                <span class="text-danger">*</span>
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
                                                    <fieldset class="border p-3 mb-3">
                                                        <div class="row">
                                                            <div class="col-md-12 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.categoryofthesociety') }}</label>
                                                                <span class="text-danger">*</span>
                                                                <div class="d-flex justify-content-evenly">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio"
                                                                            onchange="validateData(this,'society_category')"
                                                                            name="society_category" id="primary"
                                                                            value="1"
                                                                            {{ isset($societyDetails) && $societyDetails->society_category == 'Primary' ? 'checked' : '' }} />
                                                                        <label class="form-check-label ms-2"
                                                                            for="primary">{{ __('messages.primary') }}</label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio"
                                                                            onchange="validateData(this,'society_category')"
                                                                            name="society_category" id="centralApex"
                                                                            value="2"
                                                                            {{ isset($societyDetails) && $societyDetails->society_category == 'Central' ? 'checked' : '' }} />
                                                                        <label class="form-check-label ms-2"
                                                                            for="centralApex">{{ __('messages.central') }}</label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio"
                                                                            onchange="validateData(this,'society_category')"
                                                                            name="society_category" id="agricultural"
                                                                            value="3"
                                                                            {{ isset($societyDetails) && $societyDetails->society_category == 'Apex' ? 'checked' : '' }} />
                                                                        <label class="form-check-label ms-2"
                                                                            for="agricultural">{{ __('messages.apex') }}</label>
                                                                    </div>
                                                                </div>
                                                                <span class="error" id="society_category_err"></span>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                    <fieldset class="border p-3 mb-3">
                                                        <div class="row g-3">
                                                            <div class="col-md-6 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.Society-Sector-Type') }}:</label>
                                                                <span class="text-danger">*</span>
                                                                <select class="form-select form-control select2"
                                                                    name="society_sector_type_id"
                                                                    id="society_sector_type_id">
                                                                    <option value="">-- Select --</option>
                                                                    @foreach ($sectors as $sector)
                                                                        <option value="{{ $sector->id }}"
                                                                            {{ @$societyDetails->society_sector_type_id == $sector->id ? 'selected' : '' }}>
                                                                            {{ $sector->cooperative_sector_name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                <span class="error" id="society_sector_type_err"></span>
                                                            </div>

                                                            <div class="col-md-6 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.iscreditsociety') }}</label>
                                                                <span class="text-danger">*</span>
                                                                <div>
                                                                    <label class="mr-10"><input
                                                                            class="form-check-input mr-10"
                                                                            name="is_credit_society" type="radio"
                                                                            onchange="validateData(this,'is_credit_society')"
                                                                            value="1"
                                                                            {{ isset($societyDetails) && $societyDetails->is_credit_society == '1' ? 'checked' : '' }} />{{ __('messages.yes') }}</label>
                                                                    <label class="mr-10"><input
                                                                            class="form-check-input mr-10"
                                                                            onchange="validateData(this,'is_credit_society')"
                                                                            name="is_credit_society" type="radio"
                                                                            value="0"
                                                                            {{ isset($societyDetails) && $societyDetails->is_credit_society == '0' ? 'checked' : '' }} />{{ __('messages.no') }}</label>
                                                                </div>
                                                                <!-- <div class="d-flex justify-content-evenly">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="radio"
                                                                                onchange="validateData(this,'is_credit_society')"
                                                                                name="is_credit_society" id="yes" value="1" {{ isset($societyDetails) && $societyDetails->is_credit_society == '1' ? 'checked' : '' }} />
                                                                            <label class="form-check-label ms-2"
                                                                                for="yes">{{ __('messages.yes') }}</label>
                                                                        </div>
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="radio"
                                                                                onchange="validateData(this,'is_credit_society')"
                                                                                name="is_credit_society" id="no" value="0" {{ isset($societyDetails) && $societyDetails->is_credit_society == '0' ? 'checked' : '' }} />
                                                                            <label class="form-check-label ms-2"
                                                                                for="no">{{ __('messages.no') }}</label>
                                                                        </div>

                                                                    </div> -->
                                                                <span class="error" id="is_credit_society_err"></span>
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
                                                <form id="step_form2" enctype="multipart/form-data">
                                                    @csrf
                                                    <!-- Responsibilities -->
                                                    <label
                                                        class="col-form-label fw-bold">{{ __('messages.responsibilitiesofsocietymembers') }}</label>
                                                    <fieldset class="border p-3 mb-3">
                                                        <div class="row">
                                                            <div class="col-md-12 mb-3">
                                                                <input class="form-control form-control-sm"
                                                                    id="mobject_detailsId" name="mobject_detailsId"
                                                                    type="hidden"
                                                                    value="{{ $membersObjectives->id ?? '' }}" />
                                                                <input type="hidden" value="2" id="step2"
                                                                    name="step" />
                                                                <div class="col-md-10">
                                                                    <div class="society-response">
                                                                        <input class="form-check-input" type="radio"
                                                                            onclick="showDiv('show','responsibility_type')"
                                                                            name="member_responsibility_type"
                                                                            id="responsibilityType" value="1"
                                                                            required />
                                                                        <label class="form-label fw-bold"
                                                                            for="responsibilityType"
                                                                            style="margin-right:10px">{{ __('messages.societyscapitaluptothefinalvaluation') }}</label>
                                                                        <input class="form-check-input" type="radio"
                                                                            onclick="showDiv('hide','responsibility_type')"
                                                                            name="member_responsibility_type"
                                                                            id="indefinite" value="2" checked />
                                                                        <label class="form-label fw-bold"
                                                                            for="indefinite">{{ __('messages.indefinite society capital') }}</label>
                                                                    </div>
                                                                    <div id="responsibility_type" style="display: none;" class="col-md-7">
                                                                        <input class="form-control form-control-sm"
                                                                                type="number" name="capital_amount"
                                                                                placeholder="Enter the number of share capital"
                                                                                value="" step="0.01"
                                                                                min="0"
                                                                                oninput="validateDecimal(this)" />
                                                                       
                                                                    </div>
                                                                </div>
                                                                <!-- <div class="col-md-4">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <div class="form-check">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <input class="form-check-input" type="radio"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    onclick="showDiv('hide','responsibility_type')"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    name="member_responsibility_type"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    id="indefinite" value="2" checked />
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <label class="form-label fw-bold"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    for="indefinite">{{ __('messages.indefinite society capital') }}</label>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </div> -->
                                                                <span class="error"
                                                                    id="member_responsibility_type_err"></span>
                                                            </div>
                                                        </div>
                                                    </fieldset>

                                                    <!-- Operational Area -->
                                                    <fieldset class="border p-3 mb-3">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.operationalareaoftheproposedsociety') }}
                                                                </label>
                                                                <span class="text-danger">*</span>
                                                                <input class="form-control form-control-sm" type="text"
                                                                    onkeyup="validateData(this,'society_operational_area')"
                                                                    id="society_operational_area"
                                                                    placeholder="{{ __('messages.enteroperationalarea') }}"
                                                                    name="society_operational_area"
                                                                    value="{{ $membersObjectives->society_operational_area ?? '' }}" />
                                                                <span class="error"
                                                                    id="society_operational_area_err"></span>
                                                            </div>
                                                        </div>
                                                    </fieldset>

                                                    <!-- Main Objectives -->
                                                    <fieldset class="border p-3 mb-3">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.mainobjectivesoftheproposedsociety') }}
                                                                </label>
                                                                <span class="text-danger">*</span>
                                                                <input class="form-control form-control-sm" type="text"
                                                                    onkeyup="validateData(this,'society_objective')"
                                                                    id="society_objective" name="society_objective"
                                                                    placeholder="{{ __('messages.enterobjectivesofproposedsociety') }}"
                                                                    value="{{ $membersObjectives->society_objective ?? '' }}" />
                                                                <span class="error" id="society_objective_err"></span>
                                                            </div>
                                                        </div>
                                                    </fieldset>

                                                    <!-- Number and Value of Shares -->
                                                    <fieldset class="border p-3 mb-3">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.numberandvalueofsharestobeissuedasperprovisions') }}:</label>
                                                                <input class="form-control form-control-sm"
                                                                    id="society_share_value" type="number"
                                                                    placeholder="{{ __('messages.entersocietyshare') }}"
                                                                    name="society_share_value"
                                                                    value="{{ $membersObjectives->society_share_value ?? '' }}"
                                                                    step="0.01" min="0"
                                                                    oninput="validateDecimal(this)" />
                                                                <span class="error" id="society_share_value_err"></span>
                                                            </div>
                                                        </div>
                                                    </fieldset>

                                                    <!-- Subscription Rate -->
                                                    <fieldset class="border p-3 mb-3">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.valueandrateofeachshareforsubscriptionpayment') }}
                                                                </label>
                                                                <span class="text-danger">*</span>
                                                                <input class="form-control form-control-sm"
                                                                    id="subscription_rate" type="number"
                                                                    name="subscription_rate"
                                                                    value="{{ $membersObjectives->subscription_rate ?? '' }}"
                                                                    step="0.01" min="0"
                                                                    oninput="validateDecimal(this)"
                                                                    onkeyup="validateData(this,'subscription_rate')" />
                                                                <span class="error" id="subscription_rate_err"></span>
                                                            </div>
                                                        </div>
                                                    </fieldset>

                                                    <!-- Member Liabilities -->
                                                    <fieldset class="border p-3 mb-3">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.liabilitiesofmembers') }}
                                                                </label>
                                                                <span class="text-danger">*</span>
                                                                <input class="form-control form-control-sm" type="text"
                                                                    id="member_liability" name="member_liability"
                                                                    value="{{ $membersObjectives->member_liability ?? '' }}"
                                                                    onkeyup="validateData(this,'member_liability')" />
                                                                <span class="error" id="member_liability_err"></span>
                                                            </div>
                                                        </div>
                                                    </fieldset>

                                                    <!-- General Member Count -->
                                                    <fieldset class="border p-3 mb-3">
                                                        <div class="row">
                                                            <div class="col-md-12 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.numberofindividualswhohaveagreedtobecomegeneralmembersoftheproposedsociety') }}
                                                                </label>
                                                                <span class="text-danger">*</span>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <input class="form-control form-control-sm"
                                                                    id="general_member_count" type="number"
                                                                    name="general_member_count"
                                                                    value="{{ $membersObjectives->general_member_count ?? '' }}"
                                                                    step="0.01" min="0"
                                                                    oninput="validateDecimal(this)"
                                                                    onkeyup="validateData(this,'general_member_count')" />
                                                                <span class="error" id="general_member_count_err"></span>
                                                            </div>
                                                        </div>
                                                    </fieldset>

                                                    <!-- Record Language -->
                                                    <fieldset class="border p-3 mb-3">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.languageinwhichtheproposedsocietyrecordswillbemaintained') }}
                                                                </label>
                                                                <span class="text-danger">*</span>
                                                                <select class="form-select form-control"
                                                                    onchange="validateData(this,'society_record_language')"
                                                                    id="society_record_language"
                                                                    name="society_record_language">
                                                                    <option value="">
                                                                        {{ __('messages.selectlanguage') }}
                                                                    </option>
                                                                    <option value="1"
                                                                        {{ isset($membersObjectives) && $membersObjectives->society_record_language == 1 ? 'selected' : '' }}>
                                                                        English</option>
                                                                    <option value="2"
                                                                        {{ isset($membersObjectives) && $membersObjectives->society_record_language == 2 ? 'selected' : '' }}>
                                                                        Hindi</option>
                                                                    <option value="3"
                                                                        {{ isset($membersObjectives) && $membersObjectives->society_record_language == 3 ? 'selected' : '' }}>
                                                                        Both</option>
                                                                </select>
                                                                <span class="error"
                                                                    id="society_record_language_err"></span>
                                                            </div>
                                                        </div>
                                                    </fieldset>

                                                    <!-- Representative and Secretary -->
                                                    <label
                                                        class="col-form-label fw-bold">{{ __('messages.fullnameandaddressandsignature') }}
                                                    </label>
                                                    <fieldset class="border p-3 mb-3">
                                                        <div class="row">
                                                            <div class="col-md-12 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.ProposedMainRepresentativeFirstSignature') }}
                                                                </label>
                                                                <span class="text-danger">*</span>
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <input type="text"
                                                                            id="society_representative_name"
                                                                            class="form-control form-control-sm"
                                                                            name="society_representative_name"
                                                                            onkeyup="validateData(this,'society_representative_name')"
                                                                            placeholder="{{ __('messages.representativename') }}"
                                                                            value="{{ $membersObjectives->society_representative_name ?? '' }}" />
                                                                        <span class="error"
                                                                            id="society_representative_name_err"></span>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <input type="text"
                                                                            id="society_representative_address"
                                                                            class="form-control form-control-sm"
                                                                            placeholder="{{ __('messages.representativeaddress') }}"
                                                                            name="society_representative_address"
                                                                            value="{{ $membersObjectives->society_representative_address ?? '' }}"
                                                                            onkeyup="validateData(this,'society_representative_address')" />
                                                                        <span class="error"
                                                                            id="society_representative_address_err"></span>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <input type="file"
                                                                            id="society_representative_signature"
                                                                            class="form-control form-control-sm"
                                                                            accept="image/*,application/pdf"
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
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.proposedsocietysecretary') }}
                                                                    :</label>
                                                                <span class="text-danger">*</span>
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <input type="text" id="society_secretary_name"
                                                                            class="form-control form-control-sm"
                                                                            placeholder="{{ __('messages.secretaryname') }}"
                                                                            name="society_secretary_name"
                                                                            value="{{ $membersObjectives->society_secretary_name ?? '' }}"
                                                                            onkeyup="validateData(this,'society_secretary_name')" />
                                                                        <span class="error"
                                                                            id="society_secretary_name_err"></span>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <input type="text"
                                                                            id="society_secretary_address"
                                                                            class="form-control form-control-sm"
                                                                            placeholder="{{ __('messages.secretaryaddress') }}"
                                                                            name="society_secretary_address"
                                                                            value="{{ $membersObjectives->society_secretary_address ?? '' }}"
                                                                            onkeyup="validateData(this,'society_secretary_address')" />
                                                                        <span class="error"
                                                                            id="society_secretary_address_err"></span>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <input type="file"
                                                                            id="society_secretary_signature"
                                                                            class="form-control form-control-sm"
                                                                            accept="image/*,application/pdf"
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
                                                <form id="step_form3" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="mb-3 row">
                                                        <label
                                                            class="col-md-12 col-form-label fw-bold">{{ __('messages.OrderoftheRegistrar') }}</label>
                                                    </div>
                                                    <div class="row mb-3 form-group">
                                                        <input type="hidden" id="step3" name="step"
                                                            value="3" />
                                                        <input class="form-control form-control-sm"
                                                            id="member_declarationId" name="member_declarationId"
                                                            type="hidden" value="{{ @$members_data[0]->id ?? '' }}" />
                                                        <label
                                                            class="form-label fw-bold">{{ __('messages.listofmembers') }}</label>

                                                        <div id="more_member">
                                                            @if (@$members_data[0]->id && isset($members_data[0]->members) && !empty($members_data[0]->members))
                                                                @foreach ($members_data[0]->members as $index => $member)
                                                                    <div class="row additionalMember mt-3 member-row"
                                                                        data-row-number="{{ $index + 1 }}">
                                                                        <button class="formremoveBtn"
                                                                            onclick="confirmRemoveMember({{ $index + 1 }}, {{ $member['id'] ?? 'null' }})">
                                                                            <i class="uil-times"></i>
                                                                        </button>
                                                                        <div class="member-note"
                                                                            style="margin-bottom:5px;">
                                                                            {{ __('messages.listofmembersnote') }}</div>
                                                                        <div class="member-header">
                                                                            <span class="member-number">Member
                                                                                #{{ $index + 1 }}</span>

                                                                        </div>
                                                                        <input type="hidden"
                                                                            id="member_id{{ $index }}"
                                                                            name="member_id[]"
                                                                            value="{{ $member['id'] }}" />

                                                                        <!-- Name -->
                                                                        <div class="col-md-3">
                                                                            <fieldset class="border p-0 mb-2">
                                                                                <div class="row">
                                                                                    <div class="col-md-12 mb-1">
                                                                                        <label
                                                                                            class="form-label fw-bold">{{ __('messages.name') }}<span
                                                                                                class="text-danger">*</span></label>
                                                                                        <input type="text"
                                                                                            class="form-control form-control-sm"
                                                                                            name="name[]"
                                                                                            placeholder="{{ __('messages.membername') }}"
                                                                                            value="{{ $member['name'] }}"
                                                                                            onkeyup="validateData(this,'name{{ $index }}')" />
                                                                                        <span
                                                                                            id="name{{ $index }}"
                                                                                            class="error error-name"></span>
                                                                                    </div>
                                                                                </div>
                                                                            </fieldset>
                                                                        </div>

                                                                        {{-- contact no --}}
                                                                        <div class="col-md-3">
                                                                            <fieldset class="border p-0 mb-2">
                                                                                <div class="row">
                                                                                    <div class="col-md-12 mb-1">
                                                                                        <label
                                                                                            class="form-label fw-bold">{{ __('messages.ContactNumber') }}<span
                                                                                                class="text-danger">*</span></label>
                                                                                        <input type="number"
                                                                                            class="form-control form-control-sm"
                                                                                            name="contact_no[]"
                                                                                            placeholder="{{ __('messages.ContactNumber') }}"
                                                                                            value="{{ $member['contact_no'] }}"
                                                                                            onkeyup="validateData(this,'contact_no{{ $index }}')" />
                                                                                        <span
                                                                                            id="contact_no{{ $index }}"
                                                                                            class="error error-contact_no"></span>
                                                                                    </div>
                                                                                </div>
                                                                            </fieldset>
                                                                        </div>

                                                                        <!-- Address -->
                                                                        <div class="col-md-3">
                                                                            <fieldset class="border p-0 mb-2">
                                                                                <div class="row">
                                                                                    <div class="col-md-12 mb-1">
                                                                                        <label
                                                                                            class="form-label fw-bold">{{ __('messages.fulladdress') }}<span
                                                                                                class="text-danger">*</span></label>
                                                                                        <input type="text"
                                                                                            onkeyup="validateData(this,'address{{ $index }}')"
                                                                                            class="form-control form-control-sm"
                                                                                            name="address[]"
                                                                                            placeholder="{{ __('messages.memberaddress') }}"
                                                                                            value="{{ $member['address'] }}" />
                                                                                        <span
                                                                                            id="address{{ $index }}"
                                                                                            class="error error-address"></span>
                                                                                    </div>
                                                                                </div>
                                                                            </fieldset>
                                                                        </div>

                                                                        <!-- Gender -->
                                                                        <div class="col-md-3">
                                                                            <fieldset class="border p-0 mb-2">
                                                                                <div class="row">
                                                                                    <div class="col-md-12 mb-1">
                                                                                        <label
                                                                                            class="form-label fw-bold">{{ __('messages.gender') }}<span
                                                                                                class="text-danger">*</span></label>
                                                                                        <select
                                                                                            onchange="validateData(this,'gender{{ $index }}')"
                                                                                            class="form-select form-control"
                                                                                            name="gender[]">
                                                                                            <option value="">
                                                                                                {{ __('messages.select') }}
                                                                                            </option>
                                                                                            <option value="1"
                                                                                                {{ $member['gender'] == 1 ? 'selected' : '' }}>
                                                                                                {{ __('messages.male') }}
                                                                                            </option>
                                                                                            <option value="2"
                                                                                                {{ $member['gender'] == 2 ? 'selected' : '' }}>
                                                                                                {{ __('messages.female') }}
                                                                                            </option>
                                                                                            <option value="3"
                                                                                                {{ $member['gender'] == 3 ? 'selected' : '' }}>
                                                                                                {{ __('messages.transgender') }}
                                                                                            </option>
                                                                                        </select>
                                                                                        <span
                                                                                            id="gender{{ $index }}"
                                                                                            class="error error-gender"></span>
                                                                                    </div>
                                                                                </div>
                                                                            </fieldset>
                                                                        </div>

                                                                        <!-- Membership Form -->
                                                                        <div class="col-md-3">
                                                                            <fieldset class="border p-0 mb-2">
                                                                                <div class="row">
                                                                                    <div class="col-md-12 mb-1">
                                                                                        <label
                                                                                            class="form-label fw-bold">{{ __('messages.MembershipForm') }}<span
                                                                                                class="text-danger">*</span></label>
                                                                                        <a href="javascript:void(0);"
                                                                                            class="btn btn-sm btn-success"
                                                                                            onclick="window.open('{{ asset('demo-files/New_Application_Format.pdf') }}', '_blank');">
                                                                                            Download Form
                                                                                        </a>
                                                                                        <div class="input-group">
                                                                                            <input type="file"
                                                                                                class="form-control form-control-sm"
                                                                                                name="membership_form[]"
                                                                                                accept="image/*,application/pdf"
                                                                                                required
                                                                                                onchange="validateData(this,'membership_form{{ $index }}')" />
                                                                                        </div>
                                                                                        @if (!empty($member['membership_form']))
                                                                                            <div class="mt-2">
                                                                                                <a href="javascript:void(0);"
                                                                                                    onclick="viewAttachment('{{ asset('storage/' . $member['membership_form']) }}')">View</a>
                                                                                            </div>
                                                                                        @endif
                                                                                        <span
                                                                                            id="membership_form{{ $index }}"
                                                                                            class="error error-membership_form"></span>
                                                                                    </div>
                                                                                </div>
                                                                            </fieldset>
                                                                        </div>

                                                                        <!-- Marital Status -->
                                                                        <div class="col-md-3">
                                                                            <fieldset class="border p-0 mb-2">
                                                                                <div class="row">
                                                                                    <div class="col-md-12 mb-1">
                                                                                        <label
                                                                                            class="form-label fw-bold">{{ __('messages.ismarried') }}<span
                                                                                                class="text-danger">*</span></label>
                                                                                        <select
                                                                                            onchange="validateData(this,'is_married{{ $index }}')"
                                                                                            class="form-select form-control"
                                                                                            name="is_married[]">
                                                                                            <option value="">
                                                                                                {{ __('messages.select') }}
                                                                                            </option>
                                                                                            <option value="1"
                                                                                                {{ $member['is_married'] == 1 ? 'selected' : '' }}>
                                                                                                {{ __('messages.yes') }}
                                                                                            </option>
                                                                                            <option value="2"
                                                                                                {{ $member['is_married'] == 2 ? 'selected' : '' }}>
                                                                                                {{ __('messages.no') }}
                                                                                            </option>
                                                                                        </select>
                                                                                        <span
                                                                                            id="is_married{{ $index }}"
                                                                                            class="error error-is_married"></span>
                                                                                    </div>
                                                                                </div>
                                                                            </fieldset>
                                                                        </div>

                                                                        <!-- Father/Spouse Name -->
                                                                        <div class="col-md-3">
                                                                            <fieldset class="border p-0 mb-2">
                                                                                <div class="row">
                                                                                    <div class="col-md-12 mb-1">
                                                                                        <label
                                                                                            class="form-label fw-bold">{{ __('messages.FatherName') }}<span
                                                                                                class="text-danger">*</span></label>
                                                                                        <input type="text"
                                                                                            onkeyup="validateData(this,'father_spouse_name{{ $index }}')"
                                                                                            class="form-control form-control-sm"
                                                                                            name="father_spouse_name[]"
                                                                                            placeholder="{{ __('messages.FatherName') }}"
                                                                                            value="{{ $member['father_spouse_name'] }}" />
                                                                                        <span
                                                                                            id="father_spouse_name{{ $index }}"
                                                                                            class="error error-father_spouse_name"></span>
                                                                                    </div>
                                                                                </div>
                                                                            </fieldset>
                                                                        </div>

                                                                        <!-- Designation -->
                                                                        <div class="col-md-3">
                                                                            <fieldset class="border p-0 mb-2">
                                                                                <div class="row">
                                                                                    <div class="col-md-12 mb-1">
                                                                                        <label
                                                                                            class="form-label fw-bold">{{ __('messages.designation') }}<span
                                                                                                class="text-danger">*</span></label>
                                                                                        <select
                                                                                            onchange="validateData(this,'designation{{ $index }}')"
                                                                                            class="form-select form-control"
                                                                                            name="designation[]" required>
                                                                                            <option value="">
                                                                                                {{ __('messages.select') }}
                                                                                            </option>
                                                                                            <option value="Chairman"
                                                                                                {{ isset($member['designation']) && $member['designation'] == 'Chairman' ? 'selected' : '' }}>
                                                                                                Chairman
                                                                                            </option>
                                                                                            <option value="Vice Chairman"
                                                                                                {{ isset($member['designation']) && $member['designation'] == 'Vice Chairman' ? 'selected' : '' }}>
                                                                                                Vice Chairman
                                                                                            </option>
                                                                                            <option value="Secretary"
                                                                                                {{ isset($member['designation']) && $member['designation'] == 'Secretary' ? 'selected' : '' }}>
                                                                                                Secretary
                                                                                            </option>
                                                                                            <option value="Board Member"
                                                                                                {{ isset($member['designation']) && $member['designation'] == 'Board Member' ? 'selected' : '' }}>
                                                                                                Board Member
                                                                                            </option>
                                                                                        </select>
                                                                                        <span
                                                                                            id="designation{{ $index }}"
                                                                                            class="error error-designation"></span>
                                                                                    </div>
                                                                                </div>
                                                                            </fieldset>
                                                                        </div>

                                                                        <!-- Business -->
                                                                        <div class="col-md-3">
                                                                            <fieldset class="border p-0 mb-2">
                                                                                <div class="row">
                                                                                    <div class="col-md-12 mb-1">
                                                                                        <label
                                                                                            class="form-label fw-bold">{{ __('messages.buisness') }}<small
                                                                                                class="text-muted">(optional)</small></label>
                                                                                        <input type="text"
                                                                                            class="form-control form-control-sm"
                                                                                            name="buisness_name[]"
                                                                                            placeholder="{{ __('messages.buisnessname') }}"
                                                                                            value="{{ $member['buisness_name'] }}" />
                                                                                        <span
                                                                                            id="buisness_name{{ $index }}"
                                                                                            class="error error-buisness_name"></span>
                                                                                    </div>
                                                                                </div>
                                                                            </fieldset>
                                                                        </div>

                                                                        <!-- Aadhaar No -->
                                                                        <div class="col-md-3">
                                                                            <fieldset class="border p-0 mb-2">
                                                                                <div class="row">
                                                                                    <div class="col-md-12 mb-1">
                                                                                        <label
                                                                                            class="form-label fw-bold">{{ __('messages.AadhaarUpload') }}<span
                                                                                                class="text-danger">*</span></label>
                                                                                        <input type="file"
                                                                                            class="form-control form-control-sm"
                                                                                            name="aadhar_no[]"
                                                                                            accept="image/*,application/pdf"
                                                                                            required
                                                                                            onchange="validateData(this,'aadhar_no{{ $index }}')" />
                                                                                        @if (!empty($member['aadhar_no']))
                                                                                            <div class="mt-2">
                                                                                                <a href="javascript:void(0);"
                                                                                                    onclick="viewAttachment('{{ asset('storage/' . $member['aadhar_no']) }}')">View</a>
                                                                                            </div>
                                                                                        @endif
                                                                                        <span
                                                                                            id="aadhar_no{{ $index }}"
                                                                                            class="error error-aadhar_no"></span>
                                                                                    </div>
                                                                                </div>
                                                                            </fieldset>
                                                                        </div>

                                                                        <!-- Signature -->
                                                                        <div class="col-md-3">
                                                                            <fieldset class="border p-0 mb-2">
                                                                                <div class="row">
                                                                                    <div class="col-md-12 mb-1">
                                                                                        <label
                                                                                            class="form-label fw-bold">{{ __('messages.signature') }}<span
                                                                                                class="text-danger">*</span></label>
                                                                                        <input type="file"
                                                                                            onchange="validateData(this,'signature{{ $index }}')"
                                                                                            class="form-control form-control-sm"
                                                                                            name="signature[]"
                                                                                            accept="image/*,application/pdf" />
                                                                                        @if (!empty($member['signature']))
                                                                                            <div class="mt-2">
                                                                                                <a href="javascript:void(0);"
                                                                                                    onclick="viewAttachment('{{ asset('storage/' . $member['signature']) }}')">View</a>
                                                                                            </div>
                                                                                        @endif
                                                                                        <span
                                                                                            id="signature{{ $index }}"
                                                                                            class="error error-signature"></span>
                                                                                    </div>
                                                                                </div>
                                                                            </fieldset>
                                                                        </div>

                                                                        <!-- Declaration 1 -->
                                                                        <div class="col-md-3">
                                                                            <fieldset class="border p-0 mb-2">
                                                                                <div class="row">
                                                                                    <div class="col-md-12 mb-1">
                                                                                        <label
                                                                                            class="form-label fw-bold">Declaration
                                                                                            1<span
                                                                                                class="text-danger">*</span></label>
                                                                                        <a href="javascript:void(0);"
                                                                                            class="btn btn-sm btn-success mt-1"
                                                                                            onclick="window.open('{{ asset('demo-files/Declaration_1.pdf') }}', '_blank');">
                                                                                            Download Declaration
                                                                                        </a>
                                                                                        <input type="file"
                                                                                            class="form-control form-control-sm"
                                                                                            name="declaration1[]"
                                                                                            accept="image/*,application/pdf"
                                                                                            required
                                                                                            onchange="validateData(this,'declaration1{{ $index }}')" />
                                                                                        @if (!empty($member['declaration1']))
                                                                                            <div class="mt-2">
                                                                                                <a href="javascript:void(0);"
                                                                                                    onclick="viewAttachment('{{ asset('storage/' . $member['declaration1']) }}')">View</a>
                                                                                            </div>
                                                                                        @endif

                                                                                        <span
                                                                                            id="declaration1{{ $index }}"
                                                                                            class="error error-declaration1"></span>
                                                                                    </div>
                                                                                </div>
                                                                            </fieldset>
                                                                        </div>

                                                                        <!-- Declaration 2 -->
                                                                        <div class="col-md-3">
                                                                            <fieldset class="border p-0 mb-2">
                                                                                <div class="row">
                                                                                    <div class="col-md-12 mb-1">
                                                                                        <label
                                                                                            class="form-label fw-bold">Declaration2<span
                                                                                                class="text-danger">*</span></label>&nbsp;<a
                                                                                            href="javascript:void(0);"
                                                                                            class="btn btn-sm btn-success mt-1"
                                                                                            onclick="window.open('{{ asset('demo-files/Declaration_2.pdf') }}', '_blank');">
                                                                                            Download Declaration
                                                                                        </a>
                                                                                        <input type="file"
                                                                                            class="form-control form-control-sm"
                                                                                            name="declaration2[]"
                                                                                            accept="image/*,application/pdf"
                                                                                            required
                                                                                            onchange="validateData(this,'declaration2{{ $index }}')" />
                                                                                        @if (!empty($member['declaration2']))
                                                                                            <div class="mt-2">
                                                                                                <a href="javascript:void(0);"
                                                                                                    onclick="viewAttachment('{{ asset('storage/' . $member['declaration2']) }}')">View</a>
                                                                                            </div>
                                                                                        @endif

                                                                                        <span
                                                                                            id="declaration2{{ $index }}"
                                                                                            class="error error-declaration2"></span>
                                                                                    </div>
                                                                                </div>
                                                                            </fieldset>
                                                                        </div>



                                                                        <!-- Save button for this member -->
                                                                        <div class="col-md-12 mt-3">
                                                                            <button type="button"
                                                                                class="btn btn-primary save-member-btn"
                                                                                onclick="saveMember(this, {{ $member['id'] ?? 'null' }})">Save
                                                                                Member</button>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            @else
                                                                <!-- Default single member form -->
                                                                <div class="row additionalMember mt-3 member-row"
                                                                    data-row-number="1">
                                                                    <div class="member-note" style="margin-bottom:5px;">
                                                                            {{ __('messages.listofmembersnote') }}</div>
                                                                    <div class="member-header">
                                                                        <span class="member-number">Member #1</span>
                                                                    </div>
                                                                        
                                                                    <input type="hidden" id="member_id0" name="member_id[]"
                                                                        value="" />

                                                                    <!-- Name -->
                                                                    <div class="col-md-3">
                                                                        <fieldset class="border p-2 mb-2">
                                                                            <div class="row">
                                                                                <div class="col-md-12 mb-1">
                                                                                    <label
                                                                                        class="form-label fw-bold">{{ __('messages.name') }}<span
                                                                                            class="text-danger">*</span></label>
                                                                                    <input type="text"
                                                                                        class="form-control form-control-sm"
                                                                                        name="name[]"
                                                                                        placeholder="{{ __('messages.membername') }}"
                                                                                        value=""
                                                                                        onkeyup="validateData(this,'name0')" />
                                                                                    <span id="name0"
                                                                                        class="error error-name"></span>
                                                                                </div>
                                                                            </div>
                                                                        </fieldset>
                                                                    </div>

                                                                    {{-- contact no --}}
                                                                    <div class="col-md-3">
                                                                        <fieldset class="border p-2 mb-2">
                                                                            <div class="row">
                                                                                <div class="col-md-12 mb-1">
                                                                                    <label
                                                                                        class="form-label fw-bold">{{ __('messages.ContactNumber') }}<span
                                                                                            class="text-danger">*</span></label>
                                                                                    <input type="number"
                                                                                        class="form-control form-control-sm"
                                                                                        name="contact_no[]"
                                                                                        placeholder="{{ __('messages.ContactNumber') }}"
                                                                                        value=""
                                                                                        onkeyup="validateData(this,'contact_no0')" />
                                                                                    <span id="contact_no0"
                                                                                        class="error error-contact_no"></span>
                                                                                </div>
                                                                            </div>
                                                                        </fieldset>
                                                                    </div>

                                                                    <!-- Address -->
                                                                    <div class="col-md-3">
                                                                        <fieldset class="border p-2 mb-2">
                                                                            <div class="row">
                                                                                <div class="col-md-12 mb-1">
                                                                                    <label
                                                                                        class="form-label fw-bold">{{ __('messages.fulladdress') }}<span
                                                                                            class="text-danger">*</span></label>
                                                                                    <input type="text"
                                                                                        onkeyup="validateData(this,'address0')"
                                                                                        class="form-control form-control-sm"
                                                                                        name="address[]"
                                                                                        placeholder="{{ __('messages.memberaddress') }}"
                                                                                        value="" />
                                                                                    <span id="address0"
                                                                                        class="error error-address"></span>
                                                                                </div>
                                                                            </div>
                                                                        </fieldset>
                                                                    </div>

                                                                    <!-- Gender -->
                                                                    <div class="col-md-3">
                                                                        <fieldset class="border p-2 mb-2">
                                                                            <div class="row">
                                                                                <div class="col-md-12 mb-1">
                                                                                    <label
                                                                                        class="form-label fw-bold">{{ __('messages.gender') }}<span
                                                                                            class="text-danger">*</span></label>
                                                                                    <select
                                                                                        onchange="validateData(this,'gender0')"
                                                                                        class="form-select form-control"
                                                                                        name="gender[]">
                                                                                        <option value="">
                                                                                            {{ __('messages.select') }}
                                                                                        </option>
                                                                                        <option value="1">
                                                                                            {{ __('messages.male') }}
                                                                                        </option>
                                                                                        <option value="2">
                                                                                            {{ __('messages.female') }}
                                                                                        </option>
                                                                                        <option value="3">
                                                                                            {{ __('messages.transgender') }}
                                                                                        </option>
                                                                                    </select>
                                                                                    <span id="gender0"
                                                                                        class="error error-gender"></span>
                                                                                </div>
                                                                            </div>
                                                                        </fieldset>
                                                                    </div>

                                                                    <!-- Membership Form -->
                                                                    <div class="col-md-3">
                                                                        <fieldset class="border p-2 mb-2">
                                                                            <div class="row">
                                                                                <div class="col-md-12 mb-1">
                                                                                    <label
                                                                                        class="form-label fw-bold">{{ __('messages.MembershipForm') }}<span
                                                                                            class="text-danger">*</span></label>&nbsp;
                                                                                    <a href="javascript:void(0);"
                                                                                        class="btn btn-sm btn-success"
                                                                                        onclick="window.open('{{ asset('demo-files/New_Application_Format.pdf') }}', '_blank');">
                                                                                        Download Form
                                                                                    </a>
                                                                                    <div class="input-group">
                                                                                        <input type="file"
                                                                                            class="form-control form-control-sm"
                                                                                            name="membership_form[]"
                                                                                            accept="image/*,application/pdf"
                                                                                            required
                                                                                            onchange="validateData(this,'membership_form0')" />
                                                                                    </div>
                                                                                    <span id="membership_form0"
                                                                                        class="error error-membership_form"></span>
                                                                                </div>
                                                                            </div>
                                                                        </fieldset>
                                                                    </div>

                                                                    <!-- Marital Status -->
                                                                    <div class="col-md-3">
                                                                        <fieldset class="border p-2 mb-2">
                                                                            <div class="row">
                                                                                <div class="col-md-12 mb-1">
                                                                                    <label
                                                                                        class="form-label fw-bold">{{ __('messages.ismarried') }}<span
                                                                                            class="text-danger">*</span></label>
                                                                                    <select
                                                                                        onchange="validateData(this,'is_married0')"
                                                                                        class="form-select form-control"
                                                                                        name="is_married[]">
                                                                                        <option value="">
                                                                                            {{ __('messages.select') }}
                                                                                        </option>
                                                                                        <option value="1">
                                                                                            {{ __('messages.yes') }}
                                                                                        </option>
                                                                                        <option value="2">
                                                                                            {{ __('messages.no') }}
                                                                                        </option>
                                                                                    </select>
                                                                                    <span id="is_married0"
                                                                                        class="error error-is_married"></span>
                                                                                </div>
                                                                            </div>
                                                                        </fieldset>
                                                                    </div>

                                                                    <!-- Father/Spouse Name -->
                                                                    <div class="col-md-3">
                                                                        <fieldset class="border p-2 mb-2">
                                                                            <div class="row">
                                                                                <div class="col-md-12 mb-1">
                                                                                    <label
                                                                                        class="form-label fw-bold">{{ __('messages.FatherName') }}<span
                                                                                            class="text-danger">*</span></label>
                                                                                    <input type="text"
                                                                                        onkeyup="validateData(this,'father_spouse_name0')"
                                                                                        class="form-control form-control-sm"
                                                                                        name="father_spouse_name[]"
                                                                                        placeholder="{{ __('messages.FatherName') }}"
                                                                                        value="" />
                                                                                    <span id="father_spouse_name0"
                                                                                        class="error error-father_spouse_name"></span>
                                                                                </div>
                                                                            </div>
                                                                        </fieldset>
                                                                    </div>

                                                                    <!-- Designation -->
                                                                    <div class="col-md-3">
                                                                        <fieldset class="border p-2 mb-2">
                                                                            <div class="row">
                                                                                <div class="col-md-12 mb-1">
                                                                                    <label
                                                                                        class="form-label fw-bold">{{ __('messages.designation') }}<span
                                                                                            class="text-danger">*</span></label>
                                                                                    <select
                                                                                        onchange="validateData(this,'designation0')"
                                                                                        class="form-select form-control"
                                                                                        name="designation[]" required>
                                                                                        <option value="">
                                                                                            {{ __('messages.select') }}
                                                                                        </option>
                                                                                        <option value="Chairman">Chairman
                                                                                        </option>
                                                                                        <option value="Vice Chairman">Vice
                                                                                            Chairman</option>
                                                                                        <option value="Secretary">Secretary
                                                                                        </option>
                                                                                        <option value="Board Member">Board
                                                                                            Member</option>
                                                                                    </select>
                                                                                    <span id="designation0"
                                                                                        class="error error-designation"></span>
                                                                                </div>
                                                                            </div>
                                                                        </fieldset>
                                                                    </div>

                                                                    <!-- Business -->
                                                                    <div class="col-md-3">
                                                                        <fieldset class="border p-2 mb-2">
                                                                            <div class="row">
                                                                                <div class="col-md-12 mb-1">
                                                                                    <label
                                                                                        class="form-label fw-bold">{{ __('messages.buisness') }}<small
                                                                                            class="text-muted">(optional)</small></label>
                                                                                    <input type="text"
                                                                                        class="form-control form-control-sm"
                                                                                        name="buisness_name[]"
                                                                                        placeholder="{{ __('messages.buisnessname') }}"
                                                                                        value="" />
                                                                                    <span id="buisness_name0"
                                                                                        class="error error-buisness_name"></span>
                                                                                </div>
                                                                            </div>
                                                                        </fieldset>
                                                                    </div>

                                                                    <!-- Aadhaar No -->
                                                                    <div class="col-md-3">
                                                                        <fieldset class="border p-2 mb-2">
                                                                            <div class="row">
                                                                                <div class="col-md-12 mb-1">
                                                                                    <label
                                                                                        class="form-label fw-bold">{{ __('messages.AadhaarUpload') }}<span
                                                                                            class="text-danger">*</span></label>
                                                                                    <input type="file"
                                                                                        class="form-control form-control-sm"
                                                                                        name="aadhar_no[]"
                                                                                        accept="image/*,application/pdf"
                                                                                        required
                                                                                        onchange="validateData(this,'aadhar_no0')" />
                                                                                    <span id="aadhar_no0"
                                                                                        class="error error-aadhar_no"></span>
                                                                                </div>
                                                                            </div>
                                                                        </fieldset>
                                                                    </div>

                                                                    <!-- Signature -->
                                                                    <div class="col-md-3">
                                                                        <fieldset class="border p-2 mb-2">
                                                                            <div class="row">
                                                                                <div class="col-md-12 mb-1">
                                                                                    <label
                                                                                        class="form-label fw-bold">{{ __('messages.signature') }}<span
                                                                                            class="text-danger">*</span></label>
                                                                                    <input type="file"
                                                                                        onchange="validateData(this,'signature0')"
                                                                                        class="form-control form-control-sm"
                                                                                        name="signature[]"
                                                                                        accept="image/*,application/pdf" />
                                                                                    <span id="signature0"
                                                                                        class="error error-signature"></span>
                                                                                </div>
                                                                            </div>
                                                                        </fieldset>
                                                                    </div>

                                                                    <!-- Declaration 1 -->
                                                                    <div class="col-md-3">
                                                                        <fieldset class="border p-2 mb-2">
                                                                            <div class="row">
                                                                                <div class="col-md-12 mb-1">
                                                                                    <label
                                                                                        class="form-label fw-bold">Declaration
                                                                                        1<span
                                                                                            class="text-danger">*</span></label>&nbsp;
                                                                                    <a href="javascript:void(0);"
                                                                                        class="btn btn-sm btn-success mt-1"
                                                                                        onclick="window.open('{{ asset('demo-files/Declaration_1.pdf') }}', '_blank');">
                                                                                        Download Declaration
                                                                                    </a>
                                                                                    <input type="file"
                                                                                        class="form-control form-control-sm"
                                                                                        name="declaration1[]"
                                                                                        accept="image/*,application/pdf"
                                                                                        required
                                                                                        onchange="validateData(this,'declaration10')" />
                                                                                    <span id="declaration10"
                                                                                        class="error error-declaration1"></span>
                                                                                </div>
                                                                            </div>
                                                                        </fieldset>
                                                                    </div>

                                                                    <!-- Declaration 2 -->
                                                                    <div class="col-md-3">
                                                                        <fieldset class="border p-2 mb-2">
                                                                            <div class="row">
                                                                                <div class="col-md-12 mb-1">
                                                                                    <label
                                                                                        class="form-label fw-bold">Declaration
                                                                                        2<span
                                                                                            class="text-danger">*</span></label>&nbsp;
                                                                                    <a href="javascript:void(0);"
                                                                                        class="btn btn-sm btn-success mt-1"
                                                                                        onclick="window.open('{{ asset('demo-files/Declaration_2.pdf') }}', '_blank');">
                                                                                        Download Declaration
                                                                                    </a>
                                                                                    <input type="file"
                                                                                        class="form-control form-control-sm"
                                                                                        name="declaration2[]"
                                                                                        accept="image/*,application/pdf"
                                                                                        required
                                                                                        onchange="validateData(this,'declaration20')" />
                                                                                    <span id="declaration20"
                                                                                        class="error error-declaration2"></span>
                                                                                </div>
                                                                            </div>
                                                                        </fieldset>
                                                                    </div>

                                                                    <!-- Save button for this member -->
                                                                    <div class="col-md-12 mt-3">
                                                                        <button type="button"
                                                                            class="btn btn-primary save-member-btn"
                                                                            onclick="saveMember(this, null)">Save
                                                                            Member</button>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>

                                                        <button type="button" class="btn btn-primary" id="addMemberBtn"
                                                            onclick="addMoreMember()">+ Add Member</button>

                                                        <!-- Confirmation Modal -->
                                                        {{-- <div class="modal fade" id="removeMemberModal" tabindex="-1"
                                                            role="dialog" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Confirm Removal</h5>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">×</span>
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
                                                        </div> --}}
                                                    </div>

                                                    <!-- Declaration Checkbox -->
                                                    <fieldset class="border p-3 mb-3">
                                                        <div class="row">
                                                            <div class="col-md-12 mb-3">
                                                                <div>
                                                                    <input type="checkbox" name="is_declared"
                                                                        checked={{ @$members_data[0]->is_declared ? 'checked' : '' }}
                                                                        onkeyup="validateData(this,'is_declared')" />

                                                                    <label
                                                                        class="form-label fw-bold">{{ __('messages.DeclarationforRegistration') }}</label>
                                                                </div>
                                                                <span class="error" id="is_declared_err"></span>
                                                                <p>{{ __('messages.We') }}</p>
                                                            </div>
                                                        </div>
                                                    </fieldset>

                                                    <div class="d-flex justify-content-between">
                                                        <button class="btn btn-secondary" type="button"
                                                            style="width: 12%;"
                                                            onclick="showPreviousStep(2)">{{ __('messages.back') }}</button>
                                                        <button class="btn btn-primary" type="button" id="submit_btn3"
                                                            onclick="validateAndSubmitAllMembers()">{{ __('messages.save&submit') }}</button>
                                                    </div>
                                                </form>
                                            </div>

                                            <!-- Step 4 -->
                                            <div class="tab-pane" id="step4" role="tabpanel">
                                                <form id="step_form4">
                                                    @csrf
                                                    <input type="hidden" id="step4" value="4"
                                                        name="step" />
                                                    <input type="hidden" value="{{ $feasibilityReports->id ?? '' }}"
                                                        id="feasibility_reportId" name="feasibility_reportId" />
                                                    <h6 class="fw-bold">
                                                        {{ __('messages.FeasibilityReportforRegistration') }}
                                                    </h6>

                                                    <!-- Society Name -->
                                                    <fieldset class="border p-3 mb-3">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.societyname') }}
                                                                    :</label>
                                                                <span class="text-danger">*</span>
                                                                <input class="form-control form-control-sm" type="text"
                                                                    placeholder="{{ __('messages.EnterSocietyName') }}"
                                                                    id="fsociety_name" name="society_name"
                                                                    value="{{ $feasibilityReports->society_name ?? '' }}"
                                                                    onkeyup="validateData(this,'fsociety_name')" />
                                                                <span id="fsociety_name_err" class="error"></span>
                                                            </div>
                                                        </div>
                                                    </fieldset>

                                                    <!-- Formation Reason -->
                                                    <fieldset class="border p-3 mb-3">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.HowWastheProposalfortheSocietyFormed') }}</label>
                                                                <span class="text-danger">*</span>
                                                                <input class="form-control" type="text"
                                                                    id="society_formation_reason"
                                                                    name="society_formation_reason"
                                                                    value="{{ $feasibilityReports->society_formation_reason ?? '' }}"
                                                                    onkeyup="validateData(this,'society_formation_reason')" />
                                                                <span id="society_formation_reason_err"
                                                                    class="error"></span>
                                                            </div>
                                                        </div>
                                                    </fieldset>

                                                    <!-- Village Society Type -->
                                                    <fieldset class="border p-3 mb-3">
                                                        <div class="row">
                                                            <div class="col-md-12 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.IfItIsaVillageSocietyIsItBasedonaMutualInterestorCooperativeModel') }}</label>
                                                                <span class="text-danger">*</span>
                                                                <div>
                                                                    <label class="mr-10"><input
                                                                            class="form-check-input mr-10"
                                                                            name="society_type" type="radio"
                                                                            value="1" />{{ __('messages.yes') }}</label>
                                                                    <label class="mr-10"><input
                                                                            class="form-check-input mr-10"
                                                                            name="society_type" type="radio"
                                                                            value="0"
                                                                            checked />{{ __('messages.no') }}</label>
                                                                </div>
                                                                <span id="society_type_err" class="error"></span>
                                                            </div>
                                                        </div>
                                                    </fieldset>

                                                    <!-- Bank Association -->
                                                    <fieldset class="border p-3 mb-3">
                                                        <div class="row">
                                                            <div class="col-md-12 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.WhichBankorCentralBankWilltheSocietyBeAssociatedWithandWhatIstheDistanceBetweenThem') }}
                                                                </label>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <label>{{ __('messages.enterbank') }}</label>
                                                                        <span class="text-danger">*</span>
                                                                        <input class="form-control form-control-sm"
                                                                            placeholder="{{ __('messages.enterbank') }}"
                                                                            type="text" id="bank_name"
                                                                            name="bank_name"
                                                                            value="{{ $feasibilityReports->bank_name ?? '' }}"
                                                                            onkeyup="validateData(this,'bank_name')" />
                                                                        <span id="bank_name_err" class="error"></span>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label>{{ __('messages.enterdistance') }}</label>
                                                                        <span class="text-danger">*</span>
                                                                        <input class="form-control form-control-sm"
                                                                            id="society_bank_distance"
                                                                            placeholder="{{ __('messages.enterdistance') }}"
                                                                            type="text" name="society_bank_distance"
                                                                            value="{{ $feasibilityReports->society_bank_distance ?? '' }}"
                                                                            onkeyup="validateData(this,'society_bank_distance')" />
                                                                        <span id="society_bank_distance_err"
                                                                            class="error"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </fieldset>

                                                    <!-- Membership Criteria -->
                                                    <label
                                                        class="col-form-label fw-bold">{{ __('messages.MembershipCriteria') }}
                                                    </label>
                                                    <fieldset class="border p-3 mb-3">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.Howmanyindividualsareeligibleformembership') }}
                                                                </label>
                                                                <span class="text-danger">*</span>
                                                                <input class="form-control" name="membership_limit"
                                                                    min="0" id="membership_limit"
                                                                    type="number"
                                                                    value="{{ $feasibilityReports->membership_limit ?? '' }}"
                                                                    onkeyup="validateData(this,'membership_limit')" />
                                                                <span id="membership_limit_err" class="error"></span>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.Howmanyindividualsarereadytojoin') }}
                                                                </label>
                                                                <span class="text-danger">*</span>
                                                                <input class="form-control" min="0"
                                                                    id="total_members_ready_to_join"
                                                                    name="total_members_ready_to_join" type="number"
                                                                    value="{{ $feasibilityReports->total_members_ready_to_join ?? '' }}"
                                                                    onkeyup="validateData(this,'total_members_ready_to_join')" />
                                                                <span id="total_members_ready_to_join_err"
                                                                    class="error"></span>
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.Aremostmembersactiveandinvolved') }}
                                                                </label>
                                                                <span class="text-danger">*</span>
                                                                <div>
                                                                    <label class="mr-10"><input
                                                                            class="form-check-input mr-10"
                                                                            type="radio" name="is_member_active"
                                                                            value="1"
                                                                            {{ isset($feasibilityReports) && $feasibilityReports->is_member_active == '1' ? 'checked' : '' }}>{{ __('messages.yes') }}</label>
                                                                    <label><input class="form-check-input mr-10"
                                                                            type="radio" name="is_member_active"
                                                                            value="2"
                                                                            {{ isset($feasibilityReports) && $feasibilityReports->is_member_active == '2' ? 'checked' : '' }}>{{ __('messages.no') }}</label>
                                                                </div>
                                                                <span id="is_member_active_err" class="error"></span>
                                                            </div>
                                                        </div>
                                                    </fieldset>

                                                    <!-- Panchayat Support -->
                                                    <label
                                                        class="col-form-label fw-bold">{{ __('messages.ArePanchayatOfficialsSupportiveoftheSocietyandKeepingInfluenceOverIt') }}
                                                    </label>
                                                    <fieldset class="border p-3 mb-3">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.NamesofProposedChairman') }}
                                                                </label>
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
                                                                    class="form-label fw-bold">{{ __('messages.NamesofProposedSecretary') }}
                                                                </label>
                                                                <span class="text-danger">*</span>
                                                                <input class="form-control" name="secretary_name"
                                                                    placeholder="{{ __('messages.enterscecreteryname') }}"
                                                                    type="text"
                                                                    value="{{ $feasibilityReports->secretary_name ?? '' }}"
                                                                    id="secretary_name"
                                                                    onkeyup="validateData(this,'secretary_name')" />
                                                                <span id="secretary_name_err" class="error"></span>
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.HavetheSocietyMembersUnderstoodTheirRightsandResponsibilities') }}
                                                                </label>
                                                                <span class="text-danger">*</span>
                                                                <div>
                                                                    <label class="mr-10"><input
                                                                            class="form-check-input mr-10"
                                                                            name="is_member_understood_rights"
                                                                            type="radio" value="1"
                                                                            {{ isset($feasibilityReports) && $feasibilityReports->is_member_understood_rights == '1' ? 'checked' : '' }} />{{ __('messages.yes') }}</label>
                                                                    <label class="mr-10"><input
                                                                            class="form-check-input mr-10"
                                                                            name="is_member_understood_rights"
                                                                            type="radio" value="0"
                                                                            {{ isset($feasibilityReports) && $feasibilityReports->is_member_understood_rights == '0' ? 'checked' : '' }} />{{ __('messages.no') }}</label>
                                                                </div>
                                                                <span id="is_member_understood_rights_err"
                                                                    class="error"></span>
                                                            </div>
                                                        </div>
                                                    </fieldset>

                                                    <!-- Member Awareness -->
                                                    <fieldset class="border p-3 mb-3">
                                                        <div class="row">
                                                            <div class="col-md-12 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.AreMembersAwareoftheSocietyObjectivestheImportanceoftheMeetingandTheirResponsibilities') }}
                                                                </label>
                                                                <span class="text-danger">*</span>
                                                                <div>
                                                                    <label class="mr-10"><input
                                                                            class="form-check-input mr-10"
                                                                            name="is_member_awared_objectives"
                                                                            type="radio" value="1"
                                                                            {{ isset($feasibilityReports) && $feasibilityReports->is_member_awared_objectives == '1' ? 'checked' : '' }} />{{ __('messages.yes') }}</label>
                                                                    <label class="mr-10"><input
                                                                            class="form-check-input mr-10"
                                                                            name="is_member_awared_objectives"
                                                                            type="radio" value="0"
                                                                            {{ isset($feasibilityReports) && $feasibilityReports->is_member_awared_objectives == '0' ? 'checked' : '' }} />{{ __('messages.no') }}</label>
                                                                </div>
                                                                <span id="is_member_awared_objectives_err"
                                                                    class="error"></span>
                                                            </div>
                                                        </div>
                                                    </fieldset>

                                                    <!-- Existing Society -->
                                                    <fieldset class="border p-3 mb-3">
                                                        <div class="row">
                                                            <div class="col-md-12 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.IsThereAnyExistingCooperativeSocietyintheAreaIfYesProvideDetails') }}
                                                                </label>
                                                                <div>
                                                                    <label class="mr-10"><input
                                                                            class="form-check-input mr-10"
                                                                            name="is_existing_society" type="radio"
                                                                            onclick="showDiv('show','society_details')"
                                                                            value="1"
                                                                            {{ isset($feasibilityReports) && $feasibilityReports->is_existing_society == '1' ? 'checked' : '' }} />{{ __('messages.yes') }}</label>
                                                                    <label class="mr-10"><input
                                                                            class="form-check-input mr-10"
                                                                            name="is_existing_society" type="radio"
                                                                            onclick="showDiv('hide','society_details')"
                                                                            value="0"
                                                                            {{ isset($feasibilityReports) && $feasibilityReports->is_existing_society == '0' ? 'checked' : '' }} />{{ __('messages.no') }}</label>
                                                                </div>
                                                                <span id="is_existing_society_err"
                                                                    class="error"></span>
                                                                <div id="society_details"
                                                                    style="display:{{ isset($feasibilityReports) && $feasibilityReports->is_existing_society == '1' ? 'block' : 'none' }}">
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <label>{{ __('messages.EnterSocietyDetails') }}<span
                                                                                    class="text-danger">*</span></label>
                                                                            <input class="form-control"
                                                                                id="existing_society_details"
                                                                                placeholder="{{ __('messages.EnterSocietyDetails') }}"
                                                                                name="existing_society_details"
                                                                                type="text"
                                                                                value="{{ $feasibilityReports->existing_society_details ?? '' }}" />
                                                                            <span id="existing_society_details_err"
                                                                                class="error"></span>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label>{{ __('messages.Areaofoperation') }}<span
                                                                                    class="text-danger">*</span></label>
                                                                            <input class="form-control"
                                                                                id="area_operation"
                                                                                placeholder="{{ __('messages.Areaofoperation') }}"
                                                                                name="area_operation" type="text"
                                                                                value="{{ $feasibilityReports->area_operation ?? '' }}" />
                                                                            <span id="area_operation_err"
                                                                                class="error"></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </fieldset>

                                                    <!-- Formation Time and Registration Date -->
                                                    <fieldset class="border p-3 mb-3">
                                                        <div class="row">
                                                            <div class="col-md-12 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.TimeTakenforFormingtheSocietyandProposedDateofRegistration') }}
                                                                </label>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <label>{{ __('messages.Entersocietycompletiontime') }}<span
                                                                                class="text-danger">*</span></label>
                                                                        <input class="form-control form-control-sm"
                                                                            type="number" id="society_completion_time"
                                                                            placeholder="{{ __('messages.Entersocietycompletiontime') }}"
                                                                            name="society_completion_time"
                                                                            value="{{ $feasibilityReports->society_completion_time ?? '' }}"
                                                                            onkeyup="validateData(this,'society_completion_time')" />
                                                                        <span id="society_completion_time_err"
                                                                            class="error"></span>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label>{{ __('messages.proposed_registration_date') }}<span
                                                                                class="text-danger">*</span></label>
                                                                        <input class="form-control form-control-sm"
                                                                            type="date"
                                                                            placeholder="{{ __('messages.proposed_registration_date') }}"
                                                                            id="society_registration_date"
                                                                            name="society_registration_date"
                                                                            value="{{ $feasibilityReports->society_registration_date ?? '' }}"
                                                                            onkeyup="validateData(this,'society_registration_date')" />
                                                                        <span id="society_registration_date_err"
                                                                            class="error"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </fieldset>

                                                    <!-- Additional Information -->
                                                    <fieldset class="border p-3 mb-3">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.AdditionalInformation') }}
                                                                </label>
                                                                <input class="form-control form-control-sm"
                                                                    type="text" id="additional_info"
                                                                    name="additional_info"
                                                                    value="{{ $feasibilityReports->additional_info ?? '' }}"
                                                                    onkeyup="validateData(this,'additional_info')" />
                                                                <span id="additional_info_err" class="error"></span>
                                                            </div>
                                                        </div>
                                                    </fieldset>

                                                    <!-- Signatures -->
                                                    <fieldset class="border p-3 mb-3">
                                                        <div class="row">
                                                            <div class="col-md-12 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.SignaturesforRegistrationProposal') }}
                                                                </label>
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <label>{{ __('messages.EnterAuthorityPersonName') }}<span
                                                                                class="text-danger">*</span></label>
                                                                        <input class="form-control form-control-sm"
                                                                            type="text" name="authority_name"
                                                                            id="authority_name"
                                                                            placeholder="{{ __('messages.EnterAuthorityPersonName') }}"
                                                                            value="{{ $feasibilityReports->authority_name ?? '' }}"
                                                                            onkeyup="validateData(this,'authority_name')" />
                                                                        <span class="error"
                                                                            id="authority_name_err"></span>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label>{{ __('messages.EnterAuthorityPersondesignation') }}<span
                                                                                class="text-danger">*</span></label>
                                                                        <input class="form-control form-control-sm"
                                                                            type="text" name="authority_designation"
                                                                            id="authority_designation"
                                                                            placeholder="{{ __('messages.EnterAuthorityPersondesignation') }}"
                                                                            value="{{ $feasibilityReports->authority_designation ?? '' }}"
                                                                            onkeyup="validateData(this,'authority_designation')" />
                                                                        <span class="error"
                                                                            id="authority_designation_err"></span>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label>{{ __('messages.Uploadauthoritysignature') }}<span
                                                                                class="text-danger">*</span></label>
                                                                        <input class="form-control form-control-sm"
                                                                            type="file" name="authority_signature"
                                                                            id="authority_signature"
                                                                            placeholder="Upload the Signature"
                                                                            value="" />
                                                                        @if (!empty($feasibilityReports->authority_signature))
                                                                            <div class="mt-2">
                                                                                <a href="javascript:void(0);"
                                                                                    onclick="viewAttachment('{{ asset('storage/' . $feasibilityReports->authority_signature) }}')">View</a>
                                                                            </div>
                                                                        @endif
                                                                        <span class="error"
                                                                            id="authority_signature_err"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </fieldset>

                                                    <!-- Officer Report -->
                                                    <!-- <fieldset class="border p-3 mb-3">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <div class="row">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <div class="col-md-12 mb-3">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <label
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    class="form-label fw-bold">{{ __('messages.DistrictCooperativeSocietyOfficerReport') }}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </label>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <p>"{{ __('messages.IamsatisfiedwiththemanagementandfeasibilitystudyofthesocietyTheregistrationofthesocietyisrecommended') }}"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </p>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </fieldset> -->

                                                    <div class="d-flex justify-content-between">
                                                        <button class="btn btn-secondary" type="button"
                                                            style="width: 12%;"
                                                            onclick="showPreviousStep(3)">{{ __('messages.back') }}</button>
                                                        <button class="btn btn-primary" type="button"
                                                            id="submit_btn4"
                                                            onclick="nextStep(4)">{{ __('messages.save&submit') }}</button>
                                                    </div>
                                                </form>
                                            </div>

                                            <!-- Step 5 -->
                                            <div class="tab-pane" id="step5" role="tabpanel">
                                                <h6 class="fw-bold">Final Document Submission</h6>
                                                <form id="step_form5" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" id="step5" value="5"
                                                        name="step" />
                                                    <input type="hidden" value="{{ $finalSubmission->id ?? '' }}"
                                                        id="doc_detailsId" name="doc_detailsId" />

                                                    <!-- Proposal Documents -->
                                                    <label
                                                        class="col-form-label fw-bold">{{ __('messages.ProposalDocuments') }}
                                                    </label>
                                                    <fieldset class="border p-3 mb-3">
                                                        <div class="row">
                                                            <div class="col-md-4 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.Meeting1') }}
                                                                    :<span class="text-danger">*</span></label>
                                                                <input type="file" id="meeting1"
                                                                    class="form-control form-control-sm" name="meeting1"
                                                                    accept="image/*,application/pdf"
                                                                    value="{{ $finalSubmission->meeting1 ?? '' }}"
                                                                    onkeyup="validateData(this,'meeting1')" />
                                                                @if (@$finalSubmission->meeting1)
                                                                    <a href="javascript:void(0);"
                                                                        onclick="viewAttachment('{{ asset('storage/' . $finalSubmission->meeting1) }}')">View</a>
                                                                @endif
                                                                <span class="error" id="meeting1_err"></span>
                                                            </div>
                                                            <div class="col-md-4 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.Meeting2') }}
                                                                    :<span class="text-danger">*</span></label>
                                                                <input type="file" id="meeting2"
                                                                    class="form-control form-control-sm" name="meeting2"
                                                                    accept="image/*,application/pdf"
                                                                    value="{{ $finalSubmission->meeting2 ?? '' }}"
                                                                    onkeyup="validateData(this,'meeting2')" />
                                                                @if (@$finalSubmission->meeting2)
                                                                    <a href="javascript:void(0);"
                                                                        onclick="viewAttachment('{{ asset('storage/' . $finalSubmission->meeting2) }}')">View</a>
                                                                @endif
                                                                <span class="error" id="meeting2_err"></span>
                                                            </div>
                                                            <div class="col-md-4 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.Meeting3') }}
                                                                    :<span class="text-danger">*</span></label>
                                                                <input type="file" id="meeting3"
                                                                    class="form-control form-control-sm" name="meeting3"
                                                                    accept="image/*,application/pdf"
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

                                                    <!-- Other Documents -->
                                                    <label
                                                        class="col-form-label fw-bold">{{ __('messages.OtherDocuments') }}
                                                        :</label>
                                                    <fieldset class="border p-3 mb-3">
                                                        <div class="row">
                                                            <div class="col-md-4 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.Upload_id_proofs') }}
                                                                    :<span class="text-danger">*</span></label>
                                                                <input type="file" id="all_id_proof"
                                                                    class="form-control form-control-sm"
                                                                    name="all_id_proof" accept="image/*,application/pdf"
                                                                    value="{{ $finalSubmission->all_id_proof ?? '' }}"
                                                                    onkeyup="validateData(this,'all_id_proof')" />
                                                                @if (@$finalSubmission->all_id_proof)
                                                                    <a href="javascript:void(0);"
                                                                        onclick="viewAttachment('{{ asset('storage/' . $finalSubmission->all_id_proof) }}')">View</a>
                                                                @endif
                                                                <span class="error" id="all_id_proof_err"></span>
                                                            </div>
                                                            <div class="col-md-4 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.Upload_all_application_forms') }}
                                                                    :<span class="text-danger">*</span></label>
                                                                <input type="file" id="all_application_form"
                                                                    class="form-control form-control-sm"
                                                                    accept="image/*,application/pdf"
                                                                    name="all_application_form"
                                                                    value="{{ $finalSubmission->all_application_form ?? '' }}"
                                                                    onkeyup="validateData(this,'all_application_form')" />
                                                                @if (@$finalSubmission->all_application_form)
                                                                    <a href="javascript:void(0);"
                                                                        onclick="viewAttachment('{{ asset('storage/' . $finalSubmission->all_application_form) }}')">View</a>
                                                                @endif
                                                                <span class="error"
                                                                    id="all_application_form_err"></span>
                                                            </div>
                                                            <div class="col-md-4 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.Upload_all_declaration_forms') }}
                                                                    :<span class="text-danger">*</span></label>
                                                                <input type="file" id="all_declaration_form"
                                                                    class="form-control form-control-sm"
                                                                    accept="image/*,application/pdf"
                                                                    name="all_declaration_form"
                                                                    value="{{ $finalSubmission->all_declaration_form ?? '' }}"
                                                                    onkeyup="validateData(this,'all_declaration_form')" />
                                                                @if (@$finalSubmission->all_declaration_form)
                                                                    <a href="javascript:void(0);"
                                                                        onclick="viewAttachment('{{ asset('storage/' . $finalSubmission->all_declaration_form) }}')">View</a>
                                                                @endif
                                                                <span class="error"
                                                                    id="all_declaration_form_err"></span>
                                                            </div>
                                                        </div>
                                                    </fieldset>

                                                    <!-- Society By Laws -->
                                                    {{-- <label class="col-form-label fw-bold">{{
                                                        __('messages.UploadSocietyByLaws') }}
                                                        :<span class="text-danger">*</span></label> --}}
                                                    <fieldset class="border p-3 mb-3">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.UploadSocietyByLaws') }}
                                                                    :<span class="text-danger">*</span></label>
                                                                <input type="file" id="society_by_laws"
                                                                    class="form-control form-control-sm"
                                                                    accept="image/*,application/pdf"
                                                                    name="society_by_laws"
                                                                    value="{{ $finalSubmission->society_by_laws ?? '' }}"
                                                                    onkeyup="validateData(this,'society_by_laws')" />
                                                                @if (@$finalSubmission->society_by_laws)
                                                                    <a href="javascript:void(0);"
                                                                        onclick="viewAttachment('{{ asset('storage/' . $finalSubmission->society_by_laws) }}')">View</a>
                                                                @endif
                                                                <span class="error" id="society_by_laws_err"></span>
                                                            </div>
                                                            <!-- Challan Proof -->
                                                            <div class="col-md-6 mb-3">
                                                                <label
                                                                    class="form-label fw-bold">{{ __('messages.ProofofChallan') }}
                                                                    :<span class="text-danger">*</span></label>
                                                                <input type="file" id="challan_proof"
                                                                    class="form-control form-control-sm"
                                                                    accept="image/*,application/pdf"
                                                                    name="challan_proof"
                                                                    onkeyup="validateData(this,'challan_proof')" />
                                                                <span class="error" id="challan_proof_err"></span>
                                                            </div>

                                                        </div>
                                                    </fieldset>

                                                    <!-- Challan Proof -->
                                                    {{-- <label class="col-form-label fw-bold">{{
                                                        __('messages.ProofofChallan') }}
                                                        :<span class="text-danger">*</span></label>
                                                    <fieldset class="border p-3 mb-3">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label fw-bold">{{
                                                                    __('messages.ProofofChallan') }}
                                                                    :</label>
                                                                <input type="file" id="challan_proof"
                                                                    class="form-control form-control-sm"
                                                                    accept="image/*,application/pdf" name="challan_proof"
                                                                    onkeyup="validateData(this,'challan_proof')" />
                                                                <span class="error" id="challan_proof_err"></span>
                                                            </div>
                                                        </div>
                                                    </fieldset> --}}

                                                    <div class="d-flex justify-content-between">
                                                        <button class="btn btn-secondary" type="button"
                                                            style="width: 12%;"
                                                            onclick="showPreviousStep(4)">{{ __('messages.back') }}</button>
                                                        <button class="btn btn-primary" type="button"
                                                            id="submit_btn5"
                                                            onclick="nextStep(5)">{{ __('messages.finalsubmit') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="viewModal" tabindex="-1" role="dialog"
                            aria-labelledby="viewModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Application Details</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div id="modalContent">Loading...</div>
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

    <script>
        let currentStep = 1;
        $(document).ready(function() {
            if ($('.member-row').length > 0) {
                $('#addMemberBtn').prop('disabled', false);
            }
            // Add more input fields dynamically
            $(document).on('input change', 'input, select, textarea', function() {
                const fieldName = $(this).attr('name');
                const row = $(this).closest('.member-row');

                if (fieldName === 'name[]') {
                    row.find('.error-name').text('');
                } else if (fieldName === 'address[]') {
                    row.find('.error-address').text('');
                } else if (fieldName === 'gender[]') {
                    row.find('.error-gender').text('');
                } else if (fieldName === 'is_married[]') {
                    row.find('.error-is_married').text('');
                } else if (fieldName === 'father_spouse_name[]') {
                    row.find('.error-father_spouse_name').text('');
                } else if (fieldName === 'designation[]') {
                    row.find('.error-designation').text('');
                }
            });
            $(document).on('change', 'select[name="designation[]"]', function() {
                const row = $(this).closest('.member-row');
                const index = row.data('row-number') - 1;
                validateData(this, `designation${index}`);
            });

            // Special handler for file inputs
            $(document).on('change', 'input[type="file"]', function() {
                const fieldName = $(this).attr('name');
                const row = $(this).closest('.member-row');

                if (fieldName === 'membership_form[]' && this.files.length > 0) {
                    row.find('.error-membership_form').text('');
                } else if (fieldName === 'aadhar_no[]' && this.files.length > 0) {
                    row.find('.error-aadhar_no').text('');
                } else if (fieldName === 'signature[]' && this.files.length > 0) {
                    row.find('.error-signature').text('');
                } else if (fieldName === 'declaration1[]' && this.files.length > 0) {
                    row.find('.error-declaration1').text('');
                } else if (fieldName === 'declaration2[]' && this.files.length > 0) {
                    row.find('.error-declaration2').text('');
                }
            });

            // Clear declaration checkbox error when checked
            $('input[name="is_declared"]').on('change', function() {
                if ($(this).is(':checked')) {
                    $('#is_declared_err').text('');
                }
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

        function saveMember(button, memberId) {
            const memberRow = $(button).closest('.member-row');
            const rowNumber = memberRow.data('row-number');
            const index = rowNumber - 1;

            $(button).prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');
            $('#addMemberBtn').prop('disabled', true);

            let isValid = true;
            memberRow.find('[class^="error-"]').text('');

            const fileMaxSizes = {
                'aadhar_no': 1048576,
                'membership_form': 2097152,
                'declaration1': 1048576,
                'declaration2': 1048576,
                'signature': 1048576
            };

            const allowedFileTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png', 'image/webp'];

            function validateFile(input, fieldKey, errorSelector) {
                const file = input[0]?.files[0];
                if (!file) return true;

                if (!allowedFileTypes.includes(file.type)) {
                    errorSelector.text("Only PDF or image files (jpg, jpeg, png, webp) are allowed.");
                    return false;
                }

                if (file.size > fileMaxSizes[fieldKey]) {
                    const sizeMB = fileMaxSizes[fieldKey] / (1024 * 1024);
                    errorSelector.text(`File size should not exceed ${sizeMB} MB.`);
                    return false;
                }

                return true;
            }

            // Validate fields
            const name = memberRow.find("input[name='name[]']").val().trim();
            if (!name) {
                memberRow.find(".error-name").text("Enter Name");
                isValid = false;
            }

            const contact_no = memberRow.find("input[name='contact_no[]']").val().trim();

            if (!contact_no) {
                memberRow.find(".error-contact_no").text("Enter Contact No");
                isValid = false;
            } else if (!/^\d{10}$/.test(contact_no)) {
                memberRow.find(".error-contact_no").text("Contact No must be exactly 10 digits");
                isValid = false;
            } else {
                memberRow.find(".error-contact_no").text(""); // Clear error if valid
            }

            const address = memberRow.find("input[name='address[]']").val().trim();
            if (!address) {
                memberRow.find(".error-address").text("Enter Full Address");
                isValid = false;
            }

            const gender = memberRow.find("select[name='gender[]']").val();
            if (!gender) {
                memberRow.find(".error-gender").text("Select Gender");
                isValid = false;
            }

            const membershipForm = memberRow.find("input[name='membership_form[]']");
            const hasExistingMembershipForm = memberRow.find("a[onclick*='membership_form']").length > 0;
            if (membershipForm[0].files.length === 0 && !hasExistingMembershipForm && !memberId) {
                memberRow.find(".error-membership_form").text("Upload Membership Form.");
                isValid = false;
            } else if (!validateFile(membershipForm, 'membership_form', memberRow.find(".error-membership_form"))) {
                isValid = false;
            }

            const isMarried = memberRow.find("select[name='is_married[]']").val();
            if (!isMarried) {
                memberRow.find(".error-is_married").text("Select Is Married");
                isValid = false;
            }

            const fatherSpouseName = memberRow.find("input[name='father_spouse_name[]']").val().trim();
            if (!fatherSpouseName) {
                memberRow.find(".error-father_spouse_name").text("Enter Father/Spouse Name");
                isValid = false;
            }

            const designation = memberRow.find("select[name='designation[]']").val();
            if (!designation) {
                memberRow.find(".error-designation").text("Select Designation");
                isValid = false;
            }

            const aadharNo = memberRow.find("input[name='aadhar_no[]']");
            if (aadharNo[0].files.length === 0 && memberRow.find("a[onclick*='aadhar_no']").length === 0 && !memberId) {
                memberRow.find(".error-aadhar_no").text("Upload Aadhaar.");
                isValid = false;
            } else if (!validateFile(aadharNo, 'aadhar_no', memberRow.find(".error-aadhar_no"))) {
                isValid = false;
            }

            const signature = memberRow.find("input[name='signature[]']");
            if (signature.length > 0) {
                if (signature[0].files.length === 0 && memberRow.find(".existing-signature").length === 0 && !memberId) {
                    memberRow.find(".error-signature").text("Upload Signature.");
                    isValid = false;
                } else if (signature[0].files.length > 0 && !validateFile(signature, 'signature', memberRow.find(
                        ".error-signature"))) {
                    isValid = false;
                }
            }

            // Validate Declaration 1
            const declaration1 = memberRow.find("input[name='declaration1[]']");
            if (declaration1.length > 0) {
                if (declaration1[0].files.length === 0 && memberRow.find(".existing-declaration1").length === 0 && !
                    memberId) {
                    memberRow.find(".error-declaration1").text("Upload Declaration 1.");
                    isValid = false;
                } else if (declaration1[0].files.length > 0 && !validateFile(declaration1, 'declaration1', memberRow.find(
                        ".error-declaration1"))) {
                    isValid = false;
                }
            }


            // Validate Declaration 2
            const declaration2 = memberRow.find("input[name='declaration2[]']");
            if (declaration2.length > 0) {
                if (declaration2[0].files.length === 0 && memberRow.find(".existing-declaration2").length === 0 && !
                    memberId) {
                    memberRow.find(".error-declaration2").text("Upload Declaration 2.");
                    isValid = false;
                } else if (declaration2[0].files.length > 0 && !validateFile(declaration2, 'declaration2', memberRow.find(
                        ".error-declaration2"))) {
                    isValid = false;
                }
            }

            if (!isValid) {
                $(button).prop('disabled', false).html('Save Member');
                return;
            }

            const formData = new FormData();
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
            formData.append('step', '3');
            if ($("#society_id").val()) formData.append('society_id', $("#society_id").val());
            if (memberId) formData.append('member_id[]', memberId);

            memberRow.find('input, select, textarea').each(function() {
                if (this.type === 'file' && this.files.length > 0) {
                    formData.append(this.name.replace('[]', ''), this.files[0]);
                } else if (this.type !== 'file') {
                    formData.append(this.name.replace('[]', ''), this.value);
                }
            });

            formData.append('is_declared', memberRow.find("input[name='is_declared']").is(':checked') ? '1' : '0');
            $.ajax({
                url: '{{ route('save.member') }}',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.success === true) {
                        // toastr.success(response.message);

                        // Set member ID
                        memberRow.find("input[name='member_id[]']").val(response.member_id);
                        $(button).prop('disabled', true).html('Saved');

                        // Enable the Add Member button if total members < 7
                        if ($('.member-row').length < 7) {
                            // $('#addMemberBtn').prop('disabled', false); // <-- This enables it
                        }

                        $('#addMemberBtn').prop('disabled', false);

                        // Enable Submit button if exactly 7
                        if ($('.member-row').length >= 7) {
                            $('#submit_btn3').prop('disabled', false);
                        }
                    } else {
                        // toastr.error(response.message || 'Unexpected error occurred.');
                        $(button).prop('disabled', false).html('Save Member');
                    }
                },
                error: function() {
                    // toastr.error('Something went wrong. Please try again.');
                    $(button).prop('disabled', false).html('Save Member');
                }
            });

        }

        function addMoreMember() {
            const memberRows = document.querySelectorAll('.member-row');
            const newIndex = memberRows.length;
            const newRowNumber = newIndex + 1;

            $('#addMemberBtn').prop('disabled', true);

            const firstRow = memberRows[0].cloneNode(true);

            // Reset all input, select, and textarea values
            firstRow.querySelectorAll('input, select, textarea').forEach(input => {
                if (input.type === 'file') {
                    input.value = '';
                } else {
                    input.value = '';
                }
            });

            // Clear only validation error texts (not all spans)
            firstRow.querySelectorAll('span[class^="error"]').forEach(el => el.textContent = '');

            // Remove only dynamically generated file view/download links
            firstRow.querySelectorAll('a.existing-file-link, .file-preview, .mt-2').forEach(el => el.remove());

            // Reset hidden member ID
            const memberIdInput = firstRow.querySelector('input[name="member_id[]"]');
            if (memberIdInput) memberIdInput.value = '';

            // Update row number
            firstRow.setAttribute('data-row-number', newRowNumber);
            const memberNumberLabel = firstRow.querySelector('.member-number');
            if (memberNumberLabel) memberNumberLabel.textContent = `Member #${newRowNumber}`;

            // Update save button
            const saveBtn = firstRow.querySelector('.save-member-btn');
            if (saveBtn) {
                saveBtn.disabled = false;
                saveBtn.innerHTML = 'Save Member';
                saveBtn.setAttribute('onclick', `saveMember(this, null)`);
            }

            // Set or create remove button
            const removeBtn = firstRow.querySelector('.formremoveBtn');
            if (removeBtn) {
                removeBtn.style.display = 'block';
                removeBtn.setAttribute('onclick', `confirmRemoveMember(${newRowNumber})`);
            } else {
                const newRemoveBtn = document.createElement('button');
                newRemoveBtn.className = 'formremoveBtn btn btn-danger btn-sm';
                newRemoveBtn.innerHTML = '<i class="uil-times"></i>';
                newRemoveBtn.setAttribute('type', 'button');
                newRemoveBtn.setAttribute('onclick', `confirmRemoveMember(${newRowNumber})`);

                const header = firstRow.querySelector('.member-header');
                if (header) {
                    header.appendChild(newRemoveBtn);
                }
            }

            // Optional dynamic ID update
            updateFieldIds(firstRow, newIndex);

            // Append to container
            document.getElementById('more_member').appendChild(firstRow);

            // Scroll into view
            firstRow.scrollIntoView({
                behavior: 'smooth'
            });
        }

        $(document).ready(function() {
            // Check if in edit mode and last member is saved
            let lastMemberId = $('.member-row:last').find("input[name='member_id[]']").val();

            if (lastMemberId && lastMemberId.trim() !== '') {
                // Last member is saved, so enable Add Member button
                $('#addMemberBtn').prop('disabled', false);
            } else {
                // If not saved, disable it
                $('#addMemberBtn').prop('disabled', true);
            }

            // Detect changes in the last row inputs - disable Add until saved
            $(document).on('input change', '.member-row:last input, .member-row:last select', function() {
                $('#addMemberBtn').prop('disabled', true);
            });
        });

        function validateAndSubmitAllMembers() {
            const memberRows = $('.member-row');

            // Check minimum 7 members
            if (memberRows.length < 7) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Minimum Members Required',
                    text: 'You must add at least 7 members before submitting.',
                    confirmButtonText: 'OK'
                });
                return;
            }

            let totalSaved = 0;

            memberRows.each(function() {
                const memberId = $(this).find("input[name='member_id[]']").val();
                if (memberId && memberId.trim() !== '') {
                    totalSaved++;
                }
            });

            // Final validation: all must be saved
            if (totalSaved < 7) {
                Swal.fire({
                    icon: 'info',
                    title: 'Incomplete Member Data',
                    text: 'Please save all 7 members before submitting.',
                    confirmButtonText: 'OK'
                });
                return;
            }

            // All checks passed: proceed to next step
            Swal.fire({
                icon: 'success',
                title: 'Validation Complete',
                text: 'All 7 members are saved. Proceeding to the next step...',
                timer: 1500,
                showConfirmButton: false
            }).then(() => {
                nextStep(3); // ⬅️ Trigger your step navigation
            });
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



        function validateStep(step) {
            let isValid = true;
            if (step == 1) {
                // Clear previous errors
                $('.error').text('');

                let society_name = $("#society_name").val();
                let locality = $("#locality").val();
                let post_office = $("#post_office").val();
                let developement_area = $("#developement_area").val();
                let tehsil = $("#tehsil").val();
                let district = $("#district").val();
                let nearest_station = $("#nearest_station").val();
                let society_category = document.querySelector("input[name=society_category]:checked");
                let society_sector_type_id = $("#society_sector_type_id").val();
                let is_credit_society = document.querySelector("input[name=is_credit_society]:checked");


                if (!society_name) {
                    $("#society_name_err").text("Enter Society Name.");
                    isValid = false;
                }
                if (!locality) {
                    $("#locality_err").text("Enter Locality");
                    isValid = false;
                }
                if (!post_office) {
                    $("#post_office_err").text("Enter Post Office");
                    isValid = false;
                }
                if (!developement_area) {
                    $("#developement_area_err").text("Enter Development Area");
                    isValid = false;
                }
                if (!tehsil) {
                    $("#tehsil_err").text("Enter Tehsil");
                    isValid = false;
                }
                if (!district) {
                    $("#district_err").text("Select District");
                    isValid = false;
                }
                if (!nearest_station) {
                    $("#nearest_station_err").text("Enter Nearest Station");
                    isValid = false;
                }
                if (!society_category) {
                    $("#society_category_err").text("Choose a Society Category");
                    isValid = false;
                }
                if (!society_sector_type_id) {
                    $("#society_sector_type_err").text("Select Society Sector Type");
                    isValid = false;
                }

                if (!is_credit_society) {
                    $("#is_credit_society_err").text("Please select if it is a Credit Society.");
                    isValid = false;
                }


                // Add event listeners to clear validation messages when user interacts
                if (!isValid) {
                    // For text inputs
                    $("#society_name, #locality, #post_office, #tehsil, #nearest_station").on('input', function() {
                        const id = $(this).attr('id');
                        $("#" + id + "_err").text('');
                    });

                    // For select dropdowns
                    $("#developement_area, #district,#society_sector_type_id").on('change', function() {
                        const id = $(this).attr('id');
                        $("#" + id + "_err").text('');
                    });

                    // For radio buttons
                    $("input[name='society_category']").on('change', function() {
                        $("#society_category_err").text('');
                    });
                    // For radio buttons (clear error on change)
                    $("input[name='is_credit_society']").on('change', function() {
                        $("#is_credit_society_err").text('');
                    });

                }

            } else if (step == 2) {

                let member_responsibility_type = document.querySelector(
                    "input[name=member_responsibility_type]:checked");
                let society_operational_area = $("#society_operational_area").val();
                let society_objective = $("#society_objective").val();
                let subscription_rate = $("#subscription_rate").val();
                let member_liability = $("#member_liability").val();
                let general_member_count = $("#general_member_count").val();
                let society_record_language = $("#society_record_language").val();
                let society_representative_name = $("#society_representative_name").val();
                let society_representative_address = $("#society_representative_address").val();
                let society_secretary_name = $("#society_secretary_name").val();
                let society_secretary_address = $("#society_secretary_address").val();

                // File inputs
                let rep_signature_input = document.getElementById("society_representative_signature");
                // let rep_signature_file = rep_signature_input.files[0];
                let rep_signature_file = rep_signature_input && rep_signature_input.files.length > 0 ?
                    rep_signature_input
                    .files[0] : null;

                let sec_signature_input = document.getElementById("society_secretary_signature");
                let sec_signature_file = sec_signature_input && sec_signature_input.files.length > 0 ?
                    sec_signature_input
                    .files[0] : null;
                // let sec_signature_file = sec_signature_input.files[0];

                // Existing file flags from backend
                let exist_secreatary_signature =
                    {{ @$membersObjectives->society_secretary_signature ? 'true' : 'false' }};
                let exist_representative_signature =
                    {{ @$membersObjectives->society_representative_signature ? 'true' : 'false' }};

                // Validation logic
                if (!member_responsibility_type) {
                    $("#member_responsibility_type_err").text("Choose Responsibilities of Society Members.");
                    isValid = false;
                }

                if (!society_operational_area) {
                    $("#society_operational_area_err").text("Enter Operational Area of the Proposed Society.");
                    isValid = false;
                }

                if (!society_objective) {
                    $("#society_objective_err").text("Enter Main Objectives of the Proposed Society.");
                    isValid = false;
                }

                // if (!society_share_value) {
                //     $("#society_share_value_err").text("This field is required.");
                //     isValid = false;
                // }

                if (!subscription_rate) {
                    $("#subscription_rate_err").text("Enter Value and Rate of Each Share for Subscription Payment.");
                    isValid = false;
                }

                if (!member_liability) {
                    $("#member_liability_err").text("Enter Liabilities of Members.");
                    isValid = false;
                }

                if (!general_member_count) {
                    $("#general_member_count_err").text(
                        "Enter Number of Individuals Who Have Agreed to Become General Members of the Proposed Society."
                    );
                    isValid = false;
                }

                if (!society_record_language) {
                    $("#society_record_language_err").text(
                        "Select Language in Which the Proposed Society’s Records Will Be Maintained.");
                    isValid = false;
                }

                if (!society_representative_name) {
                    $("#society_representative_name_err").text("Enter Representative Name.");
                    isValid = false;
                }

                if (!society_representative_address) {
                    $("#society_representative_address_err").text("Enter Representative Address.");
                    isValid = false;
                }

                // Representative Signature Validation
                if (!rep_signature_file && !exist_representative_signature) {
                    $("#society_representative_signature_err").text("Upload society representative signature.");
                    isValid = false;
                } else if (rep_signature_file && rep_signature_file.size > 1024 * 1024) {
                    $("#society_representative_signature_err").text("File must be less than 1 MB.");
                    isValid = false;
                } else {
                    $("#society_representative_signature_err").text(""); // Clear error if valid
                }

                // Secretary Name & Address
                if (!society_secretary_name) {
                    $("#society_secretary_name_err").text("Enter Proposed Society Secretary.");
                    isValid = false;
                }

                if (!society_secretary_address) {
                    $("#society_secretary_address_err").text("Enter Secretary Address.");
                    isValid = false;
                }

                // Secretary Signature Validation
                if (!sec_signature_file && !exist_secreatary_signature) {
                    $("#society_secretary_signature_err").text("Upload society secretary signature.");
                    isValid = false;
                } else if (sec_signature_file && sec_signature_file.size > 1024 * 1024) {
                    $("#society_secretary_signature_err").text("File must be less than 1 MB.");
                    isValid = false;
                } else {
                    $("#society_secretary_signature_err").text(""); // Clear error if valid
                }

            } else if (step == 3) {

                isValid = true;
            } else if (step == 4) {
                // Clear all previous errors first
                $('.error').text('');

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
                let is_member_understood_rights = document.querySelector(
                    "input[name=is_member_understood_rights]:checked");
                let is_member_awared_objectives = document.querySelector(
                    "input[name=is_member_awared_objectives]:checked");
                let is_existing_society = document.querySelector("input[name=is_existing_society]:checked");
                let is_existing_society_val = $('input[name="is_existing_society"]:checked').val();

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
                // let additional_info = $("#additional_info").val();
                let authority_name = $("#authority_name").val();
                let authority_designation = $("#authority_designation").val();
                let authority_signature = $("#authority_signature").val();
                let exist_authority_signature = {{ @$feasibilityReports->authority_signature ? 'true' : 'false' }};

                if (!society_name) {
                    $("#fsociety_name_err").text("Enter Society Name.");
                    isValid = false;
                }
                if (!society_formation_reason) {
                    $("#society_formation_reason_err").text("Enter Society Formation Reason.");
                    isValid = false;
                }
                if (!society_type) {
                    $("#society_type_err").text("Choose Society Type.");
                    isValid = false;
                }
                if (!bank_name) {
                    $("#bank_name_err").text("Enter Bank Name.");
                    isValid = false;
                }
                if (!society_bank_distance) {
                    $("#society_bank_distance_err").text("Enter Distance from bank.");
                    isValid = false;
                }
                if (!membership_limit) {
                    $("#membership_limit_err").text("Enter Membership Limit.");
                    isValid = false;
                }
                if (!total_members_ready_to_join) {
                    $("#total_members_ready_to_join_err").text("Enter Total Members Ready To Join.");
                    isValid = false;
                }
                if (!is_member_active) {
                    $("#is_member_active_err").text("Choose Is Member Active.");
                    isValid = false;
                }
                if (!chairman_name) {
                    $("#chairman_name_err").text("Enter Chairman Name.");
                    isValid = false;
                }
                if (!secretary_name) {
                    $("#secretary_name_err").text("Enter Secretary Name.");
                    isValid = false;
                }
                if (!is_member_understood_rights) {
                    $("#is_member_understood_rights_err").text("Choose Is Member Understood Rights.");
                    isValid = false;
                }
                if (!is_member_awared_objectives) {
                    $("#is_member_awared_objectives_err").text("Enter Is Mmember Aawared Objectives.");
                    isValid = false;
                }
                if (!is_existing_society) {
                    $("#is_existing_society_err").text("Choose Is Existing Society.");
                    isValid = false;
                }
                if (!society_completion_time) {
                    $("#society_completion_time_err").text("Enter Society Completion Time.");
                    isValid = false;
                }
                if (!society_registration_date) {
                    $("#society_registration_date_err").text("Choose Society Registration Date.");
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


                if (!isValid) {
                    // For radio buttons
                    $("input[name='society_type'], input[name='is_member_active'], input[name='is_member_understood_rights'], input[name='is_member_awared_objectives'], input[name='is_existing_society']")
                        .on('change', function() {
                            const name = $(this).attr('name');
                            $("#" + name + "_err").text('');
                        });

                    // For file upload
                    $("#authority_signature").on('change', function() {
                        $("#authority_signature_err").text('');
                    });

                    // For text inputs
                    $("#fsociety_name, #society_formation_reason, #bank_name, #society_bank_distance, #membership_limit, #total_members_ready_to_join, #chairman_name, #secretary_name, #society_completion_time, #society_registration_date, #additional_info, #authority_name, #authority_designation, #existing_society_details, #area_operation")
                        .on('input', function() {
                            const id = $(this).attr('id');
                            $("#" + id + "_err").text('');
                        });
                }

            }
            /*else if (step == 5) {
                                           let authority_name = $("#authority_name").val();
                                           let authority_designation = $("#authority_designation").val();
                                           let authority_signature = $("#authority_signature").val();

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

                               } */
            else if (step == 5) {
                /*  let meeting1 = $("#meeting1").val();
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
                    if (!challan_proof && !exist_challan_proof) {
                        $("#challan_proof_err").text("Please upload challan");
                        isValid = false;
                    } */

                // File size limits in bytes
                const maxSizes = {
                    meeting: 5 * 1024 * 1024, // 5 MB
                    bylaws: 25 * 1024 * 1024, // 25 MB
                    idProof: 10 * 1024 * 1024, // 10 MB
                    applicationForm: 10 * 1024 * 1024, // 10 MB
                    declarationForm: 10 * 1024 * 1024, // 10 MB
                    challan: 1 * 1024 * 1024 // 1 MB
                };

                // Utility function to validate file presence and size
                function checkFile(inputId, errorId, exists, maxSize, label) {
                    let fileInput = document.getElementById(inputId);
                    let file = fileInput?.files?.[0];
                    document.getElementById(errorId).innerText = '';

                    if (!file && !exists) {
                        document.getElementById(errorId).innerText = `Please upload ${label}`;
                        isValid = false;
                    } else if (file && file.size > maxSize) {
                        document.getElementById(errorId).innerText =
                            `${label} must be less than ${Math.round(maxSize / (1024 * 1024))} MB`;
                        isValid = false;
                    }
                }

                checkFile("meeting1", "meeting1_err", {{ @$finalSubmission->meeting1 ? 'true' : 'false' }}, maxSizes
                    .meeting, "document for Meeting 1");
                checkFile("meeting2", "meeting2_err", {{ @$finalSubmission->meeting2 ? 'true' : 'false' }}, maxSizes
                    .meeting, "document for Meeting 2");
                checkFile("meeting3", "meeting3_err", {{ @$finalSubmission->meeting3 ? 'true' : 'false' }}, maxSizes
                    .meeting, "document for Meeting 3");

                checkFile("all_id_proof", "all_id_proof_err", {{ @$finalSubmission->all_id_proof ? 'true' : 'false' }},
                    maxSizes.idProof, "ID proof of all members");
                checkFile("all_application_form", "all_application_form_err",
                    {{ @$finalSubmission->all_application_form ? 'true' : 'false' }}, maxSizes.applicationForm,
                    "application form of all members");
                checkFile("all_declaration_form", "all_declaration_form_err",
                    {{ @$finalSubmission->all_declaration_form ? 'true' : 'false' }}, maxSizes.declarationForm,
                    "declaration form of all members");

                checkFile("society_by_laws", "society_by_laws_err",
                    {{ @$finalSubmission->society_by_laws ? 'true' : 'false' }}, maxSizes.bylaws,
                    "Society by-laws document");
                checkFile("challan_proof", "challan_proof_err", {{ @$finalSubmission->challan_proof ? 'true' : 'false' }},
                    maxSizes.challan, "challan receipt");

            }

            return isValid;
        }


        function nextStep(stepVal) {
            var step = stepVal;
            currentStep = stepVal;
            if (step) {
                $("#submit_btn" + step).prop('disabled', true);
                let formValidate = validateStep(step); //alert(formValidate)
                if (!validateStep(step)) {
                    $("#submit_btn" + step).prop('disabled', false);
                    return;
                }
                var form_data = new FormData($("#step_form" + step)[0]);
                // alert(step);
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
                    beforeSend: function() {},
                    success: function(response) {
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
                                // $("#member_declarationId").val(response.member_declarationId);
                                // if (response.member_id_arr && response.member_id_arr.length > 0) {
                                console.log(11, response.member_id_arr);
                                // for (var i = 0; i < response.member_id_arr.length; i++) {
                                //     $("#member_id" + i).val(response.member_id_arr[i]);
                                // }
                                // }
                            } else if (step == 4) {
                                $("#feasibility_reportId").val(response.feasibility_reportId);
                                // } else if (step == 5) {
                                //     $("#inspector_reportId").val(response.inspector_reportId);
                            }

                            $("#submit_btn" + step).prop('disabled', false);
                        } else {
                            //location.reload();
                            // window.location.href = "{{ route('socialregdapp.list') }}";
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Complete Society Registration Successfully!',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = "{{ route('socialregdapp.list') }}";
                            });
                        }
                    },
                    error: function(xhr, status, error) {

                        console.log(11, error);

                        $("#submit_btn" + step).prop('disabled', false);
                    },
                    complete: function() {

                    }
                });

            }
        }

        $('#district').on('change', function() {
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
            const memberRows = document.querySelectorAll('.member-row');

            // Prevent deletion if only one row left
            if (memberRows.length === 1) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Cannot Remove',
                    text: 'At least one member must remain.',
                    confirmButtonText: 'OK'
                });
                return;
            }

            Swal.fire({
                title: `Are you sure?`,
                text: `Do you want to remove member #${rowNumber}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, remove it!',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    if (memberId) {
                        $.ajax({
                            url: "{{ route('delete_member') }}",
                            method: 'POST',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content'),
                                member_id: memberId
                            },
                            success: function(response) {
                                if (response.success) {
                                    removeMemberRow(rowNumber);
                                    Swal.fire('Deleted!', response.message, 'success');
                                } else {
                                    Swal.fire('Error!', response.message, 'error');
                                }
                            },
                            error: function() {
                                Swal.fire('Error!', 'Something went wrong.', 'error');
                            }
                        });
                    } else {
                        removeMemberRow(rowNumber);
                    }
                }
            });
        }

        function removeMemberRow(rowNumber) {
            const memberRows = document.querySelectorAll('.member-row');

            memberRows.forEach(row => {
                if (parseInt(row.getAttribute('data-row-number')) === rowNumber) {
                    row.remove();
                }
            });

            updateMemberNumbers();
        }

        function updateMemberNumbers() {
            const memberRows = document.querySelectorAll('.member-row');
            memberRows.forEach((row, index) => {
                const newRowNumber = index + 1;
                row.setAttribute('data-row-number', newRowNumber);

                const label = row.querySelector('.member-number');
                if (label) label.textContent = `Member #${newRowNumber}`;

                const removeBtn = row.querySelector('.formremoveBtn');
                if (removeBtn) {
                    const memberIdInput = row.querySelector('input[name="member_id[]"]');
                    const memberId = memberIdInput ? memberIdInput.value || 'null' : 'null';
                    removeBtn.setAttribute('onclick', `confirmRemoveMember(${newRowNumber}, ${memberId})`);
                }
            });
        }


        document.getElementById('confirmRemoveBtn').addEventListener('click', function() {
            if (currentRowToRemove) {
                const rowToRemove = document.querySelector(
                    `.member-row[data-row-number="${currentRowToRemove}"]`);
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
                    removeBtn.setAttribute('onclick',
                        `confirmRemoveMember(${rowNumber}, ${memberId || 'null'})`);
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
                // Update input IDs and events
                const inputs = row.querySelectorAll(`input[name="${field}[]"]`);
                inputs.forEach(input => {
                    input.id = `${field}${newIndex}`;
                    // Only add onkeyup for text fields
                    if (input.type === 'text') {
                        input.setAttribute('onkeyup', `validateData(this,'${field}${newIndex}')`);
                    }
                    if (field === 'aadhar_no') {
                        input.setAttribute('onblur',
                            `checkAadhaarExist(this,${input.value || 'null'})`);
                    }
                });
                // Update select IDs and events
                const selects = row.querySelectorAll(`select[name="${field}[]"]`);
                selects.forEach(select => {
                    select.id = `${field}${newIndex}`;
                    select.setAttribute('onchange', `validateData(this,'${field}${newIndex}')`);
                });
                // Update ALL error spans for this field in the row
                const errorSpans = row.querySelectorAll(`span[id^="${field}"]`);
                errorSpans.forEach((errorSpan) => {
                    errorSpan.id = `${field}${newIndex}`;
                });
            });
            // Update member_id hidden field
            const memberIdInput = row.querySelector('input[name="member_id[]"]');
            if (memberIdInput) {
                memberIdInput.id = `member_id${newIndex}`;
            }
        }

        /* function addMoreMember() {
            $('#addMemberBtn').prop('disabled', true);

            const memberRows = document.querySelectorAll('.member-row');
            const newIndex = memberRows.length;
            const newRowNumber = newIndex + 1;

            // Clone the first row
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

            // Update IDs and handlers
            firstRow.setAttribute('data-row-number', newRowNumber);
            firstRow.querySelector('.member-number').textContent = `Member #${newRowNumber}`;

            // Add remove button
            const removeBtn = firstRow.querySelector('.formremoveBtn');
            if (removeBtn) {
                removeBtn.style.display = 'block';
                removeBtn.setAttribute('onclick', `confirmRemoveMember(${newRowNumber})`);
            } else {
                const newRemoveBtn = document.createElement('button');
                newRemoveBtn.className = 'formremoveBtn';
                newRemoveBtn.innerHTML = '<i class="uil-times"></i>';
                newRemoveBtn.onclick = function() {
                    confirmRemoveMember(newRowNumber);
                };
                firstRow.querySelector('.member-header').appendChild(newRemoveBtn);
            }

            // Clear member ID
            const memberIdInput = firstRow.querySelector('input[name="member_id[]"]');
            if (memberIdInput) {
                memberIdInput.value = '';
            }

            updateFieldIds(firstRow, newIndex);

            // Append to container
            document.getElementById('more_member').appendChild(firstRow);

            // Scroll to the new member
            firstRow.scrollIntoView({
                behavior: 'smooth'
            });
        } */
    </script>
@endsection
