<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UserGalleryImage */

$this->title = 'Update User Gallery Image: ' . $model->user_id;
$this->params['breadcrumbs'][] = ['label' => 'User Gallery Images', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->user_id, 'url' => ['view', 'user_id' => $model->user_id, 'gallery_id' => $model->gallery_id, 'image_id' => $model->image_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-gallery-image-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
