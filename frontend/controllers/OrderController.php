<?php

namespace frontend\controllers;
use frontend\models\Address;
use frontend\models\Cart;
use frontend\models\Order;
use frontend\models\OrderDetail;
use yii\db\Exception;
use yii\filters\AccessControl;

class OrderController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;
    public $layout = 'flow';
    public function behaviors()
    {
        return [
            'access'=>[
                'class'=>AccessControl::className(),
                'only'=>['index'],
                'rules'=>[
                    [
                        'allow'=>true,
                        'actions'=>['index'],
                        'roles'=>['@'],
                    ]
                ],
            ],
        ];
    }
    public function actionIndex()
    {
        $addresses = Address::find()->where(['member_id'=>\Yii::$app->user->id])->all();
        $goods= Cart::find()->where(['user_id'=>\Yii::$app->user->id])->all();
        return $this->render('index',['addresses'=>$addresses,'goods'=>$goods]);
    }

    public function actionAdd(){
        $order = new Order();
        if($order->load(\Yii::$app->request->post()) ){
            $dizhi = Address::findOne(['id'=>$order->address]);
            $order->member_id=\Yii::$app->user->id;
            $order->name=$dizhi->name;
            $order->province_name=$dizhi->province;
            $order->city_name=$dizhi->city;
            $order->area_name=$dizhi->area;
            $order->detail_address=$dizhi->site;
            $order->tel=$dizhi->tel;
            if($order->validate()){
                $order->delivery_name=Order::$method[$order->delivery_id]['name'];
                $order->delivery_price=Order::$method[$order->delivery_id]['price'];

                $order->pay_type_name = Order::$pays[$order->pay_type_id]['name'];
                $order->trode_no=rand(100000,999999);
                $order->status=1;
                $order->create_time=time();
                $db = \Yii::$app->db;
                $transaction = $db->beginTransaction();
                try {
                    $order->save();
                    $carts = Cart::find()->where(['user_id' => $order->member_id])->all();
                    foreach ($carts as $cart) {
                        $detail = new OrderDetail();
                        $detail->order_info_id = $order->id;
                        $detail->goods_id = $cart->goods_id;
                        $detail->goods_name = $cart->goodson->name;
                        $detail->logo = $cart->goodson->logo;
                        $detail->price = $cart->goodson->shop_price;
                        $detail->amount = $cart->amount;
                        $detail->total_price = $detail->price * $detail->amount;
                        if($cart->amount > $cart->goodson->stock){
                            throw new Exception('商品'.$cart->goodson->name.'的库存不足');
                        }
                        $detail->save(false);
                    }
                    $transaction->commit();
                }catch (Exception $e){
                    \Yii::$app->session->setFlash('danger',$e);
                    $transaction->rollBack();
                }
            }
            return $this->redirect(['/shop/index']);
        }
    }
}
