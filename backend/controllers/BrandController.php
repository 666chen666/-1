<?php

namespace backend\controllers;



use backend\models\Brand;
use Codeception\PHPUnit\Constraint\Page;
use yii\data\Pagination;
use yii\web\Request;
use yii\web\UploadedFile;
use xj\uploadify\UploadAction;
class BrandController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $query= Brand::find()->where(['>=','status','0']);
        //总条数
        $total = $query->count();
        $pageSize = 3;
        $pager = new Pagination([
            'totalCount'=>$total,
            'pageSize'=>$pageSize
        ]);
        $brands =$query->limit($pager->limit)->offset($pager->offset)->all();
        return $this->render('index',['brands'=>$brands,'pager'=>$pager]);
    }

    public function actionAdd(){
        $model = new Brand();
        $request = new Request();
        if($request->isPost){
            $model->load($request->post());
            //$model->img_file = UploadedFile::getInstance($model,'img_file');
            if($model->validate()){
                /*if($model->img_file){
                    $filename = 'uploads/brand'.uniqid().'.'.$model->img_file->extension;
                    $model->img_file->saveAs($filename,false);
                    $model->logo=$filename;
                }*/
                $model->save();
                return $this->redirect(['brand/index']);
            }
        }

        return $this->render('add',['model'=>$model]);
    }

    public function actionEdit($id){
        $model =Brand::findOne($id);
        $request = new Request();
        if($request->isPost){
            $model->load($request->post());
            //$model->img_file = UploadedFile::getInstance($model,'img_file');
            if($model->validate()){
                /*if($model->img_file){
                    $filename = 'uploads/brand'.uniqid().'.'.$model->img_file->extension;
                    $model->img_file->saveAs($filename,false);
                    $model->logo=$filename;
                }*/
                $model->save();
                return $this->redirect(['brand/index']);
            }
        }

        return $this->render('add',['model'=>$model]);
    }

    public function actionDel($id){
        $brand = Brand::findOne($id);
        $brand->status='-1';
        $brand->save();
        return $this->redirect(['brand/index']);
    }


    public function actionRecycle()
    {
        $query= Brand::find()->where(['=','status','-1']);
        //总条数
        $total = $query->count();
        $pageSize = 3;
        $pager = new Pagination([
            'totalCount'=>$total,
            'pageSize'=>$pageSize
        ]);
        $brands =$query->limit($pager->limit)->offset($pager->offset)->all();
        return $this->render('recycle',['brands'=>$brands,'pager'=>$pager]);
    }

    public function actionRedel($id){
        $model = Brand::findOne(['id'=>$id]);
        $model->delete();
        return $this->redirect(['brand/recycle']);
    }



    public function actions() {
        return [
            's-upload' => [
                'class' => UploadAction::className(),
                'basePath' => '@webroot/upload',
                'baseUrl' => '@web/upload',
                'enableCsrf' => true, // default
                'postFieldName' => 'Filedata', // default
                //BEGIN METHOD
                /*'format' => [$this, 'methodName'],
                //END METHOD
                //BEGIN CLOSURE BY-HASH
                'overwriteIfExist' => true,
                'format' => function (UploadAction $action) {
                    $fileext = $action->uploadfile->getExtension();
                    $filename = sha1_file($action->uploadfile->tempName);
                    return "{$filename}.{$fileext}";
                },*/
                //END CLOSURE BY-HASH
                //BEGIN CLOSURE BY TIME
                'format' => function (UploadAction $action) {
                    $fileext = $action->uploadfile->getExtension();
                    $filehash = sha1(uniqid() . time());
                    $p1 = substr($filehash, 0, 2);
                    $p2 = substr($filehash, 2, 2);
                    return "{$p1}/{$p2}/{$filehash}.{$fileext}";
                },
                //END CLOSURE BY TIME
                'validateOptions' => [
                    'extensions' => ['jpg', 'png'],
                    'maxSize' => 1 * 1024 * 1024, //file size
                ],
                'beforeValidate' => function (UploadAction $action) {
                    //throw new Exception('test error');
                },
                'afterValidate' => function (UploadAction $action) {},
                'beforeSave' => function (UploadAction $action) {},
                'afterSave' => function (UploadAction $action) {
                    $action->output['fileUrl'] = $action->getWebUrl();
                    $action->getFilename(); // "image/yyyymmddtimerand.jpg"
                    $action->getWebUrl(); //  "baseUrl + filename, /upload/image/yyyymmddtimerand.jpg"
                    $action->getSavePath(); // "/var/www/htdocs/upload/image/yyyymmddtimerand.jpg"
                },
            ],
        ];
    }
}
