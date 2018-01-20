<?php
namespace app\models;
use Yii;
use yii\base\Model;
use yii\web\Controller;
use app\models\SystemControllers;
use app\models\Users;
use app\models\Login;
use yii\web\Session;
use app\models\Admin;
/**
 * LoginForm is the model behind the login form.
 */
class AdminChangePasswordForm extends Model
{
    
    public $current_password;
    public $new_password;
    public $repeat_password;

   
       public function rules(){
            return [
                [['current_password','new_password','repeat_password'],'required'],
                ['current_password','findPasswords'],
                ['repeat_password','compare','compareAttribute'=>'new_password'],
            ];
        }
        
        public function findPasswords($attribute, $params){
           $user_id = Yii::$app->common->get_current_user_data_by_field('id');
           $user_data = Admin::findOne(Yii::$app->user->identity->id);
           
           $old_pass = $user_data['password'];
           
           $curr_pass = md5($this->current_password);
          
           
            if($old_pass!=$curr_pass){
                $this->addError($attribute,'Old password is incorrect');
            }
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
    
    
}
