<?php
use yii\grid\GridView;
use yii\helpers\StringHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use app\helpers\PathHelper;
use app\models\User;

/* @var $this yii\web\View */

$this->title = 'Home | Fotokolo';
?>
<style>
    .left {
        float: left;
    }

    .right {
        float: right;
    }

    .clear {
        clear: both;
    }

    #index-page-news .item {
        border: 1px solid #cecece;
        width: 33%;
    }

    #index-page-news .item .image {
        height: 255px;
        overflow: hidden;
    }

    #index-page-news .item img {
        max-height: 250px;
    }

    .created_at {
        color: gray;
    }

    .title {
        font-weight: bold;
    }

    .mini-block-wrap {
        padding: 10px 20px;
    }

    #index-page-news {
        position: relative;
    }

    #index-page-news .banner,
    #index-page-ad .banner,
    #index-page-articles .banner {
        position: absolute;
        top: 1px;
        left: 1px;
        background: black;
        color: rgb(250, 50, 70);
        padding: 5px 10px;
    }

    #index-page-news a {
        text-decoration: none;
        color: black;
    }

    #index-page-news .read-more,
    #index-page-ad .read-more,
    #index-page-articles .read-more {
        color: rgb(250, 50, 70);
        font-weight: bold;
        font-size: 16px;
        text-decoration: underline;
    }

    #index-page-ad {
        position: relative;
    }

    #index-page-ad .item {
        border: 1px solid gray;
        width: 100%;
        padding: 20px 20px 20px 370px;
    }

    #index-page-ad a {
        color: black;
    }

    #index-page-ad a:hover {
        text-decoration: none;
    }

    #index-page-ad .title {
        font-size: 38px;
    }

    #index-page-articles .item {
        width: 50%;
        border: 1px solid gray;
    }

    #index-page-articles .item .image {
        height: 405px;
        overflow: hidden;
    }

    #index-page-articles .item img {
        max-height: 400px;
    }

    #index-page-articles {
        position: relative;
    }

    .author-link {
        color: rgb(250, 50, 70);
        text-decoration: underline;
    }

    #index-page-news,
    #index-page-articles {
        visibility: hidden;
    }

</style>
<script>
    $(document).ready(function () {
        // set same height for news blocks and show
        var newsBlocks = $("#index-page-news .item");
        fixElementHeight(newsBlocks);
        var articlesBlocks = $("#index-page-articles .item");
        fixElementHeight(articlesBlocks);

    });

    function fixElementHeight(items) {
        var maxHeight = 0;
        $.each(items, function (i, v) {
            var h = $(this).height();
            if (h > maxHeight) {
                maxHeight = h;
            }
        });
        $.each(items, function (i, v) {
            $(this).css("height", maxHeight).css("visibility", "visible");
        });
    }
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
                <div class="mini-block-wrap">
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
                        <div><a class="author-link"
                                href=""><?php echo $author->first_name . " " . $author->last_name; ?></a></div>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
            <div class="mini-block-wrap">
                <a href="<?php echo Url::toRoute(['site/post', 'id' => $v->id]); ?>" class="read-more">...</a>
            </div>
        </div>
    <?php endforeach; ?>
    <div class="clear"></div>
</div>