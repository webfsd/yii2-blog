<?php

use yii\db\Migration;

class m160907_082701_create_articles extends Migration
{
    const TAGS = 'tags';
    const ARTICLES= 'articles';

    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable(self::TAGS, [
            'id'=>$this->primaryKey(),
            'tag_name' => $this->string(12)->notNull()->comment('标签名'),
            'tag_type' => $this->smallInteger()->notNull()->comment('类型'),
            'data_id' => $this->integer()->unsigned()->comment('数据类型')
        ], $tableOptions);

        $this->createTable(self::ARTICLES, [
            'id' => $this->primaryKey(),
            'title' => $this->string(60)->notNull()->defaultValue('')->comment('文章标题'),
            'author_id' => $this->smallInteger()->unsigned()->comment('文章作者'),
            'views' => $this->integer()->unsigned()->comment('点赞数'),
            'comment_count' => $this->integer()->unsigned()->comment('评论总数'),
            'sort' => $this->smallInteger()->comment('排序'),
            'refer_url' => $this->string(1000)->comment('参考地址'),
            'created_at' => $this->timestamp()->comment('创建时间'),
            'updated_at' => $this->timestamp()->comment('更新时间'),
        ], $tableOptions);
        $this->createIndex('name-articles-unique-key', self::ARTICLES, 'name',true);
    }

    public function safeDown()
    {
        echo "m160907_082701_create_articles cannot be reverted.\n";
        
        $this->dropTable(self::TAGS);
        $this->dropTable(self::ARTICLES);
        
        return false;
    }
}
