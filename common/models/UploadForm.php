<?php
/**
 * Created by PhpStorm.
 * User: luo
 * Date: 16/9/27
 * Time: 10:19
 */

namespace curder\markdown\models;


use Yii;
use yii\base\Model;
use yii\base\Exception;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

class Image extends Model
{

    const  UPLOAD_IMG_DIR = 'markdown-image-uploads';
    /**
     * @var UploadedFile Uploaded image
     */
    public $image;

    /**
     * @var string Web accessible path to the uploaded image
     */
    public $url;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['image', 'image', 'extensions' => ['png', 'jpg', 'gif'], 'maxWidth' => 1000, 'maxHeight' => 1000, 'maxSize' => 2 * 1024 * 1024,'on'=>'upload-image']
        ];
    }

    /**
     * Validates and saves the image.
     * Creates the folder to store images if necessary.
     * @return boolean
     */
    public function uploadImage()
    {
        $this->scenario = 'upload-image';
        try {
            if ($this->validate()) {
                $save_path = FileHelper::normalizePath(Yii::getAlias('@frontend/web/' . self::UPLOAD_IMG_DIR));
                FileHelper::createDirectory($save_path);
                $this->url = Yii::getAlias('@web/' . self::UPLOAD_IMG_DIR . '/' . $this->image->baseName . '.' . $this->image->extension);
                return $this->image->saveAs(FileHelper::normalizePath($save_path . '/' . $this->image->baseName . '.' . $this->image->extension));
            }
        } catch (Exception $e) {
            Yii::error($e->getMessage());
        }
        return false;
    }

    public function uploadFile()
    {
        
    }
    
}