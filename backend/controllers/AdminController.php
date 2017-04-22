<?php

namespace backend\controllers;

use backend\models\Admin;
use backend\models\LoginForm;
use yii\helpers\ArrayHelper;
use yii\web\Request;

class AdminController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $admins = Admin::find()->all();
        return $this->render('index',['admins'=>$admins]);
    }

    public function actionAdd(){
        $model = new Admin();
        $request = new Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $password = \Yii::$app->security->generatePasswordHash($model->password);
                $model->password=$password;
                $model->last_login_ip=$_SERVER["REMOTE_ADDR"];
                $model->add_time=time();
                $res = $model->save(false);
                $authManager = \Yii::$app->authManager;
                foreach($model->roles as $role){
                    $role = $authManager->getRole($role);
                    $authManager->assign($role,$model->id);
                }
                if($res){
                    \Yii::$app->user->login($model);
                    return $this->redirect(['admin/index']);
                }

            }
        }
        return $this->render('add',['model'=>$model]);
    }

    public function actionEdit($id){
        $model = Admin::findOne(['id'=>$id]);
        $request = new Request();
        $authManager = \Yii::$app->authManager;
        $role = $authManager->getRolesByUser($id);
        $model->roles=ArrayHelper::map($role,'name','name');
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $password = \Yii::$app->security->generatePasswordHash($model->password);
                $model->password=$password;
                $model->last_login_ip=$_SERVER["REMOTE_ADDR"];
                $res = $model->save(false);

                $authManager->revokeAll($id);
                foreach($model->roles as $role){
                    $role = $authManager->getRole($role);
                    $authManager->assign($role,$model->id);
                }
                if($res){
                    \Yii::$app->user->login($model);
                    return $this->redirect(['admin/index']);
                }

            }
        }
        return $this->render('add',['model'=>$model]);
    }
    public function actionDel($id){
        $model = Admin::findOne(['id'=>$id]);
        $model->delete();
        return $this->redirect(['admin/index']);
    }

    public function actionLogin()
    {
        $model = new LoginForm();
        $request = \Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            if($model->login()){
                $admins = Admin::findOne(['username'=>$model->username]);
                $admins->last_login_time=time();
                $admins->last_login_ip=$_SERVER['REMOTE_ADDR'];
                $admins->save(false);
                \Yii::$app->session->setFlash('success','登录成功');
                return $this->redirect(['admin/index']);
            }
        }
        return $this->render('login',['model'=>$model]);
    }

    public function actionLogout(){
        \Yii::$app->user->logout();
        \Yii::$app->session->setFlash('success','注销成功');
        return $this->redirect(['admin/login']);
    }

}
