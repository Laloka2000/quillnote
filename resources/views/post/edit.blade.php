<x-app-layout>
    <div class="mt-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <h1 class="text-2xl font-bold text-gray-900 mb-6">Edit post</h1>

                <form action="{{ route('post.update', $post) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    @include('post.partials.form')

                    <div class="flex items-center gap-4 mt-4">
                        <x-primary-button>Save changes</x-primary-button>
                        <a href="{{ route('post.show', ['user' => $post->user, 'post' => $post]) }}" class="text-sm text-gray-600 hover:underline">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>