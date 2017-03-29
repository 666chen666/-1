<?php

use yii\db\Migration;

class m170329_033322_article_category extends Migration
{
    public function up()
    {
        $this->createTable('article_category', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(50)->notNull()->comment('分类名'),
            'intro'=>$this->text()->comment('简介'),
            'sort'=>$this->integer(10)->comment('排序'),
            'status'=>$this->integer(1)->notNull()->comment('状态'),
            'is_help'=>$this->integer(1)->notNull()->comment('是否为帮助信息')
        ]);
    }

    public function down()
    {
        echo "m170329_033322_article_category cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
