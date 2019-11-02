<?php

namespace app\controllers;

use Yii;
use app\models\Post;
use app\models\PostSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\User;
use app\models\ImageUpload;
use yii\web\UploadedFile;
use app\models\Image;

class PostController extends Controller
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
        $allowedUserRoles = [User::ADMIN_ROLE, User::MODERATOR_ROLE];
        if (empty($model) || !in_array($model->role, $allowedUserRoles)) {
            throw new NotFoundHttpException('You are not allowed to perform this action.');
        }
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new Post();
        $imageUploadModel = new ImageUpload();
        if ($model->load(Yii::$app->request->post())) {
            $user = Yii::$app->user->getIdentity();
            $model->user_id = $user->id;
            if ($model->save()) {

                $imageUploadModel->imageFile = UploadedFile::getInstance($model, 'image');
                if (!empty($imageUploadModel->imageFile)) {
                    $uploaded = $imageUploadModel->upload();
                    if ($uploaded instanceof Image) {
                        $model->image_id = $uploaded->id;
                    }
                }

                Yii::$app->session->setFlash('success', 'Успешно добавлено!');
                return $this->redirect(['index']);
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

            $imageUploadModel->imageFile = UploadedFile::getInstance($model, 'image');
            if (!empty($imageUploadModel->imageFile)) {
                $uploaded = $imageUploadModel->upload();
                if ($uploaded instanceof Image) {
                    $model->image_id = $uploaded->id;
                }
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Успешно обновлено!');
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = User::DELETED_STATUS;
        $model->save();
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
