@extends('layout')

@section('content')

    <div class="jumbotron">
        <h5 class="display-4">{{ $post->title }}</h5>
        <p class="lead">{{ $post->content }}</p>

        <small>Added {{ $post->created_at->diffForHumans() }}</small>

        @if ((new Carbon\Carbon())->diffInMinutes($post->created_at) < 5)
            New!
        @endif
        <hr class="my-2">
        <h4 class="mt-3">Comments</h4>
        @forelse ($post->comments as $comment)
            <div class="card text-left mt-3">
                <div class="card-body">
                    <p class="card-text">{{ $comment->content }}</p>
                    <small class="text-muted">Added {{ $comment->created_at->diffForHumans() }}</small>
                </div>
            </div>

        @empty
            <p>No comments yet!</p>
        @endforelse

    </div>

@endsection
