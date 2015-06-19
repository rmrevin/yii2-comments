<?php
/**
 * CommentatorInterface.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace rmrevin\yii\module\Comments\interfaces;

/**
 * Interface CommentatorInterface
 * @package rmrevin\yii\module\Comments\interfaces
 */
interface CommentatorInterface
{

    /**
     * @return string|false
     */
    public function getCommentatorAvatar();

    /**
     * @return string
     */
    public function getCommentatorName();

    /**
     * @return string|false
     */
    public function getCommentatorUrl();
}