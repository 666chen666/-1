<?php

use yii\db\Migration;

class m170329_052348_table_article extends Migration
{
    public function up()
    {
        $this->createTable('article', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(50)->notNull()->comment('分类名'),
            'intro'=>$this->text()->comment('简介'),
            'sort'=>$this->integer(10)->comment('排序'),
            'status'=>$this->integer(1)->notNull()->comment('状态'),
            'article_category_id'=>$this->integer(1)->notNull()->comment('是否为帮助信息'),
            'inputtime'=>$this->integer(11)->comment('添加时间')
        ]);
    }

    public function down()
    {
        echo "m170329_052348_table_article cannot be reverted.\n";

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
