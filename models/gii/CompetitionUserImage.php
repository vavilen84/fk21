<?php

namespace app\models\gii;

use Yii;

/**
 * This is the model class for table "competition_user_image".
 *
 * @property int $competition_id
 * @property int $user_id
 * @property int $image_id
 */
class CompetitionUserImage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'competition_user_image';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['competition_id', 'user_id'], 'required'],
            [['competition_id', 'user_id', 'image_id'], 'integer'],
            [['competition_id', 'user_id'], 'unique', 'targetAttribute' => ['competition_id', 'user_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'competition_id' => 'Competition ID',
            'user_id' => 'User ID',
            'image_id' => 'Image ID',
        ];
    }
}
