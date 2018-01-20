<?php

namespace app\controllers;

use app\models\Post;

class PagesController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $model = Post::find()->all();
        return $this->render('index',[
            'posts' => $model
        ]);
    }

}
