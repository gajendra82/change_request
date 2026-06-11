@php
    $activities = collect([
        [
            'time' => $changeRequest->created_at,
            'title' => 'CR Created',
            'desc' => 'Change request submitted by ' . ($changeRequest->client->name ?? 'client'),
        ],
    ]);

    if ($changeRequest->timeline) {
        $activities->push([
            'time' => $changeRequest->timeline->created_at,
            'title' => 'Timeline Added',
            'desc' => 'Estimated ' . $changeRequest->timeline->estimated_days . ' days by ' . ($changeRequest->timeline->developer->name ?? 'developer'),
        ]);

        if ($changeRequest->timeline->manager_status === 'approved') {
            $activities->push([
                'time' => $changeRequest->timeline->updated_at,
                'title' => 'Manager Approved',
                'desc' => 'Approved by ' . ($changeRequest->timeline->approver->name ?? 'manager'),
            ]);
        } elseif ($changeRequest->timeline->manager_status === 'rejected') {
            $activities->push([
                'time' => $changeRequest->timeline->updated_at,
                'title' => 'Manager Rejected',
                'desc' => $changeRequest->timeline->manager_remarks ?? 'Timeline rejected',
            ]);
        }
    }

    if ($changeRequest->status === 'completed') {
        $activities->push([
            'time' => $changeRequest->updated_at,
            'title' => 'Completed',
            'desc' => 'Change request marked as completed',
        ]);
    }

    $activities = $activities->sortBy('time');
@endphp

<div class="crms-timeline">
    @foreach($activities as $activity)
        <div class="crms-timeline-item completed">
            <div class="crms-timeline-dot">
                <i data-lucide="check" style="width:12px;height:12px"></i>
            </div>
            <div class="crms-timeline-time">{{ $activity['time']->format('h:i A') }} &middot; {{ $activity['time']->format('d M Y') }}</div>
            <div class="crms-timeline-title">{{ $activity['title'] }}</div>
            <p class="crms-timeline-desc">{{ $activity['desc'] }}</p>
        </div>
    @endforeach
</div>
