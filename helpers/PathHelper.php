<?php

namespace app\helpers;

use app\models\UserGalleryImage;
use app\models\Image;

class PathHelper
{
    public static function getUserImageGalleryPath(UserGalleryImage $userGalleryImage): string
    {
        $image = Image::findOne(['id' => $userGalleryImage->image_id]);
        if (!$image instanceof Image) {
            throwException('Image not found');
        }
        $dt = new \DateTime();
        $dt->setTimestamp($image->created_at);
        $year = $dt->format('Y');
        $month = $dt->format('m');
        $day = $dt->format('d');
        $relPath = sprintf(
            '/uploads/%d/%d/%d',
            $year,
            $month,
            $day
        );
        return $relPath . DIRECTORY_SEPARATOR . $image->uuid . '.' . $image->ext;
    }
}