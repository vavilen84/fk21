<?php

use yii\helpers\Html;
use app\models\Post;
/* @var $this yii\web\View */
/* @var $model app\models\Post */

$this->title = 'Редактировать';
$this->params['breadcrumbs'][] = ['label' => Post::$typesList[$model->type], 'url' => [$backUrl]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
