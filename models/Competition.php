<?php

namespace app\models;

use Yii;
use app\models\gii\Competition as CompetitionGii;
use yii\behaviors\TimestampBehavior;

class Competition extends CompetitionGii
{
    const RESULTS_NOT_PUBLISHED_STATUS = 1;
    const RESULTS_PUBLISHED_STATUS = 2;

    public static $statusesList = [
        self::RESULTS_NOT_PUBLISHED_STATUS => 'Результаты не опубликованы',
        self::RESULTS_PUBLISHED_STATUS => 'Результаты опубликованы',
    ];
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
}