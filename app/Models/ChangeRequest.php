<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ChangeRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'cr_number',
        'client_id',
        'project_id',
        'title',
        'description',
        'priority',
        'status',
    ];

    protected static function booted(): void
    {
        static::creating(function (ChangeRequest $changeRequest): void {
            if (empty($changeRequest->cr_number)) {
                $changeRequest->cr_number = self::generateCrNumber();
            }
        });
    }

    public static function generateCrNumber(): string
    {
        $lastRequest = self::query()->orderByDesc('id')->first();
        $nextNumber = $lastRequest
            ? (int) substr($lastRequest->cr_number, 3) + 1
            : 1;

        return 'CR-'.str_pad((string) $nextNumber, 5, '0', STR_PAD_LEFT);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function timeline(): HasOne
    {
        return $this->hasOne(ChangeRequestTimeline::class);
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'submitted' => 'badge-status-submitted',
            'timeline_added' => 'badge-status-timeline_added',
            'approved' => 'badge-status-approved',
            'rejected' => 'badge-status-rejected',
            'completed' => 'badge-status-completed',
            default => 'badge-status-submitted',
        };
    }

    public function getPriorityBadgeClassAttribute(): string
    {
        return match ($this->priority) {
            'low' => 'badge-priority-low',
            'medium' => 'badge-priority-medium',
            'high' => 'badge-priority-high',
            'critical' => 'badge-priority-critical',
            default => 'badge-priority-low',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'submitted' => 'Submitted',
            'timeline_added' => 'Timeline Added',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
            'completed' => 'Completed',
            default => ucfirst($this->status),
        };
    }
}
