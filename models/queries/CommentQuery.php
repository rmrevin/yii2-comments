<?php
/**
 * CommentQuery.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace rmrevin\yii\module\Comments\models\queries;

use rmrevin\yii\module\Comments;

/**
 * Class CommentQuery
 * @package rmrevin\yii\module\Comments\models\queries
 */
class CommentQuery extends \yii\db\ActiveQuery
{

    /**
     * @param integer|array $id
     * @return self
     */
    public function byId($id)
    {
        $this->andWhere(['id' => $id]);

        return $this;
    }

    /**
     * @param string|array $entity
     * @return self
     */
    public function byEntity($entity)
    {
        $this->andWhere(['entity' => $entity]);

        return $this;
    }

    /**
     * @return self
     */
    public function withoutDeleted()
    {
        $CommentModelClassName = \Yii::$app->getModule(Comments\Module::NAME)->model('comment');
        /** @var Comments\models\Comment $CommentModel */
        $CommentModel = \Yii::createObject($CommentModelClassName);

        $this->andWhere(['deleted' => $CommentModel::NOT_DELETED]);

        return $this;
    }
}