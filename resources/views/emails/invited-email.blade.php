@component('mail::message')
# Hello {{$name}},

You are invited to **{{$host}}'s** event at **{{$location}}** on **{{$time->format('l jS F  h:i A')}}**. Please tell us if you can attend.

@component('mail::button', ['url' => 'https://theperfecthost.xyz/email/' . $code])
Respond
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
