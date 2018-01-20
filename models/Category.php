<?php

namespace app\models;

use Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property string $category_name
 * @property integer $language_id
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $created_date
 * @property string $updated_date
 * @property string $status
 *
 * @property Language $language
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_name', 'language_id'], 'required'],
            [['language_id', 'created_by', 'updated_by'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['status'], 'string'],
            [['category_name'], 'string', 'max' => 255],
            [['language_id'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['language_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'category_name' => Yii::t('app', 'Category Name'),
            'language_id' => Yii::t('app', 'Language'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'created_date' => Yii::t('app', 'Created Date'),
            'updated_date' => Yii::t('app', 'Updated Date'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'language_id']);
    }
    
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
