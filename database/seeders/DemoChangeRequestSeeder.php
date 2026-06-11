<?php

namespace Database\Seeders;

use App\Models\ChangeRequest;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoChangeRequestSeeder extends Seeder
{
    public function run(): void
    {
        $client = User::where('email', 'client@crms.test')->first();

        if (! $client) {
            return;
        }

        $requests = [
            [
                'title' => 'Add Export to PDF Feature',
                'description' => 'Clients need the ability to export change request reports as PDF documents for offline sharing and archival.',
                'priority' => 'high',
            ],
            [
                'title' => 'Dashboard Performance Optimization',
                'description' => 'Improve dashboard load time by optimizing database queries and adding caching for frequently accessed data.',
                'priority' => 'medium',
            ],
            [
                'title' => 'Email Notification Integration',
                'description' => 'Send automated email notifications to clients and managers when change request status changes.',
                'priority' => 'low',
            ],
        ];

        foreach ($requests as $request) {
            ChangeRequest::firstOrCreate(
                [
                    'client_id' => $client->id,
                    'title' => $request['title'],
                ],
                [
                    'description' => $request['description'],
                    'priority' => $request['priority'],
                    'status' => 'submitted',
                ]
            );
        }
    }
}
