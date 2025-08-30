@php
    $roleId = null;
    if (auth()->check()) {
        $roleId = auth()->user()->roles->first()->id;
    }

@endphp

<div class="vertical-menu">
    <div data-simplebar class="sidebar-menu-scroll">
        <!--- Sidemenu -->
        <div id="sidebar-menu" class="">
            <ul class="metismenu list-unstyled" id="side-menu">
                <li>
                    <a href="{{ route('appeal.dashboard') }}">
                        <i class="uil-apps"></i><span>{{ __('messages.dashboard') }}</span>
                    </a>
                </li>
                @if ($roleId == 7)
                    <li>
                        <a href="{{ route('appeal.form') }}">
                            <i class="uil-invoice"></i><span>{{ __('messages.appeal_form') }}</span>
                        </a>
                    </li>
                @endif
                <li>
                    <a href="{{ route('appeal.list') }}">
                        <i class="uil-invoice"></i><span>{{ __('messages.appeal_list_view') }}</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('appeal.awaiting-documents') }}">
                        <i class="uil-invoice"></i><span>{{ __('messages.awaiting_documents') }}</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>

</div>
