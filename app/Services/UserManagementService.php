<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserManagementService
{
    public function __construct(private ActivityLogService $activityLog) {}

    public function create(array $data, string $role): User
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $role,
            'client_id' => $data['client_id'] ?? null,
            'mobile' => $data['mobile'] ?? null,
            'designation' => $data['designation'] ?? null,
            'employee_id' => $data['employee_id'] ?? null,
            'department' => $data['department'] ?? null,
            'experience' => $data['experience'] ?? null,
            'skills' => $data['skills'] ?? null,
            'status' => $data['status'] ?? 'active',
            'email_verified_at' => now(),
        ]);

        if (isset($data['profile_photo']) && $data['profile_photo'] instanceof UploadedFile) {
            $user->update(['profile_photo' => $data['profile_photo']->store('profiles', 'public')]);
        }

        $user->syncRoles([$role]);

        $this->activityLog->log('user_created', "Created {$role}: {$user->name}", $user);

        return $user;
    }

    public function update(User $user, array $data): User
    {
        $user->update(array_filter([
            'name' => $data['name'] ?? null,
            'email' => $data['email'] ?? null,
            'client_id' => $data['client_id'] ?? null,
            'mobile' => $data['mobile'] ?? null,
            'designation' => $data['designation'] ?? null,
            'employee_id' => $data['employee_id'] ?? null,
            'department' => $data['department'] ?? null,
            'experience' => $data['experience'] ?? null,
            'skills' => $data['skills'] ?? null,
            'status' => $data['status'] ?? null,
        ], fn ($v) => $v !== null));

        if (! empty($data['password'])) {
            $user->update(['password' => Hash::make($data['password'])]);
        }

        if (isset($data['profile_photo']) && $data['profile_photo'] instanceof UploadedFile) {
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }
            $user->update(['profile_photo' => $data['profile_photo']->store('profiles', 'public')]);
        }

        $this->activityLog->log('user_updated', "Updated user: {$user->name}", $user);

        return $user->fresh();
    }

    public function resetPassword(User $user, string $password): void
    {
        $user->update(['password' => Hash::make($password)]);
        $this->activityLog->log('password_reset', "Password reset for: {$user->name}", $user);
    }

    public function toggleStatus(User $user): void
    {
        $user->update(['status' => $user->status === 'active' ? 'inactive' : 'active']);
        $this->activityLog->log('status_changed', "Status changed for: {$user->name}", $user);
    }

    public function delete(User $user): void
    {
        $this->activityLog->log('user_deleted', "Deleted user: {$user->name}", $user);
        $user->delete();
    }
}
