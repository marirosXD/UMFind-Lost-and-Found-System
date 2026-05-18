@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">Post a Lost or Found Item</h1>
        
        <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow-md p-6">
            @csrf
            
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Title *</label>
                <input type="text" name="title" value="{{ old('title') }}" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500 @error('title') border-red-500 @enderror" required>
                @error('title')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- ====== automatic user info ====== --}}
            <div class="mb-3">
                <label>First Name</label>
                <input type="text" value="{{ $user->first_name }}" class="w-full border p-2 rounded bg-gray-100" readonly>
            </div>

            <div class="mb-3">
                <label>Last Name</label>
                <input type="text" value="{{ $user->last_name }}" class="w-full border p-2 rounded bg-gray-100" readonly>
            </div>

            <div class="mb-3">
                <label>Student ID</label>
                <input type="text" value="{{ $user->student_id }}" class="w-full border p-2 rounded bg-gray-100" readonly>
            </div>

            <div class="mb-3">
                <label>Contact Number</label>
                <input type="text" value="{{ $user->contact_number }}" class="w-full border p-2 rounded bg-gray-100" readonly>
            </div>            



            
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Description of the Item *</label>
                <textarea name="description" rows="5" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror" required>{{ old('description') }}</textarea>
                @error('description')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Category *</label>
                <select name="category" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="">Select Category</option>
                    <option value="electronics">Electronics</option>
                    <option value="documents">Documents</option>
                    <option value="jewelry">Jewelry</option>
                    <option value="clothing">Clothing</option>
                    <option value="bags">Bags</option>
                    <option value="keys">Keys</option>
                    <option value="pets">Pets</option>
                    <option value="other">Other</option>
                </select>
                @error('category')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Location Found/Lost *</label>
                <input type="text" name="location" value="{{ old('location') }}" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                @error('location')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Date Found *</label>
                <input type="date" name="date_found" value="{{ old('date_found') }}" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                @error('date_found')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Image (Optional)</label>
                <input type="file" name="image" accept="image/*" class="w-full px-3 py-2 border rounded">
                @error('image')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-4">
                <label>Attach File (Optional)</label>
                <input type="file" name="attachment" class="w-full border rounded p-2">
            </div>
            
            <div class="flex justify-end gap-3">
                <a href="{{ route('items.index') }}" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</a>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Post Item</button>
            </div>
        </form>
    </div>
</div>
@endsection