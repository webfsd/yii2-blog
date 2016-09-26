<?php
namespace backend\controllers;

use Yii;
use yii\helpers\FileHelper;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\UploadedFile;

class UploadController extends Controller
{
    public static $uploadImageDir = 'uploads/images';
    public static $uploadFileDir = 'uploads/files';
    public static $uploadRoot = '@frontend/web/';
    public static $frontDomain = 'http://www.blog.com';

    /**
     * @var
     */
    public $driver;
    /**
     * @var array
     */
    public $config = [];

    /**
     * init action.
     */
    public function init()
    {
        $this->driver = Yii::$app->request->get('driver', 'local');
        Yii::$app->request->enableCsrfValidation = true;
        parent::init();
    }

    /**
     * upload Image file
     * @return string
     */
    public function actionImage()
    {
        if (Yii::$app->request->isPost) { // 文件上传
            $imageFile = UploadedFile::getInstanceByName('image');
            $directory = Yii::getAlias(self::$uploadRoot) . self::$uploadImageDir . DIRECTORY_SEPARATOR . Yii::$app->session->id . DIRECTORY_SEPARATOR;
            if (!is_dir($directory)) {
                mkdir($directory,0777,true);
            }
            if ($imageFile) {
                $uid = uniqid(time(), true);
                $fileName = $uid . '.' . $imageFile->extension;
                $filePath = $directory . $fileName;
                if ($imageFile->saveAs($filePath)) {
                    $path = self::$frontDomain . '/' . self::$uploadImageDir . DIRECTORY_SEPARATOR . Yii::$app->session->id . DIRECTORY_SEPARATOR . $fileName;
                    return Json::encode([
                        'files' => [[
                            'name' => $imageFile->name,
                            'size' => $imageFile->size,
                            "url" => $path,
                            "thumbnailUrl" => $path,
                            "deleteUrl" => '/upload/image-delete?imageName=' . $fileName,
                            "deleteType" => "POST"
                        ]]
                    ]);
                }
            }
            return '';

        }
        return $this->renderAjax('image');
    }

    /**
     * delete file
     * @param $imageName
     * @return string
     */
    public function actionImageDelete($imageName)
    {
        $directory = Yii::getAlias(self::$uploadRoot) . self::$uploadImageDir. DIRECTORY_SEPARATOR . Yii::$app->session->id;
        if (is_file($directory . DIRECTORY_SEPARATOR . $imageName)) {
            unlink($directory . DIRECTORY_SEPARATOR . $imageName);
        }
        $files = FileHelper::findFiles($directory);
        $output = [];
        foreach ($files as $file){
            $path = self::$frontDomain . '/' . self::$uploadImageDir . Yii::$app->session->id . DIRECTORY_SEPARATOR . basename($file);
            $output['files'][] = [
                'name' => basename($file),
                'size' => filesize($file),
                "url" => $path,
                "thumbnailUrl" => $path,
                "deleteUrl" => 'image-delete?imageName=' . basename($file),
                "deleteType" => "POST"
            ];
        }
        return Json::encode($output);
    }

    /**
     * upload File.
     * @return string
     */
    public function actionFile()
    {
        if (Yii::$app->request->isPost) { // 文件上传
            $imageFile = UploadedFile::getInstanceByName('file');
            $directory = Yii::getAlias(self::$uploadRoot) . self::$uploadFileDir . DIRECTORY_SEPARATOR . Yii::$app->session->id . DIRECTORY_SEPARATOR;
            if (!is_dir($directory)) {
                mkdir($directory,0777,true);
            }
            if ($imageFile) {
                $uid = uniqid(time(), true);
                $fileName = $uid . '.' . $imageFile->extension;
                $filePath = $directory . $fileName;
                if ($imageFile->saveAs($filePath)) {
                    $path = self::$frontDomain . '/' . self::$uploadFileDir . DIRECTORY_SEPARATOR . Yii::$app->session->id . DIRECTORY_SEPARATOR . $fileName;
                    return Json::encode([
                        'files' => [[
                            'name' => $imageFile->name,
                            'size' => $imageFile->size,
                            "url" => $path,
                            "thumbnailUrl" => $path,
                            "deleteUrl" => '/upload/file-delete?fileName=' . $fileName,
                            "deleteType" => "POST"
                        ]]
                    ]);
                }
            }
            return '';

        }
        return $this->renderAjax('file');
    }

    /**
     * delete file.
     * @param $fileName
     * @return string
     */
    public function actionFileDelete($fileName)
    {
        $directory = Yii::getAlias(self::$uploadRoot) . self::$uploadFileDir. DIRECTORY_SEPARATOR . Yii::$app->session->id;
        if (is_file($directory . DIRECTORY_SEPARATOR . $fileName)) {
            unlink($directory . DIRECTORY_SEPARATOR . $fileName);
        }
        $files = FileHelper::findFiles($directory);
        $output = [];
        foreach ($files as $file){
            $path = self::$frontDomain . '/' . self::$uploadFileDir . Yii::$app->session->id . DIRECTORY_SEPARATOR . basename($file);
            $output['files'][] = [
                'name' => basename($file),
                'size' => filesize($file),
                "url" => $path,
                "thumbnailUrl" => $path,
                "deleteUrl" => 'file-delete?fileName=' . basename($file),
                "deleteType" => "POST"
            ];
        }
        return Json::encode($output);
    }

}


