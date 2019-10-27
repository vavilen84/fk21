<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Competition;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Конкурсы';
?>
<div class="competition-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать Конкурс', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            [
                'label' => 'Название',
                'value' => function ($model) {
                    return $model->title;
                },
            ],
            [
                'label' => 'Статус',
                'value' => function ($model) {
                    return Competition::$statusesList[$model->status];
                },
            ],
            [
                'label' => 'Дедлайн',
                'attribute' => 'deadline_at',
                'format' => ['date', 'php:d-M-Y']
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
            ],
        ],
    ]); ?>


</div>
