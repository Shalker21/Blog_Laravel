@extends('layout')

@section('content')
    <h1>Contact</h1>
    <p>Hello this is contact</p>

    @can('home.secret')
        <a href="{{ route('secret') }}">Go to special contact details</a>
    @endcan
@endsection
