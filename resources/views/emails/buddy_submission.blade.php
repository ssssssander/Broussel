@component('mail::message')
# {{ $name }} heeft een aanvraag gedaan om wandelbuddy te worden.<br>
[Klik hier]({{ config('app.url') }}/app/judge?id={{ $id }}) om de aanvraag te beoordelen.

@component('mail::button', ['url' => config('app.url'), 'color' => 'success'])
Ga naar de site
@endcomponent

@endcomponent
