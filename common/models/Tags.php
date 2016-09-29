<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tags".
 *
 * @property integer $id
 * @property string $name
 * @property integer $frequency
 */
class Tags extends \yii\db\ActiveRecord
{
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
            [['name'], 'required'],
            [['frequency'], 'integer'],
            [['name'], 'string', 'max' => 12],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', '标签名'),
            'frequency' => Yii::t('app', '频率'),
        ];
    }

    public static function findAllByName($name)
    {
        return self::find()->where(['like', 'name', $name])->all();
    }


    /**
     * 新增tags
     * @param $tags array
     */
    private static function addTags($tags)
    {
        if (empty($tags)) return;
        foreach ($tags as $name) {
            // 判断标签是否存在
            $aTag = Tags::find()->where(['name' => $name])->one();

            $aTagCount = Tags::find()->where(['name' => $name])->count();
            if ($aTagCount == 0) { // 不存在新增
                $tag = new Tags;
                $tag->name = $name;
                $tag->frequency = 1;
                $tag->save();
            } else { // 存在 +1
                $aTag->frequency += 1;
                $aTag->save();
            }
        }
    }

    /**
     * 删除tags
     * @param $tags array
     */
    private static function removeTags($tags)
    {
        if (empty($tags)) return;
        foreach ($tags as $name) {
            $aTag = Tags::find()->where(['name' => $name])->one();

            $aTagCount = Tags::find()->where(['name' => $name])->count();

            if ($aTagCount) {
                if ($aTagCount && $aTag->frequency <= 1) {
                    $aTag->delete();
                } else {
                    $aTag->frequency -= 1;
                    $aTag->save();
                }
            }
        }
    }


    /**
     * 将字符串转成数组
     * @param $tags string
     * @return array
     */
    private static function str2arr($tags)
    {
        return preg_split('/\s*,\s*/', trim($tags), -1, PREG_SPLIT_NO_EMPTY);
    }

    /**
     * 更新深度
     * @param $oldTags
     * @param $newTags
     */
    public static function updateFrequency($oldTags, $newTags)
    {
        if (!empty($oldTags) || !empty($newTags)) {
            $oldTagsArray = self::str2arr($oldTags);
            $newTagsArray = self::str2arr($newTags);

            self::addTags(array_values(array_diff($newTagsArray, $oldTagsArray)));
            self::removeTags(array_values(array_diff($oldTagsArray, $newTagsArray)));
        }

    }
}
