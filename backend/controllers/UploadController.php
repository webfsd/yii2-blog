<?php
namespace backend\controllers;

use curder\markdown\models\Upload;
use Yii;
use yii\helpers\FileHelper;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\UploadedFile;

class UploadController extends Controller
{
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
        $this->driver = Yii::$app->request->get('driver', 'qiniu');
        parent::init();
    }

    /**
     * upload Image file
     * @return string
     */
    public function actionImage()
    {
        if (Yii::$app->request->isPost) { // 文件上传
            $model = new Upload;
            $model->scenario = Upload::SCENARIO_UPLOAD_IMAGE;
            $model->driver = $this->driver;
            $model->image = UploadedFile::getInstanceByName('image');
            if($model->validate()){
                if($model->upload('image')){
                    return Json::encode([
                        'files' => [[
                            'name' => $model->name,
                            'size' => $model->size,
                            "url" => $model->url,
                            "thumbnailUrl" => $model->url,
                            "deleteUrl" => '/upload/image-delete?imageName=' . $model->fileName,
                            "deleteType" => "POST"
                        ]]
                    ]);
                }
            }else{
                $errors = [];
                $modelErrors = $model->getErrors();
                foreach ($modelErrors as $field => $fieldErrors) {
                    foreach ($fieldErrors as $fieldError) {
                        $errors[] = $fieldError;
                    }
                }
                if (empty($errors)) {
                    $errors = ['Unknown image upload validation error!'];
                }
                return Json::encode(['errors' => $errors]);
            }
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
        $model = new Upload();
        $model->driver = $this->driver;
        if($model->delete($imageName)){
            $output =[];
            return Json::encode($output);
        }

    }

    /**
     * upload File.
     * @return string
     */
    public function actionFile()
    {
        if (Yii::$app->request->isPost) { // 文件上传
            $model = new Upload;
            $model->driver = $this->driver;
            $model->scenario = Upload::SCENARIO_UPLOAD_FILE;
            $model->file = UploadedFile::getInstanceByName('file');

            if($model->validate()){
                if($model->upload('file')){
                    return Json::encode([
                        'files' => [[
                            'name' => $model->name,
                            'size' => $model->size,
                            "url" => $model->url,
                            "thumbnailUrl" => $model->url,
                            "deleteUrl" => '/upload/file-delete?fileName=' . $model->fileName,
                            "deleteType" => "POST"
                        ]]
                    ]);
                }
            }else{
                $errors = [];
                $modelErrors = $model->getErrors();
                foreach ($modelErrors as $field => $fieldErrors) {
                    foreach ($fieldErrors as $fieldError) {
                        $errors[] = $fieldError;
                    }
                }
                if (empty($errors)) {
                    $errors = ['Unknown file upload validation error!'];
                }
                return Json::encode(['errors' => $errors]);
            }
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
        $model = new Upload();
        $model->driver = $this->driver;
        if($model->delete($fileName,'file')){
            $output =[];
            return Json::encode($output);
        }
    }

}


