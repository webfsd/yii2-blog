<?php

use yii\db\Migration;

class m160929_075847_add_tags_field_to_posts extends Migration
{
    const TABLE_NAME = 'posts';
    public function up()
    {
        $this->addColumn(self::TABLE_NAME, 'tags', 'text');
    }

    public function down()
    {
        echo "m160929_075847_add_tags_field_to_posts cannot be reverted.\n";
        $this->dropColumn(self::TABLE_NAME, 'tags');

        return true;
    }

}
