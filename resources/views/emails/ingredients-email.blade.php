@component('mail::message')
# Hello,


For **{{$food_name}}** you are missing this ingredients: <br>
{!! $food_missing !!}



For **{{$drink_name}}** you are missing this ingredients: <br>
{!! $drink_missing !!}



Thanks,<br>
{{ config('app.name') }}
@endcomponent
