<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\UserRoles

/* @var $this yii\web\View */
/* @var $model app\models\Admin */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="admin-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php 
    $user_roles = \app\models\UserRoles::find()->all();
    ?>

    <?= $form->field($model, 'user_type')->dropDownList(ArrayHelper::map($user_roles, 'id', 'user_role'), ['prompt' => 'Select User Type', 'disabled' => !$model->isNewRecord]) ?>


    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'confirm_password')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'profile_picture')->fileInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address1')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'address2')->textarea(['rows' => 6]) ?>

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
