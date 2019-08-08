<?php
namespace frontend\controllers;


use frontend\models\TpUsers;
use yii\web\Controller;

class HelloController extends Controller{

    public function actionIndex(){
        $info=TpUsers::find()->all();
        var_dump($info);die;
        echo "hello yii!";
    }

    public function actionLogin(){
        $info=[];
        $info['name']='lichao';
        return $this->renderPartial('/hello/index',$info);
    }

    public function actionLoginhandle(){
        echo 11;
    }
}