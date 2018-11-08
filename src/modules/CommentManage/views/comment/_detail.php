<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model thienhungho\CommentManagement\modules\CommentBase\Comment */

?>
<div class="comment-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= Html::encode($model->id) ?></h2>
        </div>
    </div>

    <div class="row">
<?php 
    $gridColumn = [
        ['attribute' => 'id', 'visible' => false],
        'content:ntext',
        'author_name',
        'author_email:email',
        'author_url:url',
        'author_ip',
        'status',
        'type',
        'obj_type',
        'obj_id',
        'parent',
        [
            'attribute' => 'author0.username',
            'label' => t('app', 'Author'),
        ],
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]); 
?>
    </div>
</div>