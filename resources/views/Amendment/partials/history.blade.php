@php
    function getActionBadgeColor($action) {
        return match($action) {
            'send' => 'bg-primary',
            'approve' => 'bg-success',
            'reject' => 'bg-danger',
            'revert' => 'bg-warning',
            'verification' => 'bg-info',
            'recheck' => 'bg-primary',
            default => 'bg-light',
        };
    }

    $initialDate = optional($app)->created_at?->format('d M Y');
    $societyName = optional($app->society_details)->society_name;
@endphp

<ul class="verti-timeline list-unstyled">
    <li class="event-list">
        <div class="event-date text-primary">{{ $initialDate }}</div>
        <h6>
            {{ $societyName }} {{ __('messages.Applied for Amendment Registration') }}
            <span class="badge bg-warning">New Application</span>
        </h6>
    </li>

    @forelse ($history as $flow)
        @php
            $action = $flow->action;
            $bg = getActionBadgeColor($action);
            $from = Str::upper($flow->from_role);
            $to = $flow->to_role ? Str::upper($flow->to_role) : null;
            $direction = $flow->direction === 'reverse' ? 'Sent Back' : 'Forwarded';
            $actionLabel = ucfirst($action === 'recheck' ? 'Re-Check' : $action);
            $attachments = json_decode($flow->attachments, true) ?? [];
        @endphp

        <li class="event-list">
            <div class="event-date text-primary">{{ $flow->created_at->format('d M Y') }}</div>
            <h6>
                {{ $from }}
                @if ($to)
                    {{ $direction }} to {{ $to }}
                @else
                    Approved the Application
                @endif
                <span class="badge {{ $bg }}">{{ $actionLabel }}</span>
            </h6>

            @if ($flow->remarks)
                <p class="text-muted">
                    <span class="text-warning">Remarks:</span><br>
                    <span class="text-justify">{{ $flow->remarks }}</span>
                </p>
            @endif

            @if (count($attachments))
                <p class="icon-demo-content d-flex gap-2">
                    @foreach ($attachments as $file)
                        @php
                            $url = asset('storage/' . $file);
                            $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                            $iconClass = $extension === 'pdf' ? 'fa-file-pdf text-danger' : 'fa-file-image text-info';
                            $title = $extension === 'pdf' ? 'View PDF Attachment' : 'View Image Attachment';
                        @endphp
                        <a href="javascript:void(0);" title="{{ $title }}" onclick="viewAttachment('{{ $url }}')" style="font-size: 1.5rem;">
                            <i class="fas {{ $iconClass }}"></i>
                        </a>
                    @endforeach
                </p>
            @endif
        </li>
    @empty
        {{-- No additional history --}}
    @endforelse
</ul>
