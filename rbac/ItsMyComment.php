<?php
/**
 * ItsMyComment.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace rmrevin\yii\module\Comments\rbac;

/**
 * Class ItsMyComment
 * @package rmrevin\yii\module\Comments\rbac
 */
class ItsMyComment extends \yii\rbac\Rule
{

    public $name = 'comments.its-my-comment';

    /**
     * @inheritdoc
     */
    public function execute($user, $item, $params)
    {
        return (int)$user === (int)$params['Comment']->created_by;
    }
}