<?php
/**
 * MainTest.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace rmrevin\yii\module\Comments\tests\unit\comments;

use rmrevin\yii\module\Comments;

/**
 * Class MainTest
 * @package rmrevin\yii\fontawesome\tests\unit\fontawesome
 */
class MainTest extends Comments\tests\unit\TestCase
{

    public function testMain()
    {
        /** @var Comments\Module $Module */
        $Module = \Yii::$app->getModule('comments');

        $this->assertInstanceOf('rmrevin\yii\module\Comments\Module', $Module);
        $this->assertEquals('rmrevin\yii\module\Comments\tests\unit\models\User', $Module->userIdentityClass);
    }
}