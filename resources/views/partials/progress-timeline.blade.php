@php
    $steps = [
        ['key' => 'submitted', 'label' => 'Submitted', 'desc' => 'Change request created'],
        ['key' => 'timeline_added', 'label' => 'Timeline Added', 'desc' => 'Developer estimated timeline'],
        ['key' => 'approved', 'label' => 'Manager Approved', 'desc' => 'Timeline approved by manager'],
        ['key' => 'development', 'label' => 'Development', 'desc' => 'Implementation in progress'],
        ['key' => 'testing', 'label' => 'Testing', 'desc' => 'Quality assurance phase'],
        ['key' => 'completed', 'label' => 'Completed', 'desc' => 'Request delivered'],
    ];

    $statusOrder = ['submitted' => 0, 'timeline_added' => 1, 'rejected' => 1, 'approved' => 2, 'completed' => 5];
    $currentIndex = $statusOrder[$changeRequest->status] ?? 0;

    if ($changeRequest->status === 'rejected') {
        $currentIndex = 1;
    }
@endphp

<div class="progress-timeline">
    @foreach($steps as $i => $step)
        @php
            $state = 'upcoming';
            if ($changeRequest->status === 'rejected' && $i > 1) {
                $state = 'upcoming';
            } elseif ($i < $currentIndex) {
                $state = 'done';
            } elseif ($i === $currentIndex) {
                $state = 'current';
            }
            if ($changeRequest->status === 'completed') {
                $state = 'done';
            }
        @endphp
        <div class="progress-step {{ $state }}">
            <div class="progress-step-icon">
                @if($state === 'done')
                    <i data-lucide="check" style="width:16px;height:16px"></i>
                @elseif($state === 'current')
                    <i data-lucide="circle-dot" style="width:16px;height:16px"></i>
                @else
                    <span class="small fw-bold">{{ $i + 1 }}</span>
                @endif
            </div>
            <div>
                <div class="fw-semibold small">{{ $step['label'] }}</div>
                <div class="text-muted" style="font-size:0.8125rem">{{ $step['desc'] }}</div>
            </div>
        </div>
    @endforeach
</div>
