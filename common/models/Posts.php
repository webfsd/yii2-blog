<?php

namespace common\models;

use Yii;
use creocoder\taggable\TaggableBehavior;
use yii\helpers\ArrayHelper;

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
 * @property mixed tags
 * @property mixed categories
 */
class Posts extends \yii\db\ActiveRecord
{

    const STATUS_PUBLISH = 2; // 公开
    const STATUS_HIDDEN = 1; // 隐藏

    public $image; // 编辑器上传图片

    /**
     * 关联文章的id
     * @var array
     */
    public $category;

    /**
     * 保存前的旧分类
     * @var array
     */
    private $_oldCategory;

    /**
     * 保存前的标签
     * @var array
     */
    private $_oldTags;

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
            [['enabled_comment', 'status', 'slug', 'category'], 'required'],
            [['content'], 'string'],
            [['created_at', 'updated_at', 'views', 'tags'], 'safe'],
            [['slug'], 'string', 'max' => 20],
            [['title'], 'string', 'max' => 60],
            [['title'], 'required'],
            [['description'], 'string', 'max' => 160],
            [['password'], 'string', 'max' => 32],
            ['slug', 'unique', 'targetClass' => Posts::className(), 'message' => '该标识已经被使用'],
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
            'category' => Yii::t('app', '分类'),
            'tags' => Yii::t('app', '标签'),
            'created_at' => Yii::t('app', '发布时间'),
            'updated_at' => Yii::t('app', '更新时间'),
        ];
    }

    /**
     * @return array
     */
    public function attributeHints()
    {
        return [
            'title' => '请输入文章标题',
            'slug' => '输入一个唯一标识',
            'description' => "请输入文章的描述,默认截取前150个字符",
            'content' => '请填写文章内容',
            'status' => '请选择文章状态',
            'enabled_comment' => '是否开启评论',
            'views' => '文章浏览数',
            'category' => '请选择分类',
            'tags' => '请选择文章标签',
            'created_at' => '请选择创建时间',
            'password' => '如果文章需要加密,请输入文章密码'
        ];
    }

    /**
     * 查询后的一些操作
     */
    public function afterFind()
    {
        parent::afterFind();
        $this->category = $this->categories;
        $this->_oldTags = $this->tags; // 获取当前文章tags列表

        $this->_oldCategory = array_keys(ArrayHelper::index(ArrayHelper::toArray($this->categories), function ($element) {
            return $element['id'];
        })); // 获取分类id

    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        parent::beforeSave($insert);

        if (parent::beforeSave($insert)) {
            if ($insert) { // 新增操作
                $this->author_id = Yii::$app->user->id; // 赋值当前用户id
            }
            return true;
        } else {
            return false;
        }

    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if ($insert) { // 新增操作
            Category::addCategory($this->category, $this->primaryKey); // 新增关联分类
        } else { // 编辑操作
            Category::updateCategory($this->_oldCategory, $this->category, $this->primaryKey); // 编辑关联分类
        }

        Tags::updateFrequency($this->_oldTags, $this->tags); // 编辑标签
    }

    /**
     * 删除之后
     */
    public function afterDelete()
    {
        parent::afterDelete();
        Tags::updateFrequency($this->tags, '');
        Category::removeCategory($this->_oldCategory, $this->primaryKey);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['id' => 'category_id'])->viaTable('post_category', ['post_id' => 'id']);
    }


}
