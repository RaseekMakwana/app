<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
  <head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?php echo !empty($this->title)?Html::encode($this->title):Html::encode('WeDib'); ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- favicon icon -->
    <link rel="shortcut icon" href="<?php echo Yii::$app->request->baseUrl; ?>/web/favicon.ico" type="image/x-icon" />
    <!-- Bootstrap 3.3.4 -->
    <link href="<?php echo Yii::$app->request->baseUrl ?>/web/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="<?php echo Yii::$app->request->baseUrl ?>/web/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="<?php echo Yii::$app->request->baseUrl ?>/web/plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />

    <!-- custom style -->
    <link href="<?php echo Yii::$app->request->baseUrl ?>/web/css/admin/custom_style.css" rel="stylesheet" type="text/css" />

    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="login-page">
    <?php $this->beginBody() ?>
    <?php echo $content; ?>
    <?php $this->endBody() ?>
    <!-- jQuery 2.1.4 -->
    <!--<script src="../../plugins/jQuery/jQuery-2.1.4.min.js" type="text/javascript"></script>-->
    <!-- Bootstrap 3.3.2 JS -->
    <script src="<?php echo Yii::$app->request->baseUrl ?>/web/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="<?php echo Yii::$app->request->baseUrl ?>/web/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
  </body>
</html>
<?php $this->endPage() ?>
