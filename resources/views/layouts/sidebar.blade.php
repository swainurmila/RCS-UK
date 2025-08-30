@php
$roleId = null;
if (auth()->check()) {
//dd(auth()->user());
$roleId = auth()->user()->roles->first()->id;
// dd($roleId);
}

@endphp

<div class="vertical-menu">
    <div data-simplebar class="sidebar-menu-scroll">
        <!--- Sidemenu -->
        <div id="sidebar-menu" class="">
            <ul class="metismenu list-unstyled" id="side-menu">
                @if (request()->is('*all-dashboard*') && $roleId != 1)
                <li>
                    <a href="{{ route('all.dashboard') }}">
                        <i class="uil-apps"></i><span>{{ __('messages.dashboard') }}</span>
                    </a>
                </li>
                @else
                <!-- super admin menu start-->
                @if ($roleId == 1)
                <li>
                    <a href="{{ route('users-index') }}">
                        <i class="uil-users-alt"></i><span>{{ __('messages.users') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('roles') }}">
                        <i class="uil-setting"></i><span>{{ __('messages.Roles') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('society-types.show') }}">
                        <i class="uil-apps"></i><span>Society Types</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('society-objectives.show') }}">
                        <i class="uil-apps"></i><span>Society Objectives</span>
                    </a>
                </li>
                @endif
                <!-- super admin menu end-->

                @if (request()->is('*complaint*'))
                <li>
                    <a href="{{ route('show.complaint-dashboard') }}">
                        <i class="uil-apps"></i><span>{{ __('messages.dashboard') }}</span>
                    </a>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect" aria-expanded="false">
                        <i class="uil-clipboard-notes"></i>
                        <span>{{ __('messages.complaints') }}</span>
                    </a>
                    <ul class="sub-menu mm-collapse" aria-expanded="false" style="">
                        <li>
                            <a class="waves-effect" href="{{ route('show.complaint') }}">
                                <i class="uil-calender"></i>
                                <span>{{ __('messages.Add-Complaint') }}</span>
                            </a>
                        </li>
                        <li>
                            <a class="waves-effect" href="{{ route('listing.complaint') }}">
                                <i class="uil-calender"></i>
                                <span>{{ __('messages.Complaint-List') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @elseif(request()->is('*election*'))
                <!-- Amendment menu start  -->
                <li>
                    <a href="{{ route('show.ablm_dashboard') }}">
                        <i class="uil-apps"></i><span>{{ __('messages.dashboard') }}</span>
                    </a>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect" aria-expanded="false">
                        <i class="uil-clipboard-notes"></i>
                        <span>{{ __('messages.election') }}</span>
                    </a>
                    <ul class="sub-menu mm-collapse" aria-expanded="false">
                        <li>
                            <a class="waves-effect" href="{{ route('election.show') }}">
                                <i class="uil-calender"></i>
                                <span>{{ __('messages.nomination-form') }}</span>
                            </a>
                        </li>
                        <li>
                            <a class="waves-effect" href="{{ route('nominations.index') }}">
                                <i class="uil-calender"></i>
                                <span>{{ __('messages.nomination-list') }}</span>
                            </a>
                        </li>

                    </ul>
                </li>
                @elseif(request()->is('*ammendment*'))
                <!-- Amendment menu start  -->
                <li>
                    <a href="{{ route('show.ablm_dashboard') }}">
                        <i class="uil-apps"></i><span>{{ __('messages.dashboard') }}</span>
                    </a>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect" aria-expanded="false">
                        <i class="uil-clipboard-notes"></i>
                        <span>{{ __('messages.By-lawamendment') }}</span>
                    </a>
                    <ul class="sub-menu mm-collapse" aria-expanded="false">
                        <li>
                            <a class="waves-effect" href="{{ route('amendment.show') }}">
                                <i class="uil-calender"></i>
                                <span>{{ __('messages.ApplyforBy-lawamendment') }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect" aria-expanded="false">
                                <i class="uil-clipboard-notes"></i>
                                <span>{{ __('messages.By-lawamendment') }}</span>
                            </a>
                            <ul class="sub-menu mm-collapse" aria-expanded="false">
                                <li>
                                    <a class="waves-effect" href="{{ route('amendment.show') }}">
                                        <i class="uil-calender"></i>
                                        <span>{{ __('messages.ApplyforBy-lawamendment') }}</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="waves-effect" href="{{ route('show.ablm_listing') }}">
                                        <i class="uil-calender"></i>
                                        <span> {{ __('messages.listofBy-lawamendment') }}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @elseif(request()->is('*audit*'))
                        <li>
                            <a href="{{ route('audit.dashboard') }}">
                                <i class="uil-apps"></i><span>Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('audit.dashboard') }}">
                                <i class="uil-apps"></i><span>Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('audit.dashboard') }}">
                                <i class="uil-apps"></i><span>Dashboard</span>
                            </a>
                        </li>
                        <!-- <li>
                            <a href="#">
                                <i class="uil-apps"></i><span>DAO</span>
                            </a>

                            <ul class="sub-menu mm-collapse" aria-expanded="false">
                                <li>
                                    <a href="{{ route('auditalotment') }}">
                                        <i class="uil-apps"></i><span>Audit Allotment</span>
                                    </a>
                                </li>
                                @if ($roleId == 8)
                                    <li>
                                        <a href="{{ route('auditlst') }}">
                                            <i class="uil-apps"></i><span>Audit Allotment List</span>
                                        </a>
                                    </li>
                                @endif
                                @if ($roleId == 7)
                                    <li>
                                        <a href="{{ route('audit-plan-approval-society') }}">
                                            <i class="uil-apps"></i><span>Audit Plan Approval</span>
                                        </a>
                                    </li>
                                @endif

                            </ul>
                        </li> -->
                        
                </li>
                <li>
                    <a href="{{ route('audit.auditForm') }}">
                        <i class="uil-apps"></i><span>Audit Form</span>
                    </a>
                    <ul>

                    </ul>
                </li>
                <li>
                    <a href="{{ route('audits.bank') }}">
                        <i class="uil-apps"></i><span>Bank Details</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('audits.society') }}">
                        <i class="uil-apps"></i><span>Society Details</span>
                    </a>
                </li>
                @elseif(request()->is('*inspection*'))
                <li>
                    <a href="{{ route('inspection_dashboard.show') }}">
                        <i class="uil-apps"></i><span>{{ __('messages.dashboard') }}</span>
                    </a>
                </li>
                @if (in_array($roleId, [3, 5, 6]))
                <li>
                    <a href="{{ route('inspection-record-list') }}">
                        <i class="uil-apps"></i><span>{{ __('messages.Inspection-Records-List') }}</span>
                    </a>
                </li>
                @endif

                @elseif (request()->is('*settlement*'))
                <li>
                    <a href="{{ route('show.settlement-dashboard') }}">
                        <i class="uil-apps"></i><span>{{ __('messages.dashboard') }}</span>
                    </a>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect" aria-expanded="false">
                        <i class="uil-clipboard-notes"></i>
                        <span>{{ __('messages.settlement') }}</span>
                    </a>
                    <ul class="sub-menu mm-collapse" aria-expanded="false" style="">
                        <li>
                            <a class="waves-effect" href="{{ route('add-settlement') }}">
                                <i class="uil-calender"></i>
                                <span>{{ __('messages.Add-Settlement') }}</span>
                            </a>
                        </li>
                        <li>
                            <a class="waves-effect" href="{{ route('listing.complaint') }}">
                                <i class="uil-calender"></i>
                                <span>{{ __('messages.List-Settlement') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @else
                @if ($roleId == 7)
                <li>
                    <a href="/dashboard">
                        <i class="uil-apps"></i><span>{{ __('messages.dashboard') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/society-registration') }}">
                        <i class="uil-invoice"></i><span>{{ __('messages.society_registration') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/social-regd-app-list') }}">
                        <i class="uil-invoice"></i><span>{{ __('messages.RegistrationStatus') }}</span>
                    </a>
                </li>

                <li>
                    <a href="{{ url('/society-member') }}">
                        <i class="uil-user-circle"></i><span>{{ __('messages.society_member') }}</span>
                    </a>
                </li>
                @else
                <li>
                    <a href="{{ url('/official-dashboard') }}">
                        <i class="uil-apps"></i><span>{{ __('messages.dashboard') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/social-regd-app-list') }}">
                        <i class="uil-invoice"></i><span>{{ __('messages.society_application') }}</span>
                    </a>
                </li>
                <!-- <li>
                    <a href="{{ url('/membership') }}">
                        <i class="uil-comments-alt"></i><span>{{ __('messages.membership_details') }}</span>
                    </a>
                </li>

                <li>
                    <a href="{{ url('/society-regd-report') }}">
                        <i class="uil-clipboard-notes"></i><span>{{ __('messages.report') }}</span>
                    </a>
                </li> -->
                @endif
                @endif
                <!-- inspection menu end-->
                {{-- <li class="">
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-setting"></i>
                        <span>{{ __('messages.settings') }}</span>
                </a>

                <ul class="sub-menu" aria-expanded="false">
                    <li><a href="{{ route('roles') }}" class="waves-effect"><span>{{ __('messages.Roles')
                                    }}</span></a></li>
                    <li><a href="{{ route('module-index') }}" class="waves-effect"><span>{{
                                    __('messages.Module-Settings') }}</a></li>
                </ul>
                </li> --}}

                @endif
            </ul>
        </div>
        <!-- Sidebar -->
    </div>

</div>