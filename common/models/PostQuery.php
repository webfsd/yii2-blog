<?php
/**
 * Created by PhpStorm.
 * User: luo
 * Date: 16/9/22
 * Time: 09:58
 */

namespace common\models;


use creocoder\taggable\TaggableQueryBehavior;
use yii\db\ActiveRecord;

class PostQuery extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TaggableQueryBehavior::className(),
        ];
    }
}