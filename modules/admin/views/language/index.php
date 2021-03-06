<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\LanguageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Languages');
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
                    <?= Html::a(Yii::t('app', 'Create Language'), ['create'], ['class' => 'btn btn-success']) ?>
                </div>
                <div class="box-body">
                <?php Pjax::begin(); ?>    
                <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            //'id',
                            'language',
//                            'created_by',
//                            'updated_by',
//                            'created_date',
//                            'upated_date',
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

