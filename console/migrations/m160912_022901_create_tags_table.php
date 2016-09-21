<?php

use yii\db\Migration;

/**
 * Handles the creation for table `tags`.
 */
class m160912_022901_create_tags_table extends Migration
{
    const TAGS = 'tags';
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable(self::TAGS, [
            'id'=>$this->primaryKey(),
            'name' => $this->string(12)->notNull()->comment('标签名'),
            'frequency' => $this->integer()->unsigned()->defaultValue(0)->comment('频率')
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable(self::TAGS);
    }
}
