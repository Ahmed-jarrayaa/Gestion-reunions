<?php

use function Cake\Core\env;

return [
    /*
     * Debug Level:
     * true = mode développement (affiche les erreurs)
     */
    'debug' => filter_var(env('DEBUG', true), FILTER_VALIDATE_BOOLEAN),

    /*
     * Clé de sécurité : utilisée pour le hachage et l'encryption.
     * À remplacer par la variable d'environnement SECURITY_SALT en production.
     */
    'Security' => [
        'salt' => env('SECURITY_SALT', '422f75615cc9c719b489971fb31d3c2b693c864316c1b8c038f64c338a792bc9'),
    ],

    /*
     * Configuration de la base de données
     */
    'Datasources' => [
        'default' => [
            'className' => 'Cake\Database\Connection',
            'driver' => 'Cake\Database\Driver\Mysql',
            'persistent' => false,
            'host' => 'localhost',
            'port' => 3307, // Port personnalisé pour MySQL sur WAMP
            'username' => 'root',
            'password' => '', // Mets ton mot de passe MySQL ici si tu en as un
            'database' => 'test',
            'encoding' => 'utf8mb4',
            'timezone' => 'UTC',
            'cacheMetadata' => true,
            'log' => false,
            'url' => env('DATABASE_URL', null),
        ],

        'test' => [
            'className' => 'Cake\Database\Connection',
            'driver' => 'Cake\Database\Driver\Mysql',
            'persistent' => false,
            'host' => 'localhost',
            'port' => 3307,
            'username' => 'root',
            'password' => '',
            'database' => 'test_myapp',
            'encoding' => 'utf8mb4',
            'timezone' => 'UTC',
            'cacheMetadata' => true,
            'log' => false,
            'url' => env('DATABASE_TEST_URL', null),
        ],
    ],

    /*
     * Configuration des transports email (utile si tu fais des envois)
     */
    'EmailTransport' => [
    'debug' => [
        'className' => 'Debug'
    ]
],
'Email' => [
    'default' => [
        'transport' => 'debug',
        'from' => 'no-reply@monapp.com'
    ]
]

];
