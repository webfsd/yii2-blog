<?php

namespace backend\modules\contents\models;

use Yii;

/**
 * This is the model class for table "articles".
 *
 * @property integer $id
 * @property string $title
 * @property integer $author_id
 * @property integer $views
 * @property integer $comment_count
 * @property integer $sort
 * @property string $refer_url
 * @property string $created_at
 * @property string $updated_at
 */
class Article extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'articles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['author_id', 'views', 'comment_count', 'sort'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 60],
            [['refer_url'], 'string', 'max' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', '文章标题'),
            'author_id' => Yii::t('app', '文章作者'),
            'views' => Yii::t('app', '点赞数'),
            'comment_count' => Yii::t('app', '评论总数'),
            'sort' => Yii::t('app', '排序'),
            'refer_url' => Yii::t('app', '参考地址'),
            'created_at' => Yii::t('app', '创建时间'),
            'updated_at' => Yii::t('app', '更新时间'),
        ];
    }
}
