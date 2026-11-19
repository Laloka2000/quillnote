<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if (app()->isLocal()) {
            Storage::disk('public')->deleteDirectory('posts');
        }

        $titles = require database_path('data/post-titles.php');

        $categories = collect(array_keys($titles))
            ->map(fn(string $name) => Category::create(['name' => $name]));

        $demo = User::factory()->create([
            'name' => 'Demo User',
            'username' => 'demo',
            'email' => config('demo.email'),
            'password' => config('demo.password'),
            'bio' => 'This is the demo account. Feel free to look around, write a post or like something.',
        ]);

        $anna = User::factory()->create([
            'name' => 'Anna Kovács',
            'username' => 'anna',
            'email' => 'anna@example.com',
        ]);

        $users = User::factory(8)->create()->push($demo, $anna);

        // One published post for every title of every category, with a random author
        foreach ($categories as $category) {
            Post::factory()
                ->for($category)
                ->recycle($users)
                ->forEachSequence(
                    ...collect($titles[$category->name])->map(fn(string $title) => ['title' => $title])
                )
                ->create();
        }

        // The demo account should also showcase the draft and scheduling features
        Post::factory()->draft()->for($demo)->recycle($categories)
            ->create(['title' => 'Half-Finished Thoughts on Laravel Policies']);
        Post::factory()->scheduled()->for($demo)->recycle($categories)
            ->create(['title' => 'What I Am Building Next']);

        // Follows: each person follows 2–5 other users
        foreach ($users as $user) {
            $user->following()->attach(
                $users->except($user->id)->random(rand(2, 5))
            );
        }

        // Likes: 0–8 random users like each published post
        Post::published()->each(function (Post $post) use ($users) {
            $post->likes()->createMany(
                $users->random(rand(0, 8))->map(fn(User $user) => ['user_id' => $user->id])
            );
        });
    }
}
