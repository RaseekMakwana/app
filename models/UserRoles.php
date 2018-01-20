<?php

namespace app\models;

use Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "user_roles".
 *
 * @property integer $id
 * @property string $user_role
 * @property string $created_date
 * @property string $updated_date
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $status
 *
 * @property SystemRoleBasePermission[] $systemRoleBasePermissions
 * @property Users[] $users
 */
class UserRoles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_roles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_role'], 'required'],
            [['user_role'], 'unique'],
            [['created_date', 'updated_date', 'created_by', 'updated_by'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['status'], 'string'],
            [['user_role'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_role' => 'User Role',
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
    public function getSystemRoleBasePermissions()
    {
        return $this->hasMany(SystemRoleBasePermission::className(), ['role_id' => 'id']);
    }
    
    public function getAdminusers()
    {
        return $this->hasMany(Admin::className(), ['user_type' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(Users::className(), ['user_type' => 'id']);
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
