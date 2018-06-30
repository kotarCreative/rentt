@extends('layouts.email')

@section('content')
<h4 style="font-size: 14px; font-weight: 500; font-family: 'Roboto'; margin-bottom: 6px;">Hi {{ $user->first_name }},</h4>

<p style="padding: 10px 0px; font-size: 14px; line-height: 1.2; font-weight: 200; font-family: 'Roboto';">{{ $content->name }} has provided feedback. They have left a message below.</p>

<p style="padding: 10px 0px; font-size: 14px; line-height: 1.2; font-weight: 200; font-family: 'Roboto';">
    They are reporting an issue of type "{{ $content->issue }}" and {{ $content->respond ? 'would like' : 'don\'t want' }} a response.
</p>

<p style="padding: 10px 0px; font-size: 14px; line-height: 1.2; font-weight: 200; font-family: 'Roboto';">"{{ $content->message }}"</p>

<p style="padding: 10px 0px; font-size: 14px; line-height: 1.2; font-weight: 200; font-family: 'Roboto';">You can contact them at {{ $content->email }}.</p>
@endsection
