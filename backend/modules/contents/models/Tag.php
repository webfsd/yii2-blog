<?php

namespace backend\modules\contents\models;

use Yii;

/**
 * This is the model class for table "{{%tags}}".
 *
 * @property integer $id
 * @property string $tag_name
 * @property integer $tag_type
 * @property integer $data_id
 */
class Tag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tags}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'tag_name', 'tag_type'], 'required'],
            [['id', 'tag_type', 'data_id'], 'integer'],
            [['tag_name'], 'string', 'max' => 12],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'tag_name' => Yii::t('app', '标签名'),
            'tag_type' => Yii::t('app', '类型'),
            'data_id' => Yii::t('app', '数据类型'),
        ];
    }
}
