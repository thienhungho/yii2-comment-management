<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model thienhungho\CommentManagement\modules\CommentManage\search\CommentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-comment-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'author_name', [
        'addon' => ['prepend' => ['content' => '<span class="fa fa-user"></span>']],
    ])->textInput(['maxlength' => true, 'placeholder' => 'Author Name']) ?>

    <?= $form->field($model, 'author_email', [
        'addon' => ['prepend' => ['content' => '<span class="fa fa-envelope"></span>']],
    ])->textInput(['maxlength' => true, 'placeholder' => 'Author Email']) ?>

    <div class="form-group">
        <?= Html::submitButton(t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
