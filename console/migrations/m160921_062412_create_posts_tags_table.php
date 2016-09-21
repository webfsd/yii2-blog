<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Handles the creation for table `posts_tags`.
 */
class m160921_062412_create_posts_tags_table extends Migration
{
    const TABLE_NAME = '{{%posts_tags}}';
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable(self::TABLE_NAME, [
            'post_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'tag_id' => Schema::TYPE_INTEGER . ' NOT NULL',
        ]);

        $this->addPrimaryKey('', self::TABLE_NAME, ['post_id', 'tag_id']);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%posts_tags}}');
    }
}
