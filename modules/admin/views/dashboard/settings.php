<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use app\models\Settings;
use yii\web\Response;
$this->title = 'Settings';
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
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                    
                    <div class="box-body">
                        <?php                      
                            $form = ActiveForm::begin([
                                'enableAjaxValidation' => FALSE,
                                'enableClientValidation' => TRUE, 
                                'options' => ['enctype' => 'multipart/form-data', 'id' => 'settings-form']
                            ]);
                        ?>
          
                        <div class="form-group">
                             <?= $form->field($model, 'compnay_name')->textInput()->label('Company Name'); ?>
                        </div>
                        <div class="form-group">
                            <?= $form->field($model, 'address')->textArea()->label('Address'); ?>   
                        </div>
                        <div class="form-group">
                             <?= $form->field($model, 'phone')->textInput()->label('Phone'); ?>
                        </div>
                        <div class="form-group">
                            <?= $form->field($model, 'email')->textInput()->label('Email'); ?>   
                        </div>
                       
                        <div class="box-footer">
                            <div class="form-group">
                                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'changepassword-button']) ?>
                            </div>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?> 
                </div>
            </div>
        </div><!-- /.box -->
    </div>
</section>
