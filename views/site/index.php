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

<div id="index-page-news">
    <?php foreach ($news as $v): ?>
        <div class="item">
            <img src="<?php echo PathHelper::getPathByImageId($v->image_id); ?> " alt=''>
            <span class="created_at"><?php echo date('d\.m\.Y'); ?></span>
            <span class="title"><?php echo $v->title; ?></span>
            <a href="<?php echo Url::toRoute(['site/post', 'id' => $model->id]); ?>" class="read-more">...</a>
        </div>
    <?php endforeach; ?>
</div>

<div id="index-page-ad">
    <?php foreach ($news as $v): ?>
        <div class="item">
            <span class="title"><?php echo $ad->title; ?></span>
            <a href="<?php echo Url::toRoute(['site/post', 'id' => $ad->id]); ?>" class="read-more">...</a>
        </div>
    <?php endforeach; ?>
</div>


<div id="index-page-articles">
    <?php foreach ($news as $v): ?>
        <div class="item">
            <img src="<?php echo PathHelper::getPathByImageId($v->image_id); ?> " alt=''>
            <div>
                <div class="left">
                    <?php echo $v->title; ?>
                </div>
                <div class="right">
                    <span class="created_at"><?php echo date('d\.m\.Y'); ?></span>
                    <div>Автор</div>
                    <?php $author = User::findOne($v->user_id); ?>
                    <div><a href=""><?php echo $author->first_name . " " . $author->last_name; ?></a></div>
                </div>
                <div class="clear"></div>

            </div>

            <span class="title"><?php echo $v->title; ?></span>
            <a href="<?php echo Url::toRoute(['site/post', 'id' => $model->id]); ?>" class="read-more">...</a>
        </div>
    <?php endforeach; ?>
</div>