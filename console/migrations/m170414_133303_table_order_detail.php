<?php

use yii\db\Migration;

class m170414_133303_table_order_detail extends Migration
{
    public function up()
    {
        $this->createTable('order_detail', [
        'id' => $this->primaryKey(),
        'order_info_id'=>$this->string()->notNull()->comment('订单ID'),
        'goods_id'=>$this->integer()->notNull()->comment('商品ID'),
        'goods_name'=>$this->string()->notNull()->comment('商品的名称'),
        'logo'=>$this->string()->comment('LOGO'),
        'price'=>$this->decimal()->comment('价格'),
        'amount'=>$this->integer()->unsigned()->comment('数量'),
        'total_price'=>$this->decimal()->comment('小计'),
    ]);
    }

    public function down()
    {
        echo "m170414_133303_table_order_detail cannot be reverted.\n";

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
