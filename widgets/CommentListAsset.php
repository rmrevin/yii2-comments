<?php
/**
 * CommentListAsset.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace rmrevin\yii\module\Comments\widgets;

/**
 * Class CommentListAsset
 * @package rmrevin\yii\module\Comments\widgets
 */
class CommentListAsset extends \yii\web\AssetBundle
{

    public $sourcePath = '@vendor/rmrevin/yii2-comments/widgets/_assets';

    public $css = [
        'comment-list.css',
    ];

    public $js = [
        'comment-list.js',
    ];

    public $depends = [
        '\yii\web\YiiAsset',
        '\yii\web\JqueryAsset',
    ];
}