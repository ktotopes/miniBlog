@extends('layouts.app')

@section('content')
    <style>
        .reply-indent {
            margin-left: 20px;
            padding-left: 20px;
        }

        .comment-background {
            background-color: #f8f9fa;
        }
    </style>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow mb-5">
                    <div class="card-body">
                        <h2 class="card-title">{{ $post->title }}</h2>
                        <div>
                            <span>{!! $post->content !!}</span>
                        </div>
                        <img src="{{$post->image}}" alt="">
                    </div>
                </div>
                <div class="card shadow mb-3">
                    <div class="card-body">
                        <h4 class="mb-3">Add a comment</h4>
                        <form method="post" action="{{route('comment.add')}}">
                            @csrf
                            <div class="mb-3">
                                <input type="text" name="text" class="form-control" placeholder="Enter your comment"
                                       aria-label="Comment" />
                                <input type="hidden" name="post_id" value="{{ $post->id }}" />
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-warning">Add Comment</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card shadow">
                    <div class="card-body">
                        <h4>Comments</h4>
                        @foreach($post->comments as $comment)
                            <div class="mb-4 ps-3 pe-3 pt-2 comment-background border rounded">
                                <strong>{{ $comment->user->name }}</strong>
                                <p>{{ $comment->text }}</p>
                                @if(isset(auth()->user()->id) && auth()->user()->id == $comment->user->id)
                                    <div class="justify-content-between">
                                        <form action="{{route('delete.comment',$comment->id)}}" method="post">
                                            @csrf
                                            <button class="btn-danger btn btn-sm">Delete</button>
                                        </form>
                                    </div>
                                @endif
                                <div>
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="collapse"
                                            data-bs-target="#replyForm-{{ $comment->id }}" aria-expanded="false"
                                            aria-controls="replyForm-{{ $comment->id }}">Reply
                                    </button>
                                    <div class="collapse mt-2" id="replyForm-{{ $comment->id }}">
                                        <form method="post" action="{{ route('reply.add', $comment->id) }}">
                                            @csrf
                                            <div class="mb-3">
                                                <input type="text" name="text" placeholder="Enter your reply"
                                                       class="form-control" />
                                                <input type="hidden" name="post_id" value="{{ $post->id }}" />
                                                <input type="hidden" name="comment_id" value="{{ $comment->id }}" />
                                            </div>
                                            <button type="submit" class="btn btn-warning">Submit Reply</button>
                                        </form>
                                    </div>
                                    <div class="mt-3 ms-4">
                                        @include('comment.comment_replies', ['comments' => $comment->replies])
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
