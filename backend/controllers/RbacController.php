<?php

namespace backend\controllers;

use backend\models\PermissionForm;
use backend\models\RoleForm;

class RbacController extends \yii\web\Controller
{
    public function actionPermissionIndex()
    {
        $authManager= \Yii::$app->authManager;
        $permissions=$authManager->getPermissions();
        return $this->render('permissionIndex',['permissions'=>$permissions]);
    }

    public function actionAddPermission(){
        $model= new PermissionForm();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            $authManager = \Yii::$app->authManager;
            $permission = $authManager->createPermission($model->name);
            $permission->description = $model->description;
            $authManager->add($permission);
            \Yii::$app->session->setFlash('success','权限添加成功');
            return $this->redirect(['rbac/permission-index']);
        }
        return $this->render('addPermission',['model'=>$model]);
    }

    public function actionDelPermission($name){
        $authManager = \Yii::$app->authManager;
        $permission = $authManager->getPermission($name);
        $authManager->remove($permission);
        return $this->redirect(['rbac/permission-index']);
    }

    public function actionRoleIndex(){
        $authManager = \Yii::$app->authManager;
        $roles = $authManager->getRoles();
        return $this->render('roleIndex',['roles'=>$roles]);
    }

    public function actionRoleAdd(){
        $model = new RoleForm();
        $model->scenario = RoleForm::SCENARIO_ADD;
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            $authManager = \Yii::$app->authManager;
            $role = $authManager->createRole($model->name);
            $role->description=$model->description;
            $authManager->add($role);
            foreach($model->permissions as $permission){
                $authManager->addChild($role,$authManager->getPermission($permission));
            }
            \Yii::$app->session->setFlash('success',$role->name.' 角色添加成功');
            return $this->redirect(['rbac/role-index']);
        }
        return $this->render('addRole',['model'=>$model]);
    }

    public function actionEditRole($name)
    {
        $model = new RoleForm();
        $authManager = \Yii::$app->authManager;
        //获取要修改的角色
        $role = $authManager->getRole($name);
        $model->name= $role->name;
        $model->description = $role->description;
        $permissions = $authManager->getPermissionsByRole($role->name);

        $model->permissions = array_keys($permissions);

        if($model->load(\Yii::$app->request->post()) && $model->validate()){

            //$role->name = $model->name;
            $role->description = $model->description;
            $authManager->update($role->name,$role);//更新到数据表
            //给角色关联权限
            //先清除之前关联的所有权限
            $authManager->removeChildren($role);
            foreach($model->permissions as $permission){
                $authManager->addChild($role,$authManager->getPermission($permission));
            }
            \Yii::$app->session->setFlash('success',$role->name.' 角色更新成功');
            return $this->redirect(['rbac/role-index']);
        }
        return $this->render('addRole',['model'=>$model]);
    }

    public function actionDelRole($name)
    {
        $role = \Yii::$app->authManager->getRole($name);

        \Yii::$app->authManager->remove($role);
    }
}
