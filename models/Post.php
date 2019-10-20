<?php

namespace app\models;

use Yii;
use app\models\gii\Post as PostGii;
use yii\behaviors\TimestampBehavior;

class Post extends PostGii
{
    const PUBLISHED_STATUS = 1;
    const DRAFT_STATUS = 2;
    const DELETED_STATUS = 3;

    public static $statusesList = [
        self::PUBLISHED_STATUS => 'Опубликовано',
        self::DRAFT_STATUS => 'Черновик',
        self::DELETED_STATUS => 'Удалено'
    ];

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
}