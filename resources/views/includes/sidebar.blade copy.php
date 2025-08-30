<div class="vertical-menu">

    <div data-simplebar class="sidebar-menu-scroll">
        <!--- Sidemenu -->
        <div id="sidebar-menu" class="">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">

                @if (auth()->user()->role_id == 2)
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
                    <li>
                        <a href="{{ url('/membership') }}">
                            <i class="uil-comments-alt"></i><span>{{ __('messages.membership_details') }}</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('/society-regd-report') }}">
                            <i class="uil-clipboard-notes"></i><span>{{ __('messages.report') }}</span>
                        </a>
                    </li>
                @else
                    <li>
                        <a href="/dashboard">
                            <i class="uil-apps"></i><span>{{ __('messages.dashboard') }}</span>
                        </a>
                    </li>
                    @can('society-registration-show')
                        <li>
                            <a href="{{ url('/social-registration') }}">
                                <i class="uil-invoice"></i><span>{{ __('messages.society_registration') }}</span>
                            </a>
                        </li>
                    @endcan
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
                @endif
                <li>
                    <a href="{{ route('roles') }}">
                        <i class="uil-setting"></i><span>{{ __('messages.Roles') }}</span>
                    </a>
                </li>

                {{-- <li class="">
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-setting"></i>
                        <span>{{ __('messages.settings') }}</span>
                    </a>

                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('roles') }}"
                                class="waves-effect"><span>{{ __('messages.Roles') }}</span></a></li>
                        <li><a href="{{ route('module-index') }}"
                                class="waves-effect"><span>{{ __('messages.Module-Settings') }}</a></li>
                    </ul>
                </li> --}}

            </ul>
        </div>
        <!-- Sidebar -->
    </div>

</div>
