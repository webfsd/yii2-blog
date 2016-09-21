<?php

namespace backend\modules\contents\models;

use dosamigos\taggable\Taggable;
use Yii;

/**
 * This is the model class for table "tags".
 *
 * @property integer $id
 * @property string $tag_name
 * @property integer $tag_type
 * @property integer $frequency
 */
class Tag extends \yii\db\ActiveRecord
{
    const TAG_ARTICLE = 1; // 文章类型的标签

    public $tags;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tags';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tagNames'], 'safe'],
            [['tag_name', 'tag_type'], 'required'],
            [['tag_type', 'frequency'], 'integer'],
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
            'frequency' => Yii::t('app', '频率'),
        ];
    }

    public function behaviors()
    {
        return [
            Taggable::className(),
        ];
    }
}
