<header class="main-header">
    <!-- Logo -->
    <a href="<?php echo Yii::$app->urlManager->createUrl('admin/dashboard/index'); ?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>Demo</b>P</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Demo</b>Project</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <!--<img src="<?php echo Yii::$app->request->baseUrl ?>/web/dist/img/avatar.png" class="user-image" alt="User Image" />-->
                <?php       
                if(!empty(Yii::$app->user->identity->profile_picture) && file_exists(UPLOAD_DIR_PATH . 'profile_pictures/thumbnails/' . Yii::$app->user->identity->profile_picture)) {
                ?>
                <img src="<?php echo SITE_ABS_UPLOAD_PATH . 'profile_pictures/thumbnails/' . Yii::$app->user->identity->profile_picture; ?>" class="user-image" alt="User Image" />
                <?php
                } else { 
                ?>
                <img src="<?php echo Yii::$app->request->baseUrl ?>/web/dist/img/avatar.png" class="user-image" alt="User Image" />
                <?php
                }
                ?>
              <span class="hidden-xs">
                    <?php
                        echo (!empty(Yii::$app->user->identity->first_name))?Yii::$app->user->identity->first_name:"";                        
                        if(!empty(Yii::$app->user->identity->user_type)) {
                            $user_role_arr = array( 1 => 'Admin', 2 => 'Normal User');
                            echo (!empty($user_role_arr[Yii::$app->user->identity->user_type]))?" [".$user_role_arr[Yii::$app->user->identity->user_type]."]":"";
                        }
                    ?>
              </span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <!--<img src="<?php echo Yii::$app->request->baseUrl ?>/web/dist/img/avatar.png" class="img-circle" alt="User Image" />-->
                <?php          
                if(!empty(Yii::$app->user->identity->profile_picture) && file_exists(UPLOAD_DIR_PATH . 'profile_pictures/thumbnails/' . Yii::$app->user->identity->profile_picture)) {
                ?>
                <img src="<?php echo SITE_ABS_UPLOAD_PATH . 'profile_pictures/thumbnails/' . Yii::$app->user->identity->profile_picture; ?>" class="img-circle" alt="User Image" />
                <?php
                } else {
                ?>
                <img src="<?php echo Yii::$app->request->baseUrl ?>/web/dist/img/avatar.png" class="img-circle" alt="User Image" />
                <?php
                }
                ?>
                <p>
                  <?php echo (!empty(Yii::$app->user->identity->first_name))?Yii::$app->user->identity->first_name:""; ?>
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">             
                <div class="col-xs-7 text">
                  <a href="<?php echo Yii::$app->urlManager->createUrl('admin/dashboard/change_password'); ?>">Change Password</a>
                </div>
             
                <div class="col-xs-1 text-right">
                  <a href="<?php echo Yii::$app->urlManager->createUrl('admin/dashboard/settings'); ?>">Settings</a>
                </div>
                  
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?php echo Yii::$app->urlManager->createUrl('admin/dashboard/profile'); ?>" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="<?php echo Yii::$app->urlManager->createUrl('admin/default/logout'); ?>" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>          
        </ul>
      </div>
    </nav>
</header>
 