<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\User;
use yii\helpers\StringHelper;
use app\models\Post;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Post', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'id',
                'headerOptions' => ['style' => 'width:1%'],
            ],
            [
                'label' => 'Title',
                'attribute' => 'title',
                'headerOptions' => ['style' => 'width:16%'],
                'value' => function ($model) {
                    return StringHelper::truncate($model->title, 30);
                }
            ],
            [
                'label' => 'Author',
                'value' => function ($model) {
                    $user = User::findOne(['id' => $model->user_id]);
                    return $user->first_name . " " . $user->last_name;
                }
            ],
            [
                'label' => 'Status',
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
