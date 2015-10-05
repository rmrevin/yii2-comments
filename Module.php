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

    /** @var string module name */
    public static $moduleName = 'comments';

    /** @var string|null */
    public $userIdentityClass = null;

    /** @var bool */
    public $useRbac = true;

    /**
     * Array that will store the models used in the package
     * e.g. :
     * [
     *     'Comment' => 'frontend/models/comments/CommentModel'
     * ]
     *
     * The classes defined here will be merged with getDefaultModels()
     * having he manually defined by the user preference.
     *
     * @var array
     */
    public $modelMap = [];

    public function init()
    {
        parent::init();

        if ($this->userIdentityClass === null) {
            $this->userIdentityClass = \Yii::$app->getUser()->identityClass;
        }

        // Merge the default model classes
        // with the user defined ones.
        $this->defineModelClasses();
    }

    /**
     * @return static
     */
    public static function instance()
    {
        return \Yii::$app->getModule(static::$moduleName);
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
        $this->modelMap = ArrayHelper::merge(
            $this->getDefaultModels(),
            $this->modelMap,
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
     * Get defined className of model
     *
     * Returns an string or array compatible
     * with the Yii::createObject method.
     *
     * @param string $name
     * @param array $config // You should never send an array with a key defined as "class" since this will
     *                      // overwrite the main className defined by the system.
     * @return string|array
     */
    public function model($name, $config = [])
    {
        $modelData = $this->modelMap[ucfirst($name)];

        if (!empty($config)) {
            if (is_string($modelData)) {
                $modelData = ['class' => $modelData];
            }

            $modelData = ArrayHelper::merge(
                $modelData,
                $config
            );
        }

        return $modelData;
    }

}