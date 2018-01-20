<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\AdminChangePasswordForm;
use app\models\AdminSettingsForm;
use app\models\Users;
use app\models\User;
use app\models\Admin;
use app\models\Settings;
use yii\bootstrap\ActiveForm;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\helpers\Url;
use yii\imagine\Image;
use yii\db\Query;
use yii\web\IdentityInterface;

class DashboardController extends \yii\web\Controller {
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

    /*
     * Description: Dashboard page
     */
    public function actionIndex() {
        $this->layout = 'main';
        return $this->render('index');
    }

    /*
     * Description: You can change password
     * Output: You have to provide you passward for validation
     */
    public function actionChange_password() {
        $model = new AdminChangePasswordForm();
        if (Yii::$app->request->isPost) {
            $model->attributes = $_POST['AdminChangePasswordForm'];
            $validate = ActiveForm::validate($model);
            if (empty($validate)) {
                $user_id = Yii::$app->user->identity->id;
                $user_data = \app\models\Admin::findOne($user_id);
                $new_pass = md5($_POST['AdminChangePasswordForm']['new_password']);
                $user_data->password = $new_pass;
                if ($user_data->save(false)) {
                    \Yii::$app->getSession()->setFlash('success', "Password has been changed successfully.");
                    $this->redirect(\Yii::$app->getUrlManager()->createUrl('admin/dashboard/change_password'));
                    Yii::$app->end();
                } else {
                    \Yii::$app->getSession()->setFlash('error', "Password is not changed, Please try again.!");
                    $this->redirect(\Yii::$app->getUrlManager()->createUrl('admin/dashboard/change_password/'));
                    Yii::$app->end();
                }
            } else {
                \Yii::$app->getSession()->setFlash('error', "Password is not changed, Please try again.!");
                if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ActiveForm::validate($model);
                }
            }
            return $this->render('change_password', ['model' => $model,]);
        } else {
            return $this->render('change_password', [
                        'model' => $model,
            ]);
        }
    }
    
    /*
     * Description: To update profile of logged user
     * Output: You can update profile
     */
    public function actionProfile() {
        $current_user_id = \Yii::$app->common->get_current_user_data_by_field('id');
        $model = new \app\models\Admin();
        $model = Admin::findOne($current_user_id);
        $pre_profile_picture = $model->profile_picture;
        if (Yii::$app->request->isPost) {
            if (empty($validate)) {
                foreach ($_POST['Admin'] as $key => $val) {
                    if (!empty($_POST['Admin'][$key])) {
                        $model->$key = $_POST['Admin'][$key];
                    }
                }
                $profile_pic = $_FILES['Admin']['name']['profile_picture'];
                if (!empty($profile_pic)) {
                    $image = UploadedFile::getInstance($model, 'profile_picture');

                    $extension = end((explode(".", $image->name)));
                    $new_image_name = Yii::$app->security->generateRandomString() . ".{$extension}";

                    $original_path = PROFILE_PICTURE_ORIGINAL . $new_image_name;
                    $thumb_path = PROFILE_PICTURE_THUMBNAIL . $new_image_name;

                    $upload_pic = $image->saveAs($original_path);
                    if (file_exists($original_path)) {
                        $model->profile_picture = $new_image_name;
                        //Start: For delete previous image
                        if (!empty($pre_profile_picture) && file_exists(PROFILE_PICTURE_ORIGINAL . $pre_profile_picture)) {
                            unlink(PROFILE_PICTURE_ORIGINAL . $pre_profile_picture);
                        }
                        //#unlink(PROFILE_PICTURE_ORIGINAL.$pre_profile_picture);
                        if (!empty($pre_profile_picture) && file_exists(PROFILE_PICTURE_THUMBNAIL . $pre_profile_picture)) {
                            unlink(PROFILE_PICTURE_THUMBNAIL . $pre_profile_picture);
                        }
                        //End: For delete previous image                        
                        Image::thumbnail($original_path, THUMB_IMAGE_WIDTH, THUMB_IMAGE_HEIGHT)
                                ->save($thumb_path, ['quality' => 100]);
                    } else {
                        $model->profile_picture = $pre_profile_picture;
                    }
                }
                if ($model->save(False)) {
                    \Yii::$app->getSession()->setFlash('success', "Profile has been update successfully.");
                    $this->redirect(\Yii::$app->getUrlManager()->createUrl('admin/dashboard/profile/'));
                    Yii::$app->end();
                } else {
                    \Yii::$app->getSession()->setFlash('error', "Profile not updated.");
                    $this->redirect(\Yii::$app->getUrlManager()->createUrl('admin/dashboard/profile/'));
                    Yii::$app->end();
                }
            } else {
                if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ActiveForm::validate($model);
                }
            }
        } else {
            return $this->render('profile', [
                        'model' => $model,
            ]);
        }
    }

    /*
     * Description: By this action you can change settings of the site.
     * Output: You can update settings of the site
     */
    public function actionSettings() {
        $model = new AdminSettingsForm();
        $settings_models = Settings::find()
                ->where('status = :status', [':status' => 'Y'])
                ->all();
        foreach ($settings_models as $key_sm => $val_sm) {
            $field_name = $val_sm->name;
            $model->$field_name = $val_sm->value;
        }

        if ($model->load(Yii::$app->request->post())) {
            if (!empty($model->attributes)) {
                foreach ($_POST['AdminSettingsForm'] as $key_ma => $val_ma) {
                    $settings_model = Settings::find()
                            ->where('name = :name', [':name' => $key_ma])
                            ->one();
                    if (empty($settings_model)) {
                        $settings_model = new Settings;
                        $settings_model->id = null;
                        $settings_model->isNewRecord = true;
                    }
                    $settings_model->name = $key_ma;
                    $settings_model->value = $val_ma;
                    $settings_model->save();
                    \Yii::$app->getSession()->setFlash('success', "Settings successfully updated.");
                    $this->redirect('settings');
                }
            }
        } else {
            return $this->render('settings', [
                        'model' => $model,
            ]);
        }
    }

}
