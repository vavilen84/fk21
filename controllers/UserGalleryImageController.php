<?php

namespace app\controllers;

use app\models\Image;
use Yii;
use app\models\UserGalleryImage;
use app\models\UserGalleryImageSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\User;
use app\models\Gallery;
use app\models\ImageUpload;
use yii\web\UploadedFile;

/**
 * UserGalleryImageController implements the CRUD actions for UserGalleryImage model.
 */
class UserGalleryImageController extends Controller
{
    /**
     * {@inheritdoc}
     */
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

    public function actionUserGalleryRemoveImage($userId, $galleryId, $imageId)
    {
        $userGalleryImage = UserGalleryImage::findOne(
            [
                'user_id' => $userId,
                'gallery_id' => $galleryId,
                'image_id' => $imageId
            ]
        );
        if ($userGalleryImage instanceof UserGalleryImage) {
            $userGalleryImage->delete();
            Yii::$app->session->setFlash('success', 'Изображение удалено!');
            $this->redirect(['user-gallery-image/user-gallery', 'userId' => $userId, 'galleryId' => $galleryId]);
        }
    }

    public function actionUserGallery($userId, $galleryId)
    {
        $user = User::findOne(['id' => $userId]);
        if (!$user instanceof User) {
            throwException('User not found');
        }
        $gallery = Gallery::findById($galleryId);
        if (!$gallery instanceof Gallery) {
            throwException('Gallery not found');
        }
        $userGalleryImages = UserGalleryImage::findAll(['user_id' => $userId, 'gallery_id' => $galleryId]);
        $imageUploadModel = new ImageUpload();
        if (Yii::$app->request->isPost) {
            $imageUploadModel->imageFile = UploadedFile::getInstance($imageUploadModel, 'imageFile');
            $uploaded = $imageUploadModel->upload();
            if ($uploaded instanceof Image) {
                $userGalleryImage = new UserGalleryImage();
                $userGalleryImage->user_id = $userId;
                $userGalleryImage->gallery_id = $galleryId;
                $userGalleryImage->image_id = $uploaded->id;
                if ($userGalleryImage->save()) {
                    Yii::$app->session->setFlash('success', 'Изображение добавлено!');
                }
            }
        }

        return $this->render('user-gallery', [
            'user' => $user,
            'gallery' => $gallery,
            'userGalleryImages' => $userGalleryImages,
            'imageUploadModel' => $imageUploadModel,
        ]);
    }

    /**
     * Lists all UserGalleryImage models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserGalleryImageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserGalleryImage model.
     *
     * @param integer $user_id
     * @param integer $gallery_id
     * @param integer $image_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($user_id, $gallery_id, $image_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($user_id, $gallery_id, $image_id),
        ]);
    }

    /**
     * Creates a new UserGalleryImage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UserGalleryImage();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'user_id' => $model->user_id, 'gallery_id' => $model->gallery_id, 'image_id' => $model->image_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing UserGalleryImage model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $user_id
     * @param integer $gallery_id
     * @param integer $image_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($user_id, $gallery_id, $image_id)
    {
        $model = $this->findModel($user_id, $gallery_id, $image_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'user_id' => $model->user_id, 'gallery_id' => $model->gallery_id, 'image_id' => $model->image_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing UserGalleryImage model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $user_id
     * @param integer $gallery_id
     * @param integer $image_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($user_id, $gallery_id, $image_id)
    {
        $this->findModel($user_id, $gallery_id, $image_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the UserGalleryImage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $user_id
     * @param integer $gallery_id
     * @param integer $image_id
     * @return UserGalleryImage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($user_id, $gallery_id, $image_id)
    {
        if (($model = UserGalleryImage::findOne(['user_id' => $user_id, 'gallery_id' => $gallery_id, 'image_id' => $image_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
