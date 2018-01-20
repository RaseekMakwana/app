<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UserRoles */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-roles-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_role')->textInput(['maxlength' => true]) ?>

    <?php /* ?>
     
    <?= $form->field($model, 'created_date')->textInput() ?>

    <?= $form->field($model, 'updated_date')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?> 
    
    <?php */ ?>

    <?= $form->field($model, 'status')->dropDownList([ 'Y' => 'Active', 'N' => 'Inactive',], []) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
