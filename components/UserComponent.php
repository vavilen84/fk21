<?php
namespace app\components;

use yii\base\Component;

class UserComponent extends Component
{
    public function getSalt(): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_+~`.?/';
        $characters = str_split($characters);
        $randstring = '';
        for ($i = 0; $i < 50; $i++) {
            $randstring .= $characters[rand(0, count($characters)-1)];
        }
        return $randstring;
    }

    public function encodePassword(string $password, string $salt): string
    {
        return md5($password . $salt);
    }
}