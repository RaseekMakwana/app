<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use app\models\Users;
use yii\web\Response;
use yii\web\UploadedFile;
?>
<section class="content-header">
    <h1>
      <?php echo 'Update Profile' ?>
    </h1>

</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <?php echo Yii::$app->common->get_flash_message('error',Yii::$app->session->getFlash('error')); ?>
            <?php echo Yii::$app->common->get_flash_message('success',Yii::$app->session->getFlash('success')); ?>
            <div class="box box-primary">
                <div class="box-header">
                    &nbsp;
                </div>
                <div class="box-body table-responsive">
                 
                 <?php $form = ActiveForm::begin(['enableAjaxValidation' => FALSE,
                     'enableClientValidation' => FALSE, 
                     'options' => ['enctype' => 'multipart/form-data']]); 
                 
                 ?>
                    
               
                <div class="box-body">
                    
                    
                    <div class="form-group">
                        <?= $form->field($model, 'first_name')->textInput(
                            ['placeholder' => 'First name', 
                            'maxlength' => 32])->label('First name') ?>
                    </div>
                    
                    <div class="form-group">
                        <?= $form->field($model, 'last_name')->textInput(
                            ['placeholder' => 'Last name', 
                            'maxlength' => 32])->label('Last name') ?>
                    </div>
                    
                    <div class="form-group">
                        <?= $form->field($model, 'profile_picture')->fileInput()
                         ->label('Profile picture') ?>
                    </div>
                    <div class="form-group">
                        <?php
                            if (!empty($model->profile_picture)) {
                              $profile_img_path = SITE_ABS_UPLOAD_PATH . 'profile_pictures/thumbnails/' . $model->profile_picture;
                            } else {
                              $profile_img_path = Yii::$app->request->baseUrl."/web/images/admin/avatar_male.png";
                            }
                        ?>
                        <img src="<?php echo $profile_img_path; ?>" alt="User Image" width="120px" height="120px"/>                        
                    </div>
                    
                    <div class="form-group">
                        <?= $form->field($model, 'email')->textInput(
                            ['placeholder' => 'Email', 
                            'maxlength' => 32])->label('Email') ?>
                    </div>
                    
                    <div class="form-group">                        
                        <?= $form->field($model, 'address1')->textarea(
                            ['placeholder' => 'Address1'])->label('Address1') ?>
                    </div>
                    
                    <div class="form-group">                        
                        <?= $form->field($model, 'address2')->textarea(
                            ['placeholder' => 'Address2'])->label('Address2') ?>
                    </div>
                    
                    <div class="box-footer">                    
                        <div class="form-group">
                            <?= Html::submitButton('Update Profile', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
            </div>
        </div>
        </div>
</section>