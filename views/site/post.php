<?php
$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Главная', 'url' => ['/']];
?>
<h1><?php echo $model->title; ?></h1>
<div><?php echo $model->description; ?></div>
<div><?php echo $model->content; ?></div>