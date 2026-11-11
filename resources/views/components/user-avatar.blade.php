@props(['user', 'size' => 'w-12 h-12'])

@if ($user->image)
    <img src="{{ Storage::url($user->image) }}" alt="{{ $user->name }}"
        {{ $attributes->merge(['class' => "$size rounded-full object-cover"]) }}>
@else
    <div {{ $attributes->merge(['class' => "$size rounded-full bg-gray-200 flex items-center justify-center font-semibold text-gray-600"]) }}>
        {{ Str::upper(Str::substr($user->name, 0, 1)) }}
    </div>
@endif
