<?=\yii\bootstrap\Html::a('添加品牌',['article_-category/add'],['class'=>'btn btn-success']);?>

<h1>文章分类管理</h1>
<table class="table">
    <tr>
        <th>ID</th>
        <th>分类名</th>
        <th>排序</th>
        <th>状态</th>
        <th>是否为帮助分类</th>
        <th>操作</th>
    </tr>
    <?php foreach($categorys as $category):?>
        <tr>
            <td><?=$category->id?></td>
            <td><?=$category->name?></td>
            <td><?=$category->sort?></td>
            <td><?=$category->status?'展示':'不展示'?></td>
            <td><?=$category->is_help?'否':'是'?></td>
            <td>
                <?=\yii\bootstrap\Html::a('编辑',['article_-category/edit','id'=>$category->id],['class'=>'btn btn-info'])?>
                <?=\yii\bootstrap\Html::a('删除',['article_-category/del','id'=>$category->id],['class'=>'btn btn-danger'])?>
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