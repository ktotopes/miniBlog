<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'text' => 'required',
        ]);

        Comment::create([
            ...$validated,
            'user_id' => auth()->user()->id,
            'commentable_id' => $request->input('post_id'),
            'commentable_type' => Post::class,
        ]);

        return back();
    }

    public function replyStore(Request $request, Comment $comment)
    {
        $validated = $request->validate([
            'text' => 'required',
        ]);

        Comment::create([
            ...$validated,
            'user_id' => auth()->user()->id,
            'comment_id' => $request->input('comment_id'),
        ]);

        return back();
    }

    public function deleteComment(Comment $comment)
    {
        $comment->delete();

        return back()->with('success', 'Comment deleted successfully');
    }
}
