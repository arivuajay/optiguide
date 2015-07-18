<?php

class Myclass extends CController {

    public static function encrypt($value) {
        return hash("sha512", $value);
    }

    public static function refencryption($str) {
        return base64_encode($str);
    }

    public static function refdecryption($str) {
        return base64_decode($str);
    }

    public static function t($str = '', $params = array(), $dic = 'app') {
        return Yii::t($dic, $str, $params);
    }

    public static function getRandomString($length = 9) {
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890"; //length:36
        $final_rand = '';
        for ($i = 0; $i < $length; $i++) {
            $final_rand .= $chars[rand(0, strlen($chars) - 1)];
        }
        return $final_rand;
    }

    public static function slugify($text) {
        // replace non letter or digits by -
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
        // trim
        $text = trim($text, '-');
        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        // lowercase
        $text = strtolower($text);
        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    public static function rememberMeAdmin($username, $check) {
        if ($check > 0) {
            $time = time();     // Gets the current server time
            $cookie = new CHttpCookie('admin_username', $username);

            $cookie->expire = $time + 60 * 60 * 24 * 30;               // 30 days
            Yii::app()->request->cookies['admin_username'] = $cookie;
        } else {
            unset(Yii::app()->request->cookies['admin_username']);
        }
    }

    public static function getallcountries($id = null) {
        $criteria = new CDbCriteria;
        $criteria->order = 'NOM_PAYS_FR ASC';
        if (!is_null($id)) {
            $criteria->condition = 'ID_PAYS=:id';
            $criteria->params = array(':id' => $id);
        }
        $country = CountryDirectory::model()->findAll($criteria);
        $val = CHtml::listData($country, 'ID_PAYS', 'NOM_PAYS_FR');
        return $val;
    }

    public static function getallregions($id = null) {
        $criteria_reg = new CDbCriteria;
        $criteria_reg->order = 'NOM_REGION_FR ASC';
        if (!is_null($id)) {
            $criteria_reg->condition = 'ID_PAYS=:id';
            $criteria_reg->params = array(':id' => $id);
        }

        $regions = RegionDirectory::model()->findAll($criteria_reg);

        $regions = CHtml::listData($regions, 'ID_REGION', 'NOM_REGION_FR');

        return $regions;
    }

    public static function getallcities($id = NULL) {
        $criteria_reg = new CDbCriteria;
        $criteria_reg->order = 'NOM_VILLE ASC';
        if (!is_null($id)) {
            $criteria_reg->condition = 'ID_REGION=:id';
            $criteria_reg->params = array(':id' => $id);
        }
        $cities = CityDirectory::model()->findAll($criteria_reg);
        $cities = CHtml::listData($cities, 'ID_VILLE', 'NOM_VILLE');
        return $cities;
    }

    public static function getGuid($opt = false) {
        if (function_exists('com_create_guid')) {
            if ($opt) {
                return com_create_guid();
            } else {
                return trim(com_create_guid(), '{}');
            }
        } else {
            mt_srand((double) microtime() * 10000);    // optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);    // "-"
            $left_curly = $opt ? chr(123) : "";     //  "{"
            $right_curly = $opt ? chr(125) : "";    //  "}"
            $uuid = $left_curly
                    . substr($charid, 0, 8) . $hyphen
                    . substr($charid, 8, 4) . $hyphen
                    . substr($charid, 12, 4) . $hyphen
                    . substr($charid, 16, 4) . $hyphen
                    . substr($charid, 20, 12)
                    . $right_curly;
            return $uuid;
        }
    }

}
