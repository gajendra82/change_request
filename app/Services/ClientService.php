<?php

namespace App\Services;

use App\Models\Client;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ClientService
{
    public function __construct(private ActivityLogService $activityLog) {}

    public function create(array $data): Client
    {
        if (isset($data['logo']) && $data['logo'] instanceof UploadedFile) {
            $data['logo'] = $data['logo']->store('clients', 'public');
        }

        $client = Client::create($data);
        $this->activityLog->log('client_created', "Created client: {$client->company_name}", $client);

        return $client;
    }

    public function update(Client $client, array $data): Client
    {
        if (isset($data['logo']) && $data['logo'] instanceof UploadedFile) {
            if ($client->logo) {
                Storage::disk('public')->delete($client->logo);
            }
            $data['logo'] = $data['logo']->store('clients', 'public');
        }

        $client->update($data);
        $this->activityLog->log('client_updated', "Updated client: {$client->company_name}", $client);

        return $client->fresh();
    }

    public function toggleStatus(Client $client): void
    {
        $client->update(['status' => $client->status === 'active' ? 'inactive' : 'active']);
        $this->activityLog->log('client_status_changed', "Status changed for: {$client->company_name}", $client);
    }

    public function delete(Client $client): void
    {
        $this->activityLog->log('client_deleted', "Deleted client: {$client->company_name}", $client);
        $client->delete();
    }
}
