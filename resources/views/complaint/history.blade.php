{{-- {{ dd($complaint) }} --}}
@if ($history->isEmpty())
    <ul class="verti-timeline list-unstyled">
        <li class="event-list">
            {{-- <div class="event-date text-primary">{{ optional($app->society_details)->applied_on->format('d M Y') }}</div> --}}
            <div class="event-date text-primary">{{ optional($complaint->created_at)->format('d M Y') }}</div>
            <h6>
                <b>{{ $complaint->complaint_by }}</b> applied for a complaint
                {{-- <b>{{ optional($app->complaint_by_society)->society_name }}</b> applied for a complaint on the Society
                <b>{{ optional($app->society_details)->society_name }}</b> --}}
                <badge class="badge bg-warning">New Complaint
                </badge>
            </h6>
        </li>
    </ul>
    {{-- <p class="text-center text-muted">{{ __('messages.No-history-found') }}.</p> --}}
@else
    <div class="">
        <ul class="verti-timeline list-unstyled">
            <li class="event-list">
                {{-- <div class="event-date text-primary">
                    {{ optional($app->society_details)->applied_on->format('d M Y') }}
                </div> --}}
                <div class="event-date text-primary">{{ optional($complaint->created_at)->format('d M Y') }}</div>
                <h6>
                    <b>{{ $complaint->complaint_by }}</b> applied for a complaint
                    {{--  <b>{{ optional($app->complaint_by_society)->society_name }}</b> applied for a complaint on the
                    Society
                    <b>{{ optional($app->society_details)->society_name }}</b> --}}
                    <badge class="badge bg-warning">New Complaint
                    </badge>
                </h6>
            </li>
            @foreach ($history as $flow)
                @php
                    $action = $flow->action;
                    switch ($action) {
                        case 'send':
                            $bg = 'bg-primary';
                            break;
                        case 'approve':
                            $bg = 'bg-success';
                            break;
                        case 'reject':
                            $bg = 'bg-danger';
                            break;
                        case 'revert':
                            $bg = 'bg-warning';
                            break;
                        case 'verification':
                            $bg = 'bg-info';
                            break;
                        case 'recheck':
                            $bg = 'bg-primary';
                            break;
                        default:
                            $bg = 'bg-light';
                    }
                @endphp

                <li class="event-list">
                    <div class="event-date text-primary">{{ $flow->created_at->format('d M Y') }}</div>
                    <h6>{{ Str::upper($flow->from_role) }}
                        @if ($flow->to_role)
                            {{ Str::ucfirst($flow->direction == 'reverse' ? 'Sent Back' : 'Forwarded') }} to
                            {{ Str::upper($flow->to_role) }}
                        @else
                            Approved the Application
                        @endif
                        <badge class="badge {{ $bg }}">
                            {{ Str::ucfirst($action == 'recheck' ? 'Re-Check' : $action) }}</badge>
                    </h6>


                    <p class="text-muted">
                        <span class="text-warning"> {{ __('messages.Remarks') }}:</span></br>
                        <span class="text-justify">
                            {{ $flow->remarks ?? 'NA' }}
                        </span>

                    </p>
                    <p class="icon-demo-content d-flex">
                        @foreach (json_decode($flow->attachments ?? '[]', true) as $file)
                            @php
                                $url = asset('storage/' . $file);
                                $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                            @endphp

                            @if ($extension === 'pdf')
                                <a href="javascript:void(0);" style="font-size: 1.5rem; color: #c90000;"
                                    onclick="viewAttachment('{{ $url }}')">
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                            @else
                                <a href="javascript:void(0);" style="font-size: 1.5rem; color: #15a799;"
                                    onclick="viewAttachment('{{ $url }}')">
                                    <i class="fas fa-file-image"></i>
                                </a>
                            @endif
                        @endforeach
                    </p>
                </li>
            @endforeach

        </ul>
    </div>
@endif
