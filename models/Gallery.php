<?php

namespace app\models;

use Yii;
use app\models\gii\Gallery as GalleryGii;
use yii\behaviors\TimestampBehavior;

class Gallery extends GalleryGii
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