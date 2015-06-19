<?php
/**
 * comment-form.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 *
 * @var yii\web\View $this
 * @var Comments\forms\CommentCreateForm $CommentCreateForm
 */

use rmrevin\yii\module\Comments;
use yii\helpers\Html;

/** @var Comments\widgets\CommentFormWidget $Widget */
$Widget = $this->context;

?>

<a name="commentcreateform"></a>
<div class="row comment-form">
    <div class="col-xs-12 col-sm-9 col-md-6 col-lg-4">
        <?php
        /** @var \yii\widgets\ActiveForm $form */
        $form = \yii\widgets\ActiveForm::begin();

        echo Html::activeHiddenInput($CommentCreateForm, 'id');

        $options = [];
        if ($Widget->Comment->isNewRecord) {
            $options['data-role'] = 'new-comment';
        }
        echo $form->field($CommentCreateForm, 'text')
            ->textarea($options);

        ?>
        <div class="actions">
            <?php
            echo Html::submitButton(\Yii::t('app', 'Post comment'), [
                'class' => 'btn btn-primary',
            ]);
            echo Html::resetButton(\Yii::t('app', 'Cancel'), [
                'class' => 'btn btn-link',
            ]);
            ?>
        </div>
        <?php
        \yii\widgets\ActiveForm::end();
        ?>
    </div>
</div>