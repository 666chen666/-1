<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/27 0027
 * Time: 涓婂崍 10:05
 */

namespace backend\models;


use frontend\models\Member;
use yii\base\Model;

class LoginForm extends Model
{
    public $username;
    public $password;
    public $remember;

    public function rules(){
        return [
            [['username','password'],'required'],
            ['remember','boolean']
        ];
    }
    public function attributeLabels()
    {
        return [
            'username'=>'用户名:',
            'password'=>'密码:',
            'remember'=>'记住我'
        ];
    }

    public function login()
    {
        if($this->validate()){
            $member = Member::findOne(['username'=>$this->username]);
            if($member){
                if(\Yii::$app->security->validatePassword($this->password,$member->password)){
                   \Yii::$app->user->login($member,$this->remember?3600*24*7:0);

                    return true;
                }else{
                    $this->addError('password','密码不对');
                }
            }else{
                $this->addError('username','用户名不存在');
            }
        }
        return false;
    }

}