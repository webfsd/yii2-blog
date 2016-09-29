<?php
namespace backend\controllers;

use curder\markdown\models\Upload;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\UploadedFile;

class UploadController extends Controller
{
    public $domain;

    public function init()
    {
        parent::init();
        $this->domain = Yii::$app->params['image.domain'];
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
            $model->image = UploadedFile::getInstanceByName('image');
            if($model->validate()){
                if($model->upload('image')){
                    return Json::encode([
                        'files' => [[
                            'name' => $model->name,
                            'size' => $model->size,
                            "url" => $this->domain . $model->url,
                            "thumbnailUrl" => $this->domain . $model->url,
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
        $this->actionDelete($imageName,'image');
    }

    /**
     * upload File.
     * @return string
     */
    public function actionFile()
    {
        if (Yii::$app->request->isPost) { // 文件上传
            $model = new Upload;
            $model->scenario = Upload::SCENARIO_UPLOAD_FILE;
            $model->file = UploadedFile::getInstanceByName('file');

            if($model->validate()){
                if($model->upload('file')){
                    return Json::encode([
                        'files' => [[
                            'name' => $model->name,
                            'size' => $model->size,
                            "url" => $this->domain . $model->url,
                            "thumbnailUrl" => $this->domain . $model->url,
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
        $this->actionDelete($fileName,'file');
    }

    protected function actionDelete($fileName,$type = 'image')
    {
        $model = new Upload();
        if($model->delete($fileName,$type)){
            $output =[];
            return Json::encode($output);
        }

    }
}


