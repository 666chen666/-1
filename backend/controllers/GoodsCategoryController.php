<?php

namespace backend\controllers;

use backend\models\GoodsCategory;
use yii\data\Pagination;
use yii\db\Exception;
use yii\web\Request;

class GoodsCategoryController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $query= GoodsCategory::find()->orderBy('tree,lft');
        //总条数
        $total = $query->count();
        $pageSize = 10;
        $pager = new Pagination([
            'totalCount'=>$total,
            'pageSize'=>$pageSize
        ]);
        $categorys =$query->limit($pager->limit)->offset($pager->offset)->all();
        return $this->render('index',['categorys'=>$categorys,'pager'=>$pager]);
    }

    public function actionAdd(){
        $model = new GoodsCategory();
        $request= new Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                if($model->parent_id==0){
                    $model->makeRoot();
                    return $this->redirect(['goods-category/index']);
                }else{
                    $parent = GoodsCategory::findOne(['id'=>$model->parent_id]);
                    $model->prependTo($parent);
                    return $this->redirect(['goods-category/index']);
                }
            }
        }
        $data = GoodsCategory::find()->asArray()->all();
        $top = ['parent_id'=>0,'name'=>'顶级分类','id'=>0];
        $data []=$top;
        $data = json_encode($data);
        return $this->render('add',['model'=>$model,'data'=>$data]);
    }


    public function actionEdit($id){
        $model = GoodsCategory::findOne(['id'=>$id]);
        $request= new Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                try{
                    if($model->parent_id==0){
                        $model->makeRoot();
                        return $this->redirect(['goods-category/index']);
                    }else{
                        $parent = GoodsCategory::findOne(['id'=>$model->parent_id]);
                        $model->prependTo($parent);
                        return $this->redirect(['goods-category/index']);
                    }
                }catch(Exception $e){
                    \Yii::$app->session->setFlash('danger', $e->getMessage());
                }
            }
        }
        $data = GoodsCategory::find()->asArray()->all();
        $top = ['parent_id'=>0,'name'=>'顶级分类','id'=>0];
        $data []=$top;
        $data = json_encode($data);
        return $this->render('add',['model'=>$model,'data'=>$data]);
    }

    public function actionDel($id){

        $son =GoodsCategory::find()->where(['parent_id'=>$id])->count();
        if($son) {
            \Yii::$app->session->setFlash('danger', '下面还存在子类,不能删除');
            return $this->redirect(['goods-category/index']);
        }
        GoodsCategory::deleteAll(['id'=>$id]);
        return $this->redirect(['goods-category/index']);
    }

}
