<?php
/* @var $this yii\web\View */
/* @var $searchModel thienhungho\CommentManagement\modules\CommentManage\search\CommentSearch */

/* @var $dataProvider yii\data\ActiveDataProvider */

use kartik\grid\GridView;
use yii\helpers\Html;

$commentType = request()->get('type', 'post-comment');
$this->title = t('app', slug_to_text($commentType));
$this->params['breadcrumbs'][] = $this->title;
$search = "$('.search-button').click(function(){
	$('.search-form').toggle(1000);
	return false;
});";
$this->registerJs($search);
?>
    <div class="comment-index-head">
        <h1><?= Html::encode($this->title) ?></h1>

        <div class="row">
            <div class="col-lg-10">
                <p>
                    <? //= Html::a(__t('app', 'Create Comment'), ['create'], ['class' => 'btn btn-success']) ?>
                    <?= Html::a(t('app', 'Advance Search'), '#', ['class' => 'btn btn-info search-button']) ?>
                </p>
            </div>
            <div class="col-lg-2">
                <?php backend_per_page_form() ?>
            </div>
        </div>
        <div class="search-form" style="display:none">
            <?= $this->render('_search', ['model' => $searchModel]); ?>
        </div>
    </div>

<?= Html::beginForm(['bulk']) ?>
    <div class="comment-index">
        <?php
        $gridColumn = [
            ['class' => 'yii\grid\SerialColumn'],
            grid_checkbox_column(),
            [
                'class'         => 'kartik\grid\ExpandRowColumn',
                'width'         => '50px',
                'value'         => function($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                'detail'        => function($model, $key, $index, $column) {
                    return Yii::$app->controller->renderPartial('_expand', ['model' => $model]);
                },
                'headerOptions' => ['class' => 'kartik-sheet-style'],
                'expandOneOnly' => true,
            ],
            [
                'attribute' => 'id',
                'visible'   => false,
            ],
            'author_name',
            'author_email:email',
            //        'author_url:url',
            [
                'attribute'           => 'parent',
                'label'               => t('app', 'Parent'),
                'value'               => function($model) {
                    if ($model->parent) {
                        return $model->parent;
                    } else {
                        return null;
                    }
                },
                'filterType'          => GridView::FILTER_SELECT2,
                'filter'              => \yii\helpers\ArrayHelper::map(\thienhungho\CommentManagement\modules\CommentBase\Comment::find()->asArray()->all(), 'id', 'id'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions'  => [
                    'placeholder' => t('app', 'Comment'),
                    'id'          => 'grid-post-search-parent',
                ],
            ],
            [
                'attribute'           => 'author',
                'label'               => t('app', 'Author'),
                'value'               => function($model) {
                    if ($model->author0) {
                        return $model->author0->username;
                    } else {
                        return null;
                    }
                },
                'filterType'          => GridView::FILTER_SELECT2,
                'filter'              => \yii\helpers\ArrayHelper::map(\thienhungho\UserManagement\models\User::find()->asArray()->all(), 'id', 'username'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions'  => [
                    'placeholder' => t('app', 'User'),
                    'id'          => 'grid-post-search-author',
                ],
            ],
            [
                'format'        => [
                    'date',
                    'php:Y-m-d h:s:i',
                ],
                'attribute'     => 'created_at',
                'filterType'    => GridView::FILTER_DATETIME,
                'headerOptions' => ['style' => 'min-width:150px;'],
            ],
            [
                // this line is optional
                'format'              => 'raw',
                'attribute'           => 'status',
                'value'               => function($model, $key, $index, $column) {
                    if ($model->status == STATUS_PENDING) {
                        return '<span class="label-warning label">' . t('app', slug_to_text(STATUS_PENDING)) . '</span>';
                    } elseif ($model->status == STATUS_PUBLIC) {
                        return '<span class="label-success label">' . t('app', slug_to_text(STATUS_PUBLIC)) . '</span>';
                    }
                },
                'filterType'          => GridView::FILTER_SELECT2,
                'filter'              => \yii\helpers\ArrayHelper::map([
                    [
                        'value' => STATUS_PENDING,
                        'name'  => t('app', slug_to_text(STATUS_PENDING)),
                    ],
                    [
                        'value' => STATUS_PUBLIC,
                        'name'  => t('app', slug_to_text(STATUS_PUBLIC)),
                    ],
                ], 'value', 'name'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions'  => [
                    'placeholder' => t('app', 'Status'),
                    'id'          => 'grid-search-status',
                ],
            ],
        ];
        $active_button = grid_view_default_active_column_cofig();
        $active_button['width'] = '250px';
        $active_button['headerOptions'] = ['style' => 'min-width:250px'];
        $active_button['buttons']['change-status'] = function($url, $model, $key) {
            if ($model->status == STATUS_PUBLIC) {
                return Html::a('<span class="btn btn-xs dark"><span class="glyphicon glyphicon-thumbs-down"></span></span>', \yii\helpers\Url::to(['/comment-manage/comment/change-status']), [
                    'data-method' => 'POST',
                    'data-params' => [
                        'id'     => $model->id,
                        'status' => STATUS_PENDING,
                    ],
                ], ['title' => t('app', STATUS_PENDING)]);
            } else {
                return Html::a('<span class="btn btn-xs green-meadow"><span class="glyphicon glyphicon-thumbs-up"></span></span>', \yii\helpers\Url::to(['/comment-manage/comment/change-status']), [
                    'data-method' => 'POST',
                    'data-params' => [
                        'id'     => $model->id,
                        'status' => STATUS_PUBLIC,
                    ],
                ], ['title' => t('app', STATUS_PUBLIC)]);
            }
        };
        $active_button['buttons']['reply'] = function($url) {
            return Html::a('<span class="btn btn-xs yellow-crusta"><span class="glyphicon glyphicon-comment"></span></span>', $url, ['title' => t('app', 'Reply')]);
        };
        $active_button['template'] = '{change-status} {reply} {save-as-new} {view} {update} {delete}';
        $gridColumn[] = $active_button;
        ?>
        <?= GridView::widget([
            'dataProvider'   => $dataProvider,
            'filterModel'    => $searchModel,
            'columns'        => $gridColumn,
            'responsiveWrap' => false,
            'condensed'      => true,
            'hover'          => true,
            'pjax'           => true,
            'pjaxSettings'   => ['options' => ['id' => 'kv-pjax-container-comment']],
            'panel'          => [
                'type'    => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
            ],
            'toolbar'        => grid_view_toolbar_config($dataProvider, $gridColumn),
        ]); ?>

        <div class="row">
            <div class="col-lg-2">
                <?= \kartik\widgets\Select2::widget([
                    'name'    => 'action',
                    'value'   => '',
                    'data'    => [
                        ACTION_DELETE  => t('app', 'Delete'),
                        STATUS_PENDING => t('app', slug_to_text(STATUS_PENDING)),
                        STATUS_PUBLIC  => t('app', slug_to_text(STATUS_PUBLIC)),
                    ],
                    'theme'   => \kartik\widgets\Select2::THEME_BOOTSTRAP,
                    'options' => [
                        'multiple'    => false,
                        'placeholder' => t('app', 'Bulk Actions ...'),
                    ],
                ]); ?>
            </div>
            <div class="col-lg-10">
                <?= Html::submitButton(t('app', 'Apply'), [
                    'class'        => 'btn btn-primary',
                    'data-confirm' => t('app', 'Are you want to do this?'),
                ]) ?>
            </div>
        </div>

    </div>

<?= Html::endForm() ?>