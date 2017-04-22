<?php

namespace frontend\models;

use backend\models\Goods;
use Yii;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property integer $address
 * @property integer $member_id
 * @property string $name
 * @property string $province_name
 * @property string $city_name
 * @property string $area_name
 * @property string $detail_address
 * @property integer $tel
 * @property string $delivery_id
 * @property string $delivery_name
 * @property string $delivery_price
 * @property string $pay_type_id
 * @property string $pay_type_name
 * @property string $price
 * @property integer $status
 * @property string $trode_no
 * @property string $create_time
 */
class Order extends \yii\db\ActiveRecord
{
    public $address;
    public static $method=[
        1=>['name'=>'顺丰','price'=>'40','intro'=>'很快'],
        2=>['name'=>'管道','price'=>'20','intro'=>'一般'],
        3=>['name'=>'自提','price'=>'10','intro'=>'看你自己的速度']
    ];

    public static $pays=[
        1=>['name'=>'货到付款','intro'=>'送货上门后再收款，支持现金、POS机刷卡、支票支付'],
        2=>['name'=>'在线支付','intro'=>'即时到帐，支持绝大数银行借记卡及部分银行信用卡'],
        3=>['name'=>'上门自提','intro'=>'自提时付款，支持现金、POS刷卡、支票支付'],
        4=>['name'=>'邮局汇款','intro'=>'通过快钱平台收款 汇款后1-3个工作日到账']
    ];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['member_id', 'tel', 'delivery_id', 'pay_type_id','address'], 'integer'],
            [[ 'price'], 'number'],
            [['name', 'province_name', 'city_name', 'area_name', 'detail_address',], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'member_id' => '用户ID',
            'name' => '收货人',
            'province_name' => '省份',
            'city_name' => '城市',
            'area_name' => '地区',
            'detail_address' => '详细地址',
            'tel' => '联系电话',
            'delivery_id' => '配送方式ID',
            'delivery_name' => '配送方式的名字',
            'delivery_price' => '运费',
            'pay_type_id' => '支付方式ID',
            'pay_type_name' => '支付方式',
            'price' => '商品金额',
            'status' => '订单状态',
            'trode_no' => '第三方支付的交易号',
            'create_time' => '添加时间',
        ];
    }

}
