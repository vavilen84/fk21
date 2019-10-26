<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use app\models\ImageUpload;
use app\models\Image;

class UserController extends Controller
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
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->role == User::ADMIN_ROLE){
            throw new NotFoundHttpException('You are not allowed to perform this action.');
        }

        if ($model->load(Yii::$app->request->post())) {
            if (!empty($model->newPassword)) {
                $model->salt = Yii::$app->userComponent->getSalt();
                $model->password = Yii::$app->userComponent->encodePassword($model->newPassword, $model->salt);
            }
            if ($model->save()) {
                Yii::$app->session->setFlash('success', ' Сохранено успешно!');
                return $this->redirect(['index', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->role == User::ADMIN_ROLE){
            throw new NotFoundHttpException('You are not allowed to perform this action.');
        }
        $model->status = User::DELETED_STATUS;
        $model->save();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
