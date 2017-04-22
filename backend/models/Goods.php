<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "goods".
 *
 * @property integer $id
 * @property string $name
 * @property integer $sn
 * @property string $logo
 * @property integer $goods_category_id
 * @property string $brand_id
 * @property string $market_price
 * @property string $shop_price
 * @property integer $is_on_sale
 * @property integer $status
 * @property integer $sort
 * @property integer $inputtime
 */
class Goods extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $img_file;
    public $depth;
    public static function tableName()
    {
        return 'goods';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'shop_price', 'is_on_sale', 'status', 'sort'], 'required'],
            [['goods_category_id', 'market_price','is_on_sale', 'status', 'sort'], 'double'],
            [['name'], 'string', 'max' => 50],
            [['img_file'],'file','extensions'=>['jpg','png','gif'] ],
            [['brand_id'], 'string', 'max' => 5],
            ['sn','string'],
            ['depth','compare','compareValue'=>2,'operator'=>'>=']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'sn' => '货号',
            'img_file' => 'LOGO',
            'goods_category_id' => '',
            'brand_id' => '品牌',
            'market_price' => '市场价格',
            'shop_price' => '本店价格',
            'is_on_sale' => '是否上架',
            'status' => '状态',
            'sort' => '排序',
            'inputtime' => '录入时间',
            'depth'=>'商品层级'
        ];
    }

    public function getCate(){
        return $this->hasOne(GoodsCategory::className(),['id'=>'goods_category_id']);
    }
    public function getBrand(){
        return $this->hasOne(Brand::className(),['id'=>'brand_id']);
    }
}
