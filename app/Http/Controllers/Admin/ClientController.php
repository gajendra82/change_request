<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreClientRequest;
use App\Http\Requests\Admin\UpdateClientRequest;
use App\Models\Client;
use App\Repositories\ClientRepository;
use App\Services\ClientService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClientController extends Controller
{
    public function __construct(
        private ClientRepository $clients,
        private ClientService $clientService,
    ) {}

    public function index(Request $request): View
    {
        $clients = $this->clients->paginate($request->only(['search', 'status']));

        return view('admin.clients.index', compact('clients'));
    }

    public function create(): View
    {
        return view('admin.clients.create');
    }

    public function store(StoreClientRequest $request): RedirectResponse
    {
        $this->clientService->create($request->validated());

        return redirect()->route('admin.clients.index')->with('success', 'Client created successfully.');
    }

    public function show(Client $client): View
    {
        $client->load(['users', 'projects']);

        return view('admin.clients.show', compact('client'));
    }

    public function edit(Client $client): View
    {
        return view('admin.clients.edit', compact('client'));
    }

    public function update(UpdateClientRequest $request, Client $client): RedirectResponse
    {
        $this->clientService->update($client, $request->validated());

        return redirect()->route('admin.clients.index')->with('success', 'Client updated successfully.');
    }

    public function destroy(Client $client): RedirectResponse
    {
        $this->clientService->delete($client);

        return redirect()->route('admin.clients.index')->with('success', 'Client deleted successfully.');
    }

    public function toggleStatus(Client $client): RedirectResponse
    {
        $this->clientService->toggleStatus($client);

        return back()->with('success', 'Client status updated.');
    }
}
