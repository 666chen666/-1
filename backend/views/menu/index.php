<h1>菜单管理</h1>
<?=\yii\bootstrap\Html::a('添加菜单','add',['class'=>'btn btn-info'])?>
<table class="table table-bordered table-hover">
    <tr>
        <td>ID</td>
        <td>名称</td>
        <td>路由</td>
        <td>操作</td>
    </tr>
    <?php foreach($menus as $menu):?>
        <tr>
            <td><?=$menu->id?></td>
            <td><?=$menu->name?></td>
            <td><?=$menu->url?></td>
            <td><?=\yii\bootstrap\Html::a('编辑',['menu/edit','id'=>$menu->id],['class'=>'btn btn-info'])?>
                <?=\yii\bootstrap\Html::a('删除',['menu/del','id'=>$menu->id],['class'=>'btn btn-danger'])?></td>
        </tr>
    <?php endforeach;?>
</table>