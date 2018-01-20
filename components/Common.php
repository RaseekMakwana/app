<?php

namespace app\components;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\db\Query;
use app\models\Users;
use app\models\Admin;
use app\models\SystemControllers;
use app\models\SystemActions;
use app\models\SystemRoleBasePermission;
use yii\behaviors\TimestampBehavior;
use app\components\Url;
use app\models\Language;

Class Common extends Component {
    /*
     * creates a compressed zip file 
     */

    function create_zip($files = array(), $destination = '', $overwrite = false) {
        //if the zip file already exists and overwrite is false, return false
        if (file_exists($destination) && !$overwrite) {
            return false;
        }
        //vars
        $valid_files = array();
        //if files were passed in...
        if (is_array($files)) {
            //cycle through each file
            foreach ($files as $file) {
                //make sure the file exists
                if (file_exists($file)) {
                    $valid_files[] = $file;
                }
            }
        }
        //if we have good files...
        if (count($valid_files)) {
            //create the archive
            $zip = new \ZipArchive();
            if ($zip->open($destination, $overwrite ? \ZIPARCHIVE::OVERWRITE : \ZIPARCHIVE::CREATE) !== true) {
                return false;
            }
            //add the files
            foreach ($valid_files as $file) {
                $zip->addFile($file, basename($file));
            }
            //debug
            //echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;
            //close the zip -- done!
            $zip->close();

            //check to make sure the file exists
            return file_exists($destination);
        } else {
            return false;
        }
    }

    /*
     * Download any file
     */

    function output_file($Source_File, $Download_Name, $mime_type = '') {
        /*
          $Source_File = path to a file to output
          $Download_Name = filename that the browser will see
          $mime_type = MIME type of the file (Optional)
         */
        if (!is_readable($Source_File))
            die('File not found or inaccessible!');

        $size = filesize($Source_File);
        $Download_Name = rawurldecode($Download_Name);

        /* Figure out the MIME type (if not specified) */
        $known_mime_types = array(
            "pdf" => "application/pdf",
            "csv" => "application/csv",
            "txt" => "text/plain",
            "html" => "text/html",
            "htm" => "text/html",
            "exe" => "application/octet-stream",
            "zip" => "application/zip",
            "doc" => "application/msword",
            "xls" => "application/vnd.ms-excel",
            "ppt" => "application/vnd.ms-powerpoint",
            "gif" => "image/gif",
            "png" => "image/png",
            "jpeg" => "image/jpg",
            "jpg" => "image/jpg",
            "php" => "text/plain"
        );

        if ($mime_type == '') {
            $file_extension = strtolower(substr(strrchr($Source_File, "."), 1));
            if (array_key_exists($file_extension, $known_mime_types)) {
                $mime_type = $known_mime_types[$file_extension];
            } else {
                $mime_type = "application/force-download";
            };
        };

        @ob_end_clean(); //off output buffering to decrease Server usage
        // if IE, otherwise Content-Disposition ignored
        if (ini_get('zlib.output_compression'))
            ini_set('zlib.output_compression', 'Off');

        header('Content-Type: ' . $mime_type);
        header('Content-Disposition: attachment; filename="' . $Download_Name . '"');
        header("Content-Transfer-Encoding: binary");
        header('Accept-Ranges: bytes');

        header("Cache-control: private");
        header('Pragma: private');
        header("Expires: Thu, 26 Jul 2012 05:00:00 GMT");

        // multipart-download and download resuming support
        if (isset($_SERVER['HTTP_RANGE'])) {
            list($a, $range) = explode("=", $_SERVER['HTTP_RANGE'], 2);
            list($range) = explode(",", $range, 2);
            list($range, $range_end) = explode("-", $range);
            $range = intval($range);
            if (!$range_end) {
                $range_end = $size - 1;
            } else {
                $range_end = intval($range_end);
            }

            $new_length = $range_end - $range + 1;
            header("HTTP/1.1 206 Partial Content");
            header("Content-Length: $new_length");
            header("Content-Range: bytes $range-$range_end/$size");
        } else {
            $new_length = $size;
            header("Content-Length: " . $size);
        }

        /* output the file itself */
        $chunksize = 1 * (1024 * 1024); //you may want to change this
        $bytes_send = 0;
        if ($Source_File = fopen($Source_File, 'r')) {
            if (isset($_SERVER['HTTP_RANGE']))
                fseek($Source_File, $range);

            while (!feof($Source_File) &&
            (!connection_aborted()) &&
            ($bytes_send < $new_length)
            ) {
                $buffer = fread($Source_File, $chunksize);
                print($buffer); //echo($buffer); // is also possible
                flush();
                $bytes_send += strlen($buffer);
            }
            fclose($Source_File);
        } else
            die('Error - can not open file.');

        die();
    }

    /*
     * Read CSV file
     */

    function readCSV($csvFile) {
        $file_handle = fopen($csvFile, 'r');
        while (!feof($file_handle)) {
            $line_of_text[] = fgetcsv($file_handle, 1024);
        }
        fclose($file_handle);
        return $line_of_text;
    }

    /**
     * Prepend common breadcrumbs to existing ones
     * @param array $breadcrumbs
     */
    public static function get_flash_message($key, $message) {
        $alert_message = '';

        if (!empty($message)) {
            if ($key == 'error') {
                $alert_message .= '<div class="alert alert-danger alert-dismissable">
                                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                                ' . $message . '
                                            </div>';
            }
            if ($key == 'success') {
                $alert_message .= '<div class="alert alert-success alert-dismissable">
                                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                                ' . $message . '
                                           </div>';
            }
            if ($key == 'warning') {
                $alert_message .= '<div class="alert alert-warning alert-dismissable">
                                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                                ' . $message . '
                                           </div>';
            }
            return $alert_message;
        } else {
            return false;
        }
    }

    /*
     * Generate random password
     */

    public function generate_password($length = 8) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
        $password = substr(str_shuffle($chars), 0, $length);
        return $password;
    }

    /*
     * Get Randon File Name
     */

    public function getRandomFileName($extension = "jpg") {
        if (empty($extension)) {
            $extension = "jpg";
        }
        $filename = "";
        $random_filename = time() . rand(99999, 888888);
        $filename = $random_filename . "." . $extension;
        return $filename;
    }

    /*
     * Get substring
     * type = C => substring with character
     * type = W => substring with word
     */

    public function getSubString($string, $length, $type = 'C') {
        $return = '';
        if ($type == 'W') {
            $string_arr = explode(' ', $string, $length);
            $append = "";
            if (!empty($string_arr[$length - 1])) {
                unset($string_arr[$length - 1]);
                $append = "...";
            }
            $return = implode(" ", $string_arr) . $append;
        } else {
            $append = "...";
            $return = (strlen($string) > $length) ? substr($string, 0, $length) . $append : $string;
        }
        return $return;
    }

    /*
     * Returns an encrypted & utf8-encoded
     */

    public function encrypt($pure_string, $encryption_key) {
        //if($_SERVER['SERVER_NAME'] != 'testing.siliconithub.com') {
        if (function_exists('mcrypt_get_iv_size')) {
            $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
            $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
            $encrypted_string = mcrypt_encrypt(MCRYPT_BLOWFISH, $encryption_key, utf8_encode($pure_string), MCRYPT_MODE_ECB, $iv);
        } else {
            $encrypted_string = base64_encode($pure_string);
        }
        return $encrypted_string;
    }

    /*
     * Returns decrypted original string
     */

    public function decrypt($encrypted_string, $encryption_key) {
        //if($_SERVER['SERVER_NAME'] != 'testing.siliconithub.com') {
        if (function_exists('mcrypt_get_iv_size')) {
            $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
            $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
            $decrypted_string = mcrypt_decrypt(MCRYPT_BLOWFISH, $encryption_key, $encrypted_string, MCRYPT_MODE_ECB, $iv);
        } else {
            $decrypted_string = base64_decode($encrypted_string);
        }
        return $decrypted_string;
    }

    /*
     * Display Labels
     */

    public function displayLabel($type, $value) {
        if ($type == 'yes_no') {
            if ($value == 'N') {
                return 'No';
            } else {
                return 'Yes';
            }
        } else if ($type == 'act_ict') {
            if ($value == 'Y') {
                return 'Active';
            } else {
                return 'Inactive';
            }
        }
    }

    /*
     * Formate date
     */

    public function formateDate($date = null, $format = 'm/d/Y') {
        $dateReturn = "";
        if (!empty($date) && ($date != "0000-00-00 00:00:00")) {
            $dateReturn = date($format, strtotime($date));
        }
        return $dateReturn;
    }

    /*
     * Generate random string
     */

    public function generateRandomString($length = 8, $type = '') {
        if ($type == 'token') {
            $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        } else {
            $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
        }
        $password = substr(str_shuffle($chars), 0, $length);
        return $password;
    }

    /*
     * Send mail
     */

    public function sendMail($to_email, $from_email, $from_name, $subject, $message, $custom_arg = array()) {
        $from_name = empty($from_name) ? $from_email : $from_name;
        $send = false;
        if ($_SERVER['SERVER_NAME'] != 'localhost') {
            $send = Yii::$app->mailer->compose()
                    ->setTo($to_email)
                    ->setFrom([$from_email => $from_name])
                    ->setSubject($subject);

            if (!empty($custom_arg['type'])) {
                if ($custom_arg['type'] == 'text') {
                    $send = $send->setTextBody($message);
                } else {
                    $send = $send->setHtmlBody($message);
                }
            } else {
                $send = $send->setHtmlBody($message);
            }

            if (!empty($custom_arg['attachment'])) {
                foreach ($custom_arg['attachment'] as $key_at => $val_at) {
                    $send->attach($val_at);
                }
            }

            if (!empty($custom_arg['cc'])) {
                $send->setCc($custom_arg['cc']);
            }
            if (!empty($custom_arg['bcc'])) {
                $send->setBcc($custom_arg['bcc']);
            }

            $send = $send->send();
        } else {
            $send = true;
        }
        return $send;
    }

    /*
     * check Permission
     */

    public function checkPermission($rule, $action) {
        if ($action->id != 'error') {
            $admin_user = Yii::$app->user->getIdentity();

            $route_controller = $action->controller->id;
            $route_action = $action->id;

            if (!empty($admin_user->id)) {
                $controller_model = \app\models\SystemControllers::find()->where(['controller_name' => $route_controller, 'status' => 'Y'])->one();
                if (!empty($controller_model)) {
                    $action_model = \app\models\SystemActions::find()->where(['controller_id' => $controller_model->id, 'action_name' => $route_action, 'status' => 'Y'])->one();
                    if (!empty($action_model)) {
                        $system_role = \app\models\SystemRoleBasePermission::find()->where(['role_id' => $admin_user->user_type, 'controller_id' => $controller_model->id, 'allow_all_actions' => 'Y', 'status' => 'Y'])->one(); //SystemRoleBasePermission::model()->findByAttributes(array('role_id' => Yii::app()->user->roleID, 'controller_id' => $controller_model->id, 'allow_all_actions' => 'Y', 'status' => 'Y'));
                        if (!empty($system_role)) {
                            return true;
                        } else {
                            $system_role_single = \app\models\SystemRoleBasePermission::find()->where(['role_id' => $admin_user->user_type, 'controller_id' => $controller_model->id, 'action_id' => $action_model->id, 'status' => 'Y', 'allow_all_actions' => 'N'])->one();
                            if (!empty($system_role_single)) {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                return true;
            }
        } else {
            return true;
        }
    }

    /*
     * check Permission with route
     */

    public function getRoutePermission($route) {
        //#$permite = $this->routePermission($route);
        $permite = $this->routePermissionFromSession($route);
        return (!empty($permite)) ? true : false;
    }

    /*
     * check Permission with route
     */

    public function routePermission($route) {

        $route_array = explode('/', $route);

        if (!empty($route_array[2])) {
            $admin_user = Yii::$app->user->getIdentity(); //echo $admin_user->user_type; die;

            $route_controller = $route_array[1];
            $route_action = $route_array[2];

            //if($admin_user->user_type == 1 || $admin_user->user_type == 2 || $admin_user->user_type == 3) {
            if (!empty($admin_user->id)) {
                $controller_model = \app\models\SystemControllers::find()->where(['controller_name' => $route_controller, 'status' => 'Y'])->one();
                if (!empty($controller_model)) {
                    $action_model = \app\models\SystemActions::find()->where(['controller_id' => $controller_model->id, 'action_name' => $route_action, 'status' => 'Y'])->one();
                    if (!empty($action_model)) {
                        $system_role = \app\models\SystemRoleBasePermission::find()->where(['role_id' => $admin_user->user_type, 'controller_id' => $controller_model->id, 'allow_all_actions' => 'Y', 'status' => 'Y'])->one();
                        if (!empty($system_role)) {
                            return true;
                        } else {
                            $system_role_single = \app\models\SystemRoleBasePermission::find()->where(['role_id' => $admin_user->user_type, 'controller_id' => $controller_model->id, 'action_id' => $action_model->id, 'status' => 'Y', 'allow_all_actions' => 'N'])->one();
                            if (!empty($system_role_single)) {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                return true;
            }
        } else {
            return true;
        }
    }

    /*
     * check Permission with route from session
     */

    public function routePermissionFromSession($route) {
        $session = \Yii::$app->session;
        if (!empty($session['current_user_role_base_permissions'])) {
            $route_array = explode('/', $route);
            if (!empty($route_array[2])) {
                $admin_user = Yii::$app->user->getIdentity();
                $current_user_role_base_permissions = $session['current_user_role_base_permissions'];
                $route_controller = $route_array[1];
                $route_action = $route_array[2];
                if (array_key_exists($route_controller, $current_user_role_base_permissions)) {
                    if (in_array($route_action, $current_user_role_base_permissions[$route_controller]['actions'])) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                return true;
            }
        } else {
            return $this->routePermission($route);
        }
    }

    /*
     * For get access rules
     */

    public function getAccessRules() {
        $permission = array('');
        $controller = Yii::$app->controller->id;
        $admin_user = Yii::$app->user->getIdentity();
        if (!empty($controller) && !empty($admin_user->id)) {
            $controller_model = \app\models\SystemControllers::find()->where(['controller_name' => $controller, 'status' => 'Y'])->one();
            if (!empty($controller_model)) {
                $system_role = \app\models\SystemRoleBasePermission::find()->where(['role_id' => $admin_user->user_type, 'controller_id' => $controller_model->id, 'allow_all_actions' => 'Y', 'status' => 'Y'])->one();
                if (!empty($system_role)) {
                    $system_actions = \app\models\SystemActions::find()->where(['controller_id' => $controller_model->id, 'status' => 'Y'])->all();
                    if (!empty($system_actions)) {
                        foreach ($system_actions as $system_actions_row) {
                            $permission[] = $system_actions_row->action_name;
                        }
                    }
                } else {
                    $system_role_single = \app\models\SystemRoleBasePermission::find()->where(['role_id' => $admin_user->user_type, 'controller_id' => $controller_model->id, 'status' => 'Y', 'allow_all_actions' => 'N'])->all();
                    if (!empty($system_role_single)) {
                        foreach ($system_role_single as $system_actions_row) {
                            $permission[] = $system_actions_row->action->action_name;
                        }
                    }
                }
            }
        }

        return $permission;
    }

    public function getAccessRulesFromSession() {
        $session = \Yii::$app->session;
        $permission = array('');
        $controller = Yii::$app->controller->id;
        $admin_user = Yii::$app->user->getIdentity();
        if (!empty($session['current_user_role_base_permissions'])) {
            if (!empty($controller) && !empty($admin_user->id)) {
                if (array_key_exists($controller, $session['current_user_role_base_permissions'])) {
                    $permission = $session['current_user_role_base_permissions'][$controller]['actions'];
                }
            }
        } else {
            $permission = $this->getAccessRules();
        }

        return $permission;
    }

    public function updateRoleBasePermissionsArr() {
        $system_actions = '';
        $current_user_role_base_permissions = array();
        $system_role_base_permissions = SystemRoleBasePermission::find()->where(['role_id' => Yii::$app->common->get_current_user_data_by_field('user_type'), 'status' => 'Y'])->all();
        foreach ($system_role_base_permissions as $key_srbp => $val_srbp) {
            $actions_arr = array();
            if ($val_srbp->allow_all_actions == 'Y') {
                $system_actions = SystemActions::find()->select(['id', 'action_name'])->where(['controller_id' => $val_srbp->controller_id, 'status' => 'Y'])->all();
                if (!empty($system_actions)) {
                    foreach ($system_actions as $key_sa => $val_sa) {
                        $actions_arr[] = $val_sa->action_name;
                    }
                }
            } else {
                if (!empty($val_srbp->action_id)) {
                    $system_actions = SystemActions::find()->select(['id', 'action_name'])->where(['id' => $val_srbp->action_id, 'status' => 'Y'])->one();
                }
                if(!empty($system_actions)){
                   $actions_arr[] = $system_actions->action_name;
                }
            }
            $controller_data = $val_srbp->controller->attributes;
            if (!empty($current_user_role_base_permissions[$controller_data['controller_name']])) {
                $current_user_role_base_permissions[$controller_data['controller_name']]['controller_id'] = $val_srbp->controller_id;
                $current_user_role_base_permissions[$controller_data['controller_name']]['actions'] = array_merge($current_user_role_base_permissions[$val_srbp->controller->controller_name]['actions'], $actions_arr);
            } else {
                $current_user_role_base_permissions[$controller_data['controller_name']]['controller_id'] = $val_srbp->controller_id;
                $current_user_role_base_permissions[$controller_data['controller_name']]['actions'] = $actions_arr;
            }
        }
        return $current_user_role_base_permissions;
        //$session['current_user_role_base_permissions'] = $current_user_role_base_permissions;
        //\Yii::$app->end();
    }

    /*
     * Get grid action template with respect to role
     */

    public function getGridActionsTemplate() {
        $admin_user = Yii::$app->user->getIdentity();
        //#$get_permission = $this->getAccessRules();
        $get_permission = $this->getAccessRulesFromSession();
        $i = 0;
        $action_array = array();
        foreach ($get_permission as $data) {
            if (!empty($data) && in_array($data, array('view', 'update', 'delete'))) {
                $action_array[$i] = "{" . $data . "}";
                $i++;
            }
        }

        return implode(' ', $action_array);
    }

    /*
     * get user name form id
     */

    public function get_created_by_user_name($id) {
        $return = null;
        if (!empty($id)) {
            $user_data = Admin::findOne($id);
            if (!empty($user_data)) {
                if (!empty($user_data->first_name)) {
                    $return = $user_data->first_name . " " . $user_data->last_name;
                } else {
                    $return = $user_data->last_name;
                }
            }
        }
        return $return;
    }

    /*
     * get current session value by field name
     */

    public function get_current_user_data_by_field($field = '') {
        $return = '';
        if ($field == 'id' || $field == 'user_type') {
            $return = !empty(Yii::$app->user->identity->$field) ? Yii::$app->user->identity->$field : '';
        } else {
            $return = !empty(Yii::$app->user->identity->$field) ? Yii::$app->user->identity->$field : '';
        }
        return $return;
    }

    /*
     * get profile image
     */

    public function get_profile_image($profile_picture) {
        $return = null;
        if (!empty($profile_picture) && file_exists(UPLOAD_DIR_PATH . 'profile_pictures/thumbnails/' . $profile_picture)) {
            $return = '<img src="' . SITE_ABS_UPLOAD_PATH . 'profile_pictures/thumbnails/' . $profile_picture . '" class="thumb_image" alt="User Image"/>';
        }
        return $return;
    }

    /*
     * gar code
     */

    public function barcode($filepath = "", $text = "0", $size = "20", $orientation = "horizontal", $code_type = "code128", $print = false) {
        $code_string = "";
        // Translate the $text into barcode the correct $code_type
        if (in_array(strtolower($code_type), array("code128", "code128b"))) {
            $chksum = 104;
            // Must not change order of array elements as the checksum depends on the array's key to validate final code
            $code_array = array(" " => "212222", "!" => "222122", "\"" => "222221", "#" => "121223", "$" => "121322", "%" => "131222", "&" => "122213", "'" => "122312", "(" => "132212", ")" => "221213", "*" => "221312", "+" => "231212", "," => "112232", "-" => "122132", "." => "122231", "/" => "113222", "0" => "123122", "1" => "123221", "2" => "223211", "3" => "221132", "4" => "221231", "5" => "213212", "6" => "223112", "7" => "312131", "8" => "311222", "9" => "321122", ":" => "321221", ";" => "312212", "<" => "322112", "=" => "322211", ">" => "212123", "?" => "212321", "@" => "232121", "A" => "111323", "B" => "131123", "C" => "131321", "D" => "112313", "E" => "132113", "F" => "132311", "G" => "211313", "H" => "231113", "I" => "231311", "J" => "112133", "K" => "112331", "L" => "132131", "M" => "113123", "N" => "113321", "O" => "133121", "P" => "313121", "Q" => "211331", "R" => "231131", "S" => "213113", "T" => "213311", "U" => "213131", "V" => "311123", "W" => "311321", "X" => "331121", "Y" => "312113", "Z" => "312311", "[" => "332111", "\\" => "314111", "]" => "221411", "^" => "431111", "_" => "111224", "\`" => "111422", "a" => "121124", "b" => "121421", "c" => "141122", "d" => "141221", "e" => "112214", "f" => "112412", "g" => "122114", "h" => "122411", "i" => "142112", "j" => "142211", "k" => "241211", "l" => "221114", "m" => "413111", "n" => "241112", "o" => "134111", "p" => "111242", "q" => "121142", "r" => "121241", "s" => "114212", "t" => "124112", "u" => "124211", "v" => "411212", "w" => "421112", "x" => "421211", "y" => "212141", "z" => "214121", "{" => "412121", "|" => "111143", "}" => "111341", "~" => "131141", "DEL" => "114113", "FNC 3" => "114311", "FNC 2" => "411113", "SHIFT" => "411311", "CODE C" => "113141", "FNC 4" => "114131", "CODE A" => "311141", "FNC 1" => "411131", "Start A" => "211412", "Start B" => "211214", "Start C" => "211232", "Stop" => "2331112");
            $code_keys = array_keys($code_array);
            $code_values = array_flip($code_keys);
            for ($X = 1; $X <= strlen($text); $X++) {
                $activeKey = substr($text, ($X - 1), 1);
                $code_string .= $code_array[$activeKey];
                $chksum = ($chksum + ($code_values[$activeKey] * $X));
            }
            $code_string .= $code_array[$code_keys[($chksum - (intval($chksum / 103) * 103))]];
            $code_string = "211214" . $code_string . "2331112";
        } elseif (strtolower($code_type) == "code128a") {
            $chksum = 103;
            $text = strtoupper($text); // Code 128A doesn't support lower case
            // Must not change order of array elements as the checksum depends on the array's key to validate final code
            $code_array = array(" " => "212222", "!" => "222122", "\"" => "222221", "#" => "121223", "$" => "121322", "%" => "131222", "&" => "122213", "'" => "122312", "(" => "132212", ")" => "221213", "*" => "221312", "+" => "231212", "," => "112232", "-" => "122132", "." => "122231", "/" => "113222", "0" => "123122", "1" => "123221", "2" => "223211", "3" => "221132", "4" => "221231", "5" => "213212", "6" => "223112", "7" => "312131", "8" => "311222", "9" => "321122", ":" => "321221", ";" => "312212", "<" => "322112", "=" => "322211", ">" => "212123", "?" => "212321", "@" => "232121", "A" => "111323", "B" => "131123", "C" => "131321", "D" => "112313", "E" => "132113", "F" => "132311", "G" => "211313", "H" => "231113", "I" => "231311", "J" => "112133", "K" => "112331", "L" => "132131", "M" => "113123", "N" => "113321", "O" => "133121", "P" => "313121", "Q" => "211331", "R" => "231131", "S" => "213113", "T" => "213311", "U" => "213131", "V" => "311123", "W" => "311321", "X" => "331121", "Y" => "312113", "Z" => "312311", "[" => "332111", "\\" => "314111", "]" => "221411", "^" => "431111", "_" => "111224", "NUL" => "111422", "SOH" => "121124", "STX" => "121421", "ETX" => "141122", "EOT" => "141221", "ENQ" => "112214", "ACK" => "112412", "BEL" => "122114", "BS" => "122411", "HT" => "142112", "LF" => "142211", "VT" => "241211", "FF" => "221114", "CR" => "413111", "SO" => "241112", "SI" => "134111", "DLE" => "111242", "DC1" => "121142", "DC2" => "121241", "DC3" => "114212", "DC4" => "124112", "NAK" => "124211", "SYN" => "411212", "ETB" => "421112", "CAN" => "421211", "EM" => "212141", "SUB" => "214121", "ESC" => "412121", "FS" => "111143", "GS" => "111341", "RS" => "131141", "US" => "114113", "FNC 3" => "114311", "FNC 2" => "411113", "SHIFT" => "411311", "CODE C" => "113141", "CODE B" => "114131", "FNC 4" => "311141", "FNC 1" => "411131", "Start A" => "211412", "Start B" => "211214", "Start C" => "211232", "Stop" => "2331112");
            $code_keys = array_keys($code_array);
            $code_values = array_flip($code_keys);
            for ($X = 1; $X <= strlen($text); $X++) {
                $activeKey = substr($text, ($X - 1), 1);
                $code_string .= $code_array[$activeKey];
                $chksum = ($chksum + ($code_values[$activeKey] * $X));
            }
            $code_string .= $code_array[$code_keys[($chksum - (intval($chksum / 103) * 103))]];
            $code_string = "211412" . $code_string . "2331112";
        } elseif (strtolower($code_type) == "code39") {
            $code_array = array("0" => "111221211", "1" => "211211112", "2" => "112211112", "3" => "212211111", "4" => "111221112", "5" => "211221111", "6" => "112221111", "7" => "111211212", "8" => "211211211", "9" => "112211211", "A" => "211112112", "B" => "112112112", "C" => "212112111", "D" => "111122112", "E" => "211122111", "F" => "112122111", "G" => "111112212", "H" => "211112211", "I" => "112112211", "J" => "111122211", "K" => "211111122", "L" => "112111122", "M" => "212111121", "N" => "111121122", "O" => "211121121", "P" => "112121121", "Q" => "111111222", "R" => "211111221", "S" => "112111221", "T" => "111121221", "U" => "221111112", "V" => "122111112", "W" => "222111111", "X" => "121121112", "Y" => "221121111", "Z" => "122121111", "-" => "121111212", "." => "221111211", " " => "122111211", "$" => "121212111", "/" => "121211121", "+" => "121112121", "%" => "111212121", "*" => "121121211");
            // Convert to uppercase
            $upper_text = strtoupper($text);
            for ($X = 1; $X <= strlen($upper_text); $X++) {
                $code_string .= $code_array[substr($upper_text, ($X - 1), 1)] . "1";
            }
            $code_string = "1211212111" . $code_string . "121121211";
        } elseif (strtolower($code_type) == "code25") {
            $code_array1 = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
            $code_array2 = array("3-1-1-1-3", "1-3-1-1-3", "3-3-1-1-1", "1-1-3-1-3", "3-1-3-1-1", "1-3-3-1-1", "1-1-1-3-3", "3-1-1-3-1", "1-3-1-3-1", "1-1-3-3-1");
            for ($X = 1; $X <= strlen($text); $X++) {
                for ($Y = 0; $Y < count($code_array1); $Y++) {
                    if (substr($text, ($X - 1), 1) == $code_array1[$Y])
                        $temp[$X] = $code_array2[$Y];
                }
            }
            for ($X = 1; $X <= strlen($text); $X+=2) {
                if (isset($temp[$X]) && isset($temp[($X + 1)])) {
                    $temp1 = explode("-", $temp[$X]);
                    $temp2 = explode("-", $temp[($X + 1)]);
                    for ($Y = 0; $Y < count($temp1); $Y++)
                        $code_string .= $temp1[$Y] . $temp2[$Y];
                }
            }
            $code_string = "1111" . $code_string . "311";
        } elseif (strtolower($code_type) == "codabar") {
            $code_array1 = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0", "-", "$", ":", "/", ".", "+", "A", "B", "C", "D");
            $code_array2 = array("1111221", "1112112", "2211111", "1121121", "2111121", "1211112", "1211211", "1221111", "2112111", "1111122", "1112211", "1122111", "2111212", "2121112", "2121211", "1121212", "1122121", "1212112", "1112122", "1112221");
            // Convert to uppercase
            $upper_text = strtoupper($text);
            for ($X = 1; $X <= strlen($upper_text); $X++) {
                for ($Y = 0; $Y < count($code_array1); $Y++) {
                    if (substr($upper_text, ($X - 1), 1) == $code_array1[$Y])
                        $code_string .= $code_array2[$Y] . "1";
                }
            }
            $code_string = "11221211" . $code_string . "1122121";
        }
        // Pad the edges of the barcode
        $code_length = 20;
        if ($print) {
            $text_height = 30;
        } else {
            $text_height = 0;
        }

        for ($i = 1; $i <= strlen($code_string); $i++) {
            $code_length = $code_length + (integer) (substr($code_string, ($i - 1), 1));
        }
        if (strtolower($orientation) == "horizontal") {
            $img_width = $code_length;
            $img_height = $size;
        } else {
            $img_width = $size;
            $img_height = $code_length;
        }
        $image = imagecreate($img_width, $img_height + $text_height);
        $black = imagecolorallocate($image, 0, 0, 0);
        $white = imagecolorallocate($image, 255, 255, 255);
        imagefill($image, 0, 0, $white);
        if ($print) {
            imagestring($image, 5, 31, $img_height, $text, $black);
        }
        $location = 10;
        for ($position = 1; $position <= strlen($code_string); $position++) {
            $cur_size = $location + ( substr($code_string, ($position - 1), 1) );
            if (strtolower($orientation) == "horizontal")
                imagefilledrectangle($image, $location, 0, $cur_size, $img_height, ($position % 2 == 0 ? $white : $black));
            else
                imagefilledrectangle($image, 0, $location, $img_width, $cur_size, ($position % 2 == 0 ? $white : $black));
            $location = $cur_size;
        }

        // Draw barcode to the screen or save in a file
        if ($filepath == "") {
            header('Content-type: image/png');
            imagepng($image);
            imagedestroy($image);
        } else {
            imagepng($image, $filepath);
            imagedestroy($image);
        }
    }

    /*
     * create query for bulk update
     */

    public function createQueryForBulkInsert($table_name = '', $data = array()) {
        $sql = '';
        if (!empty($data)) {
            //INSERT INTO tbl_name (a,b,c) VALUES(1,2,3),(4,5,6),(7,8,9);
            $fields = $values = "";

            //fields code
            $fields_arr = $this->getL2Keys($data);
            foreach ($fields_arr as $key_fa => $val_fa) {
                $fields_arr[$key_fa] = "`$val_fa`";
            }
            $fields = '(' . implode(",", $fields_arr) . ')';

            //values codes
            $i = 0;
            foreach ($data as $key_d => $val_d) {
                $values_arr = array();
                foreach ($val_d as $key_d_in => $val_d_in) {
                    if ($val_d[$key_d_in] != null) {
                        $values_arr[] = "'" . mysql_real_escape_string($val_d[$key_d_in]) . "'";
                    } else {
                        $values_arr[] = "" . mysql_real_escape_string($val_d[$key_d_in]) . "";
                    }
                }
                if ($i != 0) {
                    $values .= ", ";
                }
                $values .= '(' . implode(",", $values_arr) . ')';

                $i++;
            }

            //query
            $sql = "INSERT INTO `$table_name` $fields VALUES $values";
        }

        return $sql;
    }

    /*
     * Gets a list of all the 2nd-level keys in the array
     */

    public function getL2Keys($array) {
        $result = array();
        foreach ($array as $sub) {
            $result = array_merge($result, $sub);
        }
        return array_keys($result);
    }

    /*
     * set login session data
     */

    public function setLoginSessionData() {
        $session = Yii::$app->session;
        if (empty($session['user_id']) || empty($session['current_user_role_base_permissions'])) {
            if (!empty(Yii::$app->user->identity->id)) {
                $user_detail = \app\models\Admin::findOne(Yii::$app->user->identity->id);
                $session['user_id'] = Yii::$app->user->identity->id;
                $session['user_type'] = Yii::$app->user->identity->user_type;
                $session['current_user_role_base_permissions'] = $this->updateRoleBasePermissionsArr();
                $session['first_name'] = $user_detail->first_name;
                $session['profile_pic'] = $user_detail->profile_picture;
            } else {
                $session['user_id'] = 0;
                $session['user_type'] = 0;
                $session['current_user_role_base_permissions'] = array();
            }
        }
    }

    /*
     * Get login user detail
     */

    public function getLoginUserDetail($user_id = '0') {
        $return = array();
        if (!empty($user_id)) {
            $model_user = Users::findOne($user_id);
            if(empty($model_user)){
                $model_user = \app\models\Admin::findOne($user_id);
            }
            if (!empty($model_user)) {
                $return['user_id'] = $model_user->id;
                $return['user_type'] = $model_user->user_type;
                $return['first_name'] = $model_user->first_name;
                $return['last_name'] = $model_user->last_name;
            }
        }
        return $return;
    }

    /*
     * backup the db OR just a table
     */

    public function actionDatabase_backup() {
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
            $dbname = 'demoproject_v1';
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

    public function array_sort($array, $on, $order = SORT_ASC) {
        $new_array = array();
        $sortable_array = array();
        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $on) {
                            $sortable_array[$k] = $v2;
                        }
                    }
                } else {
                    $sortable_array[$k] = $v;
                }
            }
            switch ($order) {
                case SORT_ASC:
                    asort($sortable_array);
                    break;
                case SORT_DESC:
                    arsort($sortable_array);
                    break;
            }

            foreach ($sortable_array as $k => $v) {
                $new_array[$k] = $array[$k];
            }
        }
        return $new_array;
    }
    /*
     * Description: Get Time ago
     */
    public function ago($time) {
        $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
        $lengths = array("60", "60", "24", "7", "4.35", "12", "10");
        //#$now = time();
        $get_current_timestamp_from_db = self::getCurrentTimestampFromDB();
        $now = strtotime($get_current_timestamp_from_db);
        $difference = $now - $time;
        $tense = "ago";

        for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths) - 1; $j++) {
            $difference /= $lengths[$j];
        }

        $difference = round($difference);

        if ($difference != 1) {
            $periods[$j].= "s";
        }

        return "$difference $periods[$j] ago ";
    }
    /*
     * Description: Get database time
     */
    public function getCurrentTimestampFromDB() {
        $current_timestamp = '';
        $current_timestamp = Yii::$app->db->createCommand('SELECT NOW() as my_db_current_time')->queryAll(); // Yii-2

        if (empty($current_timestamp)) {
            $current_timestamp = array('CURRENT_TIMESTAMP' => date('Y-m-d H:i:s'));
        } else {
            $ctime = $current_timestamp[0]['my_db_current_time'];
            $current_timestamp = array('CURRENT_TIMESTAMP' => $ctime);
        }
        return $current_timestamp['CURRENT_TIMESTAMP'];
    }

    /*
     * Call curl
     */

    public function call_curl($type = '', $url = '', $params = array()) {
        $result = '';
        if (!empty($url)) {
            if ($type == 'ROW_JSON') {
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
                $result = curl_exec($curl);
                curl_close($curl);
            } elseif ($type == 'GET') {
                // Get cURL resource
                $curl = curl_init();
                // Set some options - we are passing in a useragent too here
                curl_setopt_array($curl, array(
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_URL => $url,
                        //#CURLOPT_USERAGENT => 'Codular Sample cURL Request'
                ));
                // Send the request & save response to $resp
                $result = curl_exec($curl);
                // Close request to clear up some resources
                curl_close($curl);
            } elseif ($type == 'POST') {
                // Get cURL resource
                $curl = curl_init();
                // Set some options - we are passing in a useragent too here
                curl_setopt_array($curl, array(
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_URL => $url,
                    //#CURLOPT_USERAGENT => 'Codular Sample cURL Request',
                    CURLOPT_POST => 1,
                    CURLOPT_POSTFIELDS => $params
                ));
                // Send the request & save response to $resp
                $result = curl_exec($curl);
                // Close request to clear up some resources
                curl_close($curl);
            }
        }
        return $result;
    }
    
    /*
     * Descrioption: To close fency box
     */
    public function close_fancybox($redirect_url)
    {
        echo "<script type='text/javascript' src='http://code.jquery.com/jquery-1.11.1.js'></script>
        <script type='text/javascript'>
                $(function() { parent.$.fancybox.close(); });
                window.parent.location.href = '" . $redirect_url . "';
                </script>";
    }
    
    /*
     * Description: Get Latitude longitude by address
     */
    public function getLatLngUsingGoogleMaps($address) {
        $address = urlencode($address);
        $url = "http://maps.googleapis.com/maps/api/geocode/json?address=$address&sensor=false";

        // Make the HTTP request
        $data = @file_get_contents($url);
        
        // Parse the json response
        $jsondata = json_decode($data,true); //echo "<pre>"; print_r($jsondata); die;

        // If the json data is invalid, return empty array
        if (!$this->check_googleapis_status($jsondata)) {
            return array(); 
        }
        
        $LatLng = array(
            'lat' => $jsondata["results"][0]["geometry"]["location"]["lat"],
            'lng' => $jsondata["results"][0]["geometry"]["location"]["lng"],
            'address' => $jsondata["results"][0]["formatted_address"],
        );
        
        return $LatLng;
    }
    
    /**
     * @Return: get_language_name
     */
    public function get_language_name($id){
        $model = Language::find()->where(['id' => $id])->one();
        return $model->language;
    }
    
    public function post_image_view($image){
        if(!empty($image) && file_exists(POSTS_PICTURE_ABS_THUMBNAIL.$image)){
            return '<img src="'.POSTS_PICTURE_URL_THUMBNAIL.$image.'" style="width:150px;" >';
        }
    }
    public function post_type($type){
        if($type == 1):
            return 'Image';
        else:
            return 'Canvas';
        endif;
    }
    
}
