<x-app-layout>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mt-8 text-gray-900">
                <div class="p-6 text-gray-900">
                    <x-category-tabs></x-category-tabs>
                </div>
            </div>
            <div class="mt-8 text-gray-900">
                @forelse($posts as $post)
                   <x-post-item :post="$post">

                   </x-post-item>
                @empty
                    <div class="text-center text-gray-600">
                        <p class="text-center text-gray-500">No posts found.</p>
                    </div>
                @endforelse
            </div>
            {{ $posts->onEachSide(1)->links() }}
        </div>
    </div>
</x-app-layout>