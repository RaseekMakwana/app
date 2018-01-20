<?php

namespace app\modules\admin\controllers;

use Yii;
use TCPDF;
use yii\db\Query;
use app\models\Admin;
use app\models\AdminSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\IdentityInterface;

/**
 * AdminusersController implements the CRUD actions for Admin model.
 */
class TestsController extends \yii\web\Controller {
    
    /*
     * Description: TEST pdf
     */
    public function actionTestpdf() {
        $items = array(
            'header' => array(
                array('#', 'text', 15, 'C', ''),
                array('ID', 'text', 35, 'L', ''),
                array('Name', 'text', 55, 'L', ''),
                array('Price', 'number', 25, 'R', ' Baht.'),
                array('Amount', 'number', 25, 'R', ' items.'),
                array('Total', 'number', 25, 'R', ' Baht.'),
            ),
            'items' => array(
                array('1', 'PRO5900001', 'Yii 2 Framework Book', 250, 3, 750)
            )
        );

        (new TCPDF('P'))->table('demoproject.pdf', $items);
        \Yii::$app->end();
    }
    public function actionTestExcel(){
        $filename = 'DemoprojectName_'.time();
        if(!empty($data)){
            $objPHPExcel = new \PHPExcel();

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename=' . $file_name);
            header('Cache-Control: max-age=0');

            $objPHPExcel->getActiveSheet()->fromArray($data, null, 'A2');
            $objPHPExcel->getActiveSheet()->setTitle('Demo');

            $objPHPExcel->getActiveSheet()->setCellValue('A1', 'First Name');
            $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Last Name');
            $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Surname');
            $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Address');


            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);

            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            // Write file to the browser
            // ob_clean();
            $objWriter->save('php://output');

            echo '<br/>END: temp<br/>';
            \Yii::$app->end();
        }
    }
    
    public function actionGetusers(){
        $users= \app\models\UserRoles::find()->with(['users','adminusers'])->asArray()->all();
    }
    public function actionBackup(){
        ini_set('display_errors', 1);
        error_reporting(-1);
          if ($_SERVER['SERVER_NAME'] == 'testing.siliconithub.com') {
            $dbhost = 'localhost';
            $dbuser = 'siliconithub';
            $dbpwd = 'it@adm123';
            $dbname = 'demoproject_v1';
        } else if ($_SERVER['SERVER_NAME'] == 'beta.demoproject.in') {
            $dbhost = 'localhost';
            $dbuser = 'Username';
            $dbpwd = 'password';
            $dbname = 'demoproject_v1';
        } else if ($_SERVER['SERVER_NAME'] == 'demoproject.in' || $_SERVER['SERVER_NAME'] == 'www.demoproject.in') {
            $dbhost = 'hostname';
            $dbuser = 'password';
            $dbpwd = 'username';
            $dbname = 'demoproject_v1';
        } else {
            $dbhost = 'localhost';
            $dbuser = 'root';
            $dbpwd = '';
            $dbname = 'demo';
        }
        $backup_filename_name = $dbname.'_'.date('Y-m-d_H-i-s');
        $backup_file = SITE_REL_PATH . 'db_backup/mysql/' . $backup_filename_name . '.gz';
        $command = "";
        if ($_SERVER['SERVER_NAME'] == 'testing.siliconithub.com') {
            $command = "/usr/bin/";
        } else if ($_SERVER['SERVER_NAME'] == 'beta.demoproject.in') {
            $command = "/usr/bin/";
        } else if ($_SERVER['SERVER_NAME'] == 'sitename.in' || $_SERVER['SERVER_NAME'] == 'sitename.in') {
           $command = "/usr/bin/";
        } else {
            $command = "/opt/lampp/bin/";
        }
        
        $command .= "mysqldump --user={$dbuser} --password={$dbpwd} --host={$dbhost} {$dbname} | gzip > {$backup_file}";
        exec($command, $output, $return_var);
        \Yii::$app->end();
    }
}