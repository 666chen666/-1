<?php

use yii\db\Migration;

class m170414_033858_table_cart extends Migration
{
    public function up()
    {
        $this->createTable('cart', [
            'id' => $this->primaryKey(),
            'user_id'=>$this->integer()->comment('用户ID'),
            'goods_id'=>$this->integer()->comment('商品ID'),
            'amount'=>$this->integer()->comment('数量'),
        ]);
    }

    public function down()
    {
        echo "m170414_033858_table_cart cannot be reverted.\n";

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
