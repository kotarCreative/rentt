Hi {{ $reference->first_name }},

{{ $user->first_name }} {{ $user->last_name }} just added you as a reference on Rentt. We just want to make sure you are ok with them using you as a reference. If you go to the address below you can let us know if you want to be used as a reference. If you don't simply go to the second listed address and we will let {{ $user->first_name }} know you don't wish to be used as a reference.

Go to {{ url('references/verify/'. $reference->email_token . '?approve=true') }} to approve being used as a reference.

Go to {{ url('references/verify/'. $reference->email_token . '?approve=false') }} to deny being used as a reference.

Thanks,
The Rentt Team