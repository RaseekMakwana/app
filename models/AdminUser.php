<?php

namespace app\models;

use app\models\Admin as DbUser;
use yii\web\IdentityInterface;

class AdminUser extends \yii\base\Object implements \yii\web\IdentityInterface {

    public $id;
    public $user_type;
    public $first_name;
    public $last_name;
    public $username;
    public $email;
    public $password;
    public $phone;
    public $profile_picture;
    public $address1;
    public $address2;
    public $created_date;
    public $updated_date;
    public $created_by;
    public $updated_by;    
    public $status;
    public $authKey;
    public $accessToken;
    

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
