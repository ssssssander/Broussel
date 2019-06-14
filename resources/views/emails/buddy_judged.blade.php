@component('mail::message')
    # Beste {{ $name }}

    @if($status == 'accepted')
        Proficiat! Je aanvraag om wandelbuddy op broussel.be te worden is geaccepteerd, je kan met dit wachtwoord inloggen als wandelbuddy:<br>
        <strong>{{ $password }}</strong><br>
        Verander onmiddelijk je wachtwoord na het inloggen met dit wachtwoord door naar instellingen te gaan. Gebruik het e-mailadres waarmee je deze mail hebt gekregen.
    @else
        Je aanvraag om wandelbuddy te worden op broussel.be is helaas geweigerd, bedankt voor je interesse.
    @endif

    @component('mail::button', ['url' => config('app.url')])
        Ga naar de site
    @endcomponent

    Bedankt voor het gebruiken van onze service,<br>
    het team van {{ config('app.name') }}
@endcomponent
