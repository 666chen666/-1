<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/11 0011
 * Time: 上午 10:37
 */

namespace frontend\controllers;


use backend\models\Goods;
use backend\models\GoodsCategory;
use frontend\models\Cart;
use yii\web\Controller;
use yii\web\Cookie;

class ShopController extends Controller
{
    public $enableCsrfValidation = false;
    public $layout = 'index';
    public function actionIndex(){
        if(\Yii::$app->session->hasFlash('danger')){
            echo "<script>alert('".\Yii::$app->session->getFlash('danger').")</script>";
        }
        $goods =GoodsCategory::find()->where(['parent_id'=>0])->all();
        return $this->render('index',['goods'=>$goods]);
    }

    public function actionList(){
        $this->layout='list';
        $goods =GoodsCategory::find()->where(['parent_id'=>0])->all();
        return $this->render('list',['goods'=>$goods]);
    }
    public function actionGood(){
        $this->layout='goods';
        $goods =GoodsCategory::find()->where(['parent_id'=>0])->all();
        return $this->render('good',['goods'=>$goods]);
    }

    public function actionNotice(){
        //获取商品Id和数量
        $goods_id=$_POST['goods_id'];
        $num=$_POST['amount'];
        //将商品id和数量保存到cookie中
        if(\Yii::$app->user->isGuest){
            $cookies=\Yii::$app->request->cookies;
            //判断购物车中是否有前台的商品
            if($cookies->get('cart')==null){
                $data=[];
            }else{
                $data=unserialize($cookies->get('cart'));
            }
            if(array_key_exists($goods_id,$data)){
                //2 购物车已经有该商品  数量累加
                $data[$goods_id] += $num;
            }else{
                //1 购物车没有该商品   直接添加到数组
                $data[$goods_id] = $num;
            }
            $cookies=\Yii::$app->response->cookies;
            $cookie=new Cookie(['name'=>'cart','value'=>serialize($data)]);
            $cookies->add($cookie);
        }else{
            //1 检查购物车有没有该商品(根据goods_id member_id查询)
            $user_id = \Yii::$app->user->id;
            $cart = new Cart();
            $res =Cart::find()->where(['goods_id'=>$goods_id,'user_id'=>$user_id])->One();
            //1.1 有该商品  数量累加
            if($res){
                $res->amount += $num;
                $res->update();
            }else{
                $cart->user_id = $user_id;
                $cart->goods_id = $goods_id;
                $cart->amount = $num;
                $cart->save();
            }
            //1.2 没有该商品  添加到数据表
        }

        //跳转到购物车页面
        return $this->redirect(['shop/cart']);
    }
    public function actionCart(){
        $this->layout = 'cart';

        if(\Yii::$app->user->isGuest){
            //将商品id和数量从cookie取出
            $cookies = \Yii::$app->request->cookies;
            $cookie = $cookies->get('cart');
            if($cookie == null){//购物车cookie不存在
                $cart = [];
            }else{//购物车cookie存在
                $cart = unserialize($cookie->value);
            }
        }else{
            //用户已登录，从数据表获取购物车数据
            $cart = [];
            $goods =Cart ::find()->where(['user_id'=>\Yii::$app->user->id])->all();
            foreach($goods as $good){
                $cart[$good->goods_id]=$good->amount;
            }
        }
        $models = [];
        //循环获取商品数据，构造购物车需要的格式
        foreach($cart as $id=>$num){
            $goods = Goods::find()->where(['id'=>$id])->asArray()->one();
            $goods['num']=$num;
            $models[]=$goods;
        }

        return $this->render('cart',['models'=>$models]);
        }

    public function actionAjax($filter)
    {
        switch ($filter) {
            case 'modify':
                //修改商品数量 goods_id  num
                $goods_id = \Yii::$app->request->post('goods_id');
                $num = \Yii::$app->request->post('num');

                if (\Yii::$app->user->isGuest) {
                    $cookies = \Yii::$app->request->cookies;
                    $cookie = $cookies->get('cart');
                    if ($cookie == null) {//购物车cookie不存在
                        $cart = [];
                    } else {//购物车cookie存在
                        $cart = unserialize($cookie->value);
                    }

                    $cart[$goods_id] = $num;
                    //将购车数据保存回cookie
                    $cookies = \Yii::$app->response->cookies;
                    $cookie = new Cookie([
                        'name' => 'cart',
                        'value' => serialize($cart)
                    ]);
                    $cookies->add($cookie);
                    // \Yii::$app->cartCookie->updateCart($goods_id,$num)->save();
                }else{

                }
                return 'success';
                break;

            case 'del':
                //删除商品
                $goods_id = \Yii::$app->request->post('goods_id');

                if (\Yii::$app->user->isGuest) {
                    $cookies = \Yii::$app->request->cookies;
                    $cookie = $cookies->get('cart');
                    if ($cookie == null) {//购物车cookie不存在
                        $cart = [];
                    } else {//购物车cookie存在
                        $cart = unserialize($cookie->value);
                    }
                    //清除购物车中该id对应的商品
                    unset($cart[$goods_id]);
                    //将购车数据保存回cookie
                    $cookies = \Yii::$app->response->cookies;
                    $cookie = new Cookie([
                        'name' => 'cart',
                        'value' => serialize($cart)
                    ]);

                    $cookies->add($cookie);
                    /*$cart = new CookieHandler();
                     $cart->delCart($goods_id);
                     $cart->save();*/
                    //\Yii::$app->cartCookie->delCart($goods_id)->save();
                    return 'success';
                }else{
                    $cart = Cart::findOne(['goods_id'=>$goods_id,'user_id'=>\Yii::$app->user->id]);
                    $cart->delete();
                    return 'success';
                }
                break;
        }
    }
}