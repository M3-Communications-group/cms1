<?php

return [
   'settings' => [
        // Slim Settings
        'displayErrorDetails' => DEV_MODE,
        'addContentLengthHeader' => false,
        'determineRouteBeforeAppMiddleware' => true,
        // View settings
        'view' => [
            'template_path' => __DIR__ . '/../app/templates', ///var/www/clients/client1/web34/web/app/templates
            'twig' => [
                //'cache' => __DIR__ . '/../Cache/twig',
                'debug' => DEV_MODE,
                //'auto_reload' => true,
            ],
        ],
    ],
    'DB' => new \M3\Core\DB()
];