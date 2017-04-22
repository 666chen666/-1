<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/18 0018
 * Time: 下午 2:07
 */

namespace frontend\controllers;


use frontend\models\Member;
use yii\web\Controller;

class ApiController extends Controller
{
    public function actionLogin(){
        $username = $_GET['username'];
        $pwd = $_GET['pwd'];
        $member = Member::findOne(['username'=>$username]);
        if($member){
            if(\Yii::$app->security->validatePassword($pwd,$member->password)){
                \Yii::$app->user->login($member);
            }
        }
    }
}