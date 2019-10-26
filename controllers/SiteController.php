<?php

namespace app\controllers;

use app\helpers\StringHelper;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\Post;
use app\models\User;
use app\models\ForgotPasswordForm;
use yii\web\NotFoundHttpException;
use app\models\UserGalleryImage;
use app\models\Gallery;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actionRegister()
    {
        $model = new User();
        if ($model->load(Yii::$app->request->post())) {
            $model->role = User::USER_ROLE;
            $model->status = User::NEW_STATUS;
            $model->salt = Yii::$app->userComponent->getSalt();
            $model->password = Yii::$app->userComponent->encodePassword($model->password, $model->salt);
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Регистрация успешна!');
                Yii::$app->user->login($model, User::DEFAULT_IDENTITY_COOKIE_DURATION);
                return $this->redirect('/');
            }
        }

        return $this->render('register', [
            'model' => $model,
        ]);
    }

    public function actionUser($type)
    {
        if (!array_key_exists($type, User::$typesList)) {
            throw new NotFoundHttpException('User type not found.');
        }
        $users = User::find()->where(['type' => $type, 'status' => User::ACTIVE_STATUS])->all();

        return $this->render('student', [
            'users' => $users,
        ]);
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionUserPortfolio($userId){
        $user = User::findOne($userId);
        if (empty($user)) {
            throw new NotFoundHttpException('Use not found');
        }
        $userGalleryImages = UserGalleryImage::findAll(['user_id' => $userId, 'gallery_id' => Gallery::PORTFOLIO['id']]);

        return $this->render('user-portfolio', [
            'user' => $user,
            'userGalleryImages' => $userGalleryImages,
        ]);
    }

    public function actionIndex()
    {
        $query = Post::find()->where(['status' => Post::PUBLISHED_STATUS])->orderBy('id DESC');
        $countQuery = clone $query;
        $pages = new \yii\data\Pagination(
            [
                'totalCount' => $countQuery->count(),
                'defaultPageSize' => 10
            ]
        );
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('index', [
            'models' => $models,
            'pages' => $pages,
        ]);
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionPost($id)
    {
        $model = Post::findOne($id);
        if (empty($model)) {
            throw new NotFoundHttpException('Post not found');
        }

        return $this->render('post', [
            'model' => $model,
        ]);
    }
}
