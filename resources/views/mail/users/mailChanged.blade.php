<x-mail::message>
# Email Confirmation

Dear {{ $user->name }},

We noticed you changed your email, while that is good, we will need you to verify your new email.

<x-mail::button url="{{ route('verify', $user->verification_token) }}">
Verify new email
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
