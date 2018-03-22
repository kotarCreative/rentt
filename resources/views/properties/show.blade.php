@extends('layouts.app')

@section('title', $property->title)

@section('content')
@if(session('success'))
    <div class="alert success">
        {{ session('success') }}
    </div>
@endif
<single-property-page :property="{{ json_encode($property) }}"></single-property-page>
@endsection
