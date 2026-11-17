@php
    $url = route('post.show', ['user' => $post->user, 'post' => $post]);
@endphp

<article class="flex bg-white border border-gray-200 rounded-lg shadow-sm mb-8 overflow-hidden">
    <div class="p-5 flex-1">
        <div class="flex items-center gap-2 mb-2 text-sm text-gray-500">
            <a href="{{ route('profile.show', $post->user) }}" class="font-medium text-gray-900 hover:underline">
                {{ $post->user->name }}
            </a>
            <span>|</span>
            <span>{{ $post->category->name }}</span>
            <span>|</span>
            <span>{{ $post->readTime() }} min read</span>
            <span>|</span>
            <time datetime="{{ $post->created_at->toDateString() }}">
                {{ $post->created_at->format('Y. m. d.') }}
            </time>
            <span>|</span>
            <span>{{ $post->likes_count }} likes</span>
        </div>

        <a href="{{ $url }}">
            <h2 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 hover:underline">
                {{ $post->title }}
            </h2>
        </a>

        <p class="mb-4 text-gray-700">
            {{ Str::words($post->content, 20) }}
        </p>

        <a href="{{ $url }}"
            class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-800 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition">
            Read more
            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 12H5m14 0-4 4m4-4-4-4" />
            </svg>
        </a>
    </div>

    <a href="{{ $url }}" class="hidden sm:block shrink-0 w-48">
        <img class="w-full h-full object-cover" src="{{ Storage::url($post->image) }}" alt="{{ $post->title }}">
    </a>
</article>