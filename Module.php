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

        $AuthManager = \Yii::$app->getAuthManager();
        $ItsMyCommentRule = new \rmrevin\yii\module\Comments\rbac\ItsMyComment();

        $AuthManager->add($ItsMyCommentRule);

        $AuthManager->add(new \yii\rbac\Role(['name' => Permission::CREATE]));
        $AuthManager->add(new \yii\rbac\Role(['name' => Permission::UPDATE]));
        $AuthManager->add(new \yii\rbac\Role(['name' => Permission::UPDATE_OWN, 'ruleName' => $ItsMyCommentRule->name]));
        $AuthManager->add(new \yii\rbac\Role(['name' => Permission::DELETE]));
        $AuthManager->add(new \yii\rbac\Role(['name' => Permission::DELETE_OWN, 'ruleName' => $ItsMyCommentRule->name]));

        if ($this->userIdentityClass === null) {
            $this->userIdentityClass = \Yii::$app->getUser()->identityClass;
        }
    }
}

