<x-mail::message>
# Verify Email Address

Please enter the following code to verify your email address.

<p style="font-size: 3rem; font-weight: bold; letter-spacing: 0.5rem; text-align: center; margin-bottom: 1.5rem;">
  <strong >{{ $code }}</strong>
</p>

If you did not create an account, no further action is required.

Regards,<br>
{{ config('app.name') }}

</x-mail::message>
