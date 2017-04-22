<?php
/* @var $this yii\web\View */
?>
<h1>管理员 管理</h1>
<table class="table table-bordered table-hover">
    <tr>
        <td>ID</td>
        <td>用户名</td>
        <td>邮箱</td>
        <td>操作</td>
    </tr>
    <?php foreach($admins as $admin):?>
        <tr>
            <td><?=$admin->id?></td>
            <td><?=$admin->username?></td>
            <td><?=$admin->email?></td>
            <td><?=\yii\bootstrap\Html::a('编辑',['admin/edit','id'=>$admin->id],['class'=>'btn btn-info'])?>
                <?=\yii\bootstrap\Html::a('删除',['admin/del','id'=>$admin->id],['class'=>'btn btn-danger'])?></td>
        </tr>
    <?php endforeach;?>
</table>
