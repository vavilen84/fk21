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

<script>
    $(document).ready(function () {
        // set same height for news blocks and show
        var images = $("#lightgallery .gallery-image");
        fixElementHeight(images, 30);
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
        <a class="gallery-image" href="#">
            <?php $imageSize = getimagesize(getenv("PROJECT_PATH") . "/web" . PathHelper::getPathByImage($image)); ?>
            <img
                    data-id="<?php echo $image->id; ?>"
                    data-width="<?php echo $imageSize[0]; ?>"
                    data-height="<?php echo $imageSize[1]; ?>"
                    src="<?php echo PathHelper::getPathByImage($image); ?>">
            <div style="display:none;" class="competition-image-info">
                <div style="color:black;">
                    <?php echo $image->title; ?>
                </div>
                <div style="color:black;">
                    <?php echo $image->description; ?>
                </div>
            </div>
        </a>
    <?php endforeach; ?>
</div>
