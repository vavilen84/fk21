<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\Gallery;
use app\helpers\PathHelper;
use app\models\User;

$this->title = $competition->title;
$this->params['breadcrumbs'][] = ['label' => 'Мой профиль', 'url' => ['/user-gallery-image/profile']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php if (!empty($existingImage)): ?>
        <img src="<?php echo PathHelper::getPathByImage($existingImage); ?>" alt="">
    <?php endif; ?>
    <?= $form->field($model, 'imageFile')->fileInput()->label('Фото') ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
