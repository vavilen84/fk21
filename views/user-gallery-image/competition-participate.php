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



    <?php if (!empty($existingImage)): ?>
        <img src="<?php echo PathHelper::getPathByImage($existingImage); ?>" alt="">

        <br>
        <?php echo $existingImage->title; ?>
        <br>
        <?php echo $existingImage->description; ?>
        <br>
        <?php echo Html::a(
            'Удалить',
            Url::toRoute(
                [
                    'user-gallery-image/competition-participate-remove-image',
                    'userId' => $user->id,
                    'competitionId' => $competition->id,
                    'imageId' => $existingImage->id
                ]
            ),
            [
                'class' => 'btn btn-danger',
                'onclick' => "return confirm('Are you sure you want to delete this item?');"
            ]
        ) ?>
        <?php echo Html::a(
            'Редактировать',
            Url::toRoute(
                [
                    'user-gallery-image/update-competition-image',
                    'userId' => $user->id,
                    'competitionId' => $competition->id,
                    'imageId' => $existingImage->id
                ]
            ),
            ['class' => 'btn btn-default']
        ) ?>
    <?php else: ?>
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'imageFile')->fileInput()->label('Фото') ?>

        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    <?php endif; ?>
</div>
