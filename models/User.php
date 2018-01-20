<?php

namespace app\models;

use app\models\Users as DbUser;

class User extends \yii\base\Object implements \yii\web\IdentityInterface
{
    public $id;
    public $user_type;
    public $first_name;
    public $last_name;
    public $email;
    public $password;
    public $phone;
    public $mobile;
    public $image_name;
    public $address;
    public $city;
    public $state;
    public $zipcode;
    public $authKey;
    public $accessToken;
    public $facebook_id;
    public $google_plus_id;
    public $is_facebook_logged_in;
    public $is_google_plus_logged_in;
    public $possword_token;
    public $dropbox_access_token;
    public $created_by;
    public $created_date;
    public $updated_by;
    public $updated_date;
    public $status;    

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
                    "email" => $username,
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
