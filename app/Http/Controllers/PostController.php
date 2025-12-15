<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Post;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;

class PostController extends Controller
{   
    public function index()
    {
        $posts = Post::latest()->paginate(10);

        return view('posts.index', compact('posts'));
    }

    public function store(StorePostRequest $request)
    {
        $data = $request->validated();

        $post = Post::create($data);

        return redirect()->route('posts.index')->with('success', 'Post Created successfully');
    }

    public function update(UpdatePostRequest $request)
    {
        $data = $request->validated();

        
    }
}
