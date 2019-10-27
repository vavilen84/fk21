<?php

namespace app\models;

use Yii;
use app\models\gii\User as UserGii;
use yii\behaviors\TimestampBehavior;

class User extends UserGii implements \yii\web\IdentityInterface
{
    const DEFAULT_IDENTITY_COOKIE_DURATION = 3600 * 24 * 30;

    const ACTIVE_STATUS = 1;
    const DELETED_STATUS = 2;
    const NEW_STATUS = 3;

    CONST ADMIN_ROLE = 1;
    const USER_ROLE = 2;
    const MODERATOR_ROLE = 3;

    const STUDENT_TYPE = 1;
    const GRADUATE_TYPE = 2;
    const ADMIN_TYPE = 3;

    public static $rolesList = [
        self::ADMIN_ROLE => 'Админ',
        self::USER_ROLE => 'Пользователь',
        self::MODERATOR_ROLE => 'Модератор'
    ];

    public static $statusesList = [
        self::ACTIVE_STATUS => 'Активный',
        self::DELETED_STATUS => 'Удален',
        self::NEW_STATUS => 'Новый'
    ];

    public static $typesList = [
        self::STUDENT_TYPE => 'Учащийся',
        self::GRADUATE_TYPE => 'Выпускник'
    ];

    public static $typesTitleList = [
        self::STUDENT_TYPE => 'Ученики',
        self::GRADUATE_TYPE => 'Выпускники'
    ];

    public $avatarImage;
    public $newPassword;

    public function rules()
    {
        $rules = parent::rules();
        $rules[] = [['avatarImage'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'];
        $rules[] = [['email'], 'unique'];
        $rules[] = [['first_name', 'last_name', 'password', 'salt', 'status', 'role'], 'required'];
        $rules[] = [['newPassword'], 'string'];

        return $rules;
    }

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
        return;
    }

    public function validateAuthKey($authKey)
    {
        return true;
    }

    public function validatePassword($password)
    {
        return $this->password === Yii::$app->userComponent->encodePassword($password, $this->salt);
    }
}
