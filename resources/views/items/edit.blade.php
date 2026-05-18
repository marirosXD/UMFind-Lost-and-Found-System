@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">Edit Item</h1>

        <form action="{{ route('items.update', $item) }}" method="POST" enctype="multipart/form-data"
              class="bg-white rounded-lg shadow-md p-6">
            @csrf
            @method('PUT')

            <!-- TITLE -->
            <div class="mb-4">
                <label class="block mb-1">Title *</label>
                <input type="text" name="title"
                       value="{{ old('title', $item->title) }}"
                       class="w-full border rounded p-2" required>
            </div>

        

            <!-- DESCRIPTION -->
            <div class="mb-4">
                <label class="block mb-1">Description *</label>
                <textarea name="description" class="w-full border rounded p-2" required>{{ old('description', $item->description) }}</textarea>
            </div>

            <!-- CATEGORY -->
            <div class="mb-4">
                <label class="block mb-1">Category *</label>
                <select name="category" class="w-full border rounded p-2" required>
                    @foreach(['electronics','documents','jewelry','clothing','bags','keys','pets','other'] as $cat)
                        <option value="{{ $cat }}" {{ $item->category == $cat ? 'selected' : '' }}>
                            {{ ucfirst($cat) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- LOCATION -->
            <div class="mb-4">
                <label class="block mb-1">Location *</label>
                <input type="text" name="location"
                       value="{{ old('location', $item->location) }}"
                       class="w-full border rounded p-2" required>
            </div>

            <!-- DATE -->
            <div class="mb-4">
                <label class="block mb-1">Date Found *</label>
                <input type="date" name="date_found"
                       value="{{ old('date_found', $item->date_found->format('Y-m-d')) }}"
                       class="w-full border rounded p-2" required>
            </div>

            <!-- IMAGE -->
            <div class="mb-4">
                <label class="block mb-1">Image (optional)</label>
                @if($item->image)
                    <img src="{{ $item->image_url }}" class="h-20 mb-2">
                @endif
                <input type="file" name="image" class="w-full border rounded p-2">
            </div>

            <!-- ATTACHMENT -->
            <div class="mb-4">
                <label class="block mb-1">Attachment (optional)</label>
                <input type="file" name="attachment" class="w-full border rounded p-2">
            </div>

            <!-- BUTTONS -->
            <div class="flex justify-end gap-3">
                <a href="{{ route('items.show', $item) }}"
                   class="px-4 py-2 bg-gray-300 rounded">Cancel</a>

                <button type="submit"
                        class="px-4 py-2 bg-blue-500 text-white rounded">
                    Update Item
                </button>
            </div>

        </form>
    </div>
</div>
@endsection