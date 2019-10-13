<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\Gallery;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $gallery app\models\Gallery */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php foreach (Gallery::getList() as $gallery): ?>
        <?php echo Html::a(
            $gallery->title,
            Url::toRoute('user-gallery-image/user-gallery', ['userId' => $model->id, 'galleryId' => $gallery->id]),
            ['class' => 'btn btn-primary']
        ) ?>
    <?php endforeach; ?>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'about')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'avatar')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'pinterest_link')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'instagram_link')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'facebook_link')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'skype')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'telegram')->textInput(['maxlength' => true]) ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
