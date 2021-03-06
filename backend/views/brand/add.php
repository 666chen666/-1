<?php
use yii\web\JsExpression;

$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
echo $form->field($model,'intro')->textarea();
echo $form->field($model,'logo')->hiddenInput();

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
]);
echo \yii\bootstrap\Html::img($model->logo,['width'=>100,'id'=>'logoh']);
echo $form->field($model,'sort');
echo $form->field($model,'status')->inline()->radioList(\backend\models\Brand::$status_zt);
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-success']);
\yii\bootstrap\ActiveForm::end();

