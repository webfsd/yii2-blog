<?php

use yii\db\cubrid\Schema;
use yii\db\Migration;

/**
 * Handles the creation for table `post_category`.
 */
class m160929_014621_create_post_category_table extends Migration
{
    const TABLE_NAME = 'post_category';
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable(self::TABLE_NAME, [
            'post_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'category_id' => Schema::TYPE_INTEGER . ' NOT NULL',
        ]);

        $this->createIndex(self::TABLE_NAME . '_post_id_and_category_id', self::TABLE_NAME, ['post_id', 'category_id']);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable(self::TABLE_NAME);
    }
}
