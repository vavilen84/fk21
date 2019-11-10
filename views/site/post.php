<?php
$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Главная', 'url' => ['/']];
use app\helpers\PathHelper;

?>
<style>
    .h1 {
        padding-top: 50px;
    }

    .post-image-block {
        text-align: center;
        padding-top: 50px;
    }

    .post-content {
        padding-top: 50px;
        padding-left: 200px;
    }

    .post-content img {
        position: relative;
        left: -200px;
    }
</style>
<h1 class="h1">
    <?php echo $model->title; ?>
</h1>
<?php if (!empty($model->image_id)): ?>
    <div class="post-image-block">
        <img src="<?php echo PathHelper::getPathByImageId($model->image_id); ?>" alt="">
    </div>
<?php endif; ?>
<div class="post-content">
    <?php echo $model->content; ?>
</div>