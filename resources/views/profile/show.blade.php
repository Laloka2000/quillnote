<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col-reverse lg:flex-row gap-8">

                {{-- Posztok --}}
                <div class="flex-1">
                    <h1 class="text-4xl font-bold text-gray-900 mb-8 px-4 sm:px-0">
                        {{ $user->name }}
                    </h1>

                    @forelse ($posts as $post)
                        <x-post-item :post="$post" />
                    @empty
                        <p class="text-gray-500 px-4 sm:px-0">No posts yet.</p>
                    @endforelse

                    {{ $posts->links() }}
                </div>

                {{-- Oldalsáv --}}
                <aside class="lg:w-80 shrink-0">
                    <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                        <x-user-avatar :user="$user" size="w-24 h-24" class="text-3xl" />

                        <h2 class="mt-4 text-lg font-semibold text-gray-900">{{ $user->name }}</h2>
                        <p class="text-sm text-gray-500">{{ '@' . $user->username }}</p>
                        <p class="mt-1 text-sm text-gray-500">
                            {{ $posts->total() }} posts
                            . {{ $user->followers_count }} followers
                            . {{ $user->following_count }} following
                        </p>

                        @if ($user->bio)
                            <p class="mt-4 text-gray-700 whitespace-pre-line">{{ $user->bio }}</p>
                        @endif

                        @if (auth()->user()?->is($user))
                            <a href="{{ route('profile.edit') }}" class="mt-6 inline-block text-sm font-medium text-blue-600 hover:underline">
                                Edit profile
                            </a>
                        @elseif ($isFollowing)
                            <form method="POST" action="{{ route('follow.destroy', $user) }}" class="mt-6">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-5 py-2 rounded-full border border-gray-300 text-sm font-medium text-gray-700 hover:bg-gray-50">
                                    Following
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('follow.store', $user) }}" class="mt-6">
                                @csrf
                                <button type="submit" class="px-5 py-2 rounded-full bg-gray-900 text-sm font-medium text-white hover:bg-gray-700">
                                    Follow
                                </button>
                            </form>
                        @endif
                    </div>
                </aside>
            </div>
        </div>
    </div>
</x-app-layout>
