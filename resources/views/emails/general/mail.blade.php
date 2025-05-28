@component('mail::message')
    Bonjour {{ $insertion->first_name }} {{ $insertion->last_name   }},<br>
    Vos identifiants : <br>
    Email : <strong>{{ $insertion->email }}</strong><br>
    Votre mot de passe est : <strong>{{ $password }}</strong><br>
    Cordialement, <br>
    {{ config('app.name') }}<br>
    <p>{{ 'Tel :' }} 01 84 20 46 49 | {{ 'Email :' }}  contact@harmen-botts.com|
        {{ 'Adresse' }} : HARMEN & BOTTS, 37 av. du Roule 92200 Neuilly/Seine</p>
@endcomponent
