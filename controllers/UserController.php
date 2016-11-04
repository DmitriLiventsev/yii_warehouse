<?php

namespace app\controllers;

class UserController extends \yii\web\Controller
{
    public function actionAdd()
    {
        return $this->render('add');
    }

}
