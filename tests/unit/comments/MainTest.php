<?php
/**
 * MainTest.php
 * @author Revin Roman http://phptime.ru
 */

namespace rmrevin\yii\module\Comments\tests\unit\comments;

use rmrevin\yii\module\Comments\tests\unit\TestCase;

/**
 * Class MainTest
 * @package rmrevin\yii\fontawesome\tests\unit\fontawesome
 */
class MainTest extends TestCase
{

    public function testMain()
    {
        $this->assertInstanceOf('rmrevin\yii\module\Comments\Module', \Yii::$app->getModule('comments'));
    }
}