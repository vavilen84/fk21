<?php
use dosamigos\fileupload\FileUpload;
use yii\helpers\Html;
use yii\helpers\Url;
use app\helpers\PathHelper;
use yii\widgets\ActiveForm;
use app\models\Image;

?>
<script
        src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous"></script>
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
<style>
    #lightgallery a {
        max-width: 23%;
        padding: 1%;
        margin: 3px 0;
        display: inline-block;
        text-align: center;
    }

    #user-list a {
        color: black;
        font-weight: bold;
    }

    #lightgallery a img {
        max-width: 100%;
    }
</style>
<h1></h1>
<br>

<div id="lightgallery">
    <?php foreach ($userGalleryImages as $userGalleryImage): ?>
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
