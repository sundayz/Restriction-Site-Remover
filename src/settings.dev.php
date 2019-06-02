<?php

/* Settings for development environment.
 * Do NOT use in production!
 */

return [
    'settings' => [
        'debug' => isset($_ENV['ENVIRONMENT']) && $_ENV['ENVIRONMENT'] == 'DEBUG',
        'displayErrorDetails' => true,
        'addContentLengthHeader' => true,

        // Renderer settings
        'view' => [
            'templatePath' => __DIR__ . '/../src/views/',
            'cache' => false,
        ],
    ],
];
