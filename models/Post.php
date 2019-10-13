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
        self::PUBLISHED_STATUS => 'Published',
        self::DRAFT_STATUS => 'Draft',
        self::DELETED_STATUS => 'Deleted'
    ];

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
}