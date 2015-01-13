<?php
/**
 * main.php
 * @author Roman Revin http://phptime.ru
 */

return [
    'id' => 'testapp',
    'basePath' => realpath(__DIR__ . '/..'),
    'modules' => [
        'comments' => [
            'class' => 'rmrevin\yii\module\Comments\Module',
            'userIdentityClass' => 'rmrevin\yii\module\Comments\tests\unit\models\User',
        ],
    ]
];