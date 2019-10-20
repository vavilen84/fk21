<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\helpers\PathHelper;

?>
<style>
    #user-list li {
        list-style: none;
        width: 23%;
        padding: 1%;
        margin: 3px 0;
        display: inline-block;
        text-align: center;
    }

    #user-list li a {
        color: black;
        font-weight: bold;
    }

    #user-list li img {
        max-width: 100%;
    }
</style>

<ul id="user-list">
    <?php foreach ($users as $user): ?>
        <li>
            <a href="<?php echo Url::toRoute(['user-gallery-image/user-portfolio', 'userId' => $user->id]) ?>">
                <?php echo Html::img(PathHelper::getUserAvatarImagePath($user)); ?>
                <br>
                <span><?php echo $user->first_name . " " . $user->last_name; ?></span>
            </a>
        </li>
    <?php endforeach; ?>
</ul>
