@extends('layouts.app')

@section('title', $property->title)

@section('content')
<single-property-page :property="{{ json_encode($property) }}"></single-property-page>
@endsection
