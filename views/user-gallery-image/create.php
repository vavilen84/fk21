<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UserGalleryImage */

$this->title = 'Create User Gallery Image';
$this->params['breadcrumbs'][] = ['label' => 'User Gallery Images', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-gallery-image-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
