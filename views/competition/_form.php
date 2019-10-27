<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Competition;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Competition */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    .datepicker{
        z-index: 9999999 !important;
    }
</style>
<div class="competition-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->errorSummary($model); ?>

    <?= $form->field($model, 'title')->textInput(['rows' => 6])->label('Название') ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6])->label('Краткое описание') ?>

    <?= $form->field($model, 'content')->widget(\yii\redactor\widgets\Redactor::className())->label('Детали конкурса') ?>

    <?= $form->field($model, 'status')->dropDownList(Competition::$statusesList)->label('Статус') ?>

    <?php
    $time = !empty($model->deadline_at) ? $model->deadline_at : strtotime('+14 days');
    echo '<label>Дедлайн</label>';
    echo DatePicker::widget(
        [
            'name' => 'Competition[deadline_at]',
            'value' =>  date('d-M-Y', $time),
            'options' => ['placeholder' => 'Select issue date ...'],
            'pluginOptions' => [
                'format' => 'dd-M-yyyy',
                'todayHighlight' => true
            ]
        ]
    );

    ?>
    <br>
    <br>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
