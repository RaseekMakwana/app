<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SystemRoleBasePermission */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'System Role Base Permission',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'System Role Base Permissions'), 'url' => ['index']];
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



