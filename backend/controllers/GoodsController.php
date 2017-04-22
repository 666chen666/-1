<?php

namespace backend\controllers;

use backend\models\Brand;
use backend\models\Goods;
use backend\models\GoodsCategory;
use backend\models\GoodsDayCount;
use backend\models\GoodsIntro;
use backend\models\GoodsSearchForm;
use yii\helpers\ArrayHelper;
use yii\web\Request;
use yii\web\UploadedFile;

class GoodsController extends \yii\web\Controller
{

    public function actionIndex()
    {
        $good = Goods::find();
        $model = new GoodsSearchForm();
        $good->andWhere(['status'=>1]);
        if($model->load(\Yii::$app->request->get()) && $model->validate()){
            if($model->name){
                $good->andWhere(['like','name',$model->name]);
            }
            if($model->sn){
                $good->andWhere(['like','sn',$model->sn]);
            }
            if($model->minPrice){
                $good->andWhere(['>=','shop_price',$model->minPrice]);
            }
            if($model->maxPrice){
                $good->andWhere(['<=','shop_price',$model->maxPrice]);
            }
        }
        $good=$good->all();
        return $this->render('index',['good'=>$good,'model'=>$model]);
    }

    public function actionAdd(){
        $model = new Goods();
        $model_intro= new GoodsIntro();
        $_fenlei = GoodsCategory::find()->all();
        $goods_fen = ArrayHelper::map($_fenlei,'id','name');
        $brand = Brand::find()->all();
        $brand_fen = ArrayHelper::map($brand,'id','name');
        $request = new Request();
        if($request->isPost){
            $model->load($request->post());
            $model_intro->load($request->post());
            $model->img_file = UploadedFile::getInstance($model,'img_file');
            if($model->validate()&& $model_intro->validate()){
                if($model->img_file) {
                    $filename = 'uploads/goods/' . uniqid() . '.' . $model->img_file->extension;
                    $model->img_file->saveAs($filename, false);
                    $model->logo = $filename;
                }
                $model->inputtime=time();

                $goods_count=new GoodsDayCount();
                $goods_count->day= date('Ymd',$model->inputtime);
                $res=$goods_count->find()->where(['day'=>$goods_count->day])->count();
                if($res){
                   $day= $goods_count->findOne(['day'=>$goods_count->day]);
                    $day->count+=1;
                    $day->save();
                    $model->sn=date('Ymd',$model->inputtime).str_pad("$day->count",4,0,STR_PAD_LEFT);
                }else{
                    $goods_count->count=1;
                    $goods_count->save();
                    $model->sn=date('Ymd',$model->inputtime).str_pad("$goods_count->count",4,0,STR_PAD_LEFT);
                }
                $model->save();
                $model_intro->goods_id=$model->id;
                $model_intro->save();
                return $this->redirect(['goods-gallery/add?id='.$model->id]);
            }
        }
        $data = GoodsCategory::find()->asArray()->all();
        $top = ['parent_id'=>0,'name'=>'顶级分类','id'=>0];
        $data []=$top;
        $data = json_encode($data);

        return $this->render('add',['model'=>$model,'goods_fen'=>$goods_fen,'brand_fen'=>$brand_fen,'model_intro'=>$model_intro,'data'=>$data]);
    }
    public function actionEdit($id){
        $model =Goods::findOne(['id'=>$id]);
        $model_intro=GoodsIntro::findOne(['goods_id'=>$id]);
        $brand = Brand::find()->all();
        $brand_fen = ArrayHelper::map($brand,'id','name');
        $request = new Request();
        if($request->isPost){
            $model->load($request->post());
            $model_intro->load($request->post());
            $model->img_file = UploadedFile::getInstance($model,'img_file');
            if($model->validate()&& $model_intro->validate()){
                if($model->img_file) {
                    $filename = 'uploads/goods/' . uniqid() . '.' . $model->img_file->extension;
                    $model->img_file->saveAs($filename, false);
                    $model->logo = $filename;
                }
                $model->save();
                $model_intro->goods_id=$model->id;
                $model_intro->save();
                return $this->redirect(['goods/index']);
            }
        }
        $data = GoodsCategory::find()->asArray()->all();
        $top = ['parent_id'=>0,'name'=>'顶级分类','id'=>0];
        $data []=$top;
        $data = json_encode($data);
        return $this->render('add',['model'=>$model,'model_intro'=>$model_intro,'brand_fen'=>$brand_fen,'model_intro'=>$model_intro,'data'=>$data]);
    }

    public function actionDel($id){
        $goods= Goods::findOne(['id'=>$id]);
        $goods->status=0;
        $goods->save(false);
        return $this->redirect(['goods/index']);
    }
    public function actionRecycle(){
        $good =Goods::find()->where(['status'=>'0'])->all();
        return $this->render('recycle',['good'=>$good]);
    }

    public function actionRedel($id){
        $goods= Goods::findOne(['id'=>$id]);
        $goods->delete();
        return $this->redirect(['goods/recycle']);
    }
    public function actions()
    {
        return [
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
                'config' => [
                    "imageUrlPrefix"  => "",//图片访问路径前缀
                    "imagePathFormat" => "/upload/image/{yyyy}{mm}{dd}/{time}{rand:6}", //上传保存路径
                    "imageRoot" => \Yii::getAlias("@webroot"),
            ]
            ],
        ];
    }

}
