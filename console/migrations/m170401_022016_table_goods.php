<?php

use yii\db\Migration;

class m170401_022016_table_goods extends Migration
{
    public function up()
    {
        $this->createTable('goods', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(50)->notNull()->comment('名称'),
            'sn'=>$this->integer(20)->comment('货号'),
            'logo'=>$this->string(150)->comment('LOGO'),
            'goods_category_id'=>$this->integer(3)->comment('LOGO'),
            'brand_id'=>$this->string(5)->comment('LOGO'),
            'market_price'=>$this->decimal(10,2)->unsigned()->comment('市场价格'),
            'shop_price'=>$this->decimal(10,2)->notNull()->comment('本店价格'),
            'is_on_sale'=>$this->integer(4)->notNull()->comment('是否上架'),
            'status'=>$this->integer(4)->notNull()->comment('状态'),
            'sort'=>$this->integer(4)->notNull()->comment('排序'),
            'inputtime'=>$this->integer(11)->notNull()->comment('录入时间'),
        ]);

    }

    public function down()
    {
        echo "m170401_022016_table_goods cannot be reverted.\n";

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
