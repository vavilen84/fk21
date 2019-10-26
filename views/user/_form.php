<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\User;
/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'role')->dropDownList(User::$rolesList)->label('Роль') ?>

    <?= $form->field($model, 'type')->dropDownList(User::$typesList)->label('Тип') ?>

    <?= $form->field($model, 'status')->dropDownList(User::$statusesList)->label('Статус') ?>

    <?= $form->field($model, 'newPassword')->textInput()->label('Новый пароль') ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
