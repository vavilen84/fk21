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
        $source = $this->tempDir . $filename;
        $date = new \DateTime();
        $destination = '/db-backup/' . $date->format('Y') . '/' . $date->format('n') . '/' . $date->format('j') . '/' . $filename;
        $this->uploadToDropbox($source, $destination);
    }

    public function backupRedactorImages()
    {
        $backupFolder = getenv('PROJECT_PATH') . "/web/uploads-redactor";
        if (file_exists($backupFolder)) {
            $userIds = $this->filterFileDirList($backupFolder);
            if (!empty($userIds)) {
                foreach ($userIds as $userId) {
                    $imageFolder = $backupFolder . DIRECTORY_SEPARATOR . $userId;
                    $images = $this->filterFileDirList($imageFolder);
                    if (empty($images)) {
                        continue;
                    }
                    foreach ($images as $imageFilename) {
                        $source = $imageFolder . DIRECTORY_SEPARATOR . $imageFilename;
                        $destination = "/uploads-redactor/" . $userId . "/" . $imageFilename;
                        $this->uploadToDropbox($source, $destination);
                    }
                }
            }
        }
    }

    protected function filterFileDirList($dir)
    {
        if (!is_dir($dir)) {
            return [];
        }
        $list = scandir($dir);
        if (empty($list)) {
            return [];
        }
        $result = [];
        $exclude = [".", "..", ".gitignore"];
        foreach ($list as $v) {
            if (!in_array($v, $exclude)) {
                $result[] = $v;
            }
        }
        return $result;
    }

    public function backupImages()
    {
        $backupFolder = getenv('PROJECT_PATH') . "/web/uploads";
        if (file_exists($backupFolder)) {
            $years = $this->filterFileDirList($backupFolder);
            if (!empty($years)) {
                foreach ($years as $year) {
                    $yearDir = $backupFolder . DIRECTORY_SEPARATOR . $year;
                    $months = $this->filterFileDirList($yearDir);
                    if (empty($months)) {
                        continue;
                    }
                    foreach ($months as $month) {
                        $monthDir = $yearDir . DIRECTORY_SEPARATOR . $month;
                        $days = $this->filterFileDirList($monthDir);
                        if (empty($days)) {
                            continue;
                        }
                        foreach ($days as $day) {
                            $imageFolder = $monthDir . DIRECTORY_SEPARATOR . $day;
                            $images = $this->filterFileDirList($imageFolder);
                            if (empty($images)) {
                                continue;
                            }
                            foreach ($images as $imageFilename) {
                                $source = $imageFolder . DIRECTORY_SEPARATOR . $imageFilename;
                                $destination = "/uploads/" . $year . "/" . $month . "/" . $day . "/" . $imageFilename;
                                $this->uploadToDropbox($source, $destination);
                            }
                        }
                    }
                }
            }
        }
    }

    public function uploadToDropbox($source, $destination)
    {
        $api_url = 'https://content.dropboxapi.com/2/files/upload';
        $headers = array('Authorization: Bearer ' . getenv('DROPBOX_ACCESS_TOKEN'),
            'Content-Type: application/octet-stream',
            'Dropbox-API-Arg: ' .
            json_encode(
                [
                    "path" => $destination,
                    "mode" => "add",
                    "autorename" => true,
                    "mute" => false
                ]
            )
        );
        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        $fp = fopen($source, 'rw');
        $filesize = filesize($source);
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