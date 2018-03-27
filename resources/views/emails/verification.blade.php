@extends('layouts.email')

@section('content')
<h4 style="font-size: 16px; font-weight: 500; font-family: 'Roboto'; margin-bottom: 6px;">Hey,</h4>

<p style="padding: 10px 0px; font-size: 14px; line-height: 1.2; font-weight: 200;">Welcome to Rentt! We just want to make sure you aren't a robot. If you confirm your email address by clicking the link below we can make sure your new account isn't deleted.</p>

<a class="btn" href="{{ url('register/verify/'. $user->email_token) }}" style="background: #45dd91; color: #fff; font-family: 'Roboto'; padding: 8px 15px; border-radius: 5px; font-size: 14px; text-decoration: none;">Confirm Email</a>

<h4 style="font-size: 16px; font-weight: 500; font-family: 'Roboto'; margin-bottom: 6px; margin-top: 20px;">Thanks,</h4>
<h4 style="font-size: 16px; font-weight: 500; font-family: 'Roboto'; margin-bottom: 6px; margin-top: 0px;">The Rentt Team</h4>
@endsection
