Yii2 Comment Management System
====================
Comment Management System for Yii2

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist thienhungho/yii2-comment-management "*"
```

or add

```
"thienhungho/yii2-comment-management": "*"
```

to the require section of your `composer.json` file.

### Migration

Run the following command in Terminal for database migration:

```
yii migrate/up --migrationPath=@vendor/thienhungho/CommentManagement/migrations
```

Or use the [namespaced migration](http://www.yiiframework.com/doc-2.0/guide-db-migrations.html#namespaced-migrations) (requires at least Yii 2.0.10):

```php
// Add namespace to console config:
'controllerMap' => [
    'migrate' => [
        'class' => 'yii\console\controllers\MigrateController',
        'migrationNamespaces' => [
            'thienhungho\CommentManagement\migrations\namespaced',
        ],
    ],
],
```

Then run:
```
yii migrate/up
```

Config
------------

Add module CommentManage to your `AppConfig` file.

```php
...
'modules'          => [
    ...
    /**
     * Comment Manage
     */
    'comment-manage' => [
        'class' => 'thienhungho\CommentManagement\modules\CommentManage\CommentManage',
    ],
    ...
],
...
```

Modules
------------

[CommentBase](https://github.com/thienhungho/yii2-comment-management/tree/master/src/modules/CommentBase), [CommentManage](https://github.com/thienhungho/yii2-comment-management/tree/master/src/modules/CommentManage)

Functions
------------

[Core](https://github.com/thienhungho/yii2-comment-management/tree/master/src/functions/core.php)

Models
------------

[Comment](https://github.com/thienhungho/yii2-comment-management/tree/master/src/models/Comment.php)

Constant
------------

[Core](https://github.com/thienhungho/yii2-comment-management/tree/master/src/const/core.php)