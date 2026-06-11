<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChangeRequestTimeline extends Model
{
    use HasFactory;

    protected $fillable = [
        'change_request_id',
        'developer_id',
        'estimated_days',
        'cost',
        'start_date',
        'end_date',
        'remarks',
        'manager_status',
        'manager_remarks',
        'approved_by',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'cost' => 'decimal:2',
        ];
    }

    public static function calculateCost(int $estimatedDays): float
    {
        $dailyRate = Setting::getFloat('default_cost_per_day', 12000);

        return $estimatedDays * $dailyRate;
    }

    public static function dailyRate(): float
    {
        return Setting::getFloat('default_cost_per_day', 12000);
    }

    public function changeRequest(): BelongsTo
    {
        return $this->belongsTo(ChangeRequest::class);
    }

    public function developer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'developer_id');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function getManagerStatusBadgeClassAttribute(): string
    {
        return match ($this->manager_status) {
            'pending' => 'badge-manager-pending',
            'approved' => 'badge-manager-approved',
            'rejected' => 'badge-manager-rejected',
            default => 'badge-manager-pending',
        };
    }
}
