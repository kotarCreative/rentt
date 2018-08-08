@extends('layouts.email')

@section('content')
<h4 style="font-size: 14px; font-weight: 500; font-family: 'Roboto'; margin-bottom: 6px;">Hi {{ $owner->first_name }},</h4>

<p style="padding: 10px 0px; font-size: 14px; line-height: 1.2; font-weight: 200; font-family: 'Roboto';">{{ $user->first_name }} {{ $user->last_name }} wants to talk to you about your property. They have left you a personal message below.</p>

<p style="padding: 10px 0px; font-size: 14px; line-height: 1.2; font-weight: 200; font-family: 'Roboto';">"{{ $content->message }}"</p>

<p style="padding: 10px 0px; font-size: 14px; line-height: 1.2; font-weight: 200; font-family: 'Roboto';">You can contact them best by {{ $content->contact_form }} at {{ isset($content->phone_num) ? $content->phone_num : $user->email }}.</p>

<a class="btn" href="{{ url('properties/' . $content->property->slug) }}" style="background: #45dd91; color: #fff; font-family: 'Roboto'; padding: 8px 15px; border-radius: 5px; font-size: 14px; text-decoration: none; display: inline-block; margin-right: 10px;">View Your Property</a>
@endsection