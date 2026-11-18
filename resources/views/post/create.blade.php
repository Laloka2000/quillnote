<x-app-layout>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <form action="{{ route('post.store') }}" enctype="multipart/form-data" method="post">

                    @csrf
                    
                    @include('post.partials.form', ['post' => null])

                    <x-primary-button class="mt-4">Save</x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>