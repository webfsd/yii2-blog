<?php

namespace common\models;

use mdm\admin\components\Helper;
use Yii;

/**
 * This is the model class for table "{{%categories}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property integer $parent
 * @property integer $order
 * @property string $description
 */
class Category extends \yii\db\ActiveRecord
{
    public static $category_list;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%categories}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'slug','parent'], 'required'],
            [['parent', 'order'], 'integer'],
            ['name', 'string', 'max' => 255],
            ['name', 'unique', 'targetClass' => Category::className(), 'message' => '分类名已存在.'],
            ['slug', 'string', 'max' => 20],
            ['slug', 'unique', 'targetClass' => Category::className(), 'message' => '分类名已存在.'],
            ['description', 'string', 'max' => 120],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', '分类名'),
            'slug' => Yii::t('app', '缩略名'),
            'parent' => Yii::t('app', '上级分类'),
            'order' => Yii::t('app', '排序'),
            'description' => Yii::t('app', '描述'),
        ];
    }

    /**
     * 获取所有分类树
     * @return mixed
     */
    public function getCategories()
    {
        $categories = self::find()->select('name,parent,id')->indexBy('id')->all();

        foreach ($categories as $value) {
            if ($value->id != $value->parent && $value->parent == 0) {
                self::$category_list[$value->id] = $value->name;
                self::dropDownTree($categories, $value->id);
            }
        }
        return self::$category_list;
    }

    /**
     * 当前分类下的子元素列表
     * array[
     *  1 => ['disabled' => true],
     *  4 => ['disabled' => true],
     * ];
     */
    public static function getDisabledIds($id)
    {
        $categories = self::find()->all();

        $ids = array_merge(self::getChildrensIds($categories, $id), [(int)$id]);
        $resault = [];
        foreach ($ids as $id) {
            $resault[$id] = ['disabled' => true];
        }
        return $resault;
    }

    /**
     * 获取当前分类下的所有分类个数
     * @param $id
     * @return int
     */
    public static function getSubCategoriesCount($id)
    {
        $categories = self::find()->all();

        return count( self::getChildrensIds($categories, $id));
    }

    /**
     * 通过分类id查找名称
     */
    public static function getCategoryNameByParentId($id)
    {
        return self::find()->select('name')->where(['parent'=>$id])->one();
    }
    
    /**
     * @param $array array
     * @param $parent integer
     * @param int $laravel
     */
    protected function dropDownTree($array, $parent, $laravel = 0)
    {
        foreach ($array as $item) {
            if ($item->id != $item->parent && $item->parent == $parent) {
                self::$category_list[$item->id] = str_repeat("ㄴ", $laravel + 1) . $item->name;
                self::dropDownTree($array, $item->id, $laravel + 1);
            }
        }
    }

    /**
     * 无限极分类组合一维数组 获取所有子级id（典型利用场景:查找pid为0栏目下的商品 合并数组用in在数据中查找数据）
     * @param $array array 数组形式的cates
     * @param $parent integer 待查找的父级id
     * @return array 所有子级分类id
     */
    protected static function getChildrensIds($array, $parent)
    {
        $arr = [];
        foreach ($array as $v) {
            if ($v['parent'] == $parent) {
                $arr[] = $v['id'];
                $arr = array_merge($arr, self::getChildrensIds($array, $v['id']));
            }
        }
        return $arr;
    }
}
