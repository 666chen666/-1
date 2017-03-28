<?php
/* @var $this yii\web\View */
?>
<?=\yii\bootstrap\Html::a('品牌管理首页',['brand/index'],['class'=>'btn btn-success']);?>
<h1>品牌管理</h1>

<table class="table table-bordered table-hover">
    <tr>
        <th>ID</th>
        <th>品牌名</th>
        <th>LOGO</th>
        <th>状态</th>
        <th>操作</th>
    </tr>
    <?php foreach($brands as $brand):?>
        <tr>
            <td><?=$brand->id?></td>
            <td><?=$brand->name?></td>
            <td><?=$brand->logo?\yii\bootstrap\Html::img('@web'.$brand->logo,['width'=>30]):''?></td>
            <td><?=\backend\models\Brand::$status_zt[$brand->status]?></td>
            <td>
                <?=\yii\bootstrap\Html::a('编辑',['brand/edit','id'=>$brand->id],['class'=>'btn btn-info'])?>
                <?=\yii\bootstrap\Html::a('彻底删除',['brand/redel','id'=>$brand->id],['class'=>'btn btn-danger'])?>
            </td>
        </tr>
    <?php endforeach;?>
</table>


<?php
echo \yii\widgets\LinkPager::widget([
    'pagination'=>$pager,
    'nextPageLabel'=>'下一页',
    'prevPageLabel'=>'上一页',
]);

