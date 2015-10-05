<?php
/**
 * DemoController.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace rmrevin\yii\module\Comments\tests\web\controllers;

/**
 * Class DemoController
 * @package rmrevin\yii\module\Comments\tests\web\controllers
 */
class DemoController extends \yii\web\Controller
{

    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}