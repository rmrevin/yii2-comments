<?php
/**
 * index.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

use rmrevin\yii\module\Comments\tests\web\models\User;
use rmrevin\yii\module\Comments\widgets\CommentListWidget;
use yii\helpers\Html;

/** @var User $User */
$User = \Yii::$app->getUser()->getIdentity();

?>
    <div class="login">
        <?php
        if (\Yii::$app->getUser()->getIsGuest()) {
            echo 'Not logged. ';
            echo Html::a('Login', ['/sign/in']);
        } else {
            echo sprintf('Logged as %s. ', $User->name);
            echo Html::a('Logout', ['/sign/out']);
        }
        ?>
    </div>
<?php

echo CommentListWidget::widget([
    'entity' => 'test-1',
]);