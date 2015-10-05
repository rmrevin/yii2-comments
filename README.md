Yii 2 Comments Module
=====================
[![License](https://poser.pugx.org/rmrevin/yii2-comments/license.svg)](https://packagist.org/packages/rmrevin/yii2-comments)
[![Latest Stable Version](https://poser.pugx.org/rmrevin/yii2-comments/v/stable.svg)](https://packagist.org/packages/rmrevin/yii2-comments)
[![Latest Unstable Version](https://poser.pugx.org/rmrevin/yii2-comments/v/unstable.svg)](https://packagist.org/packages/rmrevin/yii2-comments)
[![Total Downloads](https://poser.pugx.org/rmrevin/yii2-comments/downloads.svg)](https://packagist.org/packages/rmrevin/yii2-comments)

Code Status
-----------
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/rmrevin/yii2-comments/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/rmrevin/yii2-comments/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/rmrevin/yii2-comments/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/rmrevin/yii2-comments/?branch=master)
[![Travis CI Build Status](https://travis-ci.org/rmrevin/yii2-comments.svg)](https://travis-ci.org/rmrevin/yii2-comments)
[![Dependency Status](https://www.versioneye.com/user/projects/54b46c192eea784acc000442/badge.svg)](https://www.versioneye.com/user/projects/54119b799e16229fe00000da)

Installation
------------
```bash
composer require "rmrevin/yii2-comments:1.4.*"
```

Configuration
-------------

In config `/protected/config/main.php`
```php
<?php
return [
	// ...
	'modules' => [
		// ...
		'comments' => [
		    'class' => 'rmrevin\yii\module\Comments\Module',
		    'userIdentityClass' => 'app\models\User',
		    'useRbac' => true,
		]
	],
	// ...
];
```

In your `User` model (or another model implements the interface `IdentityInterface`) need to implement the interface "\rmrevin\yii\module\Comments\interfaces\CommentatorInterface"
```php
class User extends \yii\db\ActiveRecord
    implements
        \yii\web\IdentityInterface,
        \rmrevin\yii\module\Comments\interfaces\CommentatorInterface
{
    // ...
    
    public function getCommentatorAvatar()
    {
        return $this->avatar_url;
    }
    
    public function getCommentatorName()
    {
        return $this->name;
    }
    
    public function getCommentatorUrl()
    {
        return ['/profile', 'id' => $this->id]; // or false, if user does not have a public page
    }
    
    // ...
}
```

In auth manager add rules (if `Module::$useRbac = true`):
```php
<?php
use \rmrevin\yii\module\Comments\Permission;
use \rmrevin\yii\module\Comments\rbac\ItsMyComment;

$AuthManager = \Yii::$app->getAuthManager();
$ItsMyCommentRule = new ItsMyComment();

$AuthManager->add($ItsMyCommentRule);

$AuthManager->add(new \yii\rbac\Permission([
    'name' => Permission::CREATE,
    'description' => 'Can create own comments',
]));
$AuthManager->add(new \yii\rbac\Permission([
    'name' => Permission::UPDATE,
    'description' => 'Can update all comments',
]));
$AuthManager->add(new \yii\rbac\Permission([
    'name' => Permission::UPDATE_OWN,
    'ruleName' => $ItsMyCommentRule->name,
    'description' => 'Can update own comments',
]));
$AuthManager->add(new \yii\rbac\Permission([
    'name' => Permission::DELETE,
    'description' => 'Can delete all comments',
]));
$AuthManager->add(new \yii\rbac\Permission([
    'name' => Permission::DELETE_OWN,
    'ruleName' => $ItsMyCommentRule->name,
    'description' => 'Can delete own comments',
]));
```

Updating database schema
------------------------
After you downloaded and configured `rmrevin/yii2-comments`,
the last thing you need to do is updating your database schema by applying the migrations:

In `command line`:
```
php yii migrate/up --migrationPath=@vendor/rmrevin/yii2-comments/migrations/
```

Usage
-----
In view
```php
<?php
// ...

use rmrevin\yii\module\Comments;

echo Comments\widgets\CommentListWidget::widget([
    'entity' => (string) 'photo-15', // type and id
]);

```

Parameters
----------

### Module parameters

* **userIdentityClass** (required, string) The user identity class that Yii2 uses to provide identity information about the users in the App.

* **useRbac** (optional, boolean) Default TRUE. Defines if the comment system will use Rbac validation to check the comment permissions when trying to update, delete or add new comments.

* **modelClasses** (optional, string[]) Stores the user defined model classes that will be used instead of the default ones in the comment system. Must have a key => classname format. e.g. `'Comment' => '@app\comments\CommentModel'`


### Widget parameters

* **entity** (required, string) The entity that will identify the comments under on section from all the comments in this module.

* **theme** (optional, string) In case you want to use a theme in your application you should define here it's location.

* **viewParams** (optional, array) Data that will be sent directly into the widget view files. Must have a key => data format. The key will be the variable name in the view. The variable `CommentsDataProvider` it's already taken.

* **options** (optional, array) Default `['class' => 'comments-widget']`. Option data array that will be sent into the div holding the comment system in your views.

* **pagination** (optional, array) Pagination configuration that will be used in the comment panel.
Default data:
```php
public $pagination = 
    [
        'pageParam' => 'page',
        'pageSizeParam' => 'per-page',
        'pageSize' => 20,
        'pageSizeLimit' => [1, 50],
    ];
```

* **sort** (optional, array) Type of sorting used to retrieve the comments into the panel. Can be sorted by any of the columns defined in the `comment` table.
Default data:
```php
        'defaultOrder' => [
            'id' => SORT_ASC,
        ],
```

* **showDeleted** (optional, boolean) Default `True`. Defines if the comments panel will show a message indicating the deleted comments.

* **showCreateForm** (optional, boolean) Default `True`. Will show or hide the form to add a comment in this panel.


Extending the package
---------------------

### Extending Model files

Depending on which ones you need, you can set the `modelMap` config property:

```php

	// ...
	'modules' => [
		// ...
		'comments' => [
		    'class' => 'rmrevin\yii\module\Comments\Module',
		    'userIdentityClass' => 'app\models\User',
		    'useRbac' => true,
		    'modelMap' => [
		        'Comment' => '@app\comments\CommentModel'
		    ]
		]
	],
	// ...
```


Attention: keep in mind that if you are changing the `Comment` model, the new class should always extend the package's original `Comment` class.


### Attaching behaviors and event handlers
 
The package allows you to attach behavior or event handler to any model. To do this you can set model map like so:

```php

	// ...
	'modules' => [
		// ...
		'comments' => [
		    'class' => 'rmrevin\yii\module\Comments\Module',
		    'userIdentityClass' => 'app\models\User',
		    'useRbac' => true,
		    'modelMap' => [
		        'Comment' => [
		            'class' => '@app\comments\CommentModel',
		            'on event' => function(){
		                // code here
		            },
		            'as behavior' => 
		                ['class' => 'Foo'],
		    ]
		]
	],
	// ...
```

### Extending View files

You can extend the view files supplied by this package using the `theme` component in the config file.

```php
// app/config/web.php

'components' => [
    'view' => [
        'theme' => [
            'pathMap' => [
                '@vendor/rmrevin/yii2-comments/widgets/views' => '@app/views/comments', // example: @app/views/comment/comment-form.php
            ],
        ],
    ],
],

```

### Extending Widgets

To extend the widget code and behavior you only have to extend the widget classes and call them instead of the package's ones.