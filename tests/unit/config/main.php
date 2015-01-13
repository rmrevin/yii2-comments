<?php
/**
 * main.php
 * @author Roman Revin http://phptime.ru
 */

use rmrevin\yii\module\Comments;

return [
    'id' => 'testapp',
    'basePath' => realpath(__DIR__ . '/..'),
    'modules' => [
        'comments' => [
            'class' => Comments\Module::class,
            'userIdentityClass' => Comments\tests\unit\models\User::class,
        ],
    ]
];