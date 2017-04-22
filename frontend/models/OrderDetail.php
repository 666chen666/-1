<?php

namespace frontend\models;

use backend\models\Goods;
use Yii;

/**
 * This is the model class for table "order_detail".
 *
 * @property integer $id
 * @property string $order_info_id
 * @property integer $goods_id
 * @property string $goods_name
 * @property string $logo
 * @property string $price
 * @property string $amount
 * @property string $total_price
 */
class OrderDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_info_id', 'goods_id', 'goods_name'], 'required'],
            [['goods_id', 'amount'], 'integer'],
            [['price', 'total_price'], 'number'],
            [['order_info_id', 'goods_name', 'logo'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_info_id' => '订单ID',
            'goods_id' => '商品ID',
            'goods_name' => '商品的名称',
            'logo' => 'LOGO',
            'price' => '价格',
            'amount' => '数量',
            'total_price' => '小计',
        ];
    }

}
