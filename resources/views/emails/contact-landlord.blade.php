@extends('layouts.email')

@section('content')
<h4 style="font-size: 14px; font-weight: 500; font-family: 'Roboto'; margin-bottom: 6px;">Hi {{ $content->landlord_first_name }},</h4>

<p style="padding: 10px 0px; font-size: 14px; line-height: 1.2; font-weight: 200; font-family: 'Roboto';">{{ $user->first_name }} {{ $user->last_name }} would like to know more about {{ $content->user_name }}. They have left you a personal message below.</p>

<p style="padding: 10px 0px; font-size: 14px; line-height: 1.2; font-weight: 200; font-family: 'Roboto';">"{{ $content->message }}"</p>

<p style="padding: 10px 0px; font-size: 14px; line-height: 1.2; font-weight: 200; font-family: 'Roboto';">You can contact them at {{ $user->email }}.</p>
@endsection
