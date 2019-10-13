<?php

namespace app\models\gii;

use Yii;

/**
 * This is the model class for table "image".
 *
 * @property int $id
 * @property string $uuid
 * @property string $ext
 * @property string $original_filename
 * @property string $title
 * @property string $description
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 */
class Image extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'image';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['uuid', 'ext', 'original_filename', 'title'], 'string', 'max' => 255],
            [['uuid'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uuid' => 'Uuid',
            'ext' => 'Ext',
            'original_filename' => 'Original Filename',
            'title' => 'Title',
            'description' => 'Description',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
