<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "system_role_base_permission".
 *
 * @property integer $id
 * @property integer $role_id
 * @property integer $controller_id
 * @property integer $action_id
 * @property string $allow_all_actions
 * @property string $status
 */
class SystemRoleBasePermission extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'system_role_base_permission';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role_id', 'controller_id'], 'required'],
            [['role_id', 'controller_id', 'action_id'], 'integer'],
            [['allow_all_actions', 'status'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'role_id' => Yii::t('app', 'Role ID'),
            'controller_id' => Yii::t('app', 'Controller ID'),
            'action_id' => Yii::t('app', 'Action ID'),
            'allow_all_actions' => Yii::t('app', 'Allow All Actions'),
            'status' => Yii::t('app', 'Status'),
        ];
    }
     /**
     * @return \yii\db\ActiveQuery
     */
    public function getAction()
    {
        return $this->hasOne(SystemActions::className(), ['id' => 'action_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getController()
    {
        return $this->hasOne(SystemControllers::className(), ['id' => 'controller_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(UserRoles::className(), ['id' => 'role_id']);
    }
}
