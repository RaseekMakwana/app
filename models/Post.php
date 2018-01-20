<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "post".
 *
 * @property integer $id
 * @property integer $language_id
 * @property string $title
 * @property string $description
 * @property string $caption
 * @property string $image
 * @property integer $type
 * @property string $html_source
 * @property string $css_source
 * @property string $js_source
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $created_date
 * @property string $updated_date
 * @property string $status
 *
 * @property Language $language
 */
class Post extends \yii\db\ActiveRecord
{
    public $thumbnail_image;
    public $large_image;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['slug', 'title', 'type'], 'required'],
            [['description', 'html_source', 'css_source', 'js_source', 'status'], 'string'],
            [['created_date', 'updated_date'], 'safe'],
            [['title', 'caption'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'language_id' => Yii::t('app', 'Language'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'caption' => Yii::t('app', 'Caption'),
            'image' => Yii::t('app', 'Image'),
            'type' => Yii::t('app', 'Type'),
            'html_source' => Yii::t('app', 'Html Source'),
            'css_source' => Yii::t('app', 'Css Source'),
            'js_source' => Yii::t('app', 'Js Source'),
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
}
