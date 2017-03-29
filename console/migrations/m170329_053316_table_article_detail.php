<?php

use yii\db\Migration;

class m170329_053316_table_article_detail extends Migration
{
    public function up()
    {
        $this->createTable('article_detail', [
            'article_id'=>$this->string(50)->notNull()->comment('文章ID'),
            'content'=>$this->text()->comment('内容'),
        ]);
    }

    public function down()
    {
        echo "m170329_053316_table_article_detail cannot be reverted.\n";

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
