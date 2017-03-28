<?php

use yii\db\Migration;

class m170328_050253_table_brand extends Migration
{
    public function up()
    {
        $this->createTable('brand', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(50)->notNull()->comment('Æ·ÅÆÃû'),
            'intro'=>$this->text()->comment('¼ò½é'),
            'logo'=>$this->string(100)->comment('LOGO'),
            'status'=>$this->integer(1)->notNull()->comment('×´Ì¬'),
        ]);
    }

    public function down()
    {
        echo "m170328_050253_table_brand cannot be reverted.\n";

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
