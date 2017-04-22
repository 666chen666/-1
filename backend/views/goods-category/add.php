
<?php
/* @var $this yii\web\View */
$this->registerCssFile('/zTree/css/zTreeStyle/zTreeStyle.css');
$this->registerJsFile('/zTree/js/jquery.ztree.core.js',['depends'=>\yii\web\JqueryAsset::className()]);
$js=<<<ETO
 var zTreeObj;
   // zTree 的参数配置，深入使用请参考 API 文档（setting 配置详解）
   var setting = {data: {
		simpleData: {
			enable: true,
			idKey: "id",
			pIdKey: "parent_id",
			rootPId: 0

	}

    },
    callback: {
		   onClick:function (event, treeId, treeNode) {

             $("#goodscategory-parent_id").val(treeNode.id);
	        }
        }
  };
   // zTree 的数据属性，深入使用请参考 API 文档（zTreeNode 节点数据详解）
   var zNodes = {$data};
       zTreeObj = $.fn.zTree.init($("#treeDemo"), setting, zNodes);
       zTreeObj.expandAll(true);
       zTreeObj.selectNode(zTreeObj.getNodeByParam("id","{$model->parent_id}",null));
ETO;


$this->registerJs($js);
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
echo $form->field($model,'parent_id')->hiddenInput();
echo '<div>
   <ul id="treeDemo" class="ztree"></ul>
</div>';
echo $form->field($model,'intro')->textarea();
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-success']);
\yii\bootstrap\ActiveForm::end();
?>


