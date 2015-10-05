<?php

return [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [],
    'controllerNamespace' => 'app\commands',
    'components' => [
        'db' => require(__DIR__ . '/db.php'),
    ],
    'params' => [],
];
