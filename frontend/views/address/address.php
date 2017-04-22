<?php

?>
 <!--右侧内容区域 start-->
    <div class="content fl ml10">


        <div class="address_bd mt10">
            <h4>新增收货地址</h4>
<!--            <form action="" name="address_form">-->
<!--            --><?php //$form = \yii\widgets\ActiveForm::begin();
//            echo '<ul>';
//            echo '<li>';
//
//            echo '</li>';
//
//            echo '</ul>';
//            ?>
            <?php $form = \yii\widgets\ActiveForm::begin();?>
                <ul>
                    <li>
<!--                        <label for=""><span>*</span>收 货 人：</label>-->
                        <?php echo $form->field($model,'name')->textInput(['class'=>'txt'])?>
<!--                        <input type="text" name="" class="txt" />-->
                    </li>
                    <li>

                        <label for=""><span>*</span>所在地区：</label>
                        <select name="province" id="cmbProvince">

                        </select>

                        <select name="city" id="cmbCity">

                        </select>

                        <select name="area" id="cmbArea">

                        </select>
                    </li>
                    <li>
<!--                        <label for=""><span>*</span>详细地址：</label>-->
<!--                        <input type="text" name="" class="txt address"  />-->
                        <?php echo $form->field($model,'site')->textInput(['class'=>'txt address'])?>
                    </li>
                    <li>
<!--                        <label for=""><span>*</span>手机号码：</label>-->
<!--                        <input type="text" name="" class="txt" />-->
                        <?php echo $form->field($model,'tel')->textInput(['class'=>'txt'])?>
                    </li>
                    <li>
<!--                        <label for="">&nbsp;</label>-->
<!--                        <input type="checkbox" name="" class="check" />设为默认地址-->
                        <?php echo $form->field($model,'flag')->checkbox(['class'=>'check'])?>
                    </li>
                    <br>
                    <br>
                    <li>
<!--                        <label for="">&nbsp;</label>-->
<!--                        <input type="submit" name="" class="btn" value="保存" />-->
                        <?php echo \yii\helpers\Html::submitButton('保存',['class'=>'btn'])?>
                    </li>
                </ul>
            <?php \yii\widgets\ActiveForm::end();?>
        </div>

        <div class="address_hd">
            <h3>收货地址薄</h3>
            <?php foreach($addresss as $address):?>
                <dl>
                    <dt><?=$address->id.' '.$address->name.' '.$address->site.''.$address->tel?></dt>
                    <dd>
                        <?=\yii\helpers\Html::a('修改',['address/edit','id'=>$address->id])?>
                        <?=\yii\helpers\Html::a('删除',['address/delete','id'=>$address->id])?>
                        <?php if($address->flag == 1){
                            echo '<span style="color: red">默认地址</span>';
                        }else{
                        echo \yii\helpers\Html::a('设为默认地址',['address/check','id'=>$address->id]);

                        }?>
                    </dd>
                </dl>
            <?php endforeach;?>

        </div>

    </div>
    <!-- 右侧内容区域 end-->
<script type="text/javascript">
    addressInit('cmbProvince', 'cmbCity', 'cmbArea', '四川', '成都', '武侯区');
</script>
