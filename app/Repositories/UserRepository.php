<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class UserRepository
{
    public function query(): Builder
    {
        return User::query()->with(['client']);
    }

    public function byRole(string $role): Builder
    {
        return $this->query()->where('role', $role);
    }

    public function paginateByRole(string $role, int $perPage = 15): LengthAwarePaginator
    {
        return $this->byRole($role)->latest()->paginate($perPage);
    }

    public function paginateAll(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = $this->query();

        if (! empty($filters['role'])) {
            $query->where('role', $filters['role']);
        }

        if (! empty($filters['client_id'])) {
            $query->where('client_id', $filters['client_id']);
        }

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (! empty($filters['department'])) {
            $query->where('department', $filters['department']);
        }

        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function (Builder $q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('mobile', 'like', "%{$search}%")
                    ->orWhere('employee_id', 'like', "%{$search}%");
            });
        }

        return $query->latest()->paginate($perPage)->withQueryString();
    }

    public function countByRole(string $role): int
    {
        return User::where('role', $role)->where('status', 'active')->count();
    }

    public function managers(): Collection
    {
        return User::where('role', 'manager')->where('status', 'active')->orderBy('name')->get();
    }
}
