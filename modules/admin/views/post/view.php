<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Post */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Posts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
echo Yii::$app->common->get_flash_message('success', Yii::$app->session->getFlash('success'));
echo Yii::$app->common->get_flash_message('error', Yii::$app->session->getFlash('error'));
?>
<section class="content-header">
    <h1><?= Html::encode($this->title) ?></h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <?= Html::a(Yii::t('app', 'Manage Posts'), ['index'], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a(Yii::t('app', 'Create Post'), ['create'], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <?=
                    Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                            'method' => 'post',
                        ],
                    ])
                    ?>
                </div>
                <div class="box-body">
                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            'title',
                            'description:ntext',
                            'caption',
                            [
                                'attribute' => 'image',
                                'value' => Yii::$app->common->post_image_view($model->image),
                                'format' => 'html'
                            ],
                            [
                                'attribute' => 'type',
                                'value' => Yii::$app->common->post_type($model->image),
                                'format' => 'html'
                            ],
                            'html_source:ntext',
                            'css_source:ntext',
                            'js_source:ntext',
                            
                            'status',
                        ],
                    ])
                    ?>
                </div>                
            </div>            
        </div>
    </div>    
</section>


