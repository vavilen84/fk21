<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\Gallery;
use app\helpers\PathHelper;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $gallery app\models\Gallery */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php foreach (Gallery::getList() as $gallery): ?>
        <?php echo Html::a(
            $gallery->title,
            Url::toRoute(['user-gallery-image/user-gallery', 'userId' => $model->id, 'galleryId' => $gallery->id]),
            ['class' => 'btn btn-primary']
        ) ?>
    <?php endforeach; ?>
    <br>
    <br>
    <?php foreach ($activeCompetitions as $competition): ?>
        <?php echo Html::a(
            'Учавствовать в конкурсе: ' . $competition->title,
            Url::toRoute(['user-gallery-image/competition-participate', 'userId' => $model->id, 'competitionId' => $competition->id]),
            ['class' => 'btn btn-success']
        ) ?>
        <br>
        <br>
    <?php endforeach; ?>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true])->label('Имя') ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true])->label('Фамилия') ?>

    <?= $form->field($model, 'about')->textarea(['rows' => 6])->label('Обо мне') ?>

    <?php if (!empty($model->avatar)): ?>
        <img src="<?php echo PathHelper::getUserAvatarImagePath($model); ?>" alt="">
    <?php endif; ?>
    <?= $form->field($model, 'avatarImage')->fileInput()->label('Аватар') ?>

    <?= $form->field($model, 'pinterest_link')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'instagram_link')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'facebook_link')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true])->label('Телефон') ?>

    <?= $form->field($model, 'skype')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'telegram')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'newPassword')->textInput()->label('Новый пароль') ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
