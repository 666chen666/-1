<?php
/* @var $this yii\web\View */
?>
<?=\yii\bootstrap\Html::a('添加商品',['goods/add'],['class'=>'btn btn-success']);?>
<?=\yii\bootstrap\Html::a('回收站',['goods/recycle'],['class'=>'btn btn-danger']);?>
<br><br>
<div class="container ">
    <?php $form = \yii\bootstrap\ActiveForm::begin(
        [   'method'=>'get',
            'options'=>['class'=>'form-inline searchBar'],
            'action'=>\yii\helpers\Url::to(['goods/index'])
        ]
    );
    echo $form->field($model,'name');
    echo $form->field($model,'sn');
    echo $form->field($model,'minPrice');
    echo $form->field($model,'maxPrice');
    echo '&nbsp;&nbsp;&nbsp;&nbsp;';
    echo \yii\bootstrap\Html::submitButton('搜索',['class'=>'btn btn-primary']);
    \yii\bootstrap\ActiveForm::end();?>
</div>
<h1>商品管理</h1>
<table class="table table-bordered table-hover">
    <tr>
        <td>ID</td>
        <td>名称</td>
        <td>货号</td>
        <td>分类</td>
        <td>品牌</td>
        <td>市场价格</td>
        <td>本店价格</td>
        <td>是否上架</td>
        <td>添加时间</td>
        <td>操作</td>
    </tr>
    <?php foreach($good as $goods):?>
        <tr>
            <td><?=$goods->id?></td>
            <td><?=$goods->name?></td>
            <td><?=$goods->sn?></td>
            <td><?=$goods->cate->name?></td>
            <td><?=$goods->brand->name?></td>
            <td><?=$goods->market_price?></td>
            <td><?=$goods->shop_price?></td>
            <td><?=$goods->is_on_sale?'是':'否'?></td>
            <td><?=date('Y-m-d H:i:s',$goods->inputtime)?></td>
            <td>
                <?=\yii\bootstrap\Html::a('相册',['goods-gallery/index','id'=>$goods->id],['class'=>'btn btn-success'])?>
                <?=\yii\bootstrap\Html::a('编辑',['goods/edit','id'=>$goods->id],['class'=>'btn btn-info'])?>
                <?=\yii\bootstrap\Html::a('删除',['goods/del','id'=>$goods->id],['class'=>'btn btn-danger'])?>

            </td>
        </tr>
    <?php endforeach;?>
</table>

