<?php
namespace app\commands;

use yii\console\Controller;
use app\models\User;
use Yii;

class AdminController extends Controller
{
    public function actionCreateAdmin()
    {
        $user = new User();
        $user->email = getenv('ADMIN_EMAIL');
        $user->salt = Yii::$app->userComponent->getSalt();
        $user->password = Yii::$app->userComponent->encodePassword(getenv('ADMIN_PASSWORD'), $user->salt);
        $user->first_name = 'ADMIN';
        $user->last_name = 'ADMIN';
        $user->status = User::ACTIVE_STATUS;
        $user->role = User::ADMIN_ROLE;
        $user->save();
        echo "Admin created!";
    }
}
