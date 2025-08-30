@extends('layouts.app')


@section('content')
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
    <!-- start page title -->

    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body p-0 dash-body">

                    <div class="row">
                        <div class="dash-col">
                            <div class="dash-card-body">
                                <div class="card-img" style="background: #e1e5fb;">
                                    <img src="/assets/images/dash-icons/registration.png" class="img-fluid">
                                </div>
                                <h4 class="mb-1 mt-1">
                                    Registration of Co-operative
                                </h4>
                                <a href="{{ url('/dashboard') }}" class="dash-login">
                                    <span> View</span>
                                    <i class="fas fa-long-arrow-alt-right"></i>
                                </a>
                            </div>
                        </div>

                        <div class="dash-col">
                            <div class="dash-card-body">
                                <div class="card-img" style="background: #e2eed3;">
                                    <img src="/assets/images/dash-icons/laws.png" class="img-fluid">
                                </div>
                                <h4 class="mb-1 mt-1">
                                    Amendment of By-Laws
                                </h4>
                                <a href={{ route('show.ablm_dashboard') }} class="dash-login">
                                    <span>View</span>
                                    <i class="fas fa-long-arrow-alt-right"></i>
                                </a>
                            </div>
                        </div>

                        <div class="dash-col">
                            <div class="dash-card-body">
                                <div class="card-img" style="background: #d7eef0;">
                                    <img src="/assets/images/dash-icons/return.png" class="img-fluid">
                                </div>
                                <h4 class="mb-1 mt-1">
                                    Annual Return Filling
                                </h4>
                                <a href="#" class="dash-login" style="margin-top:38px;">
                                    <span> View</span>
                                    <i class="fas fa-long-arrow-alt-right"></i>
                                </a>
                            </div>
                        </div>

                        <div class="dash-col">
                            <div class="dash-card-body">
                                <div class="card-img" style="background: #f1e3f4;">
                                    <img src="/assets/images/dash-icons/membership.png" class="img-fluid">
                                </div>
                                <h4 class="mb-1 mt-1">
                                    Assets Management System
                                </h4>
                                <a href="#" class="dash-login">
                                    <span> View</span>
                                    <i class="fas fa-long-arrow-alt-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="dash-col">
                            <div class="dash-card-body">
                                <div class="card-img" style="background: #f7e5e7;">
                                    <img src="/assets/images/dash-icons/settlement.png" class="img-fluid">
                                </div>
                                <h4 class="mb-1 mt-1">
                                    Settlement of Disputes
                                </h4>
                                <a href="{{ route('show.settlement-dashboard') }}" class="dash-login">
                                    <span> View</span>
                                    <i class="fas fa-long-arrow-alt-right"></i>
                                </a>
                            </div>
                        </div>

                        <div class="dash-col">
                            <div class="dash-card-body">
                                <div class="card-img" style="background: #e8eff3;">
                                    <img src="/assets/images/dash-icons/audit.png" class="img-fluid">
                                </div>
                                <h4 class="mb-1 mt-1">
                                    Audit
                                </h4>
                                <a href="{{ route('audit.dashboard') }}" class="dash-login">
                                    <span> View</span>
                                    <i class="fas fa-long-arrow-alt-right"></i>
                                </a>
                            </div>
                        </div>

                        <div class="dash-col">
                            <div class="dash-card-body">
                                <div class="card-img" style="background:#f5efe3;">
                                    <img src="/assets/images/dash-icons/records.png" class="img-fluid">
                                </div>
                                <h4 class="mb-1 mt-1">
                                    Inspection of Records
                                </h4>
                                <a href="{{ route('inspection_dashboard.show') }}" class="dash-login">
                                    <span>View</span>
                                    <i class="fas fa-long-arrow-alt-right"></i>
                                </a>

                            </div>
                        </div>

                        <div class="dash-col">
                            <div class="dash-card-body">
                                <div class="card-img" style="background: #ffecf4;">
                                    <img src="/assets/images/dash-icons/liquidation.png" class="img-fluid">
                                </div>
                                <h4 class="mb-1 mt-1">
                                    Liquidation
                                </h4>
                                <a href="#" class="dash-login">
                                    <span> View</span>
                                    <i class="fas fa-long-arrow-alt-right"></i>
                                </a>
                            </div>
                        </div>

                        <div class="dash-col">
                            <div class="dash-card-body">
                                <div class="card-img" style="background:#e2f7eb;">
                                    <img src="/assets/images/dash-icons/complaints.png" class="img-fluid">
                                </div>
                                <h4 class="mb-1 mt-1">
                                    Complaints
                                </h4>
                                <a href="{{ route('show.complaint-dashboard') }}" class="dash-login">
                                    <span> View</span>
                                    <i class="fas fa-long-arrow-alt-right"></i>
                                </a>
                            </div>
                        </div>

                        <div class="dash-col">
                            <div class="dash-card-body">
                                <div class="card-img" style="background: #fff4e8;">
                                    <img src="/assets/images/dash-icons/election.png" class="img-fluid">
                                </div>
                                <h4 class="mb-1 mt-1">
                                    Election
                                </h4>
                                <a href="{{ route('show.election-dashboard') }}" class="dash-login">
                                    <span> View</span>
                                    <i class="fas fa-long-arrow-alt-right"></i>
                                </a>
                            </div>
                        </div>


                        <div class="dash-col">
                            <div class="dash-card-body">
                                <div class="card-img" style="background: #fff4e8;">
                                    <img src="/assets/images/dash-icons/election.png" class="img-fluid">
                                </div>
                                <h4 class="mb-1 mt-1">
                                    Appeal
                                </h4>
                                <a href="{{route('appeal.dashboard')}}"  class="dash-login">
                                    <span> View</span>
                                    <i class="fas fa-long-arrow-alt-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('js')
    <!-- jquery step -->
    <script src="{{ asset('assets/libs/jquery-steps/build/jquery.steps.min.js') }}"></script>

    <!-- apexcharts -->
    <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/apexcharts.init.js') }}"></script>
@endsection
