<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
echo $form->field($model,'intro')->textarea();
echo $form->field($model,'content')->textarea();
echo $form->field($model,'article_category_id')->dropDownList($article_fen);
echo $form->field($model,'sort');
echo $form->field($model,'status')->inline()->radioList(['0'=>'不展示','1'=>'展示']);
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-success']);
\yii\bootstrap\ActiveForm::end();

