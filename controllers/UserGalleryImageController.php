<?php

namespace app\controllers;

use app\models\Image;
use Faker\Test\Provider\en_US\CompanyTest;
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
use app\models\Competition;
use app\models\CompetitionUserImage;

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

    public function actionCompetitionParticipate($userId, $competitionId)
    {
        $user = User::findOne($userId);
        if (empty($user)) {
            throw new NotFoundHttpException('User not found.');
        }
        $competition = Competition::findOne($competitionId);
        if (empty($competition)) {
            throw new NotFoundHttpException('Competition not found.');
        }

        $imageUploadModel = new ImageUpload();
        if ($imageUploadModel->load(Yii::$app->request->post())) {
            // delete old image
            $oldImage = CompetitionUserImage::findOne(['user_id' => $userId, 'competition_id' => $competitionId]);
            if (!empty($oldImage)) {
                $oldImage->delete();
            }
            // add new one
            $imageUploadModel->imageFile = UploadedFile::getInstance($imageUploadModel, 'imageFile');
            if (!empty($imageUploadModel->imageFile)) {
                $uploaded = $imageUploadModel->upload();
                if ($uploaded instanceof Image) {

                    $competitionUserImage = new CompetitionUserImage();
                    $competitionUserImage->competition_id = $competitionId;
                    $competitionUserImage->user_id = $userId;
                    $competitionUserImage->image_id = $uploaded->id;

                    if ($competitionUserImage->save()) {
                        Yii::$app->session->setFlash('success', ' Сохранено успешно!');
                        return $this->redirect(['competition-participate', 'userId' => $user->id, 'competitionId' => $competitionId]);
                    }
                }
            }
        }

        $existingImage = null;
        $existingCompetitionUserImage = CompetitionUserImage::findOne(['user_id' => $userId, 'competition_id' => $competitionId]);
        if (!empty($existingCompetitionUserImage)) {
            $existingImage = Image::findOne($existingCompetitionUserImage->image_id);
        }

        return $this->render('competition-participate', [
            'existingImage' => $existingImage,
            'model' => $imageUploadModel,
            'user' => $user,
            'competition' => $competition,
        ]);
    }

    public function actionProfile()
    {
        $model = Yii::$app->user->getIdentity();
        $imageUploadModel = new ImageUpload();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            if (!empty($model->newPassword)) {
                $model->salt = Yii::$app->userComponent->getSalt();
                $model->password = Yii::$app->userComponent->encodePassword($model->newPassword, $model->salt);
            }

            $imageUploadModel->imageFile = UploadedFile::getInstance($model, 'avatarImage');
            if (!empty($imageUploadModel->imageFile)) {
                $uploaded = $imageUploadModel->upload();
                if ($uploaded instanceof Image) {
                    $model->avatar = $uploaded->id;
                }
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('success', ' Сохранено успешно!');
                return $this->redirect(['profile', 'id' => $model->id]);
            }
        }

        $activeCompetitions = Competition::find()->where(['status' => Competition::RESULTS_NOT_PUBLISHED_STATUS])->all();

        return $this->render('profile', [
            'activeCompetitions' => $activeCompetitions,
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

    public function actionUpdateCompetitionImage($imageId, $userId, $competitionId)
    {
        $model = Image::findOne($imageId);
        if (empty($model)) {
            throw new NotFoundHttpException("Image not found");
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Сохранено!');
            return $this->redirect(['competition-participate', 'userId' => $userId, 'competitionId' => $competitionId]);
        }

        return $this->render('update-competition-image', [
            'model' => $model,
        ]);
    }

    public function actionCompetitionParticipateRemoveImage($imageId, $userId, $competitionId)
    {
        $model = Image::findOne($imageId);
        if (empty($model)) {
            throw new NotFoundHttpException("Image not found");
        }
        $competitionUserImage = CompetitionUserImage::find()->where(
            [
                'image_id' => $imageId,
                'user_id' => $userId,
                'competition_id' => $competitionId
            ])->one();
        if (!empty($competitionUserImage)) {
            $competitionUserImage->delete();
        }
        Yii::$app->session->setFlash('success', 'Удалено!');
        return $this->redirect(['competition-participate', 'userId' => $userId, 'competitionId' => $competitionId]);

    }
}
