<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\helpers\PathHelper;

?>
<style>

</style>

<ul id="user-list">
    <?php foreach ($users as $user): ?>
        <li>
            <a href="<?php echo Url::toRoute(['user/view', 'userId' => $user->id]) ?>">
                <?php echo Html::img(PathHelper::getUserAvatarPath($user)); ?>
                <br>
                <span><?php echo $user->first_name . " " . $user->last_name; ?></span>
            </a>
        </li>
    <?php endforeach; ?>
</ul>
