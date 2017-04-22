<div class="fillin w990 bc mt15">
    <div class="fillin_hd">
        <h2>填写并核对订单信息</h2>
    </div>
    <form action="<?=\yii\helpers\Url::to(['order/add'])?>" method="post">
    <div class="fillin_bd">
        <!-- 收货人信息  start-->
        <div class="address">
            <h3>收货人信息 </h3>

            <div class="address_info">

                    <?php foreach($addresses as $address):?>
                <p>
                        <input type="radio" name="Order[address]" checked="checked" value="<?=$address->id?>"/><?=$address->name.' '.$address->province.' '.$address->city.' '.$address->area.' '.$address->site.' '.$address->tel?>
                </p>
                    <?php endforeach;?>

            </div>
        </div>
        <!-- 收货人信息  end-->

        <!-- 配送方式 start -->
        <div class="delivery">
            <h3>送货方式</h3>

            <div class="delivery_info ">
                <table width="500px">
                    <thead>
                    <tr>
                        <th class="col1">送货方式</th>
                        <th class="col2">运费</th>
                        <th class="col3">运费标准</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach(\frontend\models\Order::$method as $k =>$met):?>
                        <tr class="cur">

                            <td><input type="radio" name="Order[delivery_id]" value="<?=$k?>"/><?=$met['name']?></td>
                            <td>￥<?=$met['price']?></td>
                            <td><?=$met['intro']?></td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- 配送方式 end -->

        <!-- 支付方式  start-->
        <div class="pay">
            <h3>支付方式</h3>

            <div class="pay_select">
                <table>
                    <?php foreach(\frontend\models\Order::$pays as $i => $pay):?>
                        <tr>
                            <td class="col1"><input type="radio" name="Order[pay_type_id]" value="<?=$i?>" /><?=$pay['name']?></td>
                            <td class="col2"><?=$pay['intro']?></td>
                        </tr>
                    <?php endforeach;?>
                </table>

            </div>
        </div>
        <!-- 支付方式  end-->

        <!-- 发票信息 start-->
        <div class="receipt">
            <h3>发票信息 <a href="javascript:;" id="receipt_modify">[修改]</a></h3>
            <div class="receipt_info">
                <p>个人发票</p>
                <p>内容：明细</p>
            </div>

            <div class="receipt_select none">
                <a href="" class="confirm_btn"><span>确认发票信息</span></a>
            </div>
        </div>
        <!-- 发票信息 end-->

        <!-- 商品清单 start -->
        <div class="goods">
            <h3>商品清单</h3>
            <table>
                <thead>
                <tr>
                    <th class="col1">商品</th>
                    <th class="col3">价格</th>
                    <th class="col4">数量</th>
                    <th class="col5">小计</th>
                </tr>
                </thead>
                <tbody>
                <?php $total=0;?>
                <?php foreach($goods as $good):?>
                    <tr>
                        <td class="col1"><a href=""><img src="<?=Yii::$app->params['backend_logo'].$good->goodson->logo?>" alt="" /></a>  <strong><a href=""><?=$good->goodson->name?></a></strong></td>
                        <td class="col3">￥<?=$good->goodson->shop_price?></td>
                        <td class="col4"><?=$good->amount?></td>
                        <td class="col5"><span>￥<?=$good->goodson->shop_price * $good->amount?></span></td>
                        <?php $total+=$good->goodson->shop_price * $good->amount?>
                    </tr>
                <?php endforeach;?>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="5">
                        <ul>
                            <li>
                                <span><?=count($goods)?> 件商品，总商品金额：</span>
                                <em>￥<?=$total?></em>
                            </li>
                            <li>
                                <span>返现：</span>
                                <em>￥0.00</em>
                            </li>
                            <li>
                                <span>运费：</span>
                                <em>￥10.00</em>
                            </li>
                            <li>
                                <span>应付总额：</span>
                                <em>￥<?=$total-10?></em>
                            </li>
                        </ul>
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
        <!-- 商品清单 end -->

    </div>

    <div class="fillin_ft">

        <p>应付总额：<strong>￥<?=$total-10?>元</strong></p>
        <input type="hidden" name="Order[price]" value="<?=$total-10?>">
        <input type="submit" value="">
    </div>

    </form>
</div>