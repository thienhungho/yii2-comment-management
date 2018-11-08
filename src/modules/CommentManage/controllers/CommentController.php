<?php

namespace thienhungho\CommentManagement\modules\CommentManage\controllers;

use Yii;
use thienhungho\CommentManagement\modules\CommentBase\Comment;
use thienhungho\CommentManagement\modules\CommentManage\search\CommentSearch;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CommentController implements the CRUD actions for Comment model.
 */
class CommentController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'changeStatus' => ['post'],
                    'bulk' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @param string $type
     *
     * @return string
     */
    public function actionIndex($type = 'post-comment')
    {
        $searchModel = new CommentSearch();
        $queryParams = request()->queryParams;
        $queryParams['CommentSearch']['type'] = $type;
        $dataProvider = $searchModel->search($queryParams);
        $dataProvider->sort->defaultOrder = ['id' => SORT_DESC];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    //    /**
    //     * Creates a new Comment model.
    //     * If creation is successful, the browser will be redirected to the 'view' page.
    //     * @return mixed
    //     */
    //    public function actionCreate()
    //    {
    //        $model = new Comment();
    //
    //        if ($model->loadAll(request()->post()) && $model->saveAll()) {
    //            return $this->redirect(['view', 'id' => $model->id]);
    //        } else {
    //            return $this->render('create', [
    //                'model' => $model,
    //            ]);
    //        }
    //    }
    /**
     * @param $id
     *
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws \yii\db\Exception
     */
    public function actionUpdate($id)
    {
        if (request()->post('_asnew') == '1') {
            $model = new Comment();
        }else{
            $model = $this->findModel($id);
        }

        if ($model->loadAll(request()->post())) {
            if ($model->saveAll()) {
                set_flash_has_been_saved();
                return $this->redirect(['update', 'id' => $model->id]);
            } else {
                set_flash_has_not_been_saved();
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);

    }

    /**
     * @param $id
     *
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \yii\db\Exception
     */
    public function actionDelete($id)
    {
        if ($this->findModel($id)->deleteWithRelated()) {
            set_flash_success_delete_content();
        } else {
            set_flash_error_delete_content();
        }

        return $this->goBack(request()->referrer);
    }

    /**
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionChangeStatus()
    {
        $id = request()->post('id');
        $status = request()->post('status');
        $model = $this->findModel($id);
        $model->status = $status;

        if ($model->save()) {
            set_flash_has_been_saved();
        } else {
            set_flash_has_not_been_saved();
        }

        return $this->goBack(request()->referrer);
    }

    /**
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \yii\db\Exception
     */
    public function actionBulk()
    {
        $action = request()->post('action');
        $ids = request()->post('selection');
        if (!empty($ids)) {
            if ($action == ACTION_DELETE) {
                foreach ($ids as $id) {
                    if ($this->findModel($id)->deleteWithRelated()) {
                        set_flash_success_delete_content();
                    } else {
                        set_flash_error_delete_content();
                    }
                }
            } elseif ($action == STATUS_PENDING) {
                foreach ($ids as $id) {
                    $model = $this->findModel($id);
                    $model->status = STATUS_PENDING;
                    if ($model->save()) {
                        set_flash_has_been_saved();
                    } else {
                        set_flash_has_not_been_saved();
                    }
                }
            } elseif ($action == STATUS_PUBLIC) {
                foreach ($ids as $id) {
                    $model = $this->findModel($id);
                    $model->status = STATUS_PUBLIC;
                    if ($model->save()) {
                        set_flash_has_been_saved();
                    } else {
                        set_flash_has_not_been_saved();
                    }
                }
            }
        }

        return $this->goBack(request()->referrer);
    }

    /**
     * @param $id
     *
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionPdf($id) {
        $model = $this->findModel($id);

        $content = $this->renderAjax('_pdf', [
            'model' => $model,
        ]);

        $pdf = new \kartik\mpdf\Pdf([
            'mode' => \kartik\mpdf\Pdf::MODE_UTF8,
            'format' => \kartik\mpdf\Pdf::FORMAT_A4,
            'orientation' => \kartik\mpdf\Pdf::ORIENT_PORTRAIT,
            'destination' => \kartik\mpdf\Pdf::DEST_BROWSER,
            'content' => $content,
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            'cssInline' => '.kv-heading-1{font-size:18px}',
            'options' => ['title' => \Yii::$app->name],
            'methods' => [
                'SetHeader' => [\Yii::$app->name],
                'SetFooter' => ['{PAGENO}'],
            ]
        ]);

        return $pdf->render();
    }

    /**
     * @param $id
     *
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws \yii\db\Exception
     */
    public function actionSaveAsNew($id) {
        $model = new Comment();

        if (request()->post('_asnew') != '1') {
            $model = $this->findModel($id);
        }

        if ($model->loadAll(request()->post())) {
            if ($model->saveAll()) {
                set_flash_has_been_saved();
                return $this->redirect(['update', 'id' => $model->id]);
            } else {
                set_flash_has_not_been_saved();
            }
        }

        return $this->render('saveAsNew', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     *
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws \yii\db\Exception
     */
    public function actionReply($id) {
        $comment = $this->findModel($id);
        $model = new Comment();
        $model->author_name = Yii::$app->user->identity->username;
        $model->author_email = Yii::$app->user->identity->email;
        $model->author_url = Url::base(true);
        $model->author_ip = request()->getUserIP();
        $model->obj_id = $comment->obj_id;
        $model->obj_type = $comment->obj_type;
        $model->type = $comment->type;
        $model->parent = $comment->id;
        $model->status = STATUS_PUBLIC;
        $model->author = Yii::$app->user->id;

        if ($model->loadAll(request()->post())) {
            if ($model->saveAll()) {
                set_flash_has_been_saved();
                return $this->redirect(['update', 'id' => $model->id]);
            } else {
                set_flash_has_not_been_saved();
            }
        }

        return $this->render('reply', [
            'comment' => $comment,
            'model' => $model,
        ]);

    }

    /**
     * Finds the Comment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Comment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Comment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(t('app', 'The requested page does not exist.'));
        }
    }
}
