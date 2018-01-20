<?php

namespace app\controllers;

class SharemasterController extends \yii\web\Controller
{
    public function actionIndex($id)
    {
        p($id);
        return $this->render('index');
    }

}
