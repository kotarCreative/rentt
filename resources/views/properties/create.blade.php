@extends('layouts.creation')

@section('title', $property->id ? 'Edit Property' : 'Create Property')

@section('content')
<property-creation :existing="{{ json_encode($property) }}"></property-creation>
@endsection
