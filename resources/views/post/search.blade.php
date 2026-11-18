<x-app-layout>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-xl font-semibold">
                        Results for “{{ $term }}”
                    </h1>
                    <p class="mt-1 text-sm text-gray-500">
                        {{ $posts->total() }} {{ Str::plural('post', $posts->total()) }} found
                    </p>
                </div>
            </div>

            <div class="mt-8 text-gray-900">
                @forelse ($posts as $post)
                    <x-post-item :post="$post" />
                @empty
                    <p class="text-center text-gray-500">
                        No posts match your search. Try a different keyword.
                    </p>
                @endforelse
            </div>

            {{ $posts->onEachSide(1)->links() }}
        </div>
    </div>
</x-app-layout>
