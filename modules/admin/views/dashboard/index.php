<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Dashboard</h1>
</section>

<section class="content">
    <div class="row">
        <?php echo Yii::$app->common->get_flash_message('error', Yii::$app->session->getFlash('error')); ?>
        <?php echo Yii::$app->common->get_flash_message('success', Yii::$app->session->getFlash('success')); ?>
    </div>
</section>
