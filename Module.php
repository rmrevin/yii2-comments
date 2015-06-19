<?php
/**
 * Module.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace rmrevin\yii\module\Comments;

/**
 * Class Module
 * @package rmrevin\yii\module\Comments
 */
class Module extends \yii\base\Module
{

    const NAME = 'comments';

    /** @var string|null */
    public $userIdentityClass = null;

    /** @var bool */
    public $useRbac = true;

    public function init()
    {
        parent::init();

        if ($this->userIdentityClass === null) {
            $this->userIdentityClass = \Yii::$app->getUser()->identityClass;
        }
    }
}