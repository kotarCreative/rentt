Hi {{ $user->first_name }},

{{ $content->name }} has provided feedback. They have left a message below.

They are reporting an issue of type "{{ $content->issue }}" and {{ $content->respond ? 'would like' : 'don\'t want' }} a response.

"{{ $content->message }}"

You can contact them at {{ $content->email }}.
