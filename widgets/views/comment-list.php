<?php
/**
 * comment-list.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 *
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $CommentsDataProvider
 */

use rmrevin\yii\fontawesome\FA;
use rmrevin\yii\module\Comments;
use yii\helpers\Html;
use yii\helpers\Json;

/** @var Comments\widgets\CommentListWidget $CommentListWidget */
$CommentListWidget = $this->context;

$comments = [];

echo Html::tag('h3', Yii::t('app', 'Comments'), ['class' => 'comment-title']);

echo yii\widgets\ListView::widget([
    'dataProvider' => $CommentsDataProvider,
    'options' => ['class' => 'comments-list'],
    'layout' => "{items}\n{pager}",
    'itemView' =>
        function (Comments\models\Comment $Comment, $key, $index, yii\widgets\ListView $Widget)
        use (&$comments, $CommentListWidget) {
            ob_start();

            $Formatter = Yii::$app->getFormatter();

            $Author = $Comment->author;

            $comments[$Comment->id] = $Comment->attributes;

            $options = [
                'data-comment' => $Comment->id,
                'class' => 'row comment',
            ];

            if ($index === 0) {
                Html::addCssClass($options, 'first');
            }

            if ($index === ($Widget->dataProvider->getCount() - 1)) {
                Html::addCssClass($options, 'last');
            }

            if ($Comment->isDeleted()) {
                Html::addCssClass($options, 'deleted');
            }

            ?>
            <div <?= Html::renderTagAttributes($options) ?>>
                <div class="col-lg-12">
                    <div class="author">
                        <?php
                        $avatar = false;
                        $name = Yii::t('app', 'Unknown author');
                        $url = false;

                        if (empty($Author)) {
                            $name = empty($Comment->from) ? $name : $Comment->from;
                        } elseif ($Author instanceof Comments\interfaces\CommentatorInterface) {
                            $avatar = $Author->getCommentatorAvatar();
                            $name = $Author->getCommentatorName();
                            $name = empty($name) ? Yii::t('app', 'Unknown author') : $name;
                            $url = $Author->getCommentatorUrl();
                        }

                        $name_html = Html::tag('strong', $name);

                        if (false === $avatar) {
                            $avatar_html = Html::tag('div', FA::icon('male'), [
                                'class' => 'avatar fake',
                                'title' => Yii::t('app', 'Unknown author'),
                            ]);
                        } else {
                            $avatar_html = Html::img($avatar, [
                                'class' => 'avatar',
                                'alt' => Yii::t('app', 'Author avatar'),
                                'title' => $name,
                            ]);
                        }

                        if (false !== $url) {
                            echo Html::a($avatar_html, $url, ['target' => '_blank']);
                            echo Html::a($name_html, $url, ['target' => '_blank']);
                        } else {
                            echo $avatar_html;
                            echo $name_html;
                        }

                        if ((time() - $Comment->created_at) > (86400 * 2)) {
                            echo Html::tag('span', $Formatter->asDatetime($Comment->created_at), ['class' => 'date']);
                        } else {
                            echo Html::tag('span', $Formatter->asRelativeTime($Comment->created_at), ['class' => 'date']);
                        }
                        ?>
                    </div>
                    <div class="text">
                        <?php
                        if ($Comment->isDeleted()) {
                            echo Yii::t('app', 'Comment was deleted.');
                        } else {
                            echo yii\helpers\Markdown::process($Comment->text, 'gfm-comment');

                            if ($Comment->isEdited()) {
                                echo Html::tag('small', Yii::t('app', 'Updated at {date-relative}', [
                                    'date' => $Formatter->asDate($Comment->updated_at),
                                    'date-time' => $Formatter->asDatetime($Comment->updated_at),
                                    'date-relative' => $Formatter->asRelativeTime($Comment->updated_at),
                                ]));
                            }
                        }
                        ?>
                    </div>
                    <?php
                    if ($Comment->canUpdate() && !$Comment->isDeleted()) {
                        ?>
                        <div class="edit">
                            <?php
                            echo Comments\widgets\CommentFormWidget::widget([
                                'entity' => $CommentListWidget->entity,
                                'Comment' => $Comment,
                                'anchor' => $CommentListWidget->anchorAfterUpdate,
                            ]);
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="actions">
                        <?php
                        if (!$Comment->isDeleted()) {
                            if ($Comment->canCreate()) {
                                echo Html::a(FA::icon('reply') . ' ' . Yii::t('app', 'Reply'), '#', [
                                    'class' => 'btn btn-info btn-xs',
                                    'data-role' => 'reply',
                                ]);
                            }

                            if ($Comment->canUpdate()) {
                                echo Html::a(
                                    FA::icon('pencil') . ' ' . Yii::t('app', 'Edit'),
                                    '#',
                                    [
                                        'data-role' => 'edit',
                                        'class' => 'btn btn-primary btn-xs',
                                    ]
                                );
                            }

                            if ($Comment->canDelete()) {
                                echo Html::a(
                                    FA::icon('times') . ' ' . Yii::t('app', 'Delete'),
                                    ['', 'delete-comment' => $Comment->id],
                                    ['class' => 'btn btn-danger btn-xs']
                                );
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <?php

            return ob_get_clean();
        }
]);

/** @var Comments\models\Comment $CommentModel */
$CommentModel = \Yii::createObject(Comments\Module::instance()->model('comment'));

if ($CommentListWidget->showCreateForm && $CommentModel::canCreate()) {
    echo Html::tag('h3', Yii::t('app', 'Add comment'), ['class' => 'comment-title']);

    echo Comments\widgets\CommentFormWidget::widget([
        'theme' => $CommentListWidget->theme,
        'entity' => $CommentListWidget->entity,
        'Comment' => $CommentModel,
        'anchor' => $CommentListWidget->anchorAfterUpdate,
    ]);
}

$CommentListWidget
    ->getView()
    ->registerJs('jQuery("#' . $CommentListWidget->options['id'] . '").yiiCommentsList(' . Json::encode($comments) . ');');
