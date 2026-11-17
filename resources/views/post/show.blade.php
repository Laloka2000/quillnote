<x-app-layout>
    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6">
            <article class="bg-white p-6 sm:p-10 shadow-sm sm:rounded-lg">
                <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-6">
                    {{ $post->title }}
                </h1>

                <div class="flex items-center gap-4 mb-8">
                    <a href="{{ route('profile.show', $post->user) }}">
                        <x-user-avatar :user="$post->user" />
                    </a>
                    <div>
                        <a href="{{ route('profile.show', $post->user) }}" class="font-medium text-gray-900 hover:underline">
                            {{ $post->user->name }}
                        </a>
                        <div class="text-sm text-gray-500">
                            {{ $post->readTime() }} min read
                            ·
                            <time datetime="{{ $post->created_at->toDateString() }}">
                                {{ $post->created_at->format('Y. m. d.') }}
                            </time>
                        </div>
                    </div>
                </div>

                <img src="{{ Storage::url($post->image) }}" alt="{{ $post->title }}"
                    class="w-full rounded-lg mb-8">

                <div class="text-lg leading-relaxed text-gray-800 whitespace-pre-line">{{ $post->content }}</div>

                <div class="mt-10 pt-6 border-t border-gray-200 flex items-center justify-between">
                    <span class="px-3 py-1 rounded-full bg-gray-100 text-sm text-gray-700">
                        {{ $post->category->name }}
                    </span>

                    <x-like-button :post="$post" :liked="$isLiked" />
                </div>
            </article>
        </div>
    </div>
</x-app-layout>
