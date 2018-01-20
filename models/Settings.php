<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "settings".
 *
 * @property integer $id
 * @property string $name
 * @property string $value
 * @property integer $created_by
 * @property string $created_date
 * @property integer $updated_by
 * @property string $updated_date
 * @property string $status
 */
class Settings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'settings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['value', 'status'], 'string'],
            [['created_by', 'updated_by'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['name'], 'string', 'max' => 250],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'value' => Yii::t('app', 'Value'),
            'created_by' => Yii::t('app', 'Created By'),
            'created_date' => Yii::t('app', 'Created Date'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'updated_date' => Yii::t('app', 'Updated Date'),
            'status' => Yii::t('app', 'Status'),
        ];
    }
}
