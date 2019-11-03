<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Post;
use app\helpers\PathHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textarea(['rows' => 6])->label('Название') ?>

    <?php if (!empty($model->image_id)): ?>
        <img src="<?php echo PathHelper::getPathByImageId($model->image_id); ?>" alt="">
    <?php endif; ?>
    <?= $form->field($model, 'image')->fileInput()->label('Изображение') ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6])->label('Описание') ?>

    <?= $form->field($model, 'content')->widget(\yii\redactor\widgets\Redactor::className())->label('Содержание') ?>

    <?= $form->field($model, 'status')->dropDownList(Post::$statusesList)->label('Статус') ?>

    <?= $form->field($model, 'type')->dropDownList(Post::$typesList)->label('Тип') ?>


    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
