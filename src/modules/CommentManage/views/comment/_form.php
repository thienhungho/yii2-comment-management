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
        <?= $form->field($model, 'author_name', [
            'addon' => ['prepend' => ['content' => '<span class="fa fa-user"></span>']],
        ])->textInput([
            'maxlength'   => true,
            'placeholder' => t('app', 'Author Name'),
        ]) ?>

        <?= $form->field($model, 'author_email', [
            'addon' => ['prepend' => ['content' => '<span class="fa fa-envelope"></span>']],
        ])->textInput([
            'maxlength'   => true,
            'placeholder' => t('app', 'Author Email'),
        ]) ?>

        <?= $form->field($model, 'author_url', [
            'addon' => ['prepend' => ['content' => '<span class="fa fa-link"></span>']],
        ])->textInput([
            'maxlength'   => true,
            'placeholder' => t('app', 'Author Url'),
        ]) ?>

        <?= $form->field($model, 'author_ip', [
            'addon' => ['prepend' => ['content' => '<span class="fa fa-desktop"></span>']],
        ])->textInput([
            'maxlength'   => true,
            'placeholder' => t('app', 'Author Ip'),
        ]) ?>

        <?= $form->field($model, 'content', [
            'addon' => ['prepend' => ['content' => '<span class="fa fa-copy"></span>']],
        ])->textarea(['rows' => 6]) ?>
    </div>

    <div class="col-lg-3 col-xs-12">

        <?= $form->field($model, 'status', [
            'addon' => ['prepend' => ['content' => '<span class="fa fa-eye"></span>']],
        ])->radioButtonGroup([
            STATUS_PUBLIC  => t('app', slug_to_text(STATUS_PUBLIC)),
            STATUS_PENDING => t('app', slug_to_text(STATUS_PENDING)),
        ], [
            'class' => 'btn-group-sm',
            'itemOptions' => ['labelOptions' => ['class' => 'btn green']]
        ]); ?>

        <?= $form->field($model, 'obj_id', [
            'addon' => ['prepend' => ['content' => '<span class="fa fa-copy"></span>']],
        ])->textInput(['placeholder' => 'Obj']) ?>

<!--        --><?//= $form->field($model, 'parent', [
//            'addon' => ['prepend' => ['content' => '<span class="fa fa-copy"></span>']],
//        ])->textInput(['placeholder' => 'Parent']) ?>

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
