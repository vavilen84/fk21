<?php

namespace app\models;

use Yii;
use app\models\gii\User as UserGii;
use yii\behaviors\TimestampBehavior;

class User extends UserGii implements \yii\web\IdentityInterface
{
    const ACTIVE_STATUS = 1;
    const DELETED_STATUS = 2;

    CONST ADMIN_ROLE = 1;
    const USER_ROLE = 2;
    const MODERATOR_ROLE = 3;

    public static $statusesList = [
        self::ACTIVE_STATUS => 'Active',
        self::DELETED_STATUS => 'Deleted',
    ];

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public static function findByEmail($email)
    {
        return self::findOne(['email' => $email]);
    }

    public static function findIdentity($id)
    {
        return self::findOne(['id' => $id]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->access_token;
    }

    public function validateAuthKey($authKey)
    {
        return $this->access_token === $authKey;
    }

    public function validatePassword($password)
    {
        return $this->password === Yii::$app->userComponent->encodePassword($password, $this->salt);
    }
}
