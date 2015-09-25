<?php
/**
 * CommentFormWidget.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace rmrevin\yii\module\Comments\widgets;

use rmrevin\yii\module\Comments;

/**
 * Class CommentFormWidget
 * @package rmrevin\yii\module\Comments\widgets
 */
class CommentFormWidget extends \yii\base\Widget
{

    /** @var string|null */
    public $theme;

    /** @var string */
    public $entity;

    /** @var Comments\models\Comment */
    public $Comment;

    /** @var string */
    public $anchor = '#comment-%d';

    /**
     * @inheritdoc
     */
    public function run()
    {
        CommentFormAsset::register($this->getView());

        /** @var Comments\forms\CommentCreateForm $CommentCreateForm */
        $CommentCreateForm = \Yii::$app->getModule(Comments\Module::NAME)->model('CommentCreateForm',
            [
                'Comment' => $this->Comment,
                'entity' => $this->entity,
            ]);

        if ($CommentCreateForm->load(\Yii::$app->getRequest()->post())) {
            if ($CommentCreateForm->validate()) {
                if ($CommentCreateForm->save()) {
                    \Yii::$app->getResponse()
                        ->refresh(sprintf($this->anchor, $CommentCreateForm->Comment->id))
                        ->send();

                    exit;
                }
            }
        }

        return $this->render('comment-form', [
            'CommentCreateForm' => $CommentCreateForm,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getViewPath()
    {
        if (empty($this->theme)) {
            return parent::getViewPath();
        } else {
            return \Yii::$app->getViewPath() . DIRECTORY_SEPARATOR . $this->theme;
        }
    }
}