<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/9
 * Time: 19:51
 */

namespace frontend\controllers;


use frontend\models\Address;
use yii\web\Controller;

class AddressController extends Controller
{
    public $layout = 'address';

    public function actionAdd()
    {
        $model = new Address();
        $addresss = Address::find()->all();
        $request = \Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            $model->province = $_POST['province'];
            $model->city = $_POST['city'];
            $model->area = $_POST['area'];
            $model->save();
            if($model->validate()){
                if($model->flag){
                    $status1 = Address::find()->where(['flag'=>1])->all();

                    foreach($status1 as $status){
                        $status->flag = 0;
                        $status->update();
                    }
                    $model->flag = 1;
                }
                $model->member_id = \Yii::$app->user->id;
                $model->save();
                \Yii::$app->session->setFlash('success','添加地址成功');
                return $this->refresh();
            }
        }
        return $this->render('address',['model'=>$model,'addresss'=>$addresss]);
    }

    public function actionEdit($id)
    {
        $model = Address::findOne(['id'=>$id]);
        $addresss = Address::find()->all();
        $request = \Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            $model->province = $_POST['province'];
            $model->city = $_POST['city'];
            $model->area = $_POST['area'];
            $model->save();
            if($model->validate()){
                if($model->flag){
                    $status1 = Address::find()->where(['flag'=>1])->all();

                    foreach($status1 as $status){
                        $status->flag = 0;
                        $status->update();
                    }
                    $model->flag = 1;
                }
                $model->member_id = \Yii::$app->user->id;
                $model->save();
                \Yii::$app->session->setFlash('success','添加地址成功');
                return $this->refresh();
            }
        }
        return $this->render('address',['model'=>$model,'addresss'=>$addresss]);
    }

    public function actionDelete($id)
    {
        $model = Address::findOne(['id'=>$id]);
        $model->delete();
        \Yii::$app->session->setFlash('success','删除地址成功');
        return $this->redirect(['address/add']);
    }

    public function actionCheck($id)
    {
        $model = Address::findOne(['id'=>$id]);
        $status1 = Address::find()->where(['flag'=>1])->all();

        foreach($status1 as $status){
            $status->flag = 0;
            $status->update();
        }
        $model->flag = 1;
        $model->save();
        \Yii::$app->session->setFlash('success','设置默认地址成功');
        return $this->redirect(['address/add']);
    }
}