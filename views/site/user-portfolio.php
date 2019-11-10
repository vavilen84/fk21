<?php
use dosamigos\fileupload\FileUpload;
use yii\helpers\Html;
use yii\helpers\Url;
use app\helpers\PathHelper;
use yii\widgets\ActiveForm;
use app\models\Image;
use app\models\User;
$this->title = 'Портфолио';
$this->params['breadcrumbs'][] = ['label' => 'Главная', 'url' => ['/']];
$this->params['breadcrumbs'][] = ['label' => User::$typesTitleList[$user->type], 'url' => ['/site/user', 'type' => $user->type]];
?>
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

<h1><?php echo $user->first_name . " " . $user->last_name; ?></h1>
<br>

<div class="container">
    <div class="fl w25">
        <div>
            <img alt="" src="<?php echo PathHelper::getUserAvatarImagePath($user); ?>">
        </div>
    </div>
    <div class="fr w70">
        <div>
            <?php echo $user->about; ?>
        </div>
        <div class="links">
            <div class="fl w45">
                <div class="item">
                    <img alt="" src="/images/pinterest.png">
                    <?php echo $user->pinterest_link; ?>
                </div>
                <div class="item">
                    <img alt="" src="/images/instagram.png">
                    <?php echo $user->instagram_link; ?>
                </div>
                <div class="item">
                    <img alt="" src="/images/facebook.png">
                    <?php echo $user->facebook_link; ?>
                </div>
            </div>
            <div class="fr w45">
                <div class="item">
                    <img alt="" src="/images/phone.png">
                    <?php echo $user->phone; ?>
                </div>
                <div class="item">
                    <img alt="" src="/images/skype.png">
                    <?php echo $user->skype; ?>
                </div>
                <div class="item">
                    <img alt="" src="/images/telegram.png">
                    <?php echo $user->telegram; ?>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    <div class="clear"></div>
</div>
<h2>Портфолио</h2>
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
