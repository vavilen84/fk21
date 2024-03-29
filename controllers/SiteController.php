<?php

namespace app\controllers;

use app\helpers\StringHelper;
use app\models\gii\CompetitionUserImage;
use app\models\ResetPasswordForm;
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
use app\models\Competition;
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
                $format = "<a target='_blank' href='%s://%s/user/update/%d'>Moderate User</a>";
                $link = sprintf(
                    $format,
                    getenv('PROTOCOL'),
                    getenv('DOMAIN'),
                    $model->id
                );
                $body = 'New user has just registered and requires moderation.Proceed by click the link: ' . $link;
                Yii::$app->mailerComponent->send(getenv('ADMIN_EMAIL'), "New User", $body);
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
            'type' => $type,
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

    public function actionUserPortfolio($userId)
    {
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

    public function actionResetPassword($token)
    {
        $user = User::find()->where(['password_reset_token' => $token])->one();
        if (empty($user)) {
            throw new NotFoundHttpException('Use not found');
        }
        $model = new ResetPasswordForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user->salt = Yii::$app->userComponent->getSalt();
            $user->password = Yii::$app->userComponent->encodePassword($model->password, $user->salt);
            $user->password_reset_token = null;
            if ($user->save()) {
                Yii::$app->user->login($user, User::DEFAULT_IDENTITY_COOKIE_DURATION);
                Yii::$app->session->setFlash('success', 'Пароль удачно изменен!');
                return $this->redirect('/');
            }
        }
        return $this->render('reset-password', [
            'model' => $model
        ]);
    }

    public function actionForgotPassword()
    {
        $model = new ForgotPasswordForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = User::findByEmail($model->email);
            if ($user instanceof User) {
                $user->password_reset_token = StringHelper::getRandomString(50);
                if ($user->save()) {
                    $format = "<a target='_blank' href='%s://%s/site/reset-password?token=%s'>Reset Password</a>";
                    $link = sprintf(
                        $format,
                        getenv('PROTOCOL'),
                        getenv('DOMAIN'),
                        $user->password_reset_token
                    );
                    $body = 'Follow the link to change the password: ' . $link;
                    Yii::$app->mailerComponent->send($user->email, "Reset password", $body);
                    Yii::$app->session->setFlash('success', 'Вам отправлено письмо для сброса пароля!');
                    return $this->goHome();
                }
            } else {
                $model->addError("email", "Пользователя с такой почтой не зарегистрирован");
            }
        }

        return $this->render('forgot-password', [
            'model' => $model,
        ]);
    }

    public function actionPosts()
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

    public function actionIndex()
    {
        $news = Post::find()->where(['type' => Post::NEWS_TYPE])->limit(3)->orderBy('id DESC')->all();
        $ads = Post::find()->where(['type' => Post::AD_TYPE])->orderBy('id DESC')->all();
        $articles = Post::find()->where(['type' => Post::ARTICLE_TYPE])->limit(2)->orderBy('id DESC')->all();
        $users = User::find()->all();
        shuffle($users);
        $users = array_slice($users, 0, 4);
        $competitions = Competition::find()->where(['!=', 'status', Competition::DELETED_STATUS])->all();

        return $this->render('index', [
            'news' => $news,
            'ads' => $ads,
            'articles' => $articles,
            'users' => $users,
            'competitions' => $competitions
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

    public function actionCompetition($id)
    {
        $model = Competition::findOne($id);
        if (empty($model)) {
            throw new NotFoundHttpException('Competition not found');
        }
        $images = CompetitionUserImage::find()->where(['competition_id' => $id])->all();

        return $this->render('competition', [
            'model' => $model,
            'images' => $images
        ]);
    }
}
