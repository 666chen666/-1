<?php

use yii\db\Migration;

class m170401_102826_table_gallery extends Migration
{
    public function up()
    {
        $this->createTable('goods_gallery', [
            'id' => $this->primaryKey(),
            'goods_id'=>$this->bigInteger(20)->notNull()->comment('商品ID'),
            'path'=>$this->text()->comment('商品图片地址')
        ]);
    }

    public function down()
    {
        echo "m170401_102826_table_gallery cannot be reverted.\n";

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
