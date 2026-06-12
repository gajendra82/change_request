@if($changeRequest->attachments->isNotEmpty())
    <div class="crms-card mb-4">
        <div class="crms-card-header"><h5>Attachments</h5></div>
        <div class="crms-card-body">
            <ul class="attachment-list list-unstyled mb-0">
                @foreach($changeRequest->attachments as $attachment)
                    <li class="attachment-item">
                        @if($attachment->isImage())
                            <a href="{{ $attachment->url }}" target="_blank" rel="noopener" class="attachment-thumb-link">
                                <img src="{{ $attachment->url }}" alt="{{ $attachment->original_name }}" class="attachment-thumb">
                            </a>
                        @endif
                        <a href="{{ route('change-requests.attachments.download', [$changeRequest, $attachment]) }}" class="attachment-link">
                            <i data-lucide="{{ $attachment->isImage() ? 'image' : 'file-text' }}" style="width:16px;height:16px"></i>
                            <span>{{ $attachment->original_name }}</span>
                            <span class="text-muted small">({{ $attachment->human_size }})</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
