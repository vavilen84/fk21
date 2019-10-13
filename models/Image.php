<?php

namespace app\models;

use Yii;
use app\models\gii\Image as ImageGii;
use yii\behaviors\TimestampBehavior;

class Image extends ImageGii
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