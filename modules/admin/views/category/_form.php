<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Language;

/* @var $this yii\web\View */
/* @var $model app\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category_name')->textInput(['maxlength' => true]) ?>

    <?php $data = ArrayHelper::map(Language::find()->all(), 'id', 'language'); ?>
    <?= $form->field($model, 'language_id')->dropDownList($data, ['prompt' => '-- Select Language --']) ?>

    <?php /* $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <?= $form->field($model, 'created_date')->textInput() ?>

    <?= $form->field($model, 'updated_date')->textInput() */ ?>

    <?= $form->field($model, 'status')->dropDownList([ 'Y' => 'Y', 'N' => 'N', ], ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
