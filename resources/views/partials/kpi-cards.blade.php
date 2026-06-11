<div class="row g-3 mb-4">
    <div class="col-xl-2 col-lg-4 col-md-6">
        <div class="kpi-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="kpi-label">Total Change Requests</div>
                    <div class="kpi-value">{{ $stats['total'] }}</div>
                </div>
                <div class="kpi-icon primary"><i data-lucide="file-text" style="width:20px;height:20px"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-lg-4 col-md-6">
        <div class="kpi-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="kpi-label">Pending Timelines</div>
                    <div class="kpi-value">{{ $stats['pending_timelines'] }}</div>
                </div>
                <div class="kpi-icon warning"><i data-lucide="clock" style="width:20px;height:20px"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-lg-4 col-md-6">
        <div class="kpi-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="kpi-label">Approved Requests</div>
                    <div class="kpi-value">{{ $stats['approved'] }}</div>
                </div>
                <div class="kpi-icon success"><i data-lucide="check-circle" style="width:20px;height:20px"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-lg-4 col-md-6">
        <div class="kpi-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="kpi-label">Rejected Requests</div>
                    <div class="kpi-value">{{ $stats['rejected'] }}</div>
                </div>
                <div class="kpi-icon danger"><i data-lucide="x-circle" style="width:20px;height:20px"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-lg-4 col-md-6">
        <div class="kpi-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="kpi-label">Completed Requests</div>
                    <div class="kpi-value">{{ $stats['completed'] }}</div>
                </div>
                <div class="kpi-icon purple"><i data-lucide="badge-check" style="width:20px;height:20px"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-lg-4 col-md-6">
        <div class="kpi-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="kpi-label">Est. Revenue</div>
                    <div class="kpi-value" style="font-size:1.25rem">₹{{ number_format($stats['total_revenue'], 0) }}</div>
                </div>
                <div class="kpi-icon navy"><i data-lucide="indian-rupee" style="width:20px;height:20px"></i></div>
            </div>
        </div>
    </div>
</div>
