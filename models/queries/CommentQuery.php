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
 *
 * @method \rmrevin\yii\module\Comments\models\Comment|array|null one($db = null)
 * @method \rmrevin\yii\module\Comments\models\Comment[]|array all($db = null)
 */
class CommentQuery extends \yii\db\ActiveQuery
{

    /**
     * @param integer|array $id
     * @return static
     */
    public function byId($id)
    {
        $this->andWhere(['id' => $id]);

        return $this;
    }

    /**
     * @param string|array $entity
     * @return static
     */
    public function byEntity($entity)
    {
        $this->andWhere(['entity' => $entity]);

        return $this;
    }

    /**
     * @return static
     */
    public function withoutDeleted()
    {
        /** @var Comments\models\Comment $CommentModel */
        $CommentModel = \Yii::createObject(Comments\Module::instance()->model('comment'));

        $this->andWhere(['deleted' => $CommentModel::NOT_DELETED]);

        return $this;
    }
}
