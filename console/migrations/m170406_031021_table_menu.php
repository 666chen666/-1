<?php

use yii\db\Migration;

class m170406_031021_table_menu extends Migration
{
    public function up()
    {
        $this->createTable('menu', [
            'id' => $this->primaryKey(),
            'name'=>$this->string()->notNull()->comment('菜单名'),
            'parent_id'=>$this->integer()->notNull()->defaultValue(0)->comment('上级菜单'),
            'url'=>$this->string()->notNull()->comment('权限（路由）'),
            'intro'=>$this->string()->comment('描述'),
        ]);


    }

    public function down()
    {
        echo "m170406_031021_table_menu cannot be reverted.\n";

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
