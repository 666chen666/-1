<?php

namespace backend\controllers;

use backend\models\Article;
use backend\models\ArticleCategory;
use backend\models\ArticleDetail;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\web\Request;

class ArticleController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $query= Article::find();
        //总条数
        $total = $query->count();
        $pageSize = 3;
        $pager = new Pagination([
            'totalCount'=>$total,
            'pageSize'=>$pageSize
        ]);
        $articles =$query->limit($pager->limit)->offset($pager->offset)->all();
        return $this->render('index',['articles'=>$articles,'pager'=>$pager]);
    }

    public function actionAdd(){
        $model = new Article();
        $request = new Request();
        $article_detail = new ArticleDetail();
        $_fenlei = ArticleCategory::find()->all();
        $article_fen = ArrayHelper::map($_fenlei,'id','name');
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $model->inputtime=time();
                $model->save();
                $id =\yii\BaseYii::$app->db->getLastInsertID();
                $article_detail->article_id=$id;
                $article_detail->content = $model->content;
                $article_detail->save();
                return $this->redirect(['article/index']);
            }
        }

        return $this->render('add',['model'=>$model,'article_fen'=>$article_fen]);
    }

    public function actionEdit($id){
        $model = Article::findOne(['id'=>$id]);
        $request = new Request();
        $article_detail =ArticleDetail::findOne(['article_id'=>$id]);
        $model->content = $article_detail->content;
        $_fenlei = ArticleCategory::find()->all();
        $article_fen = ArrayHelper::map($_fenlei,'id','name');
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $model->inputtime=time();
                $model->save();
                $article_detail->article_id=$id;
                $article_detail->content = $model->content;
                $article_detail->save();
                return $this->redirect(['article/index']);
            }
        }

        return $this->render('add',['model'=>$model,'article_fen'=>$article_fen]);
    }

    public function actionDel($id){
        $article = Article::findOne(['id'=>$id]);
        $article->delete();
        $detail = ArticleDetail::findOne(['article_id'=>$id]);
        $detail->delete();
        return $this->redirect(['article/index']);
    }
}
