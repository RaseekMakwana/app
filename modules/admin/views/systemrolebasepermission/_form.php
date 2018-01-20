<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use yii\helpers\ArrayHelper;    

/* @var $this yii\web\View */
/* @var $model app\models\SystemRoleBasePermission */
/* @var $form yii\widgets\ActiveForm */
?>

<script type="text/javascript">
    $(document).ready(function () {
        var allow_all_action = $("#systemrolebasepermission-allow_all_actions").val();
        if (allow_all_action == 'N') {
            $(".action_id_class").show();
        } else {
            $(".action_id_class").hide();
        }

        $("#systemrolebasepermission-allow_all_actions").change(function () {
            var allow_all_action = this.value;
            if (allow_all_action == 'N') {
                $(".action_id_class").show();
            } else {
                $(".action_id_class").hide();
            }
        });

        $("#systemrolebasepermission-controller_id").change(function () {
            var option_value = this.value;
            $.ajax({
                type: "GET",
                url: "<?php echo Yii::$app->urlManager->createUrl(['admin/systemrolebasepermission/getactioncombo']); ?>",
                async: false,
                data: "&id=" + option_value,
                success: function (data) {
                    $('#systemrolebasepermission-action_id').find('option').remove().end().append(data);
                    if (option_value != '') {
                        $("#systemrolebasepermission-action_id").prop("disabled", false);
                    } else {
                        $("#systemrolebasepermission-action_id").prop("disabled", true);
                    }
                    $("#systemrolebasepermission-action_id").trigger('change');
                }
            });
        });

    });

    function hubValidation(messages) {
        var main_val = $("#systemrolebasepermission-action_id").val();
        var allow_all_action = $("#systemrolebasepermission-allow_all_actions").val();

        if (main_val == '' && allow_all_action == 'N') {
            messages.push("Action cannot be blank.");
        }
        return false;
    }
</script>
    
<div class="system-role-base-permission-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'role_id')->dropDownList(ArrayHelper::map(\app\models\UserRoles::find()->all(), 'id', 'user_role'), ['prompt' => 'Select User Role']) ?>
    
    <?= $form->field($model, 'controller_id')->dropDownList(ArrayHelper::map(\app\models\SystemControllers::find()->all(), 'id', 'controller_name'), ['prompt' => 'Select Controller']) ?>

    <?= $form->field($model, 'allow_all_actions')->dropDownList([ 'N' => 'No', 'Y' => 'Yes', ], [])->label('Allow All Actions *') ?>
    
    <div class="action_id_class">
        <?php
            if (!empty($model->controller_id)) {
                echo $form->field($model, 'action_id')->dropDownList(ArrayHelper::map(\app\models\SystemActions::find()->where("controller_id = $model->controller_id")->all(), 'id', 'action_name'), ['prompt' => 'Select Action'])->label('Action *');
            } else {
                echo $form->field($model, 'action_id')->dropDownList(array(), array('empty' => 'Select Action', 'disabled' => 'disabled'))->label('Action *');
            }
        ?>
    </div>

    <?= $form->field($model, 'status')->dropDownList([ 'Y' => 'Active', 'N' => 'Inactive', ], []) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
