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
    <title><?php echo !empty($this->title)?Html::encode($this->title):Html::encode('Demo Project'); ?></title>
    <?php $this->head() ?>
    <?= $this->render('header_includes') ?>
</head>
<body class="skin-green-light sidebar-mini fixed">
<?php $this->beginBody() ?>
<?= $this->render('header') ?>
<!--header end-->

<!--sidebar start-->
 <?= $this->render('left_menu') ?>
<!--sidebar end-->

<!--main content start-->
<div class="content-wrapper">
    <?php  ?>
    <?= 
        Breadcrumbs::widget([
           'homeLink' => [ 
                            'label' => Yii::t('yii', 'Dashboard'),
                            //#'url' => Yii::$app->homeUrl.'/admin',
                            'url' => ($_SERVER['SERVER_NAME'] == 'url')?SITE_ABS_PATH.'admin':Yii::$app->homeUrl.'/admin',
                      ],
           'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) 
    ?>
    <?php echo $content; ?>
</div>
<!--main content end-->    

<!--footer start-->
<?= $this->render('footer') ?>

<?php $this->endBody() ?>
<?= $this->render('footer_includes') ?>
<!--footer Ends-->

</body>
</html>
<?php $this->endPage() ?>


<script>
    /*
     * This script is for to search leftside menus
     */
    $(function() {
        $('#search_input').fastLiveFilter('#search_list');
    });
</script>
