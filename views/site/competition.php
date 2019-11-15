<?php

use app\helpers\PathHelper;
use app\models\Competition;
use app\models\Image;
use app\models\User;

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Главная', 'url' => ['/']];

?>
<script>
    $(document).ready(function () {
        var images = $("#lightgallery .gallery-image");
        fixElementHeight(images, 40);
    });
</script>
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

<?php if ($model->status == Competition::RESULTS_NOT_PUBLISHED_STATUS): ?>
    <div class="deadline">
        Результаты будут опубликованы после: <?php echo date('d-M-Y', $model->deadline_at); ?>
    </div>
<?php endif; ?>

<?php if (($model->status == Competition::RESULTS_PUBLISHED_STATUS) && !empty($images)): ?>
    <h3>Конкурсные работы</h3>
    <div id="lightgallery">
        <?php foreach ($images as $k => $v): ?>
            <?php $image = Image::findOne($v->image_id); ?>
            <?php $dataSubHtml = ""; ?>
            <?php if (!empty($image->title) || !empty($image->description)): ?>
                <?php $dataSubHtml = $image->title . "<br>" . $image->description; ?>
            <?php endif ?>
            <a class="gallery-image" href="#">
                <?php $imageSize = getimagesize(getenv("PROJECT_PATH") . "/web" . PathHelper::getPathByImage($image)); ?>
                <img
                        data-id="<?php echo $image->id; ?>"
                        data-width="<?php echo $imageSize[0]; ?>"
                        data-height="<?php echo $imageSize[1]; ?>"
                        src="<?php echo PathHelper::getPathByImage($image); ?>">
                <div class="competition-image-info">
                    <div style="color:black;">
                        <?php echo $image->title; ?>
                    </div>
                    <div style="color:black;">
                        <?php echo $image->description; ?>
                    </div>
                    <span class="author">
                        <?php $author = User::findOne($v->user_id); ?>
                        <?php echo $author->first_name . " " . $author->last_name; ?>
                    </span>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

