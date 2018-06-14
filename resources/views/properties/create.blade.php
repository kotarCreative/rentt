@extends('layouts.creation')

@section('title', isset($property) ? 'Edit Property' : 'Create Property')

@section('content')
<property-creation :existing="{{ isset($property) ? json_encode($property) : '{}' }}"></property-creation>
@endsection
