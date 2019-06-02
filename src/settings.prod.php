<?php

/* Settings for production environment. */

return [
    'settings' => [
        'debug' => false,
        'displayErrorDetails' => false,
        'addContentLengthHeader' => true,

        // Renderer settings
        'view' => [
            'templatePath' => __DIR__ . '/../src/views/',
            'cache' => '../cache/',
        ],
    ],
];
