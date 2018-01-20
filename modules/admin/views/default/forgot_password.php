<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\Users;

$this->title = 'Forgot Password';

?>

<div class="login-box">
    <div class="login-logo">
<!--    <a href=""><b>We</b>Dib</a>-->
<a href=""><img src="<?php echo Yii::$app->request->baseUrl ?>/web/images/admin/logoanc.png" alt="Logo" title="Logo" /></a>
    </div><!-- /.login-logo -->
    <div class="login-box-body">
      <p class="login-box-msg">Forgot your password</p>
        <?php echo Yii::$app->common->get_flash_message('error',Yii::$app->session->getFlash('error')); ?>
        <?php echo Yii::$app->common->get_flash_message('success',Yii::$app->session->getFlash('success')); ?>
        <?php $form = ActiveForm::begin([
            'id' => 'admin-forgot-password-form',    
            'options' => ['class' => 'form-horizontal'],
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"col-lg-12\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                'labelOptions' => ['class' => 'col-lg-1 control-label'],
            ],
        ]); ?>        
            
            <?= $form->field($model, 'email')->textInput(['placeholder' => 'Email','class' => 'form-control'])->label(false); ?>
        
          <div class="row">          
          <div class="col-xs-4">
            <?= Html::submitButton('Send', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
          </div><!-- /.col -->
        </div>
      <?php ActiveForm::end(); ?>      
      Redirect Login Page? <?= Html::a('Click here', ['default/index'], ['class'=>'']) ?><br>
    </div><!-- /.login-box-body --> 
</div><!-- /.login-box -->