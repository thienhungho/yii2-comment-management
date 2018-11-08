<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model thienhungho\CommentManagement\modules\CommentBase\Comment */

$this->title = t('app', 'Create Comment');
$this->params['breadcrumbs'][] = ['label' => t('app', 'Comment'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
