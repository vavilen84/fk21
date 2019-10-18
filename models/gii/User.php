<?php

namespace app\models\gii;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $email
 * @property string $first_name
 * @property string $last_name
 * @property string $password
 * @property string $password_reset_token
 * @property string $salt
 * @property int $role
 * @property int $type
 * @property string $about
 * @property int $avatar
 * @property string $pinterest_link
 * @property string $instagram_link
 * @property string $facebook_link
 * @property string $phone
 * @property string $skype
 * @property string $telegram
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['password', 'salt', 'about'], 'string'],
            [['role', 'type', 'avatar', 'status', 'created_at', 'updated_at'], 'integer'],
            [['email', 'first_name', 'last_name', 'password_reset_token', 'pinterest_link', 'instagram_link', 'facebook_link', 'phone', 'skype', 'telegram'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'password' => 'Password',
            'password_reset_token' => 'Password Reset Token',
            'salt' => 'Salt',
            'role' => 'Role',
            'type' => 'Type',
            'about' => 'About',
            'avatar' => 'Avatar',
            'pinterest_link' => 'Pinterest Link',
            'instagram_link' => 'Instagram Link',
            'facebook_link' => 'Facebook Link',
            'phone' => 'Phone',
            'skype' => 'Skype',
            'telegram' => 'Telegram',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
