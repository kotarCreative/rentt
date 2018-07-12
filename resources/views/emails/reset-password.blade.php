@extends('layouts.email')

@section('content')
<h4 style="font-size: 14px; font-weight: 500; font-family: 'Roboto'; margin-bottom: 6px;">Hi,</h4>

<p style="padding: 10px 0px; font-size: 14px; line-height: 1.2; font-weight: 200; font-family: 'Roboto';">A password reset has been requested for this email. If you did not request a password reset you can ignore this email. Click the button below to reset your password.</p>

<a class="btn" href="{{ url('password/reset/'. $token) }}" style="background: #45dd91; color: #fff; font-family: 'Roboto'; padding: 8px 15px; border-radius: 5px; font-size: 14px; text-decoration: none; display: inline-block; margin-right: 10px;">Reset Password</a>
@endsection