<?php

namespace Database\Seeders;

use App\Models\ChangeRequest;
use App\Models\ChangeRequestTimeline;
use App\Models\Client;
use App\Models\Project;
use App\Models\User;
use App\Services\SettingService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminDemoDataSeeder extends Seeder
{
    public function run(): void
    {
        app(SettingService::class)->seedDefaults();

        $managers = collect();
        for ($i = 1; $i <= 3; $i++) {
            $manager = User::updateOrCreate(
                ['email' => $i === 1 ? 'manager@crms.test' : "manager{$i}@crms.test"],
                [
                    'name' => $i === 1 ? 'Manager User' : "Manager User {$i}",
                    'password' => Hash::make('password'),
                    'role' => 'manager',
                    'employee_id' => 'MGR-'.str_pad((string) $i, 3, '0', STR_PAD_LEFT),
                    'department' => 'Operations',
                    'designation' => 'Project Manager',
                    'status' => 'active',
                    'email_verified_at' => now(),
                ]
            );
            $manager->syncRoles(['manager']);
            $managers->push($manager);
        }

        $developers = collect();
        for ($i = 1; $i <= 10; $i++) {
            $dev = User::updateOrCreate(
                ['email' => $i === 1 ? 'developer@crms.test' : "developer{$i}@crms.test"],
                [
                    'name' => $i === 1 ? 'Developer User' : "Developer {$i}",
                    'password' => Hash::make('password'),
                    'role' => 'developer',
                    'employee_id' => 'DEV-'.str_pad((string) $i, 3, '0', STR_PAD_LEFT),
                    'department' => ['Engineering', 'Frontend', 'Backend', 'QA'][$i % 4],
                    'experience' => ($i + 2).' years',
                    'skills' => 'PHP, Laravel, JavaScript',
                    'status' => 'active',
                    'email_verified_at' => now(),
                ]
            );
            $dev->syncRoles(['developer']);
            $developers->push($dev);
        }

        $clients = collect();
        for ($i = 1; $i <= 5; $i++) {
            $clients->push(Client::updateOrCreate(
                ['company_code' => 'CLT-'.str_pad((string) $i, 3, '0', STR_PAD_LEFT)],
                [
                    'company_name' => "Client Company {$i}",
                    'gst_number' => '29AABCU9603R1Z'.($i % 10),
                    'address' => "{$i}00 Business Park",
                    'city' => 'Bangalore',
                    'state' => 'Karnataka',
                    'country' => 'India',
                    'pincode' => '56000'.$i,
                    'primary_contact_name' => "Contact Person {$i}",
                    'primary_contact_email' => "contact{$i}@client{$i}.com",
                    'primary_contact_mobile' => '987654321'.$i,
                    'status' => 'active',
                ]
            ));
        }

        $clientUsers = collect();
        $userIndex = 1;
        foreach ($clients as $client) {
            for ($j = 0; $j < 3; $j++) {
                $user = User::updateOrCreate(
                    ['email' => "clientuser{$userIndex}@crms.test"],
                    [
                        'name' => "Client User {$userIndex}",
                        'password' => Hash::make('password'),
                        'role' => 'client',
                        'client_id' => $client->id,
                        'designation' => 'Business Analyst',
                        'mobile' => '912345678'.$userIndex,
                        'status' => 'active',
                        'email_verified_at' => now(),
                    ]
                );
                $user->syncRoles(['client']);
                $clientUsers->push($user);
                $userIndex++;
            }
        }

        User::updateOrCreate(
            ['email' => 'client@crms.test'],
            [
                'name' => 'Client User',
                'password' => Hash::make('password'),
                'role' => 'client',
                'client_id' => $clients->first()->id,
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        )->syncRoles(['client']);

        $projects = collect();
        $projectIndex = 1;
        foreach ($clients as $client) {
            for ($k = 0; $k < 4; $k++) {
                $projects->push(Project::updateOrCreate(
                    ['code' => 'PRJ-'.str_pad((string) $projectIndex, 4, '0', STR_PAD_LEFT)],
                    [
                        'name' => "Project {$projectIndex} — {$client->company_name}",
                        'client_id' => $client->id,
                        'description' => 'Demo project for change request management.',
                        'start_date' => now()->subMonths(2),
                        'end_date' => now()->addMonths(6),
                        'project_manager_id' => $managers->random()->id,
                        'status' => 'active',
                    ]
                ));
                $projectIndex++;
            }
        }

        $statuses = ['submitted', 'timeline_added', 'approved', 'rejected', 'completed'];
        $priorities = ['low', 'medium', 'high', 'critical'];

        for ($cr = 1; $cr <= 50; $cr++) {
            $clientUser = $clientUsers->random();
            $project = $projects->where('client_id', $clientUser->client_id)->random();
            $status = $statuses[array_rand($statuses)];

            $changeRequest = ChangeRequest::updateOrCreate(
                ['cr_number' => 'CR-'.str_pad((string) $cr, 5, '0', STR_PAD_LEFT)],
                [
                    'client_id' => $clientUser->id,
                    'project_id' => $project->id,
                    'title' => "Change Request #{$cr}",
                    'description' => "Demo change request description for CR-{$cr}. This is sample business requirement text.",
                    'priority' => $priorities[array_rand($priorities)],
                    'status' => $status === 'submitted' ? 'submitted' : $status,
                ]
            );

            if (in_array($status, ['timeline_added', 'approved', 'rejected', 'completed'])) {
                $days = rand(2, 15);
                $managerStatus = match ($status) {
                    'approved', 'completed' => 'approved',
                    'rejected' => 'rejected',
                    default => 'pending',
                };

                ChangeRequestTimeline::updateOrCreate(
                    ['change_request_id' => $changeRequest->id],
                    [
                        'developer_id' => $developers->random()->id,
                        'estimated_days' => $days,
                        'cost' => ChangeRequestTimeline::calculateCost($days),
                        'start_date' => now()->addDays(rand(1, 10)),
                        'end_date' => now()->addDays(rand(11, 30)),
                        'remarks' => 'Demo timeline estimation.',
                        'manager_status' => $managerStatus,
                        'approved_by' => in_array($managerStatus, ['approved', 'rejected']) ? $managers->random()->id : null,
                    ]
                );
            }
        }
    }
}
