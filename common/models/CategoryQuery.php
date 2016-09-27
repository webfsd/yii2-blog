<?php
/**
 * Created by PhpStorm.
 * User: luo
 * Date: 16/9/27
 * Time: 17:11
 */

namespace common\models;


use yii\db\ActiveRecord;

class CategoryQuery extends ActiveRecord
{
    public function behaviors() {
        return [
            NestedSetsQueryBehavior::className(),
        ];
    }
}