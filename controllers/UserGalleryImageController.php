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

class UserGalleryImageController extends Controller
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
        if (empty($model)) {
            throw new NotFoundHttpException('You are not allowed to perform this action.');
        }
        return parent::beforeAction($action);
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

    public function actionProfile()
    {
        $model = Yii::$app->user->getIdentity();
        $imageUploadModel = new ImageUpload();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $imageUploadModel->imageFile = UploadedFile::getInstance($model, 'avatarImage');
            if (!empty($imageUploadModel->imageFile)) {
                $uploaded = $imageUploadModel->upload();
                if ($uploaded instanceof Image) {
                    $model->avatar = $uploaded->id;
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', ' Сохранено успешно!');
                        return $this->redirect(['profile', 'id' => $model->id]);
                    } else {
                        var_dump($model->getErrors());die;
                    }
                }
            } else {
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Сохранено успешно!');
                    return $this->redirect(['profile', 'id' => $model->id]);
                }
            }
        }

        return $this->render('profile', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($userId, $galleryId, $imageId)
    {
        $model = Image::findOne($imageId);
        if (empty($model)) {
            throw new NotFoundHttpException("Image not found");
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Сохранено!');
            return $this->redirect(
                [
                    'user-gallery',
                    'userId' => $userId,
                    'galleryId' => $galleryId,
                    'imageId' => $imageId
                ]
            );
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
}
