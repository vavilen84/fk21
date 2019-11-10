<?php

namespace app\controllers;

use Yii;
use app\models\Competition;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\User;
use app\models\ImageUpload;
use app\models\Image;
use yii\web\UploadedFile;

class CompetitionController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        $model = Yii::$app->user->getIdentity();
        if (empty($model) || ($model->role != User::ADMIN_ROLE)) {
            throw new NotFoundHttpException('You are not allowed to perform this action.');
        }
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider(
            [
                'query' => Competition::find(),
            ]
        );

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new Competition();
        $imageUploadModel = new ImageUpload();
        if ($model->load(Yii::$app->request->post())) {
            if (!empty($model->deadline_at)) {
                $model->deadline_at = strtotime($model->deadline_at);
            }
            $imageUploadModel->imageFile = UploadedFile::getInstance($model, 'image');
            if (!empty($imageUploadModel->imageFile)) {
                $uploaded = $imageUploadModel->upload();
                if ($uploaded instanceof Image) {
                    $model->image_id = $uploaded->id;
                }
            }
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Успешно добавлено!');
                return $this->redirect(['update', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $imageUploadModel = new ImageUpload();
        if ($model->load(Yii::$app->request->post())) {
            if (!empty($model->deadline_at)) {
                $model->deadline_at = strtotime($model->deadline_at);
            }
            $imageUploadModel->imageFile = UploadedFile::getInstance($model, 'image');
            if (!empty($imageUploadModel->imageFile)) {
                $uploaded = $imageUploadModel->upload();
                if ($uploaded instanceof Image) {
                    $model->image_id = $uploaded->id;
                }
            }
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Успешно обновлено!');
                return $this->redirect(['update', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = Competition::DELETED_STATUS;
        $model->save();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Competition::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
