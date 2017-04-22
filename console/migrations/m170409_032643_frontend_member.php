<?php

use yii\db\Migration;

class m170409_032643_frontend_member extends Migration
{
    public function up()
    {
        $this->createTable('member', [
            'id' => $this->primaryKey(),
            'username'=>$this->string()->unique()->notNull()->comment('用户名'),
            'password'=>$this->string()->notNull()->comment('密码'),
            'email'=>$this->string()->unique()->notNull()->comment('邮箱'),
            'tel'=>$this->string(11)->notNull()->comment('电话'),
            'auth_key'=>$this->string()->notNull(),
            'status'=>$this->integer(4)->notNull()->defaultValue(0)->comment('状态:-1删除,0禁用，1正常'),
            'addtime'=>$this->integer()->defaultValue(0)->comment('注册时间'),
            'last_login_time'=>$this->integer()->defaultValue(0)->comment('最后登录时间'),
            'last_login_ip'=>$this->integer()->defaultValue(null)->comment('最后登录IP'),
        ]);

    }

    public function down()
    {
        echo "m170409_032643_frontend_member cannot be reverted.\n";

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
