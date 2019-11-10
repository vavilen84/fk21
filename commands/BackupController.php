<?php
namespace app\commands;

use yii\console\Controller;
use app\models\User;
use Yii;

class BackupController extends Controller
{
    public function actionBackup()
    {
        Yii::$app->backup->createDbDump();
        Yii::$app->backup->backupImages();
        Yii::$app->backup->backupRedactorImages();
    }
}
