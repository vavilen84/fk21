<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\User;
/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'email:email',
            [
                'label' => 'Имя Фамилия',
                'value' => function ($model) {
                    return $model->first_name . " " . $model->last_name;
                },
            ],
            [
                'label' => 'Роль',
                'value' => function ($model) {
                    return User::$rolesList[$model->role] ?? '';
                },
                'filter' => User::$rolesList,
            ],
            [
                'label' => 'Тип',
                'value' => function ($model) {
                    return User::$typesList[$model->type] ?? '';
                },
                'filter' => User::$typesList,
            ],
            [
                'label' => 'Статус',
                'value' => function ($model) {
                    return User::$statusesList[$model->status] ?? '';
                },
                'filter' => User::$statusesList,
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
            ],
        ],
    ]); ?>


</div>
