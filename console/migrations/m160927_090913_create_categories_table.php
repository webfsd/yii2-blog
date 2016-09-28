<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Handles the creation for table `categories`.
 */
class m160927_090913_create_categories_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('categories', [
            'id' => Schema::TYPE_PK,
            'name' =>  $this->string(20)->notNull()->comment('分类名'),
            'slug' => $this->string(20)->notNull()->comment('缩略名'),
            'parent' => $this->smallInteger()->notNull()->comment('上级分类'),
            'order' => $this->smallInteger()->notNull()->defaultValue(100)->comment('排序'),
            'description' => $this->string(120)->notNull()->defaultValue('')->comment('描述')
        ]);
        $this->createIndex('categories_unique_key_name', 'categories', 'name',true);
        $this->createIndex('categories_unique_key_slug', 'categories', 'slug',true);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('categories');
    }
}
