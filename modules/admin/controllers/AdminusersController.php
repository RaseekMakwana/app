<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Admin;
use app\models\AdminSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\IdentityInterface;

/**
 * AdminusersController implements the CRUD actions for Admin model.
 */
class AdminusersController extends Controller {
    /*
     * controller initialization 
     */

    public function init() {
        //check user logged in or not
        $cur_user_id = Yii::$app->common->get_current_user_data_by_field('id');
        if (empty($cur_user_id)) {
            return $this->redirect(Yii::$app->urlManager->createUrl('admin/default/index'));
        } else {
            \Yii::$app->common->setLoginSessionData();
        }
    }

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
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    // allow authenticated users
                    [
                        'allow' => true,
                        //'actions' => ['@'],
                        'roles' => ['@'],
                        'denyCallback' => function ($rule, $action) {
                    return $this->redirect(Yii::$app->urlManager->createUrl('admin/default/index'));
                },
                    ],
                    // deny all guest users
                    [
                        'allow' => false,
                        //'actions' => ['@'],
                        'roles' => ['?'],
                        'denyCallback' => function ($rule, $action) {
                    return $this->redirect(Yii::$app->urlManager->createUrl('admin/default/index'));
                },
                    ]
                ],
            ],
        ];
    }

    /**
     * Lists all Admin models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new AdminSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Admin model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Admin model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Admin();
        $model->scenario = 'insert';
        if ($model->load(Yii::$app->request->post())) {
            if (!empty($_FILES['Admin']['name']['profile_picture'])) {
                $image = UploadedFile::getInstance($model, 'profile_picture');
                $extension = end((explode(".", $image->name)));
                $new_image_name = Yii::$app->security->generateRandomString() . ".{$extension}";

                $original_path = PROFILE_PICTURE_ORIGINAL . $new_image_name;
                $thumb_path = PROFILE_PICTURE_THUMBNAIL . $new_image_name;

                $upload_pic = $image->saveAs($original_path);
                if (file_exists($original_path)) {
                    $model->profile_picture = $new_image_name;
                    Image::thumbnail($original_path, THUMB_IMAGE_WIDTH, THUMB_IMAGE_HEIGHT)
                            ->save($thumb_path, ['quality' => 100]);
                }
            }
            if ($model->validate()) {
                $model->password = md5($model->password);
                $model->confirm_password = md5($model->confirm_password);
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }//#print_r($model->getErrors());
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Admin model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Admin model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Admin model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Admin the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Admin::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
