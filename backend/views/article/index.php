<?=\yii\bootstrap\Html::a('添加文章',['article/add'],['class'=>'btn btn-success']);?>
<h1>文章管理</h1>
<table class="table">
    <tr>
        <th>ID</th>
        <th>文章名</th>
        <th>简介</th>
        <th>分类</th>
        <th>排序</th>
        <th>状态</th>
        <th>添加时间</th>
        <th>操作</th>
    </tr>
    <?php foreach($articles as $article):?>
        <tr>
            <td><?=$article->id?></td>
            <td><?=$article->name?></td>
            <td><?=$article->intro?></td>
            <td><?=$article->cate->name?></td>
            <td><?=$article->sort?></td>
            <td><?=$article->status?'展示':'不展示'?></td>
            <td><?=date('Y-m-d H:i:s',$article->inputtime)?></td>
            <td>
                <?=\yii\bootstrap\Html::a('编辑',['article/edit','id'=>$article->id],['class'=>'btn btn-info'])?>
                <?=\yii\bootstrap\Html::a('删除',['article/del','id'=>$article->id],['class'=>'btn btn-danger'])?>
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