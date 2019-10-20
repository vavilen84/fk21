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

    public function backupImages()
    {
        $dt = new \DateTime();
        $dt->setTimestamp(time() - (60 * 60 * 24));
        $year = $dt->format('Y');
        $month = $dt->format('m');
        $day = $dt->format('d');
        $backupFolder = getenv('PROJECT_PATH') . "/web/uploads/" . $year . "/" . $month . "/" . $day;
        if (file_exists($backupFolder)) {
            $images = scandir($backupFolder);
            if (!empty($images) && (count($images) > 2)) {
                $images = array_slice($images, 2);
                foreach ($images as $image) {
                    $this->uploadToDropbox($backupFolder . "/" . $image, $image, "/images");
                }
            }
        }
    }

    public function uploadToDropbox($filepath, $filename, $path)
    {
        $date = new \DateTime();
        $date->add(\DateInterval::createFromDateString('yesterday'));
        $path .= '/' . $date->format('Y') . '/' . $date->format('n') . '/' . $date->format('j') . '/' . $filename;
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