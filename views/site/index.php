<?php
use yii\grid\GridView;
use yii\helpers\StringHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use app\helpers\PathHelper;
/* @var $this yii\web\View */

$this->title = 'Home | Fotokolo';
?>
<?php
foreach ($models as $model) {
    echo "<h2>" . $model->title . "</h2>";

    if (!empty($model->image_id)) {
        echo "<br>";
        echo "<img src=" . PathHelper::getPathByImageId($model->image_id) . " alt=''>";
    }

    echo "<br>";
    echo $model->description;
    echo "<br>";
    echo "<br>";
    echo Html::a('Читать далее', Url::toRoute(['site/post', 'id' => $model->id]), ['class' => 'btn btn-default']);
    echo '<hr>';
    echo "<br>";
}

echo \yii\widgets\LinkPager::widget(
    [
        'pagination' => $pages,
    ]
);
