@extends('layouts.errors')

@section('title', 'Whoops')

@section('content')
    <div class="error-page-wrapper">
        <div class="error-image">
            <img src="/imgs/error-logo.png" alt="There was an error.">
        </div>
        <div class="error-content">
            <h1>Uh Oh!</h1>
            <h3>Something went wrong.</h3>
            <h3>Looks like you are looking in the wrong place.</h3>
        </div>
    </div>
@endsection
