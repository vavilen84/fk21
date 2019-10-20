<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Image;
/* @var $this yii\web\View */
/* @var $model app\models\Image */

$this->title = 'Редактировать изображение';
?>
<div class="image-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="image-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'title')->textInput(['maxlength' => true])->label('Название') ?>

        <?= $form->field($model, 'description')->textarea(['rows' => 6])->label('Описание') ?>

        <?= $form->field($model, 'status')->dropDownList(Image::$statusesList)->label('Статус') ?>


        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>


</div>
