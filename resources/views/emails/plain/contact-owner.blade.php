Hi {{ $owner->first_name }},

{{ $user->first_name }} {{ $user->last_name }} wants to talk to you about your property. They have left you a personal message below.

"{{ strip_tags($content->message) }}"

You can contact them best by {{ $content->contact_form }} at {{ isset($content->phone_num) ? $content->phone_num : $user->email }}.

View Your Property at {{ url('properties/' . $content->property->id) }}.


Thanks,
The Rentt Team