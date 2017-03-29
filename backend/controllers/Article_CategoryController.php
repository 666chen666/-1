<?php

namespace backend\controllers;

use backend\models\Article;
use backend\models\ArticleCategory;
use yii\data\Pagination;
use yii\web\Request;

class Article_CategoryController extends \yii\web\Controller
{
    public function actionIndex()
    {

        $query= ArticleCategory::find();
        //总条数
        $total = $query->count();
        $pageSize = 3;
        $pager = new Pagination([
            'totalCount'=>$total,
            'pageSize'=>$pageSize
        ]);
        $categorys =$query->limit($pager->limit)->offset($pager->offset)->all();
        return $this->render('index',['categorys'=>$categorys,'pager'=>$pager]);
    }

    public function actionAdd(){
        $model = new ArticleCategory();
        $request = new Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $model->save();
                return $this->redirect(['article_-category/index']);
            }
        }

        return $this->render('add',['model'=>$model]);
    }

    public function actionEdit($id){
        $model = ArticleCategory::findOne($id);
        $request = new Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $model->save();
                return $this->redirect(['article_-category/index']);
            }
        }

        return $this->render('add',['model'=>$model]);
    }

    public function actionDel($id){
        $cate = Article::find()->where(['article_category_id'=>$id])->count();
        if($cate){
            \Yii::$app->session->setFlash('danger','下面有文章,不能删除');
            return $this->redirect(['article_-category/index']);
        }
        $model = ArticleCategory::findOne($id);
        $model->delete();
        return $this->redirect(['article_-category/index']);
    }

}
