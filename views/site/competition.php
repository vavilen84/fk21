<?php

use app\helpers\PathHelper;
use app\models\Competition;
use app\models\Image;

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Главная', 'url' => ['/']];

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

    .deadline {
        font-weight: bold;
        text-align: center;
        padding-top: 50px;
    }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.13/jquery.mousewheel.min.js"></script>
<link type="text/css" rel="stylesheet" href="/libs/lightGallery-master/src/css/lightgallery.css"/>
<script>
    $(document).ready(function () {
        function loadScript(url, callback) {
            var script = document.createElement("script")
            script.type = "text/javascript";
            if (script.readyState) {  //IE
                script.onreadystatechange = function () {
                    if (script.readyState == "loaded" ||
                        script.readyState == "complete") {
                        script.onreadystatechange = null;
                        callback();
                    }
                };
            } else {  //Others
                script.onload = function () {
                    callback();
                };
            }
            script.src = url;
            document.getElementsByTagName("head")[0].appendChild(script);
        }

        loadScript("/libs/lightGallery-master/src/js/lightgallery.js", function () {
            loadScript("/libs/lightGallery-master/modules/lg-thumbnail.min.js", function () {
            });
            loadScript("/libs/lightGallery-master/modules/lg-fullscreen.min.js", function () {
            });
            $("#lightgallery").lightGallery({
                mode: 'lg-fade',
                addClass: 'fixed-size',
                counter: false,
                download: false,
                startClass: '',
                enableSwipe: false,
                enableDrag: false,
                speed: 500
            });
        });

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
        <?php foreach ($images as $image): ?>
            <?php $image = Image::findOne($userGalleryImage->image_id); ?>
            <?php $dataSubHtml = ""; ?>
            <?php if (!empty($image->title) || !empty($image->description)): ?>
                <?php $dataSubHtml = $image->title . "<br>" . $image->description; ?>
            <?php endif ?>
            <a data-sub-html="<?php echo $dataSubHtml; ?>" href=" <?php echo PathHelper::getPathByImage($image); ?>">
                <img src="<?php echo PathHelper::getPathByImage($image); ?>">
            </a>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

