<?php
namespace app\components;

use Yii;
use yii\base\Component;
use app\models\User;
use app\helpers\StringHelper;

class UserComponent extends Component
{
    const SALT_LENGTH = 50;

    public function getSalt(): string
    {
        return StringHelper::getRandomString(self::SALT_LENGTH, true);
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