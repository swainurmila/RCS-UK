@extends('layouts.app')


@section('content')
<main class="main-content" class="page-content">

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Application form for registration Of co-operative society</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Cooperatives
                                        Department</a></li>
                                <li class="breadcrumb-item active">New Registration</li>
                            </ol>
                        </div>

                    </div>
                    <p>(Submitted under Section 06 of the Uttar Pradesh State Cooperative Societies Act, 2003)</p>
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
                                                    <a class="nav-link active" id="nav-link-1" data-bs-toggle="tab"
                                                        href="#step1" role="tab">
                                                        <span class="d-none d-sm-block">Step 01</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="nav-link-2" data-bs-toggle="tab"
                                                        href="#step2" role="tab">
                                                        <span class="d-none d-sm-block">Step 02</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="nav-link-3" data-bs-toggle="tab"
                                                        href="#step3" role="tab">
                                                        <span class="d-none d-sm-block">Step 03</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="nav-link-4" data-bs-toggle="tab"
                                                        href="#step4" role="tab">
                                                        <span class="d-none d-sm-block">Step 04</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="nav-link-5" data-bs-toggle="tab"
                                                        href="#step5" role="tab">
                                                        <span class="d-none d-sm-block">Step 05</span>
                                                    </a>
                                                </li>
                                            </ul>

                                            <!-- Tab panes -->
                                            <div class="tab-content p-3 text-muted">
                                                <div class="tab-pane active" id="step1" role="tabpanel">
                                                    <form id="step_form1">
                                                        @csrf
                                                        <!-- Society Details -->
                                                        <div class="mb-3 row">
                                                            <label for="example-text-input"
                                                                class="col-md-4 col-form-label fw-bold">1. Proposed
                                                                Society Name :</label>
                                                            <div class="col-md-8">
                                                                <input class="form-control form-control-sm" name="step"
                                                                    type="hidden" value="1" />
                                                                <input class="form-control form-control-sm" type="text"
                                                                    name="society_name" value="" required>
                                                                @if ($errors->has('society_name'))
                                                                <span
                                                                    class="error">{{ $errors->first('society_name') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>


                                                        <!-- Address Section -->
                                                        <label for="example-text-input"
                                                            class="col-form-label fw-bold">2.
                                                            Proposed Society
                                                            Headquarters :</label>
                                                        <fieldset class="border p-3 mb-3">
                                                            <div class="row g-3">
                                                                <div class="col-md-6">
                                                                    <label for="village"
                                                                        class="form-label">Village/Locality
                                                                        Name:</label>
                                                                    <input type="text" class="form-control" id="village"
                                                                        name="locality" required>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="postOffice" class="form-label">Post
                                                                        Office:</label>
                                                                    <input type="text" class="form-control"
                                                                        name="post_office" id="postOffice" required>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="developmentArea"
                                                                        class="form-label">Development Area:</label>
                                                                    <input type="text" class="form-control"
                                                                        name="developement_area" id="developmentArea"
                                                                        required>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="tehsil"
                                                                        class="form-label">Tehsil:</label>
                                                                    <input type="text" class="form-control" id="tehsil"
                                                                        name="tehsil" required>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="district"
                                                                        class="form-label">District:</label>
                                                                    <input type="text" class="form-control"
                                                                        name="district" id="district" required>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="nearestStation"
                                                                        class="form-label">Nearest
                                                                        Railway Station/Bus
                                                                        Station:</label>
                                                                    <input type="text" class="form-control"
                                                                        name="nearest_station" id="nearestStation"
                                                                        required>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                        <!-- Category of the Society -->
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">3. Category of the
                                                                Society:</label>
                                                            <div class="d-flex justify-content-evenly">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="society_category" id="primary" value="1"
                                                                        required>
                                                                    <label class="form-check-label ms-2"
                                                                        for="primary">Primary</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="society_category" id="centralApex"
                                                                        value="2">
                                                                    <label class="form-check-label ms-2"
                                                                        for="centralApex">Central or Apex</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="society_category" id="agricultural"
                                                                        value="3">
                                                                    <label class="form-check-label ms-2"
                                                                        for="agricultural">Agricultural</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <button class="btn btn-primary float-end" type="button"
                                                                onclick="nextStep(1)">Save & Submit</button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="tab-pane" id="step2" role="tabpanel">
                                                    <form id="step_form2" enctype="multipart/form-data">
                                                        @csrf
                                                        <!-- Responsibilities -->
                                                        <label for="example-text-input"
                                                            class="col-form-label fw-bold">4.
                                                            Responsibilities of
                                                            Society Members :</label>
                                                        <fieldset class="border p-3 mb-3">
                                                            <!-- <legend class="w-auto px-2"></legend> -->
                                                            <div class="col-md-6">
                                                                <input type="hidden" id="societyDetailsId" value=""
                                                                    name="societyDetailsId" />
                                                                <input type="hidden" value="2" name="step" />
                                                                <input class="form-check-input" type="radio"
                                                                    onclick="showDiv('show','responsibility_type')"
                                                                    name="member_responsibility_type" id="withoutShares"
                                                                    value="1" required>
                                                                <label class="form-label fw-bold">(a) Society’s capital
                                                                    up to the final valuation :</label>
                                                                <div id="responsibility_type" style="display: none;">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="capital_valuation_type"
                                                                            id="withoutShares"
                                                                            onclick="showDiv('hide','share_val')"
                                                                            value="1" required>
                                                                        <label class="form-check-label ms-2"
                                                                            for="withoutShares">Without shares</label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="capital_valuation_type"
                                                                            id="withShares"
                                                                            onclick="showDiv('show','share_val')"
                                                                            value="2">
                                                                        <label class="form-check-label ms-2"
                                                                            for="withShares">With definite share
                                                                            capital</label>
                                                                    </div>
                                                                    <div id="share_val" style="display:none;">
                                                                        <input class="form-control form-control-sm"
                                                                            type="text" name="capital_amount" value="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input class="form-check-input" type="radio"
                                                                    onclick="showDiv('hide','responsibility_type')"
                                                                    name="member_responsibility_type" value="2"
                                                                    required>
                                                                <label class="form-label fw-bold">(b) Indefinite</label>
                                                            </div>
                                                        </fieldset>

                                                        <!-- Operational Area -->
                                                        <div class="mb-3 row">
                                                            <label for="example-text-input"
                                                                class="col-md-6 col-form-label fw-bold">5. Operational
                                                                Area of the Proposed Society :</label>
                                                            <div class="col-md-6">
                                                                <input class="form-control form-control-sm" type="text"
                                                                    name="society_operational_area" value="">
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 row">
                                                            <label for="example-text-input"
                                                                class="col-md-6 col-form-label fw-bold">6. Main
                                                                Objectives of the Proposed Society :</label>
                                                            <div class="col-md-6">
                                                                <input class="form-control form-control-sm" type="text"
                                                                    name="society_objective" value="">
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 row">
                                                            <label for="example-text-input"
                                                                class="col-md-6 col-form-label fw-bold">7. Number and
                                                                Value of Shares to Be Issued as per Provisions (if any
                                                                prescribed) :</label>
                                                            <div class="col-md-6">
                                                                <input class="form-control form-control-sm"
                                                                    type="number" name="society_share_value" value="">
                                                            </div>
                                                        </div>

                                                        <div class="mb-3 row">
                                                            <label for="example-text-input"
                                                                class="col-md-6 col-form-label fw-bold">8. Value and
                                                                Rate of Each Share for Subscription Payment :</label>
                                                            <div class="col-md-6">
                                                                <input class="form-control form-control-sm"
                                                                    type="number" name="subscription_rate" value="">
                                                            </div>
                                                        </div>

                                                        <div class="mb-3 row">
                                                            <label for="example-text-input"
                                                                class="col-md-6 col-form-label fw-bold">9. Liabilities
                                                                of Members :</label>
                                                            <div class="col-md-6">
                                                                <input class="form-control form-control-sm" type="text"
                                                                    name="member_liability" value="">
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 row">
                                                            <label for="example-text-input"
                                                                class="col-md-6 col-form-label fw-bold">10. Number of
                                                                Individuals Who Have Agreed to Become General Members of
                                                                the Proposed Society : </label>
                                                            <div class="col-md-6">
                                                                <input class="form-control form-control-sm"
                                                                    type="number" name="general_member_count" value="">
                                                            </div>
                                                        </div>

                                                        <div class="mb-3 row">
                                                            <label for="example-text-input"
                                                                class="col-md-6 col-form-label fw-bold">11. Language in
                                                                Which the Proposed Society’s Records Will Be
                                                                Maintained:</label>
                                                            <div class="col-md-6">
                                                                <select class="form-control"
                                                                    name="society_record_language">
                                                                    <option value="">Select Language</option>
                                                                    <option value="1">English</option>
                                                                    <option value="2">Hindi</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <label for="example-text-input"
                                                            class="col-form-label fw-bold">12.
                                                            Full Name and Address
                                                            :</label>
                                                        <fieldset class="border p-3 mb-3">
                                                            <legend class="w-auto px-2"></legend>
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label fw-bold">(a) Proposed Main
                                                                    Representative (First Signature) :</label>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <div class="col-md-4">
                                                                    <input type="text"
                                                                        class="form-control col-md-4 form-control-sm"
                                                                        name="society_representative_name"
                                                                        placeholder="Representative's Name" value="" />
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <input type="text"
                                                                        class="form-control col-md-4 form-control-sm"
                                                                        placeholder="Representative's Address"
                                                                        name="society_representative_address"
                                                                        value="" />
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <input type="file"
                                                                        class="form-control col-md-4 form-control-sm"
                                                                        placeholder="Representative's Signature"
                                                                        name="society_representative_signature"
                                                                        value="" />
                                                                </div>

                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label class="form-label fw-bold">(b) Proposed Society
                                                                    Secretary </label>
                                                                <div class="col-md-4">
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        placeholder="Secretary's Name"
                                                                        name="society_secretary_name" value="" />
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        placeholder="Secretary's Address"
                                                                        name="society_secretary_address" value="" />
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <input type="file"
                                                                        class="form-control col-md-4 form-control-sm"
                                                                        placeholder="Secretary's Signature"
                                                                        name="society_secretary_signature" value="" />
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                        <div class="d-flex justify-content-between">
                                                            <a class="btn btn-secondary" type="button" href=""
                                                                style="width: 12%;">Back</a>
                                                            <button class="btn btn-primary" type="button"
                                                                onclick="nextStep(2)">Save &
                                                                Submit</button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="tab-pane" id="step3" role="tabpanel">

                                                    <form id="step_form3" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="mb-3 row">
                                                            <label for="example-text-input"
                                                                class="col-md-12 col-form-label fw-bold">14. Names of
                                                                Individuals Elected as Members of the Temporary
                                                                Committee, Who Will Manage the Society’s Affairs for a
                                                                Period of 90 Days or Until Extended by Written Order of
                                                                the Registrar: </label>
                                                            <!-- <div class="col-md-3">
                                                                                                                                                                                                                <input class="form-control form-control-sm" type="text"
                                                                                                                                                                                                                    value="">
                                                                                                                                                                                                            </div> -->
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label class="form-label fw-bold">List of Members</label>
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th scope="col">#Sl.No</th>
                                                                        <th scope="col">Name</th>
                                                                        <th scope="col">Father's/Husband’s Name</th>
                                                                        <th scope="col">Full Address</th>
                                                                        <th scope="col">Designation</th>
                                                                        <th scope="col">Signature</th>

                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <th scope="row">1</th>
                                                                        <td>Mark</td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">2</th>
                                                                        <td>Jacob</td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">3</th>
                                                                        <td>Larry</td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="row mb-3">

                                                            <div class="form-check">

                                                                <label class="form-label fw-bold">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="is_declared" required>
                                                                    Declaration for
                                                                    Registration</label>
                                                            </div>
                                                            <p>We, the undersigned, declare that during the period of
                                                                the proposed society’s registration, we will comply with
                                                                the provisions of the Uttar Pradesh Cooperative
                                                                Societies Act, Rules, and Regulations.</p>
                                                            <!-- <table class="table">
                                                                                                                                                                                                                <thead>
                                                                                                                                                                                                                    <tr>
                                                                                                                                                                                                                        <th scope="col">#Sl.No</th>
                                                                                                                                                                                                                        <th scope="col">Name</th>
                                                                                                                                                                                                                        <th scope="col">Father's/Husband’s Name</th>
                                                                                                                                                                                                                        <th scope="col">Address</th>
                                                                                                                                                                                                                        <th scope="col">Business</th>
                                                                                                                                                                                                                        <th scope="col">Designation</th>
                                                                                                                                                                                                                        <th scope="col">Signature</th>

                                                                                                                                                                                                                    </tr>
                                                                                                                                                                                                                </thead>
                                                                                                                                                                                                                <tbody>
                                                                                                                                                                                                                    <tr>
                                                                                                                                                                                                                        <th scope="row">1</th>
                                                                                                                                                                                                                        <td>Mark</td>
                                                                                                                                                                                                                        <td></td>
                                                                                                                                                                                                                        <td></td>
                                                                                                                                                                                                                        <td></td>
                                                                                                                                                                                                                        <td></td>
                                                                                                                                                                                                                        <td></td>

                                                                                                                                                                                                                    </tr>
                                                                                                                                                                                                                    <tr>
                                                                                                                                                                                                                        <th scope="row">2</th>
                                                                                                                                                                                                                        <td>Jacob</td>
                                                                                                                                                                                                                        <td></td>
                                                                                                                                                                                                                        <td></td>
                                                                                                                                                                                                                        <td></td>
                                                                                                                                                                                                                        <td></td>

                                                                                                                                                                                                                        <td></td>
                                                                                                                                                                                                                    </tr>
                                                                                                                                                                                                                    <tr>
                                                                                                                                                                                                                        <th scope="row">3</th>
                                                                                                                                                                                                                        <td>Larry</td>
                                                                                                                                                                                                                        <td></td>
                                                                                                                                                                                                                        <td></td>
                                                                                                                                                                                                                        <td></td>
                                                                                                                                                                                                                        <td></td>
                                                                                                                                                                                                                        <td></td>

                                                                                                                                                                                                                    </tr>
                                                                                                                                                                                                                </tbody>
                                                                                                                                                                                                            </table> -->
                                                        </div>
                                                        <div class="d-flex justify-content-between">
                                                            <a class="btn btn-secondary" type="button" href=""
                                                                style="width: 12%;">Back</a>
                                                            <button class="btn btn-primary" type="button"
                                                                onclick="nextStep(3)">Save &
                                                                Submit</button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="tab-pane" id="step4" role="tabpanel">
                                                    <form id="step_form4">
                                                        <h6 class="fw-bold">Feasibility Report for Registration</h6>
                                                        <div class="mb-3 row">
                                                            <label for="example-text-input"
                                                                class="col-md-8 col-form-label fw-bold">1. Society Name
                                                            </label>
                                                            <div class="col-md-4">
                                                                <input class="form-control form-control-sm" type="text"
                                                                    value="">
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 row">
                                                            <label for="example-text-input"
                                                                class="col-md-8 col-form-label fw-bold">2. How Was the
                                                                Proposal for the Society Formed?</label>
                                                            <div class="col-md-4">
                                                                <input class="form-control form-control-sm" type="text"
                                                                    value="">
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 row">
                                                            <label for="example-text-input"
                                                                class="col-md-8 col-form-label fw-bold">3. If It Is a
                                                                Village Society, Is It Based on a Mutual Interest or
                                                                Cooperative Model?</label>
                                                            <div class="col-md-4">
                                                                <label for="society_type">
                                                                    <input class="form-check-input"
                                                                        onclick="showDiv('show','society_based_on')"
                                                                        name="society_type" type="radio" value="1" />Yes
                                                                </label>
                                                                <label for="society_type"><input
                                                                        class="form-check-input"
                                                                        onclick="showDiv('hide','society_based_on')"
                                                                        name="society_type" type="radio" value="0" />No
                                                                </label>

                                                                <div class="col-md-4" id="society_based_on"
                                                                    style="display:none">
                                                                    <label><input class="form-check-input" type="radio"
                                                                            name="society_based_on" value="1">Mutual
                                                                        Interest</label>
                                                                    <label><input class="form-check-input" type="radio"
                                                                            name="society_based_on"
                                                                            value="2">Cooperative
                                                                        Model</label>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label for="example-text-input"
                                                                    class="col-md-6 col-form-label fw-bold">4. Which
                                                                    Bank or
                                                                    Central Bank Will the Society Be Associated With,
                                                                    and
                                                                    What Is the Distance Between Them?</label>
                                                                <div class="col-md-3">
                                                                    <input class="form-control form-control-sm"
                                                                        placeholder="Enter bank name" type="text"
                                                                        name="bank_name" value="">
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <input class="form-control form-control-sm"
                                                                        placeholder="Enter distance from bank"
                                                                        type="text" name="society_bank_distance"
                                                                        value="">
                                                                </div>
                                                            </div>

                                                            <label for="example-text-input"
                                                                class="col-form-label fw-bold">5.
                                                                Membership
                                                                Criteria:</label>
                                                            <fieldset class="border p-3 mb-3">
                                                                <legend class="w-auto px-2"></legend>
                                                                <div class="mb-3">
                                                                    <label class="form-label fw-bold">(a) How many
                                                                        individuals are eligible for membership?</label>
                                                                    <input class="form-control" name="membership_limit"
                                                                        type="number">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label fw-bold">(b) How many
                                                                        individuals are ready to join?</label>
                                                                    <input class="form-control"
                                                                        name="total_members_ready_to_join"
                                                                        type="number">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label fw-bold">(c) Are most
                                                                        members active and involved?</label>
                                                                    <label><input class="form-check-input" type="radio"
                                                                            name="is_member_active" value="1">Yes
                                                                    </label>
                                                                    <label><input class="form-check-input" type="radio"
                                                                            name="is_member_active" value="2">No
                                                                    </label>
                                                                </div>
                                                            </fieldset>

                                                            <label for="example-text-input"
                                                                class="col-form-label fw-bold">6.
                                                                Are Panchayat Officials
                                                                Supportive of the Society and Keeping Influence Over
                                                                It?</label>
                                                            <fieldset class="border p-3 mb-3">
                                                                <legend class="w-auto px-2"></legend>
                                                                <div class="mb-3">
                                                                    <label class="form-label fw-bold">Names of Proposed
                                                                        Chairman :</label>
                                                                    <input class="form-control" name="chairman_name"
                                                                        placeholder="Enter Chairman name" type="text"
                                                                        value="">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label fw-bold">Names of Proposed
                                                                        Secretary:</label>
                                                                    <input class="form-control" name="secretary_name"
                                                                        placeholder="Enter Secretary name" type="text"
                                                                        value="">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label fw-bold">Have the Society
                                                                        Members Understood Their Rights and
                                                                        Responsibilities?</label>
                                                                    <input class="form-check-input"
                                                                        name="is_member_understood_rights" type="radio"
                                                                        value="1" />Yes
                                                                    <input class="form-check-input"
                                                                        name="is_member_understood_rights" type="radio"
                                                                        value="0" />No
                                                                </div>
                                                            </fieldset>
                                                            <div class="mb-3 row">
                                                                <label for="example-text-input"
                                                                    class="col-md-6 col-form-label fw-bold">7. Are
                                                                    Members Aware of the Society’s Objectives, the
                                                                    Importance of the Meeting, and Their
                                                                    Responsibilities?</label>
                                                                <div class="col-md-6">
                                                                    <input class="form-check-input"
                                                                        name="is_member_awared_objectives" type="radio"
                                                                        value="1" />Yes
                                                                    <input class="form-check-input"
                                                                        name="is_member_awared_objectives" type="radio"
                                                                        value="0" />No
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label for="example-text-input"
                                                                    class="col-md-6 col-form-label fw-bold">8. Is There
                                                                    Any Existing Cooperative Society in the Area? If
                                                                    Yes, Provide Details:</label>
                                                                <div class="col-md-3">
                                                                    <input class="form-check-input"
                                                                        name="is_existing_society" type="radio"
                                                                        onclick="showDiv('show','society_details')"
                                                                        value="1" />Yes
                                                                    <input class="form-check-input"
                                                                        name="is_existing_society" type="radio"
                                                                        onclick="showDiv('hide','society_details')"
                                                                        value="0" />No
                                                                </div>
                                                                <div class="col-md-3" id="society_details"
                                                                    style="display:none;">
                                                                    <input class="form-control"
                                                                        name="existing_society_details" type="textarea"
                                                                        value="" />

                                                                </div>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label for="example-text-input"
                                                                    class="col-md-6 col-form-label fw-bold">9. Time
                                                                    Taken for Forming the Society and Proposed Date of
                                                                    Registration:</label>
                                                                <div class="col-md-3">
                                                                    <input class="form-control form-control-sm"
                                                                        type="number"
                                                                        placeholder="Enter time taken for society completion"
                                                                        name="society_completion_time" value="">
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <input class="form-control form-control-sm"
                                                                        type="date"
                                                                        placeholder="Proposed registration date"
                                                                        name="society_registration_date" value="">
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label for="example-text-input"
                                                                    class="col-md-6 col-form-label fw-bold">
                                                                    10. Additional Information</label>
                                                                <div class="col-md-6">
                                                                    <input class="form-control form-control-sm"
                                                                        type="text" name="additional_info" value="">
                                                                </div>
                                                            </div>
                                                            <div class="d-flex justify-content-between">
                                                                <a class="btn btn-secondary" type="button" href=""
                                                                    style="width: 12%;">Back</a>
                                                                <button class="btn btn-primary" type="button"
                                                                    onclick="nextStep(4)">Save &
                                                                    Submit</button>
                                                            </div>
                                                    </form>
                                                </div>
                                                <div class="tab-pane" id="step5" role="tabpanel">
                                                    <form id="step_form5" enctype="multipart/form-data">
                                                        <div class="mb-3 row">
                                                            <label for="example-text-input"
                                                                class="col-md-4 col-form-label fw-bold">Signatures for
                                                                Registration Proposal (With Designations)</label>
                                                            <div class="col-md-3">
                                                                <input class="form-control form-control-sm" type="text"
                                                                    name="authority_name" placeholder="Enter your Name"
                                                                    value="">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input class="form-control form-control-sm" type="text"
                                                                    name="authority_designation"
                                                                    placeholder="Enter your designation" value="">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <input class="form-control form-control-sm" type="file"
                                                                    name="authority_signature"
                                                                    placeholder="Upload the Signature" value="">
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 row">
                                                            <label for="example-text-input" class="fw-bold">District
                                                                Cooperative Society Officer’s Report</label>
                                                            <p>"I am satisfied with the management and feasibility study
                                                                of the society. The registration of the society is
                                                                recommended."</p>
                                                        </div>
                                                        <div class="d-flex justify-content-between">
                                                            <a class="btn btn-secondary" type="button" href=""
                                                                style="width: 12%;">Back</a>
                                                            <button class="btn btn-primary" type="button"
                                                                onclick="nextStep(5)">Save &
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


                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>
@endsection
@section("js")
<script>
    let currentStep = 1;

    function showStep(step) {
        $("#step" + step).addClass("active");
    }

    function showDiv(show_type, div_id) {
        if (show_type == "show") {
            $("#" + div_id).show();
        } else {
            $("#" + div_id).hide();
        }
    }

    function nextStep(stepVal) {
        var step = stepVal;
        if (step) {
            var form_data = $("#step_form" + step).serialize();
            console.log(690, form_data)
            $.ajax({
                url: "{{ route('society.registration ') }}",
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    form_data
                },
                beforeSend: function() {},
                success: function(response) {
                    console.log(11, response);
                    $("#nav-link-" + step).removeClass("active");
                    $("#nav-link-" + response.nextStep).addClass("active");
                    $("#step" + step).removeClass("active");
                    $("#step" + response.nextStep).addClass("active");
                    $("#societyDetailsId").val(response.societyDetailsId);
                    // Handle success response
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    console.log(11, error);
                    $('#response-message').html('<strong>Error:</strong> Something went wrong.');
                },
                complete: function() {

                }
            });

        }
    }

    function previousStep(step) {
        currentStep--;
        showStep(currentStep);
    }

    // Initialize the form by showing the first step
    showStep(currentStep);
</script>
@endsection