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
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name=viewport content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?= $this->render('header_include'); ?>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>
        <?= $this->render('header'); ?>

        <section class="container">
            <?= $content ?>
        </section>

        


        <?= $this->render('footer'); ?>
        <?= $this->render('footer_include'); ?>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>





