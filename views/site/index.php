<?php
use yii\grid\GridView;
use yii\helpers\StringHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use app\helpers\PathHelper;
use app\models\User;
use app\models\Competition;

/* @var $this yii\web\View */

$this->title = 'Home | Fotokolo';
?>
<script>
    $(document).ready(function () {
        // set same height for news blocks and show
        var newsBlocks = $("#index-page-news .item");
        fixElementHeight(newsBlocks, 30);
        var articlesBlocks = $("#index-page-articles .item");
        fixElementHeight(articlesBlocks, 30);
        var usersBlocks = $("#users .user-avatar");
        fixElementHeight(usersBlocks, 0);

    });
</script>

<div id="index-page-news">
    <div class="banner">Новости</div>
    <?php foreach ($news as $v): ?>
        <div class="item left">
            <a href="<?php echo Url::toRoute(['site/post', 'id' => $v->id]); ?>">
                <div class="image">
                    <img src="<?php echo PathHelper::getPathByImageId($v->image_id); ?> " alt=''>
                </div>
                <div class="mini-block-wrap">
                    <span class="created_at"><?php echo date('d\.m\.Y'); ?></span>
                </div>
                <div class="mini-block-wrap">
                    <span class="title"><?php echo $v->title; ?></span>
                </div>
                <div class="mini-block-wrap read-more-block">
                    <a href="<?php echo Url::toRoute(['site/post', 'id' => $v->id]); ?>" class="read-more">...</a>
                </div>
            </a>
        </div>
    <?php endforeach; ?>
    <div class="clear"></div>
</div>

<div id="index-page-ad">
    <div class="banner">Объявления</div>
    <?php foreach ($ads as $v): ?>
        <div class="item">
            <a href="<?php echo Url::toRoute(['site/post', 'id' => $v->id]); ?>">
                <div class="mini-block-wrap">
                    <span class="title"><?php echo $v->title; ?></span>
                </div>
                <div class="mini-block-wrap">
                    <a href="<?php echo Url::toRoute(['site/post', 'id' => $v->id]); ?>" class="read-more">...</a>
                </div>
            </a>
        </div>
    <?php endforeach; ?>
</div>


<div id="index-page-articles">
    <div class="banner">Статьи</div>
    <?php foreach ($articles as $v): ?>
        <div class="item left">
            <a href="<?php echo Url::toRoute(['site/post', 'id' => $v->id]); ?>">
                <div>
                    <img src="<?php echo PathHelper::getPathByImageId($v->image_id); ?> " alt=''>
                </div>
                <div>
                    <div class="left">
                        <div class="mini-block-wrap" id="article-title-wrap">
                            <?php echo $v->title; ?>
                        </div>
                    </div>
                    <div class="right" style="width:170px;">
                        <div class="mini-block-wrap">
                            <span class="created_at"><?php echo date('d\.m\.Y'); ?></span>
                            <div style="color:gray;">Автор:</div>
                            <?php $author = User::findOne($v->user_id); ?>
                            <div><a class="author-link" href=""><?php echo $author->first_name . " " . $author->last_name; ?></a></div>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="mini-block-wrap">
                    <a href="<?php echo Url::toRoute(['site/post', 'id' => $v->id]); ?>" class="read-more">...</a>
                </div>
            </a>
        </div>
    <?php endforeach; ?>
    <div class="clear"></div>
</div>

<div id="users">
    <div class="banner">Авторы</div>
    <?php foreach ($users as $v): ?>
    <div class="item left">
        <a href="<?php echo Url::toRoute(['site/post', 'id' => $v->id]); ?>">
            <div class="user-avatar">
                <img src="<?php echo PathHelper::getUserAvatarImagePath($v); ?> " alt=''>
            </div>
            <div class="mini-block-wrap" id="first-last-name">
                <?php echo $v->first_name . ' ' . $v->last_name; ?>
            </div>
        </a>
    </div>
    <?php endforeach; ?>
    <div class="clear"></div>
</div>

<div id="competitions">
    <div class="banner">Конкурсы</div>
    <?php foreach ($competitions as $v): ?>
        <div class="item">
            <a href="<?php echo Url::toRoute(['site/competition', 'id' => $v->id]); ?>">
                <div class="competition-image competition-info">
                    <img src="<?php echo PathHelper::getPathByImageId($v->image_id); ?> " alt=''>
                    <div class="competition-info-inner">
                        <div class="mini-block-wrap title">
                            <?php echo $v->title; ?>
                        </div>
                        <div class="mini-block-wrap description">
                            <?php echo $v->description; ?>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    <?php endforeach; ?>

</div>