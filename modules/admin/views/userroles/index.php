<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;

use app\models\UserRoles;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AdminSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = Yii::t('app', 'User Roles');
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
                    <?= Html::a(Yii::t('app', 'Create User Roles'), ['create'], ['class' => 'btn btn-success']) ?>
                </div>
                <div class="box-body">
                <?php Pjax::begin(['id' => 'users-grid']); ?>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            //#'id',
                            'user_role',
                            'created_date',
                            'updated_date',
                            //#'created_by',
                            // 'updated_by',
                            // 'status',

                            ['class' => 'yii\grid\ActionColumn'],
                        ],
                    ]); ?>
                    <?php Pjax::end(); ?>
                </div>                
            </div>            
        </div>
    </div>    
</section>





