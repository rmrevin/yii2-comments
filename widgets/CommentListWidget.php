<?php
/**
 * CommentListWidget.php
 * @author Revin Roman http://phptime.ru
 */

namespace rmrevin\yii\module\Comments\widgets;

use rmrevin\yii\module\Comments;

/**
 * Class CommentListWidget
 * @package rmrevin\yii\module\Comments\widgets
 */
class CommentListWidget extends \yii\base\Widget
{

    /** @var array */
    public $options = ['class' => 'comments-widget'];

    /** @var string */
    public $entity;

    /** @var array */
    public $pagination = [
        'pageParam' => 'page',
        'pageSizeParam' => 'per-page',
        'pageSize' => 20,
        'pageSizeLimit' => [1, 50],
    ];

    /** @var array */
    public $sort = [
        'defaultOrder' => [
            'id' => SORT_ASC,
        ],
    ];

    /** @var bool */
    public $showDeleted = true;

    /** @var bool */
    public $showCreateForm = true;

    public function init()
    {
        parent::init();

        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        CommentListAsset::register($this->getView());

        $this->processDelete();

        $CommentsQuery = Comments\models\Comment::find()
            ->byEntity($this->entity);

        if (false === $this->showDeleted) {
            $CommentsQuery->withoutDeleted();
        }

        $CommentsDataProvider = new \yii\data\ActiveDataProvider([
            'query' => $CommentsQuery->with(['author', 'lastUpdateAuthor']),
            'pagination' => $this->pagination,
            'sort' => $this->sort,
        ]);

        $content = $this->render('comment-list', [
            'CommentsDataProvider' => $CommentsDataProvider,
        ]);

        return \yii\helpers\Html::tag('div', $content, $this->options);
    }

    private function processDelete()
    {
        $delete = (int)\Yii::$app->getRequest()->get('delete-comment');
        if ($delete > 0) {
            /** @var Comments\models\Comment $Comment */
            $Comment = Comments\models\Comment::find()
                ->byId($delete)
                ->one();

            if ($Comment->isDeleted()) {
                return;
            }

            if (!($Comment instanceof Comments\models\Comment)) {
                throw new \yii\web\NotFoundHttpException(\Yii::t('app', 'Comment not found.'));
            }

            if (!$Comment->canDelete()) {
                throw new \yii\web\ForbiddenHttpException(\Yii::t('app', 'Access Denied.'));
            }

            $Comment->deleted = Comments\models\Comment::DELETED;
            $Comment->update();
        }
    }
}