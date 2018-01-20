<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\AdminUser;
use app\models\AdminLoginForm;
use app\models\AdminForgotPasswordForm;
use app\models\Admin;
use yii\bootstrap\ActiveForm;
use yii\web\Response;
use yii\helpers\Url;
use yii\web\IdentityInterface;

class DefaultController extends Controller {

    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /*
     * Description: contains login functinality
     * Input: Username,password,
     */

    public function actionIndex() {
        if (!\Yii::$app->user->isGuest) {
            return $this->redirect(Url::toRoute(['dashboard/index']));
        } else {
            $this->layout = 'main_login';
            $model = new AdminLoginForm();
            //Start: Set remember me data
            $model->username = isset($_COOKIE[\Yii::$app->params['siteName'] . "_admin_username"]) ? $_COOKIE[\Yii::$app->params['siteName'] . "_admin_username"] : '';
            $model->password = isset($_COOKIE[\Yii::$app->params['siteName'] . "_admin_password"]) ? $_COOKIE[\Yii::$app->params['siteName'] . "_admin_password"] : '';
            //Ends: Set remember me data

            if ($model->load(Yii::$app->request->post()) && $model->login()) {
                //Start: save remember me in cookie
                if ($model->rememberMe == 1) {
                    setcookie(\Yii::$app->params['siteName'] . "_admin_username", $model->username, time() + 60 * 60 * 24 * 7, '/');
                    setcookie(\Yii::$app->params['siteName'] . "_admin_password", $model->password, time() + 60 * 60 * 24 * 7, '/');
                } else {
                    setcookie(\Yii::$app->params['siteName'] . "_admin_username", false, time() - 60 * 100000, '/');
                    setcookie(\Yii::$app->params['siteName'] . "_admin_password", false, time() - 60 * 100000, '/');
                }
                //End: save remember me in cookie  
                /*
                  if(!empty(Yii::$app->user->identity->id)) {
                  $model_reference = Admin::find()->where("user_id = '" . Yii::$app->user->identity->id . "'")->one();
                  $session = Yii::$app->session;
                  $session['user_id'] = Yii::$app->user->identity->id;
                  $session['user_type'] = Yii::$app->user->identity->user_type;
                  $session['first_name'] = !empty($model_reference->first_name)?$model_reference->first_name:0;
                  } else {
                  $session = Yii::$app->session;
                  $session['user_id'] = 0;
                  $session['user_type'] = 0;
                  $session['reference_id'] = 0;
                  }
                 */
                Yii::$app->common->setLoginSessionData();

                return $this->redirect(Url::toRoute(['dashboard/index']));
            }
            return $this->render('login', [
                        'model' => $model,
            ]);
        }
    }

    /*
     * Description: Used for user log out.
     */
    public function actionLogout() {
        Yii::$app->user->logout();

        //Remove session variables
        $session = Yii::$app->session;
        $session->remove('user_id');
        $session->remove('user_type');
        $session->remove('current_user_role_base_permissions');

        return $this->redirect(Url::toRoute(['default/index']));
    }
    
    /*
     * Description: To change password and send it in email.
     */
    public function actionForgotpassword() {
        $this->layout = 'main_login';
        $model = new AdminForgotPasswordForm();
        if (Yii::$app->request->isPost) {
            $email = $_POST['AdminForgotPasswordForm']['email'];
            $model->attributes = $_POST['AdminForgotPasswordForm'];
            $user_model = Admin::find()
                    ->where(['email' => $email])
                    ->one();
            $validate = ActiveForm::validate($model);
            if (empty($validate)) {
                if (!empty($user_model)) {
                    $new_password = Yii::$app->common->generate_password();
                    $to_email = $user_model->email;
                    $from_email = Yii::$app->params['adminEmail'];
                    $from_name = Yii::$app->params['siteName'];
                    $subject = "Forgot Passwords";
                    $message = "";
                    $message .= "Hi " . $user_model->first_name . " " . $user_model->last_name . ",<br/><br/>";
                    $message .= "Below is your new password.<br/>";
                    $message .= "New Password: " . $new_password . "<br/><br/>";
                    $message .= "Thanks,<br/>Site Name.";
                    $mail = Yii::$app->common->sendMail($to_email, $from_email, $from_name, $subject, $message);
                    if ($mail) {
                        $user_model->password = md5($new_password);
                        $user_model->save(false);
                    }
                    \Yii::$app->getSession()->setFlash('success', "We have send account detail to your email.");
                    $this->redirect(\Yii::$app->getUrlManager()->createUrl('admin/default/forgotpassword'));
                } else {
                    \Yii::$app->getSession()->setFlash('error', "Wrong admin email you have entered.");
                    $this->redirect(\Yii::$app->getUrlManager()->createUrl('admin/default/forgotpassword'));
                }
                Yii::$app->end();
            } else {
                if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ActiveForm::validate($model);
                }
            }
        }
        return $this->render('forgot_password', ['model' => $model,]);
    }

}
