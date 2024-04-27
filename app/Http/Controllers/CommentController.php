<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(CommentRequest $request)
    {
        Comment::create([
            ...$request->validated(),
            'user_id' => auth()->user()->id,
            'commentable_id' => $request->input('post_id'),
            'commentable_type' => Post::class,
        ]);

        return back();
    }

    public function replyStore(CommentRequest $request, Comment $comment)
    {
        Comment::create([
            ...$request->validated(),
            'user_id' => auth()->user()->id,
            'comment_id' => $comment->id,
        ]);

        return back();
    }

    public function deleteComment(Comment $comment)
    {
        $comment->delete();

        return back()->with('success', 'Comment deleted successfully');
    }
}
