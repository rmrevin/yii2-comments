<?php
/**
 * Module.php
 * @author Revin Roman http://phptime.ru
 */

namespace rmrevin\yii\module\Comments;

/**
 * Class Module
 * @package rmrevin\yii\module\Comments
 */
class Module extends \yii\base\Module
{

    /** @var string|null */
    public $userIdentityClass = null;

    public function init()
    {
        parent::init();

        if ($this->userIdentityClass === null) {
            $this->userIdentityClass = \Yii::$app->getUser()->identityClass;
        }
    }
}