<?php
/* @var $this yii\web\View */
?>
<?=\yii\bootstrap\Html::a('添加分类',['goods-category/add'],['class'=>'btn btn-success']);?>
<h1>商品分类管理列表</h1>
<table class="table table-bordered table-hover">
    <tr>
        <td>ID</td>
        <td>分类名</td>
        <td>左值</td>
        <td>右值</td>
        <td>层级</td>
        <td>父ID</td>
        <td>操作</td>
    </tr>
    <tbody id="category">
    <?php foreach($categorys as $category):?>
        <tr data-lft="<?=$category->lft?>" data-rgt="<?=$category->rgt?>" data-tree="<?=$category->tree?>">
            <td><?=$category->id?></td>
            <td><?=str_repeat(' - ',$category->depth).$category->name?></td>
            <td><?=$category->lft?></td>
            <td><?=$category->rgt?></td>
            <td><?=$category->depth?></td>
            <td><?=$category->parent_id?>
                <span class="glyphicon glyphicon-chevron-down expand" style="float: right"></span></td>
            <td><?=\yii\bootstrap\Html::a('编辑',['goods-category/edit','id'=>$category->id],['class'=>'btn btn-info'])?>
                <?=\yii\bootstrap\Html::a('删除',['goods-category/del','id'=>$category->id],['class'=>'btn btn-danger'])?>

            </td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>

<?php
echo \yii\widgets\LinkPager::widget([
    'pagination'=>$pager,
    'nextPageLabel'=>'下一页',
    'prevPageLabel'=>'上一页',
]);
$js = <<<EOT
    $(".expand").click(function(){
        //切换图标样式
        $(this).toggleClass("glyphicon-chevron-down");
        $(this).toggleClass("glyphicon-chevron-up");

        var current_tr = $(this).closest("tr");//获取当前点击图标所在tr
        var current_lft = parseInt(current_tr.attr("data-lft"));//当前分类左值
        var current_rgt = parseInt(current_tr.attr("data-rgt"));//当前分类右值
        var current_tree = parseInt(current_tr.attr("data-tree"));//当前分类tree值
        $("#category tr").each(function(){

            var lft = parseInt($(this).attr("data-lft"));//分类的左值
            var rgt = parseInt($(this).attr("data-rgt"));//分类的右值
            var tree = parseInt($(this).attr("data-tree"));//分类的tree值
            if(tree == current_tree && lft > current_lft && rgt < current_rgt){

                $(this).fadeToggle();
            }
        });

    });
EOT;

$this->registerJs($js);
