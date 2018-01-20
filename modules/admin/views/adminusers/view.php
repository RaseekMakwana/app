<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = $model->first_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
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
                           // 'id',
                            [
                                'attribute' => 'user_type',
                                'value' => $model->userType->user_role,
                            ],
                            'first_name',
                            'last_name',
                            'username',
                            'email:email',
                            'password',
                            'phone',
                            'profile_picture',
                            'address1:ntext',
                            'address2:ntext',
                            'created_date',
                            'updated_date',
                            [
                                'attribute' => 'created_by',
                                'value' => Yii::$app->common->get_created_by_user_name($model->created_by),
                            ],
                            [
                                'attribute' => 'updated_by',
                                'value' => Yii::$app->common->get_created_by_user_name($model->updated_by),
                            ],
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



