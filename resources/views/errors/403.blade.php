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
            <h3>You aren't supposed to be here. Maybe try another page.</h3>
        </div>
    </div>
@endsection
