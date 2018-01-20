<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use app\models\Language;
/* @var $this yii\web\View */
/* @var $searchModel app\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Categories');
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
                    <?= Html::a(Yii::t('app', 'Create Category'), ['create'], ['class' => 'btn btn-success']) ?>
                </div>
                <div class="box-body">
                <?php Pjax::begin(); ?>    
                <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

//                            'id',
                            'category_name',
                            //'language_id',
                            [
                                'attribute' => 'language_id',
                                'label' => 'Language',
                                'value' => function($data){
                                    return Yii::$app->common->get_language_name($data->language_id);
                                },
                                'filter' => ArrayHelper::map(Language::find()->asArray()->all(), 'id', 'language')
                            ],
//                            'created_by',
//                            'updated_by',
                            // 'created_date',
                            // 'updated_date',
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

