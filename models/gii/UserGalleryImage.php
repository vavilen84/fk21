<?php

namespace app\models\gii;

use Yii;

/**
 * This is the model class for table "user_gallery_image".
 *
 * @property int $user_id
 * @property int $gallery_id
 * @property int $image_id
 */
class UserGalleryImage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_gallery_image';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'gallery_id', 'image_id'], 'required'],
            [['user_id', 'gallery_id', 'image_id'], 'integer'],
            [['user_id', 'gallery_id', 'image_id'], 'unique', 'targetAttribute' => ['user_id', 'gallery_id', 'image_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'gallery_id' => 'Gallery ID',
            'image_id' => 'Image ID',
        ];
    }
}
