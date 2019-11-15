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
    <link rel="shortcut icon" href="/images/favicon.png" type="image/x-icon">
    <style>
        #logo {
            position: relative;
            top: 15px;
        }

        .footer {
            background: #333333;
            height: 50px;
            position: relative;
            top: 10px;
        }

        #gallery-wrap {
            position: absolute;
            top: 0;
            left: 0;
            background: black;
            min-width: 100%;
            min-height: 100%;
            height: 100%;
            z-index: 999999;
            display: none;
        }

        #gallery-wrap #controls {
            position: absolute;
            min-width: 100%;
            min-height: 100%;
            height: 100%;
        }

        #gallery-wrap img {
            max-width: 1200px;
            max-width: 90%;
        }

        #gallery-wrap #image,
        #gallery-wrap #description {
            text-align: center;
        }

        #gallery-wrap #description {
            color: white;
            padding-top: 20px;
        }

        .overflow-hidden {
            overflow: hidden;
        }

        #gallery-wrap #description
    </style>
    <base href="<?php echo getenv('PROTOCOL'); ?>://<?php echo getenv('DOMAIN'); ?>/">
    <script
            src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous"></script>
    <script>
        $(document).ready(function () {

            $("#close-wrap").click(function () {
                $("#gallery-wrap").hide();
                $("body").removeClass("overflow-hidden");
            });
            $(".gallery-image").on("click", function (e) {
                var curEl = $(this);
                e.preventDefault();
                $(window).scrollTop(0);
                var image = curEl.find("img").clone();

                $("#gallery-wrap #image").html(image);
                $("#gallery-wrap #description").html(curEl.find(".competition-image-info").html());
                $("#gallery-wrap").show();

                $("body").addClass("overflow-hidden");
                var galleryContent = $("#gallery-wrap #content");
                var galleryContentHeight = galleryContent.height();

                var maxWidth = 1200;
                var imageWidth = parseFloat(image.attr("data-width"));
                var imageHeight = parseFloat(image.attr("data-height"))
                if (imageWidth > maxWidth) {
                    var ratio = maxWidth / imageWidth;
                    imageHeight = imageHeight * ratio
                }
                var contentHeight = imageHeight + parseFloat(galleryContentHeight);

                var windowHeight = $(window).height();
                if (windowHeight > contentHeight) {
                    var heightDiff = windowHeight - contentHeight;
                    galleryContent.css("padding-top", (heightDiff / 2))
                }
            });
        });
    </script>
</head>
<body>
<div id="gallery-wrap">
    <div id="controls">
        <div id="left-wrap">
            <div id="left"></div>
        </div>
        <div id="right-wrap">
            <div id="right"></div>
        </div>
        <div id="close-wrap">
            <div id="close"></div>
        </div>
    </div>
    <div id="content">
        <div id="image"></div>
        <div id="description"></div>
    </div>
</div>
<?php $this->beginBody() ?>
<div class="wrap">
    <?php
    NavBar::begin(
        [
            'brandLabel' => "<a id=\"logo\" href=\"/\">
                        <img alt=\"logo\" src=\"/images/Logo.svg\">
                    </a>",
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
                ['label' => 'О Нас', 'url' => ['/site/about']],
                [
                    'label' => 'Галерея',
                    'items' => [
                        [
                            'label' => 'Ученики',
                            'url' => ['/site/user', 'type' => User::STUDENT_TYPE],
                        ],
                        [
                            'label' => 'Выпускники',
                            'url' => ['/site/user', 'type' => User::GRADUATE_TYPE],
                        ],
                    ],
                ],
                ['label' => '|', 'url' => null],
                [
                    'label' => 'Админка',
                    'items' => [
                        [
                            'label' => 'Новости',
                            'url' => ['/post/news'],
                        ],
                        [
                            'label' => 'Объявления',
                            'url' => ['/post/ads'],
                        ],
                        [
                            'label' => 'Статьи',
                            'url' => ['/post/articles'],
                        ],
                        [
                            'label' => 'Пользователи',
                            'url' => ['/user/index'],
                        ],
                        [
                            'label' => 'Конкурсы',
                            'url' => ['/competition/index'],
                        ],
                        [
                            'label' => 'Мой профиль',
                            'url' => ['/user-gallery-image/profile'],
                        ],
                    ],
                    'visible' => Yii::$app->userComponent->userHasRole([User::ADMIN_ROLE])
                ],
                [
                    'label' => 'Админка',
                    'items' => [
                        [
                            'label' => 'Мой профиль',
                            'url' => ['/user-gallery-image/profile'],
                        ],
                        [
                            'label' => 'Записи',
                            'url' => ['/post/index'],
                            'visible' => Yii::$app->userComponent->userHasRole([User::MODERATOR_ROLE])
                        ],
                    ],
                    'visible' => !Yii::$app->user->isGuest && !Yii::$app->userComponent->userHasRole([User::ADMIN_ROLE])
                ],
                [
                    'label' => 'Войти',
                    'url' => ['/site/login'],
                    'visible' => Yii::$app->user->isGuest
                ],
                [
                    'label' => 'Регистрация',
                    'url' => ['/site/register'],
                    'visible' => Yii::$app->user->isGuest
                ],
                Yii::$app->user->isGuest ? (['label' => '']) :
                    '<li>'
                    . Html::beginForm(['/site/logout'], 'post')
                    . Html::submitButton(
                        'Выйти (' . Yii::$app->user->identity->first_name . ')',
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
                'homeLink' => false,
            ]
        ) ?>
        <?= Alert::widget() ?>
        <?php if (Yii::$app->session->hasFlash('success')): ?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <?php echo Yii::$app->session->getFlash('success'); ?>
            </div>
        <?php endif; ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">

    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
