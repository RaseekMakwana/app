<?php

namespace app\models;

use Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "language".
 *
 * @property integer $id
 * @property string $language
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $created_date
 * @property string $upated_date
 * @property string $status
 *
 * @property Category[] $categories
 * @property Post[] $posts
 */
class Language extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'language';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['language'], 'required'],
            [['created_by', 'updated_by'], 'integer'],
            [['created_date', 'upated_date'], 'safe'],
            [['status'], 'string'],
            [['language'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'language' => Yii::t('app', 'Language'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'created_date' => Yii::t('app', 'Created Date'),
            'upated_date' => Yii::t('app', 'Upated Date'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['language_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['language_id' => 'id']);
    }
    
    public function behaviors()
    {
            return [
                [
                    'class' => TimestampBehavior::className(),
                    'createdAtAttribute' => 'created_date',
                    'updatedAtAttribute' => 'upated_date',
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
