<?php

use yii\db\Migration;

class m170401_021530_table_goods_day_count extends Migration
{
    public function up()
    {
        $this->createTable('goods_day_count', [
            'id' => $this->date(),
            'count'=>$this->integer(10)->unsigned()->comment('商品数'),
        ]);

    }

    public function down()
    {
        echo "m170401_021530_table_goods_day_count cannot be reverted.\n";

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
