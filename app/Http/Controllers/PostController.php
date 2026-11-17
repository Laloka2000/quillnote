<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCreateRequest;
use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::forListing()->paginate(5);

        return view('post.index', [
            'posts' => $posts,
        ]);
    }

    public function category(Category $category)
    {
        $posts = $category->posts()->forListing()->paginate(5);

        return view('post.index', [
            'posts' => $posts,
            'category' => $category,
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
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
