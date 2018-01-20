<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'System Role Base Permissions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
    echo Yii::$app->common->get_flash_message('success',Yii::$app->session->getFlash('success'));
    echo Yii::$app->common->get_flash_message('error',Yii::$app->session->getFlash('error'));
?>
<section class="content-header">
    <h1><?= Html::encode($this->title) ?></h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                            'method' => 'post',
                        ],
                    ]) ?>
                </div>
                <div class="box-body">
                     <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [
                                'attribute' => 'role_id',
                                'value' => !empty($model->role->user_role)?$model->role->user_role:null,
                            ],
                            [
                                'attribute' => 'controller_id',
                                'value' => !empty($model->controller->controller_name)?$model->controller->controller_name:null,
                            ],
                             [
                                'attribute' => 'role_id',
                                'value' => !empty($model->role->user_role)?$model->role->user_role:null,
                            ],
                            //'controller_id',
                            [
                                'attribute' => 'controller_id',
                                'value' => !empty($model->controller->controller_name)?$model->controller->controller_name:null,
                            ],
                            //'action_id',
                            [
                                'attribute' => 'action_id',
                                'value' => !empty($model->action->action_name)?$model->action->action_name:null,
                            ],
                            //'allow_all_actions',
                            [
                                'attribute' => 'allow_all_actions',
                                'value' => Yii::$app->common->displayLabel('yes_no', $model->allow_all_actions),
                            ],
                            //'status',
                            [
                                'attribute' => 'status',
                                'value' => Yii::$app->common->displayLabel('act_ict', $model->status),
                            ],
                        ],
                    ]) ?>
                </div>                
            </div>            
        </div>
    </div>    
</section>


