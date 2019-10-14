<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\User;
/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'email:email',
            'first_name',
            'last_name',
            [
                'label' => 'Role',
                'value' => function ($model) {
                    return User::$rolesList[$model->role] ?? '';
                },
                'filter' => User::$rolesList,
            ],
            [
                'label' => 'Type',
                'value' => function ($model) {
                    return User::$typesList[$model->type] ?? '';
                },
                'filter' => User::$typesList,
            ],
            [
                'label' => 'Status',
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
