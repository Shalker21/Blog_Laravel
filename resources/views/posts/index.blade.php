@extends('layout')

@section('content')
    <div class="row mx-auto">
        @forelse ($posts as $post)

            <div class="col-lg-6 mt-3">

                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title"><a href="{{ route('posts.show', ['post' => $post->id]) }}">{{ $post->title }}</a></h3>
                        <p class="card-text">{{ $post->content }}</p>
                        @if ($post->comments_count)
                            <p>{{ $post->comments_count }} Comments</p>
                        @else
                            <p>No comments yet!</p>
                        @endif
                        <small class="d-block mb-3">Added: {{ $post->created_at->diffForHumans() }}</small>
                        <small class="d-block mb-3">By: {{ $post->user->name }}</small>
                        <a class="btn btn-lg btn-primary" role="button" href="{{ route('posts.edit', ['post' => $post->id]) }}">Edit</a>
                        <form class="d-inline" action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-lg">Delete</button>
                        </form>
                    </div>
                </div>

            </div>
            @empty
                <p>No blog posts yet!</p>
        @endforelse
    </div>

@endsection
