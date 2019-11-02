<?php

namespace app\models;

use Yii;
use yii\base\Model;

class ResetPasswordForm extends Model
{
    public $password;

    public function rules()
    {
        return [
            [['password'], 'required'],
        ];
    }
}
