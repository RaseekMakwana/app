<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "system_controllers".
 *
 * @property integer $id
 * @property string $controller_name
 * @property string $status
 *
 * @property SystemActions[] $systemActions
 */
class SystemControllers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'system_controllers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['controller_name'], 'required'],
            [['status'], 'string'],
            [['controller_name'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'controller_name' => Yii::t('app', 'Controller Name'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSystemActions()
    {
        return $this->hasMany(SystemActions::className(), ['controller_id' => 'id']);
    }
}
