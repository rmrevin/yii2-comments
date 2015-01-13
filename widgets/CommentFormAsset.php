<?php
/**
 * CommentFormAsset.php
 * @author Revin Roman http://phptime.ru
 */

namespace rmrevin\yii\module\Comments\widgets;

/**
 * Class CommentFormAsset
 * @package rmrevin\yii\module\Comments\widgets
 */
class CommentFormAsset extends \yii\web\AssetBundle
{

    public $sourcePath = '@vendor/rmrevin/yii2-comments/widgets/_assets';

    public $css = [
        'comment-form.css',
    ];
}