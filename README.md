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
composer require "rmrevin/yii2-comments:1.2.*"
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
		    'userIdentityClass' => 'app\models\User'
		    'useRbac' => true,
		]
	],
	// ...
];
```

In auth manager add rules (if `Module::$useRbac = true`):
```php
<?php
use \rmrevin\yii\module\Comments\Permission;
use \rmrevin\yii\module\Comments\rbac\ItsMyComment;

$AuthManager = \Yii::$app->getAuthManager();
$ItsMyCommentRule = new ItsMyComment();

$AuthManager->add($ItsMyCommentRule);

$AuthManager->add(new \yii\rbac\Role([
    'name' => Permission::CREATE,
    'description' => 'Can create own comments',
]));
$AuthManager->add(new \yii\rbac\Role([
    'name' => Permission::UPDATE,
    'description' => 'Can update all comments',
]));
$AuthManager->add(new \yii\rbac\Role([
    'name' => Permission::UPDATE_OWN,
    'ruleName' => $ItsMyCommentRule->name,
    'description' => 'Can update own comments',
]));
$AuthManager->add(new \yii\rbac\Role([
    'name' => Permission::DELETE,
    'description' => 'Can delete all comments',
]));
$AuthManager->add(new \yii\rbac\Role([
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