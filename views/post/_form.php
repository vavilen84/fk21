<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Post;

/* @var $this yii\web\View */
/* @var $model app\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textarea(['rows' => 6])->label('Название') ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6])->label('Описание') ?>

    <?= $form->field($model, 'content')->widget(\yii\redactor\widgets\Redactor::className())->label('Новость') ?>

    <?= $form->field($model, 'status')->dropDownList(Post::$statusesList)->label('Статус') ?>


    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
