@if ($history->isEmpty())
    <ul class="verti-timeline list-unstyled">
        <li class="event-list">
            <div class="event-date text-primary">{{ $target->created_at->format('d M Y') }}</div>
            <h6>
                Assigned {{ $target->society_count }} societies to {{ $target->designation->display_name }}
                <span class="badge bg-warning">New Target</span>
            </h6>
            <p class="text-muted mt-2">
                <i class="fas fa-info-circle text-warning me-1"></i>
                No action has been taken on this target yet.
            </p>
        </li>
    </ul>
@else
    <div>
        <ul class="verti-timeline list-unstyled">
           

            @foreach ($history as $flow)
           
                @php
                    $action = $flow->action;
                    $bg = match($action) {
                        'send' => 'bg-primary',
                        'approve' => 'bg-success',
                        'reject' => 'bg-danger',
                        'revert' => 'bg-warning',
                        'verification' => 'bg-info',
                        'recheck' => 'bg-primary',
                        default => 'bg-light',
                    };
                @endphp

                <li class="event-list">
                    <div class="event-date text-primary">{{ $flow->created_at->format('d M Y') }}</div>
                    <h6>{{ Str::upper($flow->actedBy->name) }}
                        @if ($flow->to_role)
                            {{ $flow->direction === 'reverse' ? 'Sent Back' : 'Forwarded' }} to
                            {{ Str::upper($flow->to_role) }}
                        @else
                            Took action
                        @endif
                        <span class="badge {{ $bg }}">
                            {{ ucfirst($action == 'recheck' ? 'Re-Check' : $action) }}
                        </span>
                    </h6>

                    @if ($flow->remarks)
                        <p class="text-muted">
                            <span class="text-warning">Remarks:</span><br>
                            {{ $flow->remarks }}
                        </p>
                    @endif

                    @if ($flow->attachments)
                        <p class="icon-demo-content d-flex gap-2">
                            @foreach (json_decode($flow->attachments, true) as $file)
                                @php
                                    $url = asset('storage/' . $file);
                                    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                @endphp

                                <a href="javascript:void(0);" onclick="viewAttachment('{{ $url }}')"
                                    style="font-size: 1.5rem; color: {{ $ext === 'pdf' ? '#c90000' : '#15a799' }};">
                                    <i class="fas fa-file-{{ $ext === 'pdf' ? 'pdf' : 'image' }}"></i>
                                </a>
                            @endforeach
                        </p>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
@endif
