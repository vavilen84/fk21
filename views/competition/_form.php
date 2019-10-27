<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Competition */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="competition-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['rows' => 6])->label('Название') ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6])->label('Краткое описание') ?>

    <?= $form->field($model, 'content')->widget(\yii\redactor\widgets\Redactor::className())->label('Детали конкурса') ?>

    <?= $form->field($model, 'status')->textInput()->label('Статус') ?>

    <?= $form->field($model, 'deadline_at')->textInput()->label('Дедлайн') ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
