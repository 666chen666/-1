<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "menu".
 *
 * @property integer $id
 * @property string $name
 * @property integer $parent_id
 * @property string $url
 * @property string $intro
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['parent_id'], 'integer'],
            [['name', 'url', 'intro'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '菜单名',
            'parent_id' => '上级菜单',
            'url' => '权限（路由）',
            'intro' => '描述',
        ];
    }
    /*
 * [
      'label' => '商品管理',
      'items' => [
          ['label' => '商品列表', 'url' => ['goods/index']],
          ['label' => '添加商品', 'url' => ['goods/add']],
      ],
  ],
 */
    public static function getMenu(){
        $models = Menu::find()->where(['parent_id'=>0])->all();
        $menuItems=[];
        foreach($models as $model){
            //var_dump($model);
            $sons = Menu::find()->where(['parent_id'=>$model->id])->all();
            $items=[];

            foreach($sons as $son){
                if(Yii::$app->user->can($son->url)){
                    $items[]=
                        ['label' => $son->name, 'url' =>[$son->url]];
                }

            }
            if(!empty($items)){
                $menuItems[]=[
                    'label' => $model->name,
                    'items' =>$items,
                ];
            }

        }
        //var_dump($menuItems);exit;
        return $menuItems;
    }

    public function getSon(){

    }
}
