<div class="flex bg-white border border-gray-200 rounded-lg shadow-sm shadow-sm mb-8">
    <div class="p-5 flex-1">
        <a href="#">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">
                {{ $post->title }}
            </h5>
        </a>
        <div class="mb-3 font-normal text-gray-700">
            {{ Str::words($post->content, 20) }}
        </div>
        <x-primary-button class="ms-2">
            <a href="#">
                Read more
                <svg class="w-4 h-4 ms-1.5 rtl:rotate-180 -me-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 12H5m14 0-4 4m4-4-4-4" />
                </svg>
            </a>
        </x-primary-button>
    </div>
    <a href="#" class="w-48 h-full max-h-64 object-cover rounded-r-lg">
        <img class="rounded-r-lg" src=" {{ Storage::url($post->image) }}" alt="" />
    </a>
</div>
