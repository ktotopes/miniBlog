<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();

        return view('post.index', compact('posts'));
    }

    public function create()
    {
        return view('post.create');
    }

    public function store(PostRequest $request)
    {
        if (auth()->user()->is_admin == 0) {
            return redirect()->route('post.index');
        }

        $imgName = '';

        if ($request->file('image')) {
            $imgName = Str::random(32) . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs(formattedStorageString(), $imgName);
        }
        $replaceImg = str_replace('public', '/storage', formattedStorageString() . '/' . $imgName);

        Post::create([
            ...$request->validated(),
            'image' => $replaceImg,
            'user_id' => auth()->user()->id,
        ]);

        return redirect()->route('post.index');
    }

    public function show(Post $post)
    {
        return view('post.show', compact('post'));
    }
}
