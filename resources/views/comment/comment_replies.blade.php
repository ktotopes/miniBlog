@foreach($comments as $comment)
    <div class="mb-4 p-3 border rounded">
        <h5 class="mb-1"><strong>{{ $comment->user->name }}</strong></h5>
        <p>{{ $comment->text }}</p>

        @if(isset(auth()->user()->id) && auth()->user()->id == $comment->user->id || auth()->user()->is_admin == 1)
            <div class="justify-content-between">
                <form action="{{route('delete.comment',$comment->id)}}" method="post">
                    @csrf
                    <button class="btn-danger btn btn-sm">Delete</button>
                </form>
            </div>
        @endif

        <button class="btn btn-sm btn-primary" data-bs-toggle="collapse" data-bs-target="#replyForm-{{ $comment->id }}" aria-expanded="false" aria-controls="replyForm-{{ $comment->id }}">
            Reply
        </button>

        <div class="collapse mt-2" id="replyForm-{{ $comment->id }}">
            <form method="post" action="{{ route('reply.add',$comment->id) }}">
                @csrf
                <div class="mb-3">
                    <input type="text" name="text" placeholder="Enter your reply" class="form-control" />
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
@endforeach
