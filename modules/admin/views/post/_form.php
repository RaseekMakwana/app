<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Language;

/* @var $this yii\web\View */
/* @var $model app\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'slug')->textInput(['maxlength' => true, 'readonly' => '']) ?>
    
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'caption')->textInput(['maxlength' => true]) ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'thumbnail_image')->fileInput() ?>
            <?php if(!empty($model['image']) || file_exists(POSTS_PICTURE_ABS_THUMBNAIL.$model['image'])): ?>
                <img src="<?php echo POSTS_PICTURE_URL_THUMBNAIL.$model['image']; ?>" style="width: 100px">
            <?php endif; ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'large_image')->fileInput() ?>
            <?php if(!empty($model['image']) || file_exists(POSTS_PICTURE_ABS_ORIGINAL.$model['image'])): ?>
                <img src="<?php echo POSTS_PICTURE_URL_ORIGINAL.$model['image']; ?>" style="width: 100px">
            <?php endif; ?>
        </div>
    </div>
    

    <?= $form->field($model, 'type')->dropDownList(['1' => 'Image', '2' => 'Canvas'], ['prompt' => '-- Select Type --']) ?>

    <?php /* $form->field($model, 'html_source')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'css_source')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'js_source')->textarea(['rows' => 6]) ?>

    <?php  $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <?= $form->field($model, 'created_date')->textInput() ?>

    <?= $form->field($model, 'updated_date')->textInput() */ ?>

    <?= $form->field($model, 'status')->dropDownList([ 'Y' => 'Y', 'N' => 'N', ], ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
    $(document).ready(function(){
        $('#post-title').blur(function(){
            var ajaxUrl = '<?php echo Yii::$app->urlManager->createUrl("/admin/post/getslug"); ?>';
            var request = $('#post-title').val();
            $.ajax({
                url:ajaxUrl,
                type:'post',
                data:{request: request},
                success:function(response){
                    $('#post-slug').val(response);
                }
            });
        });
    });
</script>