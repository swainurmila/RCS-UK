@extends('layouts.app')


@section('content')
    <div class="page-content">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">{{ __('messages.dashboard') }}</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a
                                    href="javascript: void(0);">{{ __('messages.cooperatives_department') }}</a>
                            </li>
                            <li class="breadcrumb-item active">{{ __('messages.dashboard') }}</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card ">
                    <div class="card-body p-0">
                        <div class="row dash-card-row">
                            <div class="dash-col">
                                <div class="card dash-card card1">
                                    <div class="card-body dash-card-body">
                                        <div class="dash-img"> <img src="/assets/images/society.png" class="img-fluid">
                                        </div>
                                        <p class="mb-0">Total Society</p>
                                        <h4 class="mb-1 mt-1"><span data-plugin="counterup">10</span></h4>
                                        <button class="text-muted text-value btn btn-outline-primary" id="viewDetails">
                                            View Details
                                        </button>
                                    </div>
                                </div>
                            </div> <!-- end col-->
                            <div class="dash-col">
                                <div class="card dash-card card2">
                                    <div class="card-body dash-card-body">
                                        <div class="dash-img"> <img src="/assets/images/approved.png" class="img-fluid">
                                        </div>
                                        <p class="mb-0">Total Approved</p>
                                        <h4 class="mb-1 mt-1"><span data-plugin="counterup">1</span></h4>
                                        <button class="text-muted text-value btn btn-outline-primary" id="appviewDetails">
                                            View Details
                                        </button>
                                    </div>
                                </div>
                            </div> <!-- end col-->
                            <div class="dash-col">
                                <div class="card dash-card card3">
                                    <div class="card-body dash-card-body">
                                        <div class="dash-img"><img src="/assets/images/pending.png" class="img-fluid">
                                        </div>
                                        <p class="mb-0">Total Pending</p>
                                        <h4 class="mb-1 mt-1"><span data-plugin="counterup">1</span></h4>
                                        <button class="text-muted text-value btn btn-outline-primary"
                                            id="pendingviewDetails">
                                            View Details
                                        </button>
                                    </div>
                                </div>
                            </div> <!-- end col-->
                            <div class="dash-col">
                                <div class="card dash-card card4">
                                    <div class="card-body dash-card-body">
                                        <div class="dash-img"><img src="/assets/images/rejected.png" class="img-fluid">
                                        </div>
                                        <p class="mb-0">Total Rejected</p>
                                        <h4 class="mb-1 mt-1"><span data-plugin="counterup">0</span></h4>
                                        <button type="button">View Details</button>
                                    </div>
                                </div>
                            </div> <!-- end col-->
                            <div class="dash-col">
                                <div class="card dash-card card5">
                                    <div class="card-body dash-card-body">
                                        <div class="dash-img"><img src="/assets/images/members.png" class="img-fluid">
                                        </div>
                                        <p class="mb-0">Total Members</p>
                                        <h4 class="mb-1 mt-1"><span data-plugin="counterup">10</span></h4>
                                        <button class="text-muted text-value btn btn-outline-primary"
                                            id="membertableModaldetails">
                                            View Details
                                        </button>
                                    </div>
                                </div>
                            </div> <!-- end col-->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-lg-6">

                <div class="card dash-card">

                    <div class="card-body">

                        <div class="row mb-4">

                            <div class="col-lg-4">

                                <h4 class="cstm-card-title m-0">Approved Society Status</h4>

                            </div>

                            <div class="col-lg-8 d-flex align-item filter-wrapper">

                                <select class="form-control select2 form-select">

                                    <option>Month Wise</option>

                                    <option value="AK">January</option>

                                    <option value="HI">February</option>

                                </select>

                                <select class="form-control select2 form-select">

                                    <option>Year Wise</option>

                                    <option value="AK">2023</option>

                                    <option value="HI">2024</option>

                                </select>

                                <button type="button" class="btn btn-sm btn-primary">Filter</button>

                            </div>

                        </div>





                        <div id="project_status" data-colors='["#22af13", "#f85908", "#E91E63"]' class="apex-charts"
                            dir="ltr"></div>

                    </div>

                </div><!--end card-->

            </div>



            <div class="col-xl-3">

                <div class="card dash-card">

                    <div class="card-body">

                        <h4 class="cstm-card-title mb-4">Pending Society</h4>



                        <div id="project_pending" data-colors='["--bs-success", "--bs-warning"]' class="apex-charts"
                            dir="ltr"></div>

                    </div>

                </div><!--end card-->

            </div>



            <div class="col-lg-3">
                <div class="card dash-card">
                    <div class="card-body">
                        <h4 class="cstm-card-title mb-4">Rejected Society</h4>
                        <div id="rejected_project" data-colors='["--bs-success", "--bs-danger"]' class="apex-charts"
                            dir="ltr"></div>

                    </div>

                </div>

            </div>

        </div>


    </div>
    </div>
    </div>
@endsection