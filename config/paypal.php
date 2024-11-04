<?php
/**
 * PayPal Setting & API Credentials
 */

return [
    'mode'    => env('PAYPAL_MODE', 'sandbox'), // Puede ser 'sandbox' o 'live'
    'sandbox' => [
        'client_id'         => env('PAYPAL_SANDBOX_CLIENT_ID', 'AUY3cXxbLkWsQOEMbrME5GmIzNB4S6xhI7AH8CSYoTNpdOVlnAJeoubYKduSubFG98kY0adMgjGCoPe2'), // Tu Client ID de Sandbox
        'client_secret'     => env('PAYPAL_SANDBOX_CLIENT_SECRET', 'EH_Cp7mBZTIXFmVryQoytjyTWLJv6uVbcxlFN-8MbuOEg0l0f9b7DOGj299_8rI74Ff-tQvJQ7PYGlsP'),  // Tu Secret key de Sandbox
        'app_id'            => 'APP-80W284485P519543T', //  Puede que necesites generar un nuevo App ID para Sandbox
    ],
    'live' => [
        'client_id'         => env('PAYPAL_LIVE_CLIENT_ID', ''), // Reemplázalo con tu Client ID de Live cuando lo necesites
        'client_secret'     => env('PAYPAL_LIVE_CLIENT_SECRET', ''), // Reemplázalo con tu Secret key de Live cuando lo necesites
        'app_id'            => env('PAYPAL_LIVE_APP_ID', ''), // Reemplázalo con tu App ID de Live cuando lo necesites
    ],

    'payment_action' => env('PAYPAL_PAYMENT_ACTION', 'Sale'), // Puede ser 'Sale', 'Authorization' o 'Order'
    'currency'       => env('PAYPAL_CURRENCY', 'USD'),
    'notify_url'     => env('PAYPAL_NOTIFY_URL', ''), // Configura tu URL de notificación
    'locale'         => env('PAYPAL_LOCALE', 'en_US'), 
    'validate_ssl'   => env('PAYPAL_VALIDATE_SSL', true), 
];