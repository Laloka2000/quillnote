<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCreateRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::forListing()->published()->paginate(5);

        return view('post.index', [
            'posts' => $posts,
        ]);
    }

    public function category(Category $category)
    {
        $posts = $category->posts()->forListing()->published()->paginate(5);

        return view('post.index', [
            'posts' => $posts,
            'category' => $category,
        ]);
    }

    public function search(Request $request)
    {
        $term = $request->string('q')->squish()->limit(100, '')->toString();

        if ($term === '') {
            return redirect()->route('dashboard');
        }

        $posts = Post::forListing()
            ->published()
            ->search($term)
            ->paginate(5)
            ->withQueryString();

        return view('post.search', [
            'posts' => $posts,
            'term' => $term,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::get();

        return view('post.create', [
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostCreateRequest $request)
    {
        $data = $request->validated();


        $data['user_id'] = Auth::id();
        $data['slug'] = $this->uniqueSlug($data['title']);
        $data['image'] = $data['image']->store('posts', 'public');

        $post = Post::create($data);

        return redirect()->route('post.show', [
            'user' => Auth::user(),
            'post' => $post,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, User $user, Post $post)
    {
        Gate::authorize('view', $post);

        $post->loadCount('likes');

        return view('post.show', [
            'post' => $post,
            'isLiked' => $post->isLikedBy($request->user()),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        Gate::authorize('update', $post);

        return view('post.edit', [
            'post' => $post,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostUpdateRequest $request, Post $post)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $oldImage = $post->image;
            $data['image'] = $request->file('image')->store('posts', 'public');
        } else {
            unset($data['image']);
        }

        $post->update($data);

        if (isset($oldImage)) {
            Storage::disk('public')->delete($oldImage);
        }

        return redirect()->route('post.show', [
            'user' => $request->user(),
            'post' => $post,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Post $post)
    {
        Gate::authorize('delete', $post);

        $image = $post->image;

        $post->delete();

        Storage::disk('public')->delete($image);

        return redirect()->route('profile.show', $request->user());
    }

    private function uniqueSlug(string $title): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $i = 2;

        while (Post::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }
}
