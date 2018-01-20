<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Post;
use app\models\PostSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
    
    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Post model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Post();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            
            $image_original = Yii::$app->security->generateRandomString() . ".jpg";
            
            if(isset($_FILES['Post']['name']['thumbnail_image']) && !empty($_FILES['Post']['name']['thumbnail_image'])){
                $image = UploadedFile::getInstance($model, 'thumbnail_image');
                $tmp = explode('.', $image->name);
                $extension = end($tmp);
                $path = Yii::$app->params['uploadPath'] = POSTS_PICTURE_ABS_THUMBNAIL . $image_original;
                $upload_pic = $image->saveAs($path);
            }
            
            if(isset($_FILES['Post']['name']['large_image']) && !empty($_FILES['Post']['name']['large_image'])){
                $image = UploadedFile::getInstance($model, 'large_image');
                $tmp = explode('.', $image->name);
                $extension = end($tmp);
                $path = Yii::$app->params['uploadPath'] = POSTS_PICTURE_ABS_ORIGINAL . $image_original;
                $upload_pic = $image->saveAs($path);
            }
            
            $model->image = $image_original;
            
            if($model->save(false)){
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
            
//            if(isset($_FILES['Post']['name']['large_image']) && !empty($_FILES['Post']['name']['large_image'])){
//                $image = UploadedFile::getInstance($model, 'large_image');
//                $tmp = explode('.', $image->name);
//                $extension = end($tmp);
//                $image_original = Yii::$app->security->generateRandomString() . ".{$extension}";
//                $path = Yii::$app->params['uploadPath'] = POSTS_PICTURE_ORIGINAL . $image_original;
//                $upload_pic = $image->saveAs($path);
//            }
            
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            
            
            $image_original = Yii::$app->security->generateRandomString() . ".jpg";
            
            if(isset($_FILES['Post']['name']['thumbnail_image']) && !empty($_FILES['Post']['name']['thumbnail_image'])){
                $image = UploadedFile::getInstance($model, 'thumbnail_image');
                $tmp = explode('.', $image->name);
                $extension = end($tmp);
                $path = Yii::$app->params['uploadPath'] = POSTS_PICTURE_ABS_THUMBNAIL . $image_original;
                $upload_pic = $image->saveAs($path);
            }
            
            if(isset($_FILES['Post']['name']['large_image']) && !empty($_FILES['Post']['name']['large_image'])){
                $image = UploadedFile::getInstance($model, 'large_image');
                $tmp = explode('.', $image->name);
                $extension = end($tmp);
                $path = Yii::$app->params['uploadPath'] = POSTS_PICTURE_ABS_ORIGINAL . $image_original;
                $upload_pic = $image->saveAs($path);
            }
            
            if(!empty($_FILES['Post']['name']['thumbnail_image']) || !empty($_FILES['Post']['name']['large_image'])){
                $model->image = $image_original;
            }else{
                
                $model->image = $model->image;
            }
            
            if($model->save(false)){
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                            'model' => $model,
                ]);
            }
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGetslug(){
       $text = $_POST['request'];
       
           // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        $check = Post::find()->where(['slug' => $text])->one();
        if(!empty($check)){
            $text = $text.'-2';
        } 

        return $text;
    }
}
