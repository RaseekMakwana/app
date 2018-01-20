<?php

namespace app\modules\admin;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\admin\controllers';
    public $layout = '//../../modules/admin/views/layouts/main';
    
    public $homeUrl="/admin/";
    
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
