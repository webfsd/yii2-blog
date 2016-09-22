<?php

namespace common\models;

use Yii;
use creocoder\taggable\TaggableBehavior;

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
class Posts extends \yii\db\ActiveRecord
{

    const STATUS_PUBLISH = 2; // 公开
    const STATUS_HIDDEN = 1; // 隐藏

    public $tagNames;

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
            [['author_id', 'views', 'comment_count', 'sort', 'enabled_comment', 'status'], 'integer'],
            [['enabled_comment', 'status'], 'required'],
            [['content'], 'string'],
            [['created_at', 'updated_at', 'tagValues', 'views'], 'safe'],
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
            'views' => Yii::t('app', '浏览数'),
            'comment_count' => Yii::t('app', '评论总数'),
            'sort' => Yii::t('app', '排序'),
            'enabled_comment' => Yii::t('app', '开启评论'),
            'description' => Yii::t('app', '描述'),
            'content' => Yii::t('app', '文章内容'),
            'password' => Yii::t('app', '密码'),
            'status' => Yii::t('app', '状态'),
            'tagNames' => Yii::t('app', '文章标签'),
            'created_at' => Yii::t('app', '发布时间'),
            'updated_at' => Yii::t('app', '更新时间'),
        ];
    }

    public function attributeHints()
    {
        return [
            'title' => '请输入文章标题',
            'slug' => '输入一个唯一标识',
            'description' => "请输入文章的描述,默认截取前150个字符",
            'content' => '请填写文章内容',
            'tagNames' => '请输入标签名,按Tab键确认',
            'status' => '请选择文章状态',
            'enabled_comment' => '是否开启评论',
            'views'=>'文章浏览数',
            'password'=>'如果文章需要加密,请输入文章密码'
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'taggable' => [
                'class' => TaggableBehavior::className(),
                'tagValuesAsArray' => false,
                'tagRelation' => 'tags',
                'tagValueAttribute' => 'name',
                'tagFrequencyAttribute' => 'frequency',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tags::className(), ['id' => 'tag_id'])->viaTable('post_tag', ['post_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }
}
