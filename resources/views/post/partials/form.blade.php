@php 
    $publishedAt = $post
        ? $post->published_at?->format('Y-m-d\TH:i')
        : now()->format('Y-m-d\TH:i');
@endphp

<!-- Image -->
<div>
    <x-input-label for="image" :value="__('Image')"/>

    @if ($post?->image)
        <img src="{{ Storage::url($post->image) }}" alt="" class="mt-2 w-48 rounded-lg">
        <p class="mt-1 text-sm text-gray-500">Leave empty to keep the current image.</p>
    @endif

    <x-text-input id="image" class="block mt-1 w-full" type="file" name="image" accept="image/*" />
    <x-input-error :messages="$errors->get('image')" class="mt-2" />
</div>


<!-- Title -->
<div class="mt-4">
    <x-input-label  for="title" :value="__('Title')" />
    <x-text-input  id="title" class="block mt-1 w-full" type="text" name="title" 
    :value="old('title', $post?->title)" required autofocus/>
    <x-input-error :messages="$errors->get('title')" class="mt-2" />
</div>

<!-- Category -->
<div class="mt-4">
    <x-input-label for="category_id" :value="__('Category')" />
    <select id="category_id" name="category_id"
        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
        <option value="">Select a category</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}" @selected(old('category_id', $post?->category_id) == $category->id)>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
</div>

<!-- Publish date -->
<div class="mt-4">
    <x-input-label for="published_at" :value="__('Publish date')" />
    <x-text-input  id="published_at" class="block mt-1" type="datetime-local" name="published_at" :value="old('published_at', $publishedAt)" />
    <p class="mt-1 text-sm text-gray-500">Leave empty to save draft. Pick a future date to schedule it.</p>
    <x-input-error :messages="$errors->get('published_at')" class="mt-2" />
</div>

<!-- Content -->
<div class="mt-4">
    <x-input-label  for="content" :value="__('Content')" />
    <x-input-textarea id="content" class="block mt-1 w-full" name="content" rows="12">{{ old('content', $post?->content) }}</x-input-textarea>
    <x-input-error  :messages="$errors->get('content')" class="mt-2" />
</div>