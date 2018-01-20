<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="login-box">
    <div class="login-logo">
      <a href=""><b>Goo</b> Joo</a>
        <!--<a href=""><img src="<?php // echo Yii::$app->request->baseUrl ?>/web/images/admin/logo1.png" alt="Logo" title="Logo" /></a>-->
    </div><!-- /.login-logo -->
    <div class="login-box-body">
      <p class="login-box-msg">Sign in to start your session</p>
      <!--<form action="../../index2.html" method="post">-->
        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'options' => ['class' => 'form-horizontal'],
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"col-lg-12\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                'labelOptions' => ['class' => 'col-lg-1 control-label'],
            ],
        ]); ?>
        
            <!--<input type="email" class="form-control" placeholder="Email" />-->
            <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'class' => 'form-control'])->label(false); ?>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          
            <!--<input type="password" class="form-control" placeholder="Password" />-->
            <?= $form->field($model, 'password')->passwordInput(['class' => 'form-control'])->label(false); ?>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        
          <div class="row">
          <div class="col-xs-8">
            <div class="checkbox icheck">
              <label>
                <!--<input type="checkbox"> Remember Me-->
                  <?= $form->field($model, 'rememberMe')->checkbox([
                    'template' => "<div class=\"col-lg-offset-1 col-lg-12\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
                ]) ?>
              </label>
            </div>
          </div><!-- /.col -->
          <div class="col-xs-4">
            <!--<button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>-->
            <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
          </div><!-- /.col -->
        </div>
      <!--</form>-->
      <?php ActiveForm::end(); ?>
      
      <a href="<?php echo Yii::$app->urlManager->createUrl('admin/default/forgotpassword'); ?>">I forgot my password</a><br>

    </div><!-- /.login-box-body --> 
</div><!-- /.login-box -->