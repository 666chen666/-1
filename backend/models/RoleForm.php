<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/5 0005
 * Time: 下午 12:02
 */

namespace backend\models;


use yii\base\Model;
use yii\helpers\ArrayHelper;

class RoleForm extends Model
{
    public $name;
    public $description;
    public $permissions=[];
    const SCENARIO_ADD = 'add';

    public function scenarios(){
        $scenarios = parent::scenarios();
        return ArrayHelper::merge($scenarios,[self::SCENARIO_ADD=>['name','description','permission']]);
    }

    public function rules(){
       return [
           [['name','description'],'required'],
           ['name','validateName','on'=>self::SCENARIO_ADD],
           ['permissions','safe']
       ];
    }
    public function attributeLabels(){
        return [
            'name'=>'角色名',
            'description'=>'描述',
            'permission'=>'权限',
        ];
    }
    public function validateName($attribute){
        $authManager= \Yii::$app->authManager;
        if($authManager->getRole($this->$attribute)){
            $this->addError($attribute,'角色已存在');
        }
    }

    public static function getPermissionOptions()
    {
        $permissions = \Yii::$app->authManager->getPermissions();

        return ArrayHelper::map($permissions,'name','description');
    }

}