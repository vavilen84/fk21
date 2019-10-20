<?php

namespace app\helpers;

use app\models\UserGalleryImage;
use app\models\Image;
use app\models\User;

class PathHelper
{
    public static function getPathByImage(Image $image): string
    {
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

    public static function getUserImageGalleryPath(UserGalleryImage $userGalleryImage): string
    {
        $image = Image::findOne(['id' => $userGalleryImage->image_id]);
        if (!$image instanceof Image) {
            return "";
        }
        return self::getPathByImage($image);
    }

    public static function getUserAvatarImagePath(User $user): string
    {
        $image = Image::findOne(['id' => $user->avatar]);
        if (!$image instanceof Image) {
            return "";
        }
        return self::getPathByImage($image);
    }
}