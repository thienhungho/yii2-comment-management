<?php

use kartik\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model thienhungho\CommentManagement\modules\CommentBase\Comment */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="row comment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <div class="col-lg-9 col-xs-12">

        <?= $form->field($model, 'content', [
            'addon' => ['prepend' => ['content' => '<span class="fa fa-copy"></span>']],
        ])->textarea(['rows' => 6]) ?>
    </div>

    <div class="col-lg-3 col-xs-12">

        <?= $form->field($model, 'status', [
            'addon' => ['prepend' => ['content' => '<span class="fa fa-eye"></span>']],
        ])->widget(\kartik\widgets\Select2::classname(), [
            'data'          => [
                STATUS_PENDING => t('app', 'Pending'),
                STATUS_PUBLIC  => t('app', 'Public'),
            ],
            'options'       => ['placeholder' => t('app', 'Status')],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ]); ?>

        <?= $form->field($model, 'type', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

        <?= $form->field($model, 'author', [
            'addon' => ['prepend' => ['content' => '<span class="fa fa-user"></span>']],
        ])->widget(\kartik\widgets\Select2::classname(), [
            'data'          => \yii\helpers\ArrayHelper::map(\thienhungho\UserManagement\models\User::find()->orderBy('id')->asArray()->all(), 'id', 'username'),
            'options'       => ['placeholder' => t('app', 'Choose User')],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ]); ?>

    </div>

    <div class="col-lg-12">
        <div class="form-group">
            <?php if (Yii::$app->controller->action->id != 'save-as-new'): ?>
                <?= Html::submitButton($model->isNewRecord ? t('app', 'Create') : t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?><?php endif; ?><?php if (Yii::$app->controller->action->id != 'create'): ?>
                <?php endif; ?>
            <?= Html::a(t('app', 'Cancel'), request()->referrer, ['class' => 'btn btn-danger']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
