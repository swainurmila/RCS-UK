@extends('layouts.app')


@section('content')

    <div class="container-fluid">
        <div class="page-content">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">{{ __('messages.SocietyMemberList') }}</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a
                                        href="javascript: void(0);">{{ __('messages.CooperativesDepartment') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('messages.SocietyMember') }}</li>
                            </ol>
                        </div>

                    </div>
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
                                            <table id="asd" class="table table-striped table-hover" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>{{ __('messages.SINo') }}</th>
                                                        <th>{{ __('messages.MemberName') }}</th>
                                                        <th>{{ __('messages.MemberType') }}</th>
                                                        <th>{{ __('messages.Gender') }}</th>
                                                        <th>{{ __('messages.Category') }}</th>
                                                        <th>{{ __('messages.Address') }}</th>
                                                        <th>{{ __('messages.NumberofParts') }}</th>
                                                        <th>{{ __('messages.Action') }}</th>
                                                    </tr>
                                                </thead>
                                                {{-- <tbody>
                                                    <tr>
                                                        <td colspan="8">
                                                            <div style="text-align: center;">No Data Found</div>
                                                        </td>
                                                    </tr>
                                                </tbody> --}}



                                                <tbody>
                                                    @php $counter = 1; @endphp
                                                    @forelse($getSocietyDetail as $appDetail)
                                                        @if ($appDetail->society_details && $appDetail->society_details->members)
                                                            @foreach ($appDetail->society_details->members as $member)
                                                                <tr>
                                                                    <td>{{ $counter++ }}</td>
                                                                    <td>{{ $member->name ?? '-' }}</td>
                                                                    <td>Member</td>
                                                                    <td>

                                                                        @if (!empty($member->gender))
                                                                            @if ($member->gender == 1)
                                                                                {{ 'Male' }}
                                                                            @elseif($member->gender == 2)
                                                                                {{ 'Female' }}
                                                                            @elseif($member->gender == 3)
                                                                                {{ 'Transgender' }}
                                                                            @else
                                                                                {{ 'NA' }}
                                                                            @endif
                                                                        @endif

                                                                    </td>
                                                                    <td>{{ $member->category ?? '-' }}</td>
                                                                    <td>{{ $member->address ?? '-' }}</td>
                                                                    <td>--</td> {{-- Replace with actual part count if available --}}
                                                                    <td>
                                                                        <button class="btn btn-sm btn-primary"><i
                                                                                class="fas fa-edit"></i></button>
                                                                        <button class="btn btn-sm btn-danger"><i
                                                                                class="fas fa-trash"></i></button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                    @empty
                                                        <tr>
                                                            <td colspan="8">
                                                                <div style="text-align: center;">No Data Found</div>
                                                            </td>
                                                        </tr>
                                                    @endforelse
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
            </div>

        </div>

@endsection