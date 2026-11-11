<ul class="flex flex-wrap justify-center gap-2 text-sm font-medium text-center text-gray-500">
    <li>
        <a href="{{ route('dashboard') }}"
            @class([
                'inline-block px-4 py-2.5 rounded-lg',
                'text-white bg-blue-600' => ! $active,
                'hover:text-gray-900 hover:bg-gray-100' => $active,
            ])
            @if (! $active) aria-current="page" @endif>
            All
        </a>
    </li>

    @foreach ($categories as $category)
        @php($isActive = $active?->is($category))

        <li>
            <a href="{{ route('post.byCategory', $category) }}"
                @class([
                    'inline-block px-4 py-2.5 rounded-lg',
                    'text-white bg-blue-600' => $isActive,
                    'hover:text-gray-900 hover:bg-gray-100' => ! $isActive,
                ])
                @if ($isActive) aria-current="page" @endif>
                {{ $category->name }}
            </a>
        </li>
    @endforeach
</ul>
