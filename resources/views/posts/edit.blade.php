@extends('layout')

@section('content')

    <form class="border rounded mt-5 p-4" action="{{ route('posts.update', ['post' => $post->id]) }}" method="post">
        @csrf
        @method('PUT')

        @include('posts._form')

        <button class="btn btn-primary btn-lg px-5" type="submit">Edit</button>
    </form>

@endsection
