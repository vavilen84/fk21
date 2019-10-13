<?php

namespace app\models;

use Yii;
use app\models\gii\Post as PostGii;
use yii\behaviors\TimestampBehavior;

class Post extends PostGii
{
    const ACTIVE_STATUS = 1;
    const DELETED_STATUS = 2;

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
}