<?php

namespace app\models\gii;

use Yii;

/**
 * This is the model class for table "competition".
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property string $description
 * @property int $status
 * @property int $deadline_at
 * @property int $created_at
 * @property int $updated_at
 */
class Competition extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'competition';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'content', 'description'], 'string'],
            [['status', 'deadline_at', 'created_at', 'updated_at'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'content' => 'Content',
            'description' => 'Description',
            'status' => 'Status',
            'deadline_at' => 'Deadline At',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
