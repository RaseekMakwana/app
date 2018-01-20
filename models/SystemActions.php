<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "system_actions".
 *
 * @property integer $id
 * @property integer $controller_id
 * @property string $action_name
 * @property string $status
 *
 * @property SystemControllers $controller
 */
class SystemActions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'system_actions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['controller_id', 'action_name'], 'required'],
            [['controller_id'], 'integer'],
            [['status'], 'string'],
            [['action_name'], 'string', 'max' => 250],
            [['controller_id'], 'exist', 'skipOnError' => true, 'targetClass' => SystemControllers::className(), 'targetAttribute' => ['controller_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'controller_id' => Yii::t('app', 'Controller ID'),
            'action_name' => Yii::t('app', 'Action Name'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getController()
    {
        return $this->hasOne(SystemControllers::className(), ['id' => 'controller_id']);
    }
}
