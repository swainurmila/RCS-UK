<div class="vertical-menu">
    <div data-simplebar class="sidebar-menu-scroll">
        <!--- Sidemenu -->
        <div id="sidebar-menu" class="">
            <ul class="metismenu list-unstyled" id="side-menu">


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
                <li>
                    <a href="/dashboard">
                        <i class="uil-apps"></i><span>{{ __('messages.dashboard') }}</span>
                    </a>
                </li>
                    <li>
                        <a href="{{ url('/social-registration') }}">
                            <i class="uil-invoice"></i><span>{{ __('messages.society_registration') }}</span>
                        </a>
                    </li>
                <li>
                    <a href="{{ url('/social-regd-app-list') }}">
                        <i class="uil-invoice"></i><span>{{ __('messages.RegistrationStatus') }}</span>
                    </a>
                </li>
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
                <li>
                    <a href="{{ route('roles') }}">
                        <i class="uil-setting"></i><span>{{ __('messages.Roles') }}</span>
                    </a>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>

</div>
