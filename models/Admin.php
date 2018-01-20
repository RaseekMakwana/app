<?php

namespace app\models;

use Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\web\IdentityInterface;
use app\models\Admin as DbUser;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "admin".
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
class Admin extends ActiveRecord implements IdentityInterface
{
   public $confirm_password;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_type', 'first_name', 'last_name', 'username', 'email', 'password', 'phone',], 'required'],
            
            [['password', 'confirm_password'], 'required', 'on' => 'insert'],

            [['user_type', 'created_by', 'updated_by'], 'integer'],
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
            'id' => Yii::t('app', 'ID'),
            'user_type' => Yii::t('app', 'User Type'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'username' => Yii::t('app', 'Username'),
            'email' => Yii::t('app', 'Email'),
            'password' => Yii::t('app', 'Password'),
            'phone' => Yii::t('app', 'Phone'),
            'profile_picture' => Yii::t('app', 'Profile Picture'),
            'address1' => Yii::t('app', 'Address1'),
            'address2' => Yii::t('app', 'Address2'),
            'created_date' => Yii::t('app', 'Created Date'),
            'updated_date' => Yii::t('app', 'Updated Date'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'status' => Yii::t('app', 'Status'),
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
                ->where(["accessToken" => $token])
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
                    "username" => $username
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
