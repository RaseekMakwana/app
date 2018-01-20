<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel app\models\SystemRoleBasePermissionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'System Role Base Permissions');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
echo Yii::$app->common->get_flash_message('success', Yii::$app->session->getFlash('success'));
echo Yii::$app->common->get_flash_message('error', Yii::$app->session->getFlash('error'));
?>
<section class="content-header">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                        <?= Html::a(Yii::t('app', 'Create System Role Base Permission'), ['create'], ['class' => 'btn btn-success']) ?>
                </div>
                <div class="box-body">
                   <?php Pjax::begin(); ?>    
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            //#'id',
                            [
                                'attribute' => 'role_id',
                                'filter' => ArrayHelper::map(\app\models\UserRoles::find()->all(), 'id', 'user_role'),
                                'value' => function ($data) {
                                    return !empty($data->role->user_role) ? $data->role->user_role : null;
                                }
                            ],
                            //'controller_id',
                            [
                                'attribute' => 'controller_id',
                                'filter' => ArrayHelper::map(\app\models\SystemControllers::find()->all(), 'id', 'controller_name'),
                                'value' => function ($data) {
                                    return !empty($data->controller->controller_name) ? $data->controller->controller_name : null;
                                }
                            ],
                            //#'action_id',
                            [
                                'attribute' => 'allow_all_actions',
                                'filter' => ['Y' => 'Yes', 'N' => 'No'],
                                'value' => function ($data) {
                                    return Yii::$app->common->displayLabel('yes_no', $data->allow_all_actions);
                                }
                            ],
                            // 'status',

                            [
                                'header' => 'Action',
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{view} {update}',
                            ],
                        ],
                    ]); ?>
                    <?php Pjax::end(); ?>
                </div>                
            </div>            
        </div>
    </div>    
</section>


