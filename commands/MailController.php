<?php
namespace app\commands;

use yii\console\Controller;
use Yii;

class MailController extends Controller
{
    public function actionTest()
    {
        $link = "<a href='#'>Link</a>";
        $body = 'Follow the link to change the password: ' . $link;
        $recipient = "vlad.dou.development@gmail.com";
        $subject = "Subject";
        Yii::$app->mailerComponent->send($recipient, $subject, $body);
    }
}
