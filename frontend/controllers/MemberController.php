<?php

namespace frontend\controllers;


use backend\models\LoginForm;
use frontend\models\Member;



class MemberController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;
    public $layout = 'login';
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionRegister()
    {
        $model = new Member();
        if($model->load(\Yii::$app->request->post())&& $model->validate()){
            $password = \Yii::$app->security->generatePasswordHash($model->password);
            $model->auth_key=\Yii::$app->security->generateRandomString();
            $model->password=$password;
            $model->last_login_time=time();
            $model->last_login_ip=ip2long($_SERVER["REMOTE_ADDR"]);
            $model->addtime = time();
            $model->save(false);
            return $this->redirect(['member/index']);
        }
        return $this->render('register',['model'=>$model]);
    }
    public function actionLogin()
    {
        $model = new LoginForm();
        $request = \Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            if($model->login()){
                $admins = Member::findOne(['username'=>$model->username]);
                $admins->last_login_time=time();
                $admins->last_login_ip=ip2long($_SERVER['REMOTE_ADDR']);
                $admins->save(false);
                \Yii::$app->session->setFlash('success','登录成功');
                return $this->redirect(['member/index']);
            }
        }
        return $this->render('login',['model'=>$model]);
    }

    public function actionMscode(){
        $tel = \Yii::$app->request->post('tel');
        $code=rand(1000,9999);
        \Yii::$app->session->set('tel_'.$tel,$code);
        $model = new Member();
        $model->Sendcode($tel,$code);
    }

}
