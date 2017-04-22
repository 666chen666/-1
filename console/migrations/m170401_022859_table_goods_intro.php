<?php

use yii\db\Migration;

class m170401_022859_table_goods_intro extends Migration
{
    public function up()
    {
        $this->createTable('goods_intro', [
            'goods_id'=>$this->bigInteger(20)->notNull()->comment('商品ID'),
            'content'=>$this->text()->comment('商品描述'),
        ]);
    }

    public function down()
    {
        echo "m170401_022859_table_goods_intro cannot be reverted.\n";

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
