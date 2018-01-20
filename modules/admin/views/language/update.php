<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Language */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Language',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Languages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>

<section class="content-header">
    <h1><?= Html::encode($this->title) ?></h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <?= Html::a(Yii::t('app', 'Manage Languagies'), ['index'], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a(Yii::t('app', 'View Language'), ['view', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a(Yii::t('app', 'Create Language'), ['create'], ['class' => 'btn btn-primary']) ?>
                </div>
                <div class="box-body">
                    <?= $this->render('_form', [
                    'model' => $model,
                    ]) ?>   
                </div>                
            </div>            
        </div>
    </div>    
</section>



