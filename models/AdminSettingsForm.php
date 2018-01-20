<?php
namespace app\models;
use Yii;
use yii\base\Model;
use yii\web\Controller;
use app\models\SystemControllers;
use yii\web\Session;

use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * LoginForm is the model behind the login form.
 */
class AdminSettingsForm extends Model
{   
    public $compnay_name;
    public $address;
    public $phone;
    public $email;
    public function rules() {
         return [
             [['compnay_name','address','phone','email'],'required'],
             [['email'],'email'],
             [['phone'],'integer'],
             [['compnay_name', 'email'], 'string', 'max' => 250],
             [['address'], 'string', 'max' => 1000],
             [['phone'], 'string', 'max' => 50]
         ];
     }
    
     /*
     * behaviors
     */
    public function behaviors()
    {
            return [
                [
                    'class' => TimestampBehavior::className(),
                    'createdAtAttribute' => 'created_date',
                    'updatedAtAttribute' => 'updated_date',
                    'value' => new Expression('NOW()'),
                ],
                [
                    'class' => BlameableBehavior::className(),
                    'createdByAttribute' => 'created_by',
                    'updatedByAttribute' => 'updated_by',
                ],
            ];
    }
}
