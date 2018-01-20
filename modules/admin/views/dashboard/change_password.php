<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use app\models\Users;
use yii\web\Response;
$this->title = 'Change Password';
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="content-header">
    <h1><?= Html::encode($this->title) ?></h1>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-xs-12">
            <?php echo Yii::$app->common->get_flash_message('error',Yii::$app->session->getFlash('error')); ?>
            <?php echo Yii::$app->common->get_flash_message('success',Yii::$app->session->getFlash('success')); ?>
            <div class="box box-primary">
                <div class="box-header with-border">
                    &nbsp;
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                    
                    <div class="box-body">
                        <?php                      
                            $form = ActiveForm::begin(['enableAjaxValidation' => FALSE,
                            'enableClientValidation' => true, 
                            'options' => ['enctype' => 'multipart/form-data', 'id' => 'change_password']]); 
                        ?>
                        <div class="form-group">
                             <?= $form->field($model, 'current_password')->passwordInput(['placeholder' => 'Current password'])->label('Current password'); ?>
                        </div>
                        <div class="form-group">
                             <?= $form->field($model, 'new_password')->passwordInput(['placeholder' => 'New password'])->label('New password'); ?>
                        </div>
                        <div class="form-group">
                            <?= $form->field($model, 'repeat_password')->passwordInput(['placeholder' => 'Repeat password'])->label('Repeat password'); ?>   
                        </div>
                        <div class="box-footer">
                            <div class="form-group">
                                <?= Html::submitButton('Save', ['class' => 'btn btn-primary', 'name' => 'changepassword-button']) ?>
                            </div>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?> 
                </div>
            </div>
        </div><!-- /.box -->
    </div>
</section>

