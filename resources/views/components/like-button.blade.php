@props(['post', 'liked' => false])

<div x-data="{
        liked: @js($liked),
        count: @js($post->likes_count),
        loading: false,
        guest: @js(auth()->guest()),

        async toggle() {

            if (this.guest) {
                window.location.href = @js(route('login'));
                return;
            }

            if (this.loading) return;
            this.loading = true;

            try {
                const response = this.liked
                    ? await axios.delete(@js(route('like.destroy', $post)))
                    : await axios.post(@js(route('like.store', $post)));

                this.liked = response.data.liked;
                this.count = response.data.count;
            } catch (error) {
                console.error(error);
                alert('Something went wrong. Please try again.');
            } finally {
                this.loading = false;
            }
        },
    }"
    {{ $attributes->merge(['class' => 'flex items-center gap-2']) }}>

    <button type="button" @click="toggle" :disabled="loading"
        :aria-pressed="liked.toString()"
        :class="liked ? 'text-red-500' : 'text-gray-400 hover:text-gray-600'"
        class="transition disabled:opacity-50">
        <svg class="w-7 h-7" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
            stroke="currentColor" stroke-width="1.5" :fill="liked ? 'currentColor' : 'none'" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
        </svg>
        <span class="sr-only">Like</span>
    </button>

    <span class="text-sm text-gray-600" x-text="count">{{ $post->likes_count }}</span>
</div>
