@extends('layout')

@section('content')

    <form class="border rounded mt-5 p-4" action="{{ route('posts.store') }}" method="post">
        @csrf
        <h2>Create Blog Post</h2>
        @include('posts._form')

        <button class="btn btn-primary btn-lg px-5" type="submit">Create</button>
    </form>

@endsection
