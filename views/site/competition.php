<?php

use app\helpers\PathHelper;
use app\models\Competition;
use app\models\Image;
use app\models\User;

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

    #lightgallery .author {
        color: red;
        text-decoration: underline;
    }

    .competition-image {
        display: block;
        float: left;
        visibility: hidden;
        border-radius: 5px;
        border: 1px solid gray;
        position:relative;
    }
    .competition-image-info{
        text-align: center;
    }

    .competition-image:hover {
        text-decoration: none;
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
<script>
    $(document).ready(function () {
        // set same height for news blocks and show
        var images = $("#lightgallery .competition-image");
        fixElementHeight(images, 100);

    });

    function fixElementHeight(items, additinalPadding) {
        var maxHeight = 0;
        $.each(items, function (i, v) {
            var h = $(this).height();
            if (h > maxHeight) {
                if (additinalPadding) {
                    h = h + additinalPadding;
                }
                maxHeight = h;
            }
        });
        $.each(items, function (i, v) {
            var h = $(this).height();
            var padding = (maxHeight - h) / 2;
            $(this).css("height", maxHeight).css("visibility", "visible").css("padding-top", padding);
        });
    }
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
        <?php foreach ($images as $v): ?>
            <?php $image = Image::findOne($v->image_id); ?>
            <?php $dataSubHtml = ""; ?>
            <?php if (!empty($image->title) || !empty($image->description)): ?>
                <?php $dataSubHtml = $image->title . "<br>" . $image->description; ?>
            <?php endif ?>
            <a class="competition-image" data-sub-html="<?php echo $dataSubHtml; ?>"
               href=" <?php echo PathHelper::getPathByImage($image); ?>">
                <img src="<?php echo PathHelper::getPathByImage($image); ?>">
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
            <div class="clear"></div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

