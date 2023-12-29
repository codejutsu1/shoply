<x-mail::message>
# Welcome {{ $user->name }},

You are welcome to our E commerce application. Thank you for creating an account with us. 
Please verify your email using this link.

<x-mail::button url="{{ route('verify', $user->verification_token) }}" >
Verify Email Address
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
