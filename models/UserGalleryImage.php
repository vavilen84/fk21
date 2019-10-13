<?php

namespace app\models;

use Yii;
use app\models\gii\UserGalleryImage as UserGalleryImageGii;
use yii\behaviors\TimestampBehavior;

class UserGalleryImage extends UserGalleryImageGii
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