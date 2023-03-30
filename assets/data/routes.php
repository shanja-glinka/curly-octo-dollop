<?

return [
    '/' => 'Controllers\Index@Home',

    '/order' => [
        'POST' => 'Controllers\Order@CreateOrder'
    ],
    '/order/:num' => 'Controllers\Order@Index',
    '/order/payment/:num' => [
        'POST' => 'Controllers\Order@Payment'
    ],

    
    '/operation/:num' => 'Controllers\Operation@Index',

    '/payment/:num/callback/success' => 'Controllers\PayCallback@CallSuccess',
    '/payment/:num/callback/fail' => 'Controllers\PayCallback@CallFail',

];
