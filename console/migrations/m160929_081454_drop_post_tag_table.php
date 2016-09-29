<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Handles the dropping for table `post_tag`.
 */
class m160929_081454_drop_post_tag_table extends Migration
{
    const TABLE_NAME = 'post_tag';
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->dropTable('post_tag');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->createTable(self::TABLE_NAME, [
            'post_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'tag_id' => Schema::TYPE_INTEGER . ' NOT NULL',
        ]);

        $this->addPrimaryKey('', self::TABLE_NAME, ['post_id', 'tag_id']);
    }
}
