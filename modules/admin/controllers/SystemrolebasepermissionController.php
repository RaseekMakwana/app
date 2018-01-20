<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\SystemRoleBasePermission;
use app\models\SystemRoleBasePermissionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\IdentityInterface;

class SystemrolebasepermissionController extends Controller {
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
     * Lists all SystemRoleBasePermission models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new SystemRoleBasePermissionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SystemRoleBasePermission model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new SystemRoleBasePermission model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new SystemRoleBasePermission();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing SystemRoleBasePermission model.
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
     * Deletes an existing SystemRoleBasePermission model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the SystemRoleBasePermission model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SystemRoleBasePermission the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = SystemRoleBasePermission::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /*
     * Description: To get action combo 
     */
    public function actionGetactioncombo($id = '') {
        $combo = '<option value="">Select Action</option>';
        if (!empty($id)) {
            $model = SystemActions::find()->where("controller_id='" . $id . "'")->all();
            if (!empty($model)) {
                foreach ($model as $result) {
                    $combo .= '<option value="' . $result['id'] . '">' . $result['action_name'] . '</option>';
                }
            }
        }
        echo $combo;
        exit();
    }

}
