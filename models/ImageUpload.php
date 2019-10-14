<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;
use app\helpers\StringHelper;
use app\models\Image;

class ImageUpload extends Model
{
    const UUID_LENGTH = 30;
    /**
     * @var UploadedFile
     */
    public $imageFile;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg'],
        ];
    }

    public function upload():?Image
    {
        if ($this->validate()) {
            $dt = new \DateTime();
            $year = $dt->format('Y');
            $month = $dt->format('m');
            $day = $dt->format('d');
            $uuid = StringHelper::getRandomString(self::UUID_LENGTH);
            $relPath = sprintf(
                '/web/uploads/%d/%d/%d',
                $year,
                $month,
                $day
            );
            $absPath = getenv('PROJECT_PATH') . $relPath;
            @mkdir($absPath, 0777, true);
            $this->imageFile->saveAs($absPath . DIRECTORY_SEPARATOR . $uuid . '.' . $this->imageFile->extension);

            $image = new Image();
            $image->uuid = $uuid;
            $image->ext = $this->imageFile->extension;
            $image->original_filename = $this->imageFile->name;
            $image->status = Image::ACTIVE_STATUS;
            $image->save();
            return $image;
        }
        return null;
    }
}