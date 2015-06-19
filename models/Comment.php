<?php
/**
 * Comment.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace rmrevin\yii\module\Comments\models;

use rmrevin\yii\module\Comments;

/**
 * Class Comment
 * @package rmrevin\yii\module\Comments\models
 *
 * @property integer $id
 * @property string $entity
 * @property string $text
 * @property integer $deleted
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property \yii\db\ActiveRecord $author
 * @property \yii\db\ActiveRecord $lastUpdateAuthor
 *
 * @method queries\CommentQuery hasMany(string $class, array $link) see BaseActiveRecord::hasMany() for more info
 * @method queries\CommentQuery hasOne(string $class, array $link) see BaseActiveRecord::hasOne() for more info
 */
class Comment extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            \yii\behaviors\BlameableBehavior::className(),
            \yii\behaviors\TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text'], 'required'],
            [['text'], 'string'],
            [['created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['deleted'], 'boolean'],
            [['deleted'], 'default', 'value' => self::NOT_DELETED],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app', 'ID'),
            'entity' => \Yii::t('app', 'Entity'),
            'text' => \Yii::t('app', 'Text'),
            'created_by' => \Yii::t('app', 'Created by'),
            'updated_by' => \Yii::t('app', 'Updated by'),
            'created_at' => \Yii::t('app', 'Created at'),
            'updated_at' => \Yii::t('app', 'Updated at'),
        ];
    }

    /**
     * @return bool
     */
    public function isEdited()
    {
        return $this->created_at !== $this->updated_at;
    }

    /**
     * @return bool
     */
    public function isDeleted()
    {
        return $this->deleted === self::DELETED;
    }

    /**
     * @return bool
     */
    public static function canCreate()
    {
        /** @var Comments\Module $Module */
        $Module = \Yii::$app->getModule(Comments\Module::NAME);

        return $Module->useRbac === true
            ? \Yii::$app->getUser()->can(Comments\Permission::CREATE)
            : true;
    }

    /**
     * @return bool
     */
    public function canUpdate()
    {
        /** @var Comments\Module $Module */
        $Module = \Yii::$app->getModule(Comments\Module::NAME);

        return $Module->useRbac === true
            ? \Yii::$app->getUser()->can(Comments\Permission::UPDATE) || \Yii::$app->getUser()->can(Comments\Permission::UPDATE_OWN, ['Comment' => $this])
            : $this->created_by === \Yii::$app->get('user')->id;
    }

    /**
     * @return bool
     */
    public function canDelete()
    {
        /** @var Comments\Module $Module */
        $Module = \Yii::$app->getModule(Comments\Module::NAME);

        return $Module->useRbac === true
            ? \Yii::$app->getUser()->can(Comments\Permission::DELETE) || \Yii::$app->getUser()->can(Comments\Permission::DELETE_OWN, ['Comment' => $this])
            : $this->created_by === \Yii::$app->get('user')->id;
    }

    /**
     * @return queries\CommentQuery
     */
    public function getAuthor()
    {
        /** @var Comments\Module $Module */
        $Module = \Yii::$app->getModule(Comments\Module::NAME);

        return $this->hasOne($Module->userIdentityClass, ['id' => 'created_by']);
    }

    /**
     * @return queries\CommentQuery
     */
    public function getLastUpdateAuthor()
    {
        /** @var Comments\Module $Module */
        $Module = \Yii::$app->getModule(Comments\Module::NAME);

        return $this->hasOne($Module->userIdentityClass, ['id' => 'updated_by']);
    }

    /**
     * @return queries\CommentQuery
     */
    public static function find()
    {
        return new queries\CommentQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%comment}}';
    }

    const NOT_DELETED = 0;
    const DELETED = 1;
}