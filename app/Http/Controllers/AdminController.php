<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Item;
use App\Models\Claim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function dashboard()
    {
        $totalUsers = User::count();
        $totalItems = Item::count();
        $stillMissingItems = Item::where('status', 'still_missing')->count();
        $receivedItems = Item::where('status', 'received')->count();
        $claimedItems = Item::where('status', 'claimed')->count();
                
        
        

        $query = Item::with('user')->latest();

        // Search filter
        if (request('search')) {
            $query->where('title', 'like', '%' . request('search') . '%');
        }

        // Category filter
        if (request('category')) {
            $query->where('category', request('category'));
        }

        // Status filter (ADD THIS)
        if (request('status') && request('status') !== 'all') {
            $query->where('status', request('status'));
        }

        // SHOW ALL (with pagination instead of limit 5)
        $recentItems = $query->paginate(10)->withQueryString();





        $recentUsers = User::latest()->take(5)->get();
        
        return view('admin.dashboard', compact(
            'totalUsers',
            'totalItems',
            'stillMissingItems',
            'receivedItems',
            'claimedItems',
            'recentItems',
            'recentUsers'
        ));
    }

    public function users()
    {
        $users = User::withCount('items')->paginate(10);
        return view('admin.users', compact('users'));
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit-user', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:user,admin',
        ]);
        
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);
        
        if ($request->filled('password')) {
            $request->validate(['password' => 'min:8|confirmed']);
            $user->update(['password' => Hash::make($request->password)]);
        }
        
        return redirect()->route('admin.users')->with('success', 'User updated successfully!');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }
        
        $user->delete();
        return redirect()->route('admin.users')->with('success', 'User deleted successfully!');
    }




public function claims()
{
    $claims = Claim::with('item')->latest()->paginate(10);

    return view('admin.claims.index', compact('claims'));
}



public function showReturnForm(Item $item)
{
    if ($item->status === 'claimed') {
        return redirect()->route('items.show', $item)
            ->with('error', 'This item has already been claimed.');
    }

    return view('admin.items.return', compact('item'));
}


public function storeReturn(Request $request, Item $item)
{
    $request->validate([
        'returner_first_name' => 'required|string',
        'returner_last_name' => 'required|string',
        'returner_student_id' => 'required|string',
        'returner_contact' => 'required|string',
    ]);

    if ($item->status === 'claimed') {
        return redirect()->route('items.show', $item)
            ->with('error', 'This item has already been claimed.');
    }

    $claim = Claim::firstOrNew(['item_id' => $item->id]);

    if (! $claim->exists) {
        $claim->claimer_first_name = '';
        $claim->claimer_last_name = '';
        $claim->claimer_student_id = '';
        $claim->claimer_contact = '';
        $claim->status = 'pending';
        $claim->claimed_at = null;
    }

    $claim->returner_first_name = $request->returner_first_name;
    $claim->returner_last_name = $request->returner_last_name;
    $claim->returner_student_id = $request->returner_student_id;
    $claim->returner_contact = $request->returner_contact;
    $claim->item_id = $item->id;
    $claim->save();

    $item->update(['status' => 'received']);

    return redirect()->route('items.show', $item)
        ->with('success', 'Return information saved and item marked as received.');
}


}

