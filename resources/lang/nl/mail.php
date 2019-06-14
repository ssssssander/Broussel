<?php

return [

    'reset_password' => [
        'subject' => 'Reset wachtwoord - ' . config('app.name'),
        'receiving' => 'Je krijgt deze e-mail omdat we een verzoek hebben gekregen om het wachtwoord van je account te resetten.',
        'reset' => 'Reset wachtwoord',
        'expire' => 'Deze wachtwoord reset link zal verlopen binnen :count minuten.',
        'no_request' => 'Als je dit niet hebt gedaan hoef je verder niets doen.',
    ]

];
