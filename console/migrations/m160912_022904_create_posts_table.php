<?php

use yii\db\Migration;

/**
 * Handles the creation for table `post`.
 */
class m160912_022904_create_posts_table extends Migration
{
    const ARTICLES = 'posts';

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable(self::ARTICLES, [
            'id' => $this->primaryKey(),
            'slug' => $this->string(20)->notNull()->defaultValue('')->comment('缩略名'),
            'title' => $this->string(60)->notNull()->defaultValue('')->comment('文章标题'),
            'author_id' => $this->smallInteger()->unsigned()->comment('文章作者'),
            'views' => $this->integer()->unsigned()->comment('点赞数'),
            'comment_count' => $this->integer()->unsigned()->comment('评论总数'),
            'sort' => $this->smallInteger()->comment('排序'),
            'enabled_comment' =>$this->smallInteger()->unsigned()->notNull()->comment('开启评论'),
            'description'=>$this->string(160)->comment('描述'),
            'content'=>$this->text()->comment('文章内容'),
            'password'=>$this->char(32)->notNull()->defaultValue('')->comment('密码'),
            'status'=>$this->smallInteger()->unsigned()->notNull()->comment('状态'),
            'created_at' => $this->timestamp()->comment('创建时间'),
            'updated_at' => $this->timestamp()->comment('更新时间'),
        ], $tableOptions);
        $this->createIndex('name-articles-unique-slug', self::ARTICLES, 'slug', true);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable(self::ARTICLES);
    }
}
