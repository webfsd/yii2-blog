<?php
/**
 * Created by PhpStorm.
 * User: luo
 * Date: 16/9/26
 * Time: 13:24
 */

namespace common\models;

use yii\base\Model;

class UploadForm extends Model
{
    public $image;

    public function rules()
    {
        return [
            [['image'], 'file', 'skipOnEmpty' => yes, 'extensions' => 'png, jpg', 'maxFiles' => 4],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            foreach ($this->image as $file) {
                $file->saveAs('uploads/' . $file->baseName . '.' . $file->extension);
            }
            return true;
        } else {
            return false;
        }
    }

}