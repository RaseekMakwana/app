<?php

namespace app\controllers;

use app\models\Post;
use app\models\ShareApp;

class CanvasController extends \yii\web\Controller {

    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
    
    public function actionApp($cover) {
        $model = Post::find()->where(['slug' => $cover])->one();
        return $this->render('_app_master_layout', [
                    'app_id' => $model->id,
                    'app_title' => $model->title,
                    'app_description' => $model->description,
                    'post_image' => $model->image
        ]);
    }

    public function actionHtml_generate() {
        $id = $_POST['appId'];

        switch ($id):
            case 23:
                echo $this->renderPartial('123456');
                break;
            case 24:
                echo $this->renderPartial('456789');
                break;
            case 25:
                echo $this->renderPartial('789123');
                break;
        endswitch;
    }

    public function actionCanvas_images_save() {
       
        $data = explode(";base64,", $_POST['base64']);
        $file_name = $_POST['file_name'];
                
        $share_model = new ShareApp();
        $share_model->title = $_POST['app_title'];
        $share_model->description = $_POST['app_description'];
        $share_model->image = $file_name;
        $share_model->save(false);
        
        $data = base64_decode($data[1]);
        file_put_contents(TEMP_PICTURE_ABS_SAVE  . $file_name, $data);
        echo json_encode($share_model->id);
    }
    
    public function actionLogin_status(){
        $session = Yii::$app->session;
        $session['login_status'] = $_POST['status'];
    }

}
