<?php

namespace backend\controllers;

use Yii;
use backend\models\Menu;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MenuController implements the CRUD actions for Menu model.
 */
class MenuController extends Controller
{

    public function actionIndex()
    {
        $menus = Menu::find()->orderBy('parent_id')->all();
        //var_dump($menus);exit;
        return $this->render('index',['menus'=>$menus]);
    }
    public function actionAdd(){
        $model = new Menu();
        $top = [0=>'顶级分类'];
        $parent = Menu::find()->where(['parent_id'=>0])->all();
        $parent= ArrayHelper::map($parent,'id','name');
        $parent=ArrayHelper::merge($top,$parent);

        if($model->load(Yii::$app->request->post()) && $model->validate()){
            $model->save();
            return $this->redirect(['menu/index']);
        }
        return $this->render('add',['model'=>$model,'parent'=>$parent]);
    }

    public function actionEdit($id){
        $model =Menu::findOne(['id'=>$id]);
        $top = [0=>'顶级分类'];
        $parent = Menu::find()->where(['parent_id'=>0])->all();
        $parent= ArrayHelper::map($parent,'id','name');
        $parent=ArrayHelper::merge($top,$parent);

        if($model->load(Yii::$app->request->post()) && $model->validate()){
            $model->save();
            return $this->redirect(['menu/index']);
        }
        return $this->render('add',['model'=>$model,'parent'=>$parent]);
    }
    public function actionDel($id){
        $model=Menu::findOne(['id'=>$id]);
        $model->delete();
        return $this->redirect(['menu/index']);
    }
}
