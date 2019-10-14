<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

use app\models\User;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <style>

    </style>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin(
        [
            'brandLabel' => 'Fotokolo',
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-inverse navbar-fixed-top',
            ],
        ]
    );
    echo Nav::widget(
        [
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => [
                ['label' => 'Главная', 'url' => ['/site/index']],
                [
                    'label' => 'Редактировать Новости',
                    'url' => ['/post/index'],
                    'visible' => Yii::$app->userComponent->userHasRole([User::ADMIN_ROLE, User::MODERATOR_ROLE])
                ],
                [
                    'label' => 'Редактировать Пользователей',
                    'url' => ['/user/index'],
                    'visible' => Yii::$app->userComponent->userHasRole([User::ADMIN_ROLE])
                ],
                [
                    'label' => 'Мой профиль',
                    'url' => ['/user/profile'],
                    'visible' => !Yii::$app->user->isGuest && !Yii::$app->userComponent->userHasRole([User::ADMIN_ROLE])
                ],
                [
                    'label' => 'Войти',
                    'url' => ['/site/login'],
                    'visible' => Yii::$app->user->isGuest
                ],
                [
                    'label' => 'Регистрация',
                    'url' => ['/user/register'],
                    'visible' => Yii::$app->user->isGuest
                ],
                [
                    'label' => 'Login',
                    'url' => ['/site/login'],
                    'visible' => Yii::$app->user->isGuest
                ],
                Yii::$app->user->isGuest ? (['label' => '']) :
                    '<li>'
                    . Html::beginForm(['/site/logout'], 'post')
                    . Html::submitButton(
                        'Logout (' . Yii::$app->user->identity->first_name . ')',
                        ['class' => 'btn btn-link logout']
                    )
                    . Html::endForm()
                    . '</li>',

            ],
        ]
    );
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget(
            [
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]
        ) ?>
        <?= Alert::widget() ?>
        <?php if( Yii::$app->session->hasFlash('success') ): ?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <?php echo Yii::$app->session->getFlash('success'); ?>
            </div>
        <?php endif;?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Fotokolo <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
