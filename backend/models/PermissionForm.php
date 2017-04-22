<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/5 0005
 * Time: 下午 12:02
 */

namespace backend\models;


use yii\base\Model;

class PermissionForm extends Model
{
    public $name;
    public $description;

    public function rules(){
       return [
           [['name','description'],'required'],
           ['name','validateName']
       ];
    }
    public function attributeLabels(){
        return [
            'name'=>'权限名',
            'description'=>'描述'
        ];
    }
    public function validateName($attribute){
        $authManager= \Yii::$app->authManager;
        if($authManager->getPermission($this->$attribute)){
            $this->addError($attribute,'权限已存在');
        }
    }

}