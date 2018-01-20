<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "share_app".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $image
 * @property string $created_date
 */
class ShareApp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'share_app';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_date'], 'safe'],
            [['title', 'description', 'image'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'image' => Yii::t('app', 'Image'),
            'created_date' => Yii::t('app', 'Created Date'),
        ];
    }
}
