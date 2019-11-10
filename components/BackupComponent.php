<?php
namespace app\components;

use Yii;
use yii\base\Component;
use app\models\User;
use app\helpers\StringHelper;
use GuzzleHttp\Client;

class BackupComponent extends Component
{
    private $tempDir = "/tmp/fotokolo-backup-files/";

    public function __construct()
    {
        $this->removeTempDir();
        $this->createTempDir();
    }

    protected function removeTempDir()
    {
        if (is_dir($this->tempDir)) {
            system('sudo rm -Rf /tmp/fotokolo-backup-files/');
        }
    }

    protected function createTempDir()
    {
        @mkdir($this->tempDir, 0777, true);
        system('sudo chown -R www-data:www-data ' . $this->tempDir);
        system('sudo chmod 777 -R ' . $this->tempDir);
    }

    public function getFilename()
    {
        return date('d-m-Y_G:i');
    }

    public function createDbDump()
    {
        $filename = $this->getFilename() . '.sql';
        $command = sprintf(
            'mysqldump -h localhost -u %s -p%s %s > %s',
            getenv('DB_USER'),
            getenv('DB_PASSWORD'),
            getenv('DB_NAME'),
            $this->tempDir . $filename
        );
        exec($command);
        $this->uploadToDropbox($this->tempDir . $filename, $filename, '/db-backup');
    }

    public function backupRedactorImages()
    {
        $backupFolder = getenv('PROJECT_PATH') . "/web/uploads-redactor";
        if (file_exists($backupFolder)) {
            $userIds = scandir($backupFolder);
            if (!empty($userIds) && (count($userIds) > 3)) {
                $userIds = array_slice($userIds, 3); // remove ., .. , .gitignore from dir list
                foreach ($userIds as $userId) {
                    $imageFolder = $backupFolder . DIRECTORY_SEPARATOR . $userId;
                    $images = scandir($imageFolder);
                    if (!empty($images) && (count($images) > 2)) {
                        $images = array_slice($images, 2);
                        foreach ($images as $image) {
                            $this->uploadToDropbox($imageFolder . DIRECTORY_SEPARATOR . $image, $image, "/uploads-redactor", true);
                        }
                    }
                }
            }
        }
    }

    public function backupImages()
    {
        $backupFolder = getenv('PROJECT_PATH') . "/web/uploads";
        if (file_exists($backupFolder)) {
            $years = scandir($backupFolder);
            if (!empty($years) && (count($years) > 3)) {
                $years = array_slice($years, 3); // remove ., .. , .gitignore from dir list
                foreach ($years as $year) {
                    $months = scandir($backupFolder . DIRECTORY_SEPARATOR . $year);
                    if (!empty($months) && (count($months) > 2)) {
                        $months = array_slice($months, 2);
                        foreach ($months as $month) {
                            $days = scandir($backupFolder . DIRECTORY_SEPARATOR . $year . DIRECTORY_SEPARATOR . $month);
                            if (!empty($days) && (count($days) > 2)) {
                                $days = array_slice($days, 2);
                                foreach ($days as $day) {
                                    $imageFolder = $backupFolder . DIRECTORY_SEPARATOR . $year . DIRECTORY_SEPARATOR . $month . DIRECTORY_SEPARATOR . $day;
                                    $images = scandir($imageFolder);
                                    if (!empty($images) && (count($images) > 2)) {
                                        $images = array_slice($images, 2);
                                        foreach ($images as $image) {
                                            $this->uploadToDropbox($imageFolder . DIRECTORY_SEPARATOR . $image, $image, "/uploads");
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public function uploadToDropbox($filepath, $filename, $path, $skipDateFolder = false)
    {
        $date = new \DateTime();
        $path .= $skipDateFolder
            ? '/' . $filename
            : '/' . $date->format('Y') . '/' . $date->format('n') . '/' . $date->format('j') . '/' . $filename;
        $api_url = 'https://content.dropboxapi.com/2/files/upload';
        $headers = array('Authorization: Bearer ' . getenv('DROPBOX_ACCESS_TOKEN'),
            'Content-Type: application/octet-stream',
            'Dropbox-API-Arg: ' .
            json_encode(
                [
                    "path" => $path,
                    "mode" => "add",
                    "autorename" => true,
                    "mute" => false
                ]
            )
        );
        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        $fp = fopen($filepath, 'rw');
        $filesize = filesize($filepath);
        curl_setopt($ch, CURLOPT_POSTFIELDS, fread($fp, $filesize));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($ch, CURLOPT_VERBOSE, 1); // debug
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        echo($response . '<br/>');
        echo($http_code . '<br/>');
        curl_close($ch);
    }
}