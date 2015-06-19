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

    /** @var string */
    public $entity;

    /** @var Comments\models\Comment */
    public $Comment;

    /**
     * @inheritdoc
     */
    public function run()
    {
        CommentFormAsset::register($this->getView());

        $CommentCreateForm = new Comments\forms\CommentCreateForm([
            'Comment' => $this->Comment,
            'entity' => $this->entity,
        ]);

        if ($CommentCreateForm->load(\Yii::$app->getRequest()->post())) {
            if ($CommentCreateForm->validate()) {
                if ($CommentCreateForm->save()) {
                    \Yii::$app->getResponse()
                        ->refresh('#comment-' . $CommentCreateForm->Comment->id)
                        ->send();

                    exit;
                }
            }
        }

        return $this->render('comment-form', [
            'CommentCreateForm' => $CommentCreateForm,
        ]);
    }
}