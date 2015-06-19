<?php
/**
 * Permission.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace rmrevin\yii\module\Comments;

/**
 * Class Permission
 * @package rmrevin\yii\module\Comments
 */
class Permission
{

    const CREATE = 'comments.create';
    const UPDATE = 'comments.update';
    const UPDATE_OWN = 'comments.update.own';
    const DELETE = 'comments.delete';
    const DELETE_OWN = 'comments.delete.own';
}