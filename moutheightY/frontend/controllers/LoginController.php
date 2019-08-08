<?php
namespace frontend\controllers;


use yii\web\Controller;

class LoginController extends Controller{
    public $layout = false;

    public function actionLogin(){
        return $this->render('/login/login');
    }

    public function actionRegister(){
        return $this->render('/login/register');
    }
}