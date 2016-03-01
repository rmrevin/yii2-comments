<?php
/**
 * CommentListWidget.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace rmrevin\yii\module\Comments\widgets;

use rmrevin\yii\module\Comments;
use yii\helpers\Html;

/**
 * Class CommentListWidget
 * @package rmrevin\yii\module\Comments\widgets
 */
class CommentListWidget extends \yii\base\Widget
{

    /** @var string|null */
    public $theme;

    /** @var string */
    public $viewFile = 'comment-list';

    /** @var array */
    public $viewParams = [];

    /** @var array */
    public $options = ['class' => 'comments-widget'];

    /** @var string */
    public $entity;

    /** @var string */
    public $anchorAfterUpdate = '#comment-%d';

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
     * Register asset bundle
     */
    protected function registerAssets()
    {
        CommentListAsset::register($this->getView());
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $this->registerAssets();

        $this->processDelete();

        /** @var Comments\models\Comment $CommentModel */
        $CommentModel = \Yii::createObject(Comments\Module::instance()->model('comment'));
        $CommentsQuery = $CommentModel::find()
            ->byEntity($this->entity);

        if (false === $this->showDeleted) {
            $CommentsQuery->withoutDeleted();
        }

        $CommentsDataProvider = \Yii::createObject([
            'class' => \yii\data\ActiveDataProvider::className(),
            'query' => $CommentsQuery->with(['author', 'lastUpdateAuthor']),
            'pagination' => $this->pagination,
            'sort' => $this->sort,
        ]);

        $params = $this->viewParams;
        $params['CommentsDataProvider'] = $CommentsDataProvider;

        $content = $this->render($this->viewFile, $params);

        return Html::tag('div', $content, $this->options);
    }

    private function processDelete()
    {
        $delete = (int)\Yii::$app->getRequest()->get('delete-comment');
        if ($delete > 0) {

            /** @var Comments\models\Comment $CommentModel */
            $CommentModel = \Yii::createObject(Comments\Module::instance()->model('comment'));

            /** @var Comments\models\Comment $Comment */
            $Comment = $CommentModel::find()
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

            $Comment->deleted = $CommentModel::DELETED;
            $Comment->update();
        }
    }

    /**
     * @inheritdoc
     */
    public function getViewPath()
    {
        return empty($this->theme)
            ? parent::getViewPath()
            : (\Yii::$app->getViewPath() . DIRECTORY_SEPARATOR . $this->theme);
    }
}