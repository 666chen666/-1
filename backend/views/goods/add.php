<?php
use \kucha\ueditor\UEditor;

$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
//echo $form->field($model_intro,'content')->textarea();
echo $form->field($model_intro,'content')->widget('kucha\ueditor\UEditor',[]);

echo $form->field($model,'img_file')->fileInput();
echo $form->field($model,'goods_category_id')->hiddenInput();
echo $form->field($model,'depth')->hiddenInput(['display'=>'none']);
echo '<div>
   <ul id="treeDemo" class="ztree"></ul>
</div>';
echo $form->field($model,'brand_id')->dropDownList($brand_fen);
echo $form->field($model,'shop_price');
echo $form->field($model,'market_price');
echo $form->field($model,'sort');
echo $form->field($model,'is_on_sale')->inline()->radioList(['0'=>'否',1=>'是']);
echo $form->field($model,'status')->inline()->radioList(['0'=>'回收站',1=>'正常']);
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-success']);
\yii\bootstrap\ActiveForm::end();

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

             $("#goods-goods_category_id").val(treeNode.id);
             $("#goods-depth").val(treeNode.depth);
	        }
        }
  };
   // zTree 的数据属性，深入使用请参考 API 文档（zTreeNode 节点数据详解）
   var zNodes = {$data};
       //console.log($data);
       zTreeObj = $.fn.zTree.init($("#treeDemo"), setting, zNodes);
       zTreeObj.expandAll(true);
       zTreeObj.selectNode(zTreeObj.getNodeByParam("id","{$model->goods_category_id}",null));
ETO;
$this->registerJs($js);

/*
 *
//Remove Events Auto Convert



//外部TAG
echo \yii\bootstrap\Html::fileInput('test', NULL, ['id' => 'test']);
echo \xj\uploadify\Uploadify::widget([
    'url' => yii\helpers\Url::to(['s-upload']),
    'id' => 'test',
    'csrf' => true,
    'renderTag' => false,
    'jsOptions' => [
        'width' => 120,
        'height' => 40,
        'onUploadError' => new JsExpression(<<<EOF
function(file, errorCode, errorMsg, errorString) {
    console.log('The file ' + file.name + ' could not be uploaded: ' + errorString + errorCode + errorMsg);
}
EOF
        ),
        'onUploadSuccess' => new JsExpression(<<<EOF
function(file, data, response) {
    data = JSON.parse(data);
    if (data.error) {
        console.log(data.msg);
    } else {
        //console.log(data.fileUrl);
        $("#brand-logo").val(data.fileUrl);
        $("#logoh").attr('src',data.fileUrl);
    }
}
EOF
        ),
    ]
]);*/

