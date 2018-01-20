<?php

namespace app\models;

use Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use app\models\Users as DbUser;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property integer $user_type
 * @property string $first_name
 * @property string $last_name
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $phone
 * @property string $profile_picture
 * @property string $address1
 * @property string $address2
 * @property string $created_date
 * @property string $updated_date
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $status
 *
 * @property UserRoles $userType
 */
class Users extends ActiveRecord implements IdentityInterface
{
    public $confirm_password;
    public $authKey;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_type', 'first_name', 'last_name', 'username', 'email', 'password', 'phone'], 'required','on'=>'adminuser'],
            [['user_type', 'created_by', 'updated_by'], 'integer'],
            
            [['password', 'confirm_password'], 'required', 'on' => 'insert'],
            
            [['first_name', 'last_name', 'username', 'email', 'password', 'phone'], 'required','on' => 'register'],
            [['password', 'confirm_password'], 'required', 'on' => 'register'],
            ['confirm_password', 'compare', 'compareAttribute'=>'password', 'message'=>"Passwords don't match", 'on' => 'register' ],        
            ['email', 'email'],

            [['address1', 'address2', 'status'], 'string'],
            [['created_date', 'updated_date'], 'safe'],
            [['first_name', 'last_name'], 'string', 'max' => 150],
            [['username', 'email', 'profile_picture'], 'string', 'max' => 250],
            [['password'], 'string', 'max' => 32],
            [['phone'], 'string', 'max' => 20],
            [['user_type'], 'exist', 'skipOnError' => true, 'targetClass' => UserRoles::className(), 'targetAttribute' => ['user_type' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_type' => 'User Type',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'username' => 'Username',
            'email' => 'Email',
            'password' => 'Password',
            'phone' => 'Phone',
            'profile_picture' => 'Profile Picture',
            'address1' => 'Address1',
            'address2' => 'Address2',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserType()
    {
        return $this->hasOne(UserRoles::className(), ['id' => 'user_type']);
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
    /**
     * @inheritdoc
     */
    public static function findIdentity($id) {
        $dbUser = DbUser::find()
                ->where([
                    "id" => $id
                ])
                ->one();
        if (!count($dbUser)) {
            return null;
        }
        return new static($dbUser);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $userType = null) {

        $dbUser = DbUser::find()
                ->where(["token" => $token])
                ->one();
        if (!count($dbUser)) {
            return null;
        }
        return new static($dbUser);
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username) {
        $dbUser = DbUser::find()
                ->where([
                    "username" => $username,
                    "status" => "Y"
                ])
                ->one();
        if (!count($dbUser)) {
            return null;
        }
        return new static($dbUser);
    }

    /**
     * @inheritdoc
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey() {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey) {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password) {
        return $this->password === md5($password);
    }
}
