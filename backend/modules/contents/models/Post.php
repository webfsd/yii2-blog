<?php

namespace backend\modules\contents\models;

use dosamigos\taggable\Taggable;
use Yii;

/**
 * This is the model class for table "{{%posts}}".
 *
 * @property integer $id
 * @property string $slug
 * @property string $title
 * @property integer $author_id
 * @property integer $views
 * @property integer $comment_count
 * @property integer $sort
 * @property integer $enabled_comment
 * @property string $description
 * @property string $content
 * @property string $password
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 */
class Post extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 0; // 已删除
    const STATUS_HIDDEN = 1; // 未发布
    const STATUS_PUBLISH = 2; // 已发布


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%posts}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['author_id', 'views', 'comment_count', 'sort', 'enabled_comment', 'status'], 'integer'],
            [['enabled_comment', 'status'], 'required'],
            [['content'], 'string'],
            [['created_at', 'updated_at', 'tagNames'], 'safe'],
            [['slug'], 'string', 'max' => 20],
            [['title'], 'string', 'max' => 60],
            [['description'], 'string', 'max' => 160],
            [['password'], 'string', 'max' => 32],
            [['slug'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'slug' => Yii::t('app', '缩略名'),
            'title' => Yii::t('app', '文章标题'),
            'author_id' => Yii::t('app', '文章作者'),
            'views' => Yii::t('app', '点赞数'),
            'comment_count' => Yii::t('app', '评论总数'),
            'sort' => Yii::t('app', '排序'),
            'enabled_comment' => Yii::t('app', '开启评论'),
            'description' => Yii::t('app', '描述'),
            'content' => Yii::t('app', '文章内容'),
            'password' => Yii::t('app', '密码'),
            'status' => Yii::t('app', '状态'),
            'tagNames'=>Yii::t('app','标签'),
            'created_at' => Yii::t('app', '创建时间'),
            'updated_at' => Yii::t('app', '更新时间'),
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            // Taggable::className(),
            [
                'class' => Taggable::className()
            ],
        ];
    }


    /**
     * @return $this
     */
    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])->viaTable('posts_tags', ['post_id' => 'id']);
    }
}
