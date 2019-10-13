<?php
namespace app\components;

use Yii;
use yii\base\Component;
use app\models\User;

class UserComponent extends Component
{
    public function getSalt(): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_+~`.?/';
        $characters = str_split($characters);
        $randstring = '';
        for ($i = 0; $i < 50; $i++) {
            $randstring .= $characters[rand(0, count($characters) - 1)];
        }
        return $randstring;
    }

    public function encodePassword(string $password, string $salt): string
    {
        return md5($password . $salt);
    }

    public function userHasRole(array $userRoles): bool
    {
        $user = Yii::$app->user->getIdentity();
        if ($user instanceof User) {
            if (in_array($user->role, $userRoles)) {
                return true;
            }
        }
        return false;
    }
}