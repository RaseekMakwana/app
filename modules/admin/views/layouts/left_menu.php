<?php

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
?>
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar slimscroll">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <?php
                if (!empty(Yii::$app->user->identity->profile_picture) && file_exists(UPLOAD_DIR_PATH . 'profile_pictures/thumbnails/' . Yii::$app->user->identity->profile_picture)) {
                    ?>
                    <img src="<?php echo SITE_ABS_UPLOAD_PATH . 'profile_pictures/thumbnails/' . Yii::$app->user->identity->profile_picture; ?>" class="img-circle" alt="User Image" />
                    <?php
                } else {
                    ?>
                    <img src="<?php echo Yii::$app->request->baseUrl ?>/web/dist/img/avatar.png" class="img-circle" alt="User Image" />
                    <?php
                }
                ?>                
            </div>
            <div class="pull-left info">
                <p><?php echo (!empty(Yii::$app->user->identity->first_name)) ? Yii::$app->user->identity->first_name : ""; ?></p>
                <?php  if(!empty(Yii::$app->user->identity->first_name)){?><a href="#"><i class="fa fa-circle text-success"></i> Online</a><?php } ?>
            </div>
        </div>

        <?php ?>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input id= 'search_input' type="text" name="q" class="form-control" placeholder="Search..." />
                <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
                </span>
            </div>
        </form>
        <!-- /.search form -->
        <?php ?>


        <!-- sidebar menu: : style can be found in sidebar.less -->
        <?php
        echo Nav::widget([
            'options' => ['class' => 'sidebar-menu','id'=>'search_list'],
            'items' => [
                //Super Admin Access
                ['label' => '<i class="fa fa-dashboard"></i>  Dashboard', 'url' => ['/admin/dashboard/index'], 'class' => 'treeview'],
                //['label' => '<i class="fa fa-users"></i>  Users', 'url' => ['/admin/users/index'], 'class' => 'treeview', 'visible' => Yii::$app->common->getRoutePermission('admin/users/index')],
                ['label' => '<i class="fa fa-circle-o"></i>  Post', 'url' => ['/admin/post/index'], 'class' => 'treeview', 'visible' => Yii::$app->common->getRoutePermission('admin/adminusers/index')],
                ['label' => '<i class="fa fa-circle-o"></i>  Category', 'url' => ['/admin/category/index'], 'class' => 'treeview', 'visible' => Yii::$app->common->getRoutePermission('admin/adminusers/index')],
                ['label' => '<i class="fa fa-circle-o"></i>  Language', 'url' => ['/admin/language/index'], 'class' => 'treeview', 'visible' => Yii::$app->common->getRoutePermission('admin/adminusers/index')],
                ['label' => '<i class="fa fa-users"></i>  Users', 'url' => ['/admin/adminusers/index'], 'class' => 'treeview', 'visible' => Yii::$app->common->getRoutePermission('admin/adminusers/index')],
                ['label' => '<i class="fa fa-users"></i>  Users Roles', 'url' => ['/admin/userroles/index'], 'class' => 'treeview', 'visible' => Yii::$app->common->getRoutePermission('admin/userroles/index')],
                ['label' => '<i class="fa fa-unlock-alt"></i>  Users Permissions', 'url' => ['/admin/systemrolebasepermission/index'], 'class' => 'treeview', 'visible' => Yii::$app->common->getRoutePermission('admin/systemrolebasepermission/index')],
                
            ],
            'encodeLabels' => false,
        ]);
        ?>
    </section>
    <!-- /.sidebar -->
</aside>
<script> 
    $(function(){
        $('#t2').clockface({
            format: 'HH:mm',
            trigger: 'manual'
        });   
     
        $('#toggle-btn').click(function(e){   
            e.stopPropagation();
            $('#t2').clockface('toggle');
        });
    });
</script>