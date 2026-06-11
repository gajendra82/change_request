<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChangeRequest;
use App\Repositories\ClientRepository;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ChangeRequestController extends Controller
{
    public function __construct(private ClientRepository $clients) {}

    public function index(Request $request): View
    {
        $query = ChangeRequest::with(['client', 'project', 'timeline'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('cr_number', 'like', "%{$search}%")
                    ->orWhere('title', 'like', "%{$search}%");
            });
        }

        $changeRequests = $query->paginate(15)->withQueryString();
        $clients = $this->clients->allActive();

        return view('admin.change-requests.index', compact('changeRequests', 'clients'));
    }

    public function show(ChangeRequest $changeRequest): View
    {
        $changeRequest->load(['client', 'project', 'timeline.developer', 'timeline.approver']);

        return view('admin.change-requests.show', compact('changeRequest'));
    }
}
