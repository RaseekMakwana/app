<?php
namespace app\models;
use Yii;
use yii\base\Model;
use yii\web\Controller;
use app\models\SystemControllers;
/**
 * LoginForm is the model behind the login form.
 */
class AdminForgotPasswordForm extends Model
{
    
    public $email;
    private $_user = false;

    /**
     * @return array the validation rules.
     */
    public function rules()
    { 
        return [
        
            [['email'], 'required'],
            [['email'], 'email'],
          
        ];      
       
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    
    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        
        if ($this->validate()) {
           
            $email = $_POST['LoginForm']['email'];
            $password = $_POST['LoginForm']['password'];
            $model = Users::find()
                     ->where(['email' => $email, 'password' => md5($password)])
                     ->asArray()
                     ->one();
             
            if($model['id'] > 0)
            {
                return $model['id'];
            }
            else
            {
                return 0;
            }            
        }
        return false;
    }
    public function login_from_model()
    {
        if ($this->validate()) {
            $user_model = $this->getUser();
            if (!empty($user_model)) {
                if ($user_model->password == $this->password) {
                    if ($user_model->status == 'Y') {
                        Yii::$app->user->login($user_model, $this->rememberMe ? 3600 * 24 * 30 : 0);
                        return true;
                    } else {
                        Yii::$app->getSession()->setFlash('message', ['error' => 'Your account is not active, please try again later. ']);
                    }
                } else {
                    Yii::$app->getSession()->setFlash('message', ['error' => 'Invalid password, please try again later.']);
                }
            } else {
                Yii::$app->getSession()->setFlash('message', ['error' => 'Username or password is invalid.']);
            }
        }
        return false;
    }
}
