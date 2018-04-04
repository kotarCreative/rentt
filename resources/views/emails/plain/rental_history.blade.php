Hi {{ $rental_history->landlord_first_name }},

{{ $user->first_name }} {{ $user->last_name }} just added you as a previous landlord on Rentt. We just want to make sure you have actually had {{ $user->first_name }} as a tenant. If you follow the link below you can let us know {{ $user->first_name }} was one of your tenants. If {{ $user->first_name }} was not a tenant or you do not wish them to use you in their previous rental history simply follow the second link listed and we will let {{ $user->first_name }} know you don't wish to be used in their rental history listings.

Go to {{ url('profile/rental-history/verify/'. $rental_history->email_token . '?approve=1') }}" to confirm that {{ $user->first_name }} was your tenant.
Go to {{ url('profile/rental-history/verify/'. $rental_history->email_token . '?approve=0') }} to revoke being used in {{ $user->first_name }}'s rental history.

Thanks,
The Rentt Team
