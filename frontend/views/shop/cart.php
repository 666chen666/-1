
<?php foreach($models as $model):?>
    <tr data-goods-id="<?=$model['id']?>">
    <td class="col1"><a href=""><img src="<?=Yii::$app->params['backend_logo'].$model['logo']?>" alt="" /></a>  <strong><a href=""><?=$model['name']?></a></strong></td>
    <td class="col3">￥<span><?=$model['shop_price']?></span></td>
    <td class="col4">
        <a href="javascript:;" class="reduce_num"></a>
        <input type="text" name="amount" value="<?=$model['num']?>" class="amount"/>
        <a href="javascript:;" class="add_num"></a>
    </td>
    <td class="col5">￥<span><?=$model['shop_price'] * $model['num']?></span></td>
    <td class="col6"><a href="javascript:;" class="btn_del">删除</a></td>
    </tr>
<?php endforeach;?>
</tbody>
<tfoot>
<tr>
    <td colspan="6">购物金额总计： <strong>￥ <span id="total">1870.00</span></strong></td>
</tr>
</tfoot>
</table>
<div class="cart_btn w990 bc mt10">
    <a href="" class="continue">继续购物</a>
    <a href="/order/index" class="checkout">结 算</a>
</div>
</div>
<?php
$this->registerJs('totalPrice();');
