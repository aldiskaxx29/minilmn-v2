@component('mail::message')
# Email Verification Forgot Password

Your four-digit code is 
@component('mail::button', ['url' => ''])
{{$message['code']}}
@endcomponent

Berlaku sampai {{ $message['expired'] }},<br>

Thanks,<br>
{{ config('app.name') }}
@endcomponent