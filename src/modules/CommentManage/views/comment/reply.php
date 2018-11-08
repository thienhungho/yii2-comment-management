<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model thienhungho\CommentManagement\modules\CommentBase\Comment */

$this->title = t('app', 'Reply {modelClass}: ', [
    'modelClass' => 'Comment',
]). ' ' . $comment->id;
$this->params['breadcrumbs'][] = ['label' => t('app', 'Comment'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = t('app', 'Reply');
?>
<div class="comment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_reply_form', [
        'comment' => $comment,
        'model' => $model,
    ]) ?>

</div>
