<?php
/**
 * Module.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace rmrevin\yii\module\Comments;

use rmrevin\yii\module\Comments\forms\CommentCreateForm;
use rmrevin\yii\module\Comments\models\Comment;
use rmrevin\yii\module\Comments\models\queries\CommentQuery;
use yii\helpers\ArrayHelper;

/**
 * Class Module
 * @package rmrevin\yii\module\Comments
 */
class Module extends \yii\base\Module
{

    const NAME = 'comments';

    /** @var string|null */
    public $userIdentityClass = null;

    /** @var bool */
    public $useRbac = true;

    /**
     * Array that will store the models used in the package
     * e.g. : ['Comment' => 'frontend/models/comments/CommentModel'
     *
     * The classes defined here will be merged with getDefaultModels()
     * having he manually defined by the user preference.
     *
     * @var array
     */
    public $modelClasses = [];
    
    public function init()
    {
        parent::init();

        if ($this->userIdentityClass === null)
        {
            $this->userIdentityClass = \Yii::$app->getUser()->identityClass;
        }

        // Merge the default model classes
        // with the user defined ones.
        $this->defineModelClasses();
    }

    /**
     * Merges the default and user defined model classes
     * Also let's the developer to set new ones with the
     * parameter being those the ones with most preference.
     * 
     * @param array $modelClasses
     */
    public function defineModelClasses($modelClasses = [])
    {
        $this->modelClasses = ArrayHelper::merge(
            $this->getDefaultModels(),
            $this->modelClasses,
            $modelClasses
        );
    }

    /**
     * Get default model classes
     */
    protected function getDefaultModels()
    {
        return [
            'Comment' => Comment::className(),
            'CommentQuery' => CommentQuery::className(),
            'CommentCreateForm' => CommentCreateForm::className()
        ];
    }

    /**
     * Get object instance of model
     *
     * @param string $name
     * @param array $config
     * @return \yii\db\ActiveRecord
     */
    public function model($name, $config = [])
    {
        // create model and return it
        $className = $this->modelClasses[ucfirst($name)];
        return \Yii::createObject(array_merge(["class" => $className], $config));
    }

}