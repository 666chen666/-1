<?=\yii\bootstrap\Html::a('添加权限','add-permission',['class'=>'btn btn-info']);?>
<table class="table">
    <tr>
        <th>名称</th>
        <th>描述</th>
        <th>操作</th>
    </tr>
    <?php foreach($permissions as $permission):?>
        <tr>
            <td><?=$permission->name?></td>
            <td><?=$permission->description?></td>
            <td><?=\yii\bootstrap\Html::a('删除权限','del-permission?name='.$permission->name,['class'=>'btn btn-danger']);?></td>
        </tr>
    <?php endforeach;?>
</table>
