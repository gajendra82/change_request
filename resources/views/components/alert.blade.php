@if(session('success'))
    <div class="crms-alert crms-alert-success alert-dismissible fade show" role="alert">
        <i data-lucide="check-circle" style="width:18px;height:18px;flex-shrink:0"></i>
        <span>{{ session('success') }}</span>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="crms-alert crms-alert-danger alert-dismissible fade show" role="alert">
        <i data-lucide="alert-circle" style="width:18px;height:18px;flex-shrink:0"></i>
        <span>{{ session('error') }}</span>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('info'))
    <div class="crms-alert crms-alert-info alert-dismissible fade show" role="alert">
        <i data-lucide="info" style="width:18px;height:18px;flex-shrink:0"></i>
        <span>{{ session('info') }}</span>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
    </div>
@endif

@if($errors->any())
    <div class="crms-alert crms-alert-danger alert-dismissible fade show" role="alert">
        <i data-lucide="alert-triangle" style="width:18px;height:18px;flex-shrink:0"></i>
        <ul class="mb-0 ps-3">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
    </div>
@endif
