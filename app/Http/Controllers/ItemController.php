<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Claim;

class ItemController extends Controller
{

    public function __construct()
    {
        ////// $this->middleware('auth');
        $this->middleware('auth')->except(['index', 'show']);
    }
//////////////////////////////
 public function index(Request $request)
{
    $query = Item::with('user')->latest();

    // never show claimed in browse
    $query->where('status', '!=', 'claimed');

    // TAB FILTER (Lost vs Admin Office)
    if ($request->tab === 'admin') {
        $query->where('status', 'received');
    } else {
        $query->where('status', 'still_missing');
    }

    // SEARCH
    if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
        });
    }

    // CATEGORY
    if ($request->filled('category')) {
        $query->where('category', $request->category);
    }

    $items = $query->paginate(12)->withQueryString();

    return view('items.index', compact('items'));
}




    public function create()
    {
        if (auth()->user()->isAdmin()) {
        abort(403, 'Admins cannot post items.');
        }

        $user = auth()->user();
        return view('items.create', compact('user'));
    }





    public function store(Request $request)
    {
        $request->validate([
    'title' => 'required|string|max:255',
    'description' => 'required|string',
    'category' => 'required|string',
    'location' => 'required|string',
    'date_found' => 'required|date',


    'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
    'attachment' => 'nullable|file|mimes:pdf,doc,docx|max:4096',
    ]);

        $user = auth()->user();

        $item = new Item($request->only([
            'title',
            'description',
            'category',
            'location',
            'date_found'
        ]));

        $item->user_id = $user->id;

        // AUTO COPY USER INFO (NO MANUAL INPUT EVER AGAIN)
        $item->first_name = $user->first_name;
        $item->last_name = $user->last_name;
        $item->student_id = $user->student_id;
        $item->contact_number = $user->contact_number;

        $item->status = 'still_missing';

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads', 'public');
            $item->image = $path;
        }

        if ($request->hasFile('attachment')) {
            $filePath = $request->file('attachment')->store('files', 'public');
            $item->attachment = $filePath;
        }

        $item->save();

        return redirect()->route('items.index')->with('success', 'Item posted successfully!');
    }

    public function show(Item $item)
    {
        return view('items.show', compact('item'));
    }

    public function edit(Item $item)
    {
        // Only owner or admin can edit
        if (!auth()->user()->canManageItem($item)) {
            abort(403, 'You are not authorized to edit this item.');
        }
        return view('items.edit', compact('item'));
    }

    public function update(Request $request, Item $item)
    {

        if (!auth()->user()->canManageItem($item)) {
            abort(403, 'You are not authorized to update this item.');
        }

        if ($item->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        if ($request->has('status') && $request->status === 'claimed') {

            if (!auth()->user()->isAdmin()) {
                abort(403);
            }

            $item->status = 'claimed';
            $item->save();

            return redirect()->back()->with('success', 'Item marked as claimed!');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'location' => 'required|string',
            'date_found' => 'required|date',


            'status' => 'sometimes|string',

            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx|max:4096',
        ]);

        if ($request->hasFile('image')) {
            if ($item->image) {
                Storage::disk('public')->delete($item->image);
            }
            $path = $request->file('image')->store('uploads', 'public');
            $item->image = $path;
        }

        $data = $request->except(['image', 'attachment']);

        $item->update($data);

        return redirect()->route('items.show', $item)->with('success', 'Item updated successfully!');
    }

    public function destroy(Item $item)
    {
        if (!auth()->user()->canManageItem($item)) {
        abort(403, 'You are not authorized to delete this item.');
    }

        if ($item->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        if ($item->image) {
            Storage::disk('public')->delete($item->image);
        }

        $item->delete();

        return redirect()->route('items.index')->with('success', 'Item deleted successfully!');
    }

    


    // Show only the logged-in user's items
    public function myItems()
    {
        $items = Item::where('user_id', auth()->id())
                    ->latest()
                    ->paginate(12);
        return view('items.my-items', compact('items'));
    }


    public function claimForm(Item $item)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        return view('items.claim', compact('item'));
    }

    

    public function claimStore(Request $request, Item $item)
{
    if (!auth()->user()->isAdmin()) {
        abort(403);
    }

    if ($item->status !== 'received') {
        return back()->with('error', 'Item must be received before claiming.');
    }

    $request->validate([
        'claimer_first_name' => 'required|string',
        'claimer_last_name' => 'required|string',
        'claimer_student_id' => 'required|string',
        'claimer_contact_number' => 'required|string',
    ]);

    // GET CLAIM (must exist)
    $claim = Claim::where('item_id', $item->id)->first();

    if (!$claim) {
        return back()->with('error', 'No claim record found. Mark item as received first.');
    }

    // update claim
    $claim->claimer_first_name = $request->claimer_first_name;
    $claim->claimer_last_name = $request->claimer_last_name;
    $claim->claimer_student_id = $request->claimer_student_id;
    $claim->claimer_contact = $request->claimer_contact_number;
    $claim->claimed_at = now();
    $claim->status = 'claimed';
    $claim->save();

    // update item
    $item->update([
        'status' => 'claimed'
    ]);

    return redirect()->route('items.show', $item)
        ->with('success', 'Item successfully claimed.');
}


public function receiveItem($id)
{
    if (!auth()->user()->isAdmin()) {
        abort(403);
    }

    $item = Item::findOrFail($id);

    // CREATE CLAIM RECORD IF NOT EXISTS
    Claim::firstOrCreate([
        'item_id' => $item->id
    ], [
        'status' => 'pending',
        'claimed_at' => null
    ]);

    // update item status
    $item->update([
        'status' => 'received'
    ]);

    return redirect()->back()->with('success', 'Item marked as received!');
}



    
}