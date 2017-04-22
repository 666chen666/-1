<?php

use yii\db\Migration;

class m170410_015147_table_address extends Migration
{
    public function up()
    {
        $this->createTable('address', [
            'id' => $this->primaryKey(),
            'menber_id'=>$this->string()->notNull()->comment('会员ID'),
            'name'=>$this->string()->notNull()->comment('收货人'),
            'province'=>$this->string()->notNull()->comment('省'),
            'city'=>$this->string()->notNull()->comment('城市'),
            'area'=>$this->string()->notNull()->comment('地区'),
            'site'=>$this->string()->notNull()->comment('详细地址'),
            'tel'=>$this->string(11)->notNull()->comment('手机号'),
            'flag'=>$this->string()->defaultValue('0')->comment('是否为默认地址'),
        ]);
    }

    public function down()
    {
        echo "m170410_015147_table_address cannot be reverted.\n";

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
