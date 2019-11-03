<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\User;
use yii\helpers\StringHelper;
use app\models\Post;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Post::$typesList[$type];
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить', ['create', 'type' => $type], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'id',
                'headerOptions' => ['style' => 'width:1%'],
            ],
            [
                'label' => 'Название',
                'attribute' => 'title',
                'headerOptions' => ['style' => 'width:16%'],
                'value' => function ($model) {
                    return StringHelper::truncate($model->title, 30);
                }
            ],
            [
                'label' => 'Автор',
                'value' => function ($model) {
                    $user = User::findOne(['id' => $model->user_id]);
                    return $user->first_name . " " . $user->last_name;
                }
            ],
            [
                'label' => 'Статус',
                'value' => function ($model) {
                    return Post::$statusesList[$model->status];
                },
               'filter' => Post::$statusesList,
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
            ],
        ],
    ]); ?>


</div>
