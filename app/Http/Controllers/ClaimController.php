<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use Illuminate\Http\Request;

class ClaimController extends Controller
{
    public function index()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $query = Claim::with('item')->where('status', 'claimed');

        // Search filter
        if (request('search')) {
            $search = request('search');
            $query->where(function ($q) use ($search) {
                $q->whereHas('item', function ($subQ) use ($search) {
                    $subQ->where('title', 'like', "%{$search}%");
                })->orWhere('claimer_first_name', 'like', "%{$search}%")
                  ->orWhere('claimer_last_name', 'like', "%{$search}%")
                  ->orWhere('claimer_student_id', 'like', "%{$search}%")
                  ->orWhere('returner_first_name', 'like', "%{$search}%")
                  ->orWhere('returner_last_name', 'like', "%{$search}%")
                  ->orWhere('returner_student_id', 'like', "%{$search}%");
            });
        }

        $claims = $query->latest()->paginate(15)->withQueryString();

        return view('admin.claims.index', compact('claims'));
    }

    public function show(Claim $claim)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        if ($claim->status !== 'claimed') {
            abort(404);
        }

        return view('admin.claims.show', compact('claim'));
    }
}