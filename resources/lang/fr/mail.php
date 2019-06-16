<?php

return [

    'reset_password' => [
        'subject' => 'Réinitialiser le mot de passe - ' . config('app.name'),
        'receiving' => 'Vous recevez cet email car nous avons reçu une demande de réinitialisation du mot de passe de votre compte.',
        'reset' => 'Réinitialiser le mot de passe',
        'expire' => 'Ce lien de réinitialisation de mot de passe expirera dans les 60 minutes.',
        'no_request' => "Si vous ne l'avez pas fait, vous n'avez rien d'autre à faire.",
    ]

];
