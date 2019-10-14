<?php
use dosamigos\fileupload\FileUpload;
use yii\helpers\Html;
use yii\helpers\Url;
use app\helpers\PathHelper;

?>

<style>
    #file-upload-wrapper {
        height: 200px;
        width: 300%;
        margin-left: -1000px;
        background: #cecece;
        border: 1px solid black;
        position: relative;
    }

    #image-upload-hint {
        position: absolute;
        top: 80px;
        left: 40%;
        font-size: 20px;
    }

    #file-upload-wrapper #imageupload-imagefile {
        left: -1000px;
    }

    #admin-gallery-image-list li {
        list-style: none;
        width: 23%;
        padding: 1%;
        display: inline-block;
        border: 1px solid black;
        border-radius: 5px;
    }

    #admin-gallery-image-list li img {
        max-width: 100%;
    }
</style>
<h1><?php echo $gallery->title; ?></h1>
<br>
<div id="file-upload-wrapper">
    <div id="image-upload-hint">Перетащите изображение для загрузки</div>
    <?= FileUpload::widget(
        [
            'model' => $imageUploadModel,
            'attribute' => 'imageFile',
            'url' => ['user-gallery-image/user-gallery', 'userId' => $user->id, 'galleryId' => $gallery->id], // your url, this is just for demo purposes,
            'options' => ['accept' => 'image/*'],
            'clientOptions' => [
                'maxFileSize' => 2000000
            ],
            // Also, you can specify jQuery-File-Upload events
            // see: https://github.com/blueimp/jQuery-File-Upload/wiki/Options#processing-callback-options
            'clientEvents' => [
                'fileuploaddone' => 'function(e, data) {
                                 window.location.reload();
                            }',
                'fileuploadfail' => 'function(e, data) {
                                console.log(e);
                                console.log(data);
                            }',
            ],
        ]
    ); ?>
</div>
<br>
<br>
<ul id="admin-gallery-image-list">
    <?php foreach ($userGalleryImages as $userGalleryImage): ?>
        <li>
            <?php echo Html::img(PathHelper::getUserImageGalleryPath($userGalleryImage)) ?>
            <br>
            <br>
            <?php echo Html::a(
                'Удалить',
                Url::toRoute(
                    [
                        'user-gallery-image/user-gallery-remove-image',
                        'userId' => $user->id,
                        'galleryId' => $gallery->id,
                        'imageId' => $userGalleryImage->image_id,
                    ]
                ),
                [
                    'class' => 'btn btn-danger',
                    'onclick' => "return confirm('Are you sure you want to delete this item?');"
                ]
            ) ?>
            <?php echo Html::a(
                'Редактировать',
                Url::toRoute(
                    [
                        'image/update',
                        'id' => $userGalleryImage->image_id,
                    ]
                ),
                ['class' => 'btn btn-default']
            ) ?>
        </li>
    <?php endforeach; ?>
</ul>

