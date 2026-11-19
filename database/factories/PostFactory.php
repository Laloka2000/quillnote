<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = rtrim(fake()->unique()->sentence(rand(4, 8)), '.');

        return [
            'title' => $title,
            'slug' => fn(array $attributes) => Str::slug($attributes['title']),
            'content' => $this->fakeContent(),
            'image' => fn() => $this->storeRandomImage(),
            'category_id' => Category::factory(),
            'user_id' => User::factory(),
            'published_at' => fake()->dateTimeBetween('-6 months', 'now'),
        ];
    }

    public function draft(): static
    {
        return $this->state(fn() => [
            'published_at' => null,
        ]);
    }

    public function scheduled(): static
    {
        return $this->state(fn() => [
            'published_at' => fake()->dateTimeBetween('+1 day', '+1 month'),
        ]);
    }

    private function fakeContent(): string
    {
        return collect(range(1, rand(6, 12)))
            ->map(fn() => fake()->realTextBetween(300, 700))
            ->implode("\n\n");
    }

    private function storeRandomImage(): string
    {
        $images = glob(database_path('seeders/images/*.jpg'));

        if (empty($images)) {
            throw new RuntimeException('No seed images found in database/seeders/images.');
        }

        return Storage::disk('public')->putFile('posts', new File(fake()->randomElement($images)));
    }
}
