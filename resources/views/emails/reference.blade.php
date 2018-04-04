@extends('layouts.email')

@section('content')
<h4 style="font-size: 14px; font-weight: 500; font-family: 'Roboto'; margin-bottom: 6px;">Hi {{ $reference->first_name }},</h4>

<p style="padding: 10px 0px; font-size: 14px; line-height: 1.2; font-weight: 200; font-family: 'Roboto';">{{ $user->first_name }} {{ $user->last_name }} just added you as a reference on Rentt. We just want to make sure you are ok with {{ $user->first_name }} using you as a reference. If you click the button below you can let us know you are ok with being used as a reference. If you don't want to be a reference simply hit the deny button and we will let {{ $user->first_name }} know you don't wish to be used as a reference.</p>

<a class="btn" href="{{ url('profile/references/verify/'. $reference->email_token . '?approve=1') }}" style="background: #45dd91; color: #fff; font-family: 'Roboto'; padding: 8px 15px; border-radius: 5px; font-size: 14px; text-decoration: none; display: inline-block; margin-right: 10px;">Approve</a>
<a class="btn" href="{{ url('profile/references/verify/'. $reference->email_token . '?approve=0') }}" style="background: #EB5757; color: #fff; font-family: 'Roboto'; padding: 8px 15px; border-radius: 5px; font-size: 14px; text-decoration: none; display: inline-block;">Deny</a>

<h4 style="font-size: 14px; font-weight: 500; font-family: 'Roboto'; margin-bottom: 6px; margin-top: 20px;">Thanks,</h4>
<h4 style="font-size: 14px; font-weight: 500; font-family: 'Roboto'; margin-bottom: 6px; margin-top: 0px;">The Rentt Team</h4>
@endsection
