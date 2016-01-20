<?php

class Myclass extends CController {

    const TAX = 5; // In Percentage

    public static function encrypt($value) {
        return hash("sha512", $value);
    }

    public static function calculatetax($regionid) {
        $region_result = RegionDirectory::model()->findByPk($regionid);
        $taxtype = $region_result->taxt_type;
        $provincial_rates = $region_result->provincial_rates;
        $federal_rates = $region_result->federal_rates;
        $total_tax = ( $provincial_rates + $federal_rates);

        $taxvals['taxtype'] = $taxtype;
        $taxvals['provincialrates'] = $provincial_rates;
        $taxvals['federalrates'] = $federal_rates;
        $taxvals['total_tax'] = $total_tax;

        return $taxvals;
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

    public static function getRandomNUmbers($length = 8) {
        $chars = "1234567890";
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

    public static function is_home_page() {
        $app = Yii::app();
        return $app->controller->route == $app->defaultController;
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

    public static function getcountries($id) {
        $criteria = new CDbCriteria;

        $countryname = 'NOM_PAYS_' . Yii::app()->session['language'];

        $criteria->order = $countryname . ' ASC';
        if (!is_null($id)) {
            $criteria->condition = 'ID_PAYS=:id';
            $criteria->params = array(':id' => $id);
        }

        $country = CountryDirectory::model()->find($criteria);
        $val = $country->$countryname;
        return $val;
    }

    public static function getallcountries1($id = null) {
        $criteria = new CDbCriteria;

        $countryname = 'NOM_PAYS_' . Yii::app()->session['language'];

        $criteria->order = $countryname . ' ASC';
        if (!is_null($id)) {
            $criteria->condition = 'ID_PAYS=:id  ';
            $criteria->params = array(':id' => $id);
        }
        $country = CountryDirectory::model()->findAll($criteria);
        $val = CHtml::listData($country, 'ID_PAYS', $countryname);
        return $val;
    }

    public static function getallcountries($id = null) {
        $criteria = new CDbCriteria;
        $val = 1;
        $countryname = 'NOM_PAYS_' . Yii::app()->session['language'];

        $criteria->order = $countryname . ' ASC';
        if (!is_null($id)) {
            $criteria->condition = 'ID_PAYS=:id  ';
            $criteria->params = array(':id' => $id);
        }
        $criteria->condition = 'Flag_List != :val';
        $criteria->params = array(':val' => $val);
        $country = CountryDirectory::model()->findAll($criteria);
        $val = CHtml::listData($country, 'ID_PAYS', $countryname);
        return $val;
    }

    public static function getallregions($id = null) {
        $regions = array();
        $criteria_reg = new CDbCriteria;

        $regionname = 'NOM_REGION_' . Yii::app()->session['language'];

        $criteria_reg->order = $regionname . ' ASC';
        if (!is_null($id)) {
            $criteria_reg->condition = 'ID_PAYS=:id';
            $criteria_reg->params = array(':id' => $id);
            $regions = RegionDirectory::model()->findAll($criteria_reg);
            $regions = CHtml::listData($regions, 'ID_REGION', $regionname);
        }

        return $regions;
    }

    public static function getallcities($id = null) {
        $cities = array();
        $criteria_reg = new CDbCriteria;
        $criteria_reg->order = 'NOM_VILLE ASC';
        if (!is_null($id)) {

            $criteria_reg->condition = 'ID_REGION=:id';
            $criteria_reg->params = array(':id' => $id);
            $cities_result = CityDirectory::model()->findAll($criteria_reg);
            $cities1["-1"] = Myclass::t('OG173');
            $cities2 = CHtml::listData($cities_result, 'ID_VILLE', 'NOM_VILLE');
            $cities = $cities1 + $cities2;
        }
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

    public static function getMonths() {
        $months = array(
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December',
        );
        return $months;
    }

    public static function getMonths_Fr($m) {
        $months = array(
            1 => 'Janvier',
            2 => 'Février',
            3 => 'Mars',
            4 => 'Avril',
            5 => 'Mai',
            6 => 'Juin',
            7 => 'Juillet',
            8 => 'Août',
            9 => 'Septembre',
            10 => 'Octobre',
            11 => 'Novembre',
            12 => 'Décembre',
        );
        return $months[$m];
    }

    public static function getBetweenDates($date_from, $date_to) {
        // Specify the start date. This date can be any English textual format  
        $date_from = strtotime($date_from); // Convert date to a UNIX timestamp  
        // Specify the end date. This date can be any English textual format  
        $date_to = strtotime($date_to); // Convert date to a UNIX timestamp  
        // Loop from the start date to end date and output all dates inbetween  
        $result = array();
        for ($i = $date_from; $i <= $date_to; $i+=86400) {
            $result[] = date("Y-m-d", $i);
        }
        return $result;
    }

    public static function banner_display($positionid) {

        $module_controller = Yii::app()->controller->id;
        $module_action = Yii::app()->controller->action->id;
        $sectionid = '';

        /*
          Module ids

          default ( Home or any other ) - 0
          calenderEvent                 - 1
          newsManagement                - 2
          suppliersDirectory            - 3
          professionalDirectory         - 4
          groupInformation              - 5
          retailerDirectory             - 6
          marqueDirectory               - 7
          suppliersDirectory - category - 8
         */

        if ($module_controller == "calenderEvent") {
            $current_moduleid = 1;
        } else if ($module_controller == "newsManagement") {
            $current_moduleid = 2;
        } else if ($module_controller == "suppliersDirectory") {
            $sectionid = isset($_GET['SuppliersDirectory']['ID_SECTION']) ? $_GET['SuppliersDirectory']['ID_SECTION'] : '';
            if ($module_action == "category") {
                $current_moduleid = 8;
            } else {
                $current_moduleid = 3;
            }
        } else if ($module_controller == "professionalDirectory") {
            $current_moduleid = 4;
        } else if ($module_controller == "groupInformation") {
            $current_moduleid = 5;
        } else if ($module_controller == "retailerDirectory") {
            $current_moduleid = 6;
        } else if ($module_controller == "marqueDirectory") {
            $sectionid = isset($_GET['MarqueDirectory']['ID_SECTION']) ? $_GET['MarqueDirectory']['ID_SECTION'] : '';
            $current_moduleid = 7;
        } else {
            $current_moduleid = 0;
        }

        $result = Myclass::get_banner_result($positionid, $current_moduleid, $sectionid);

        $html = '';
        if (!empty($result)) {
            $title = $result->TITRE;
            $linkurl = $result->LIEN_URL;
            $ads_id = $result->ID_PUBLICITE;
            $position = $result->ID_POSITION;
            $catid = $result->ArchiveFichier->ID_CATEGORIE;
            $img = $result->ArchiveFichier->FICHIER;

            $fileurl = Yii::app()->createAbsoluteUrl("/uploads/archivage/" . $catid . "/" . $img);
            $html = '<a target="_blank" href="' . $linkurl . '" class="adsclick" id="' . $ads_id . '" postionid="' . $positionid . '">' . CHtml::image($fileurl, $title) . '</a>';

            // Add one count for the loading banner.
            Yii::app()->db
                    ->createCommand("UPDATE publicite_publicite SET NB_IMPRESSIONS_FAITES = NB_IMPRESSIONS_FAITES + 1 WHERE ID_PUBLICITE=:adsId")
                    ->bindValues(array(':adsId' => $ads_id))
                    ->execute();
        } else {
            $adsresult = Myclass::get_adsense_result($positionid);
            if (!empty($adsresult)) {
                $html = $adsresult->content;
            }
        }

        return $html;
    }

    public static function get_adsense_result($positionid) {
        // For module / sections / default / datewise filters
        $criteria = new CDbCriteria();
        $criteria->addCondition("iId_position = " . $positionid);
        $criteria->addCondition("status = 1");
        $criteria->order = "RAND()";
        $criteria->limit = 1;
        $result = PubliciteAdsense::model()->find($criteria);
        return $result;
    }

    public static function get_banner_result($positionid, $current_moduleid, $sectionid) {
        $lang = strtoupper(Yii::app()->session['language']);
        $now = date('Y-m-d', time());


        // For module / sections / default / datewise filters
        $criteria = new CDbCriteria();

        $criteria->select = "LIEN_URL,ID_PUBLICITE,TITRE";
        $criteria->addCondition("LANGUE = '" . $lang . "'");
        $criteria->addCondition("ID_POSITION = " . $positionid);
        $criteria->addCondition("DATE_DEBUT <= '" . $now . "'");
        $criteria->addCondition("DATE_FIN >= '" . $now . "'");

        if ($current_moduleid > 0) {
            $criteria->addCondition("adm.ID_MODULE = " . $current_moduleid);
            $criteria->addCondition("AFFICHER_ACCUEIL = 0");
            // $criteria->addCondition("ZONE_AFFICHAGE = 2");
            $criteria->addCondition("PRIORITE = 0");

            if ($sectionid != '' && is_numeric($sectionid)) {
                $criteria->addCondition("adc.ID_SECTION = " . $sectionid);
            }
        } else {
            $criteria->addCondition("AFFICHER_ACCUEIL = 1");
            // $criteria->addCondition("ZONE_AFFICHAGE = 1");
            $criteria->addCondition("PRIORITE = 0");
        }

        $criteria->order = "RAND()";
        $criteria->limit = 1;

        // Merge other tables for banner image and modules , category check.
        if ($current_moduleid > 0) {
            $with_array["AdsLInkModule"] = array('alias' => 'adm', 'together' => true, 'select' => false);
        }

        if ($sectionid != '' && is_numeric($sectionid)) {
            $with_array["AdsLInkCategory"] = array('alias' => 'adc', 'together' => true, 'select' => false);
        }

        $with_array["ArchiveFichier"] = array('alias' => 'af', 'together' => true, 'select' => 'af.ID_CATEGORIE,af.FICHIER');

        $criteria->with = $with_array;

        $result = PublicityAds::model()->find($criteria);

        // For section based filters result only         
        if (empty($result)) {

            $criteria = new CDbCriteria();

            $criteria->select = "LIEN_URL,ID_PUBLICITE,TITRE";
            $criteria->addCondition("LANGUE = '" . $lang . "'");
            $criteria->addCondition("AFFICHER_ACCUEIL = 1");
            //  $criteria->addCondition("ZONE_AFFICHAGE = 2");
            $criteria->addCondition("PRIORITE = 0");
            if ($sectionid != '' && is_numeric($sectionid)) {
                $criteria->addCondition("adc.ID_SECTION = " . $sectionid);
            }
            $criteria->addCondition("ID_POSITION = " . $positionid);
            $criteria->addCondition("DATE_DEBUT <= '" . $now . "'");
            $criteria->addCondition("DATE_FIN >= '" . $now . "'");
            $criteria->order = "RAND()";
            $criteria->limit = 1;

            if ($sectionid != '' && is_numeric($sectionid)) {
                $with_array["AdsLInkCategory"] = array('alias' => 'adc', 'together' => true, 'select' => false);
            }

            $with_array["ArchiveFichier"] = array('alias' => 'af', 'together' => true, 'select' => 'af.ID_CATEGORIE,af.FICHIER');

            $criteria->with = $with_array;

            $result = PublicityAds::model()->find($criteria);
        }





        // If no record exists for previous conditions , get any one banner default for that postions

        if (empty($result)) {

            // If the condition gets empty result means , get any one banner without restrictions   
            $criteria = new CDbCriteria();

            $criteria->select = "LIEN_URL,ID_PUBLICITE,TITRE";
            $criteria->addCondition("LANGUE = '" . $lang . "'");
            // home section
            $criteria->addCondition("AFFICHER_ACCUEIL = 1");
            //public
            // $criteria->addCondition("ZONE_AFFICHAGE = 1");
            // date between
            $criteria->addCondition("PRIORITE = 0");
            $criteria->addCondition("ID_POSITION = " . $positionid);
            $criteria->addCondition("DATE_DEBUT <= '" . $now . "'");
            $criteria->addCondition("DATE_FIN >= '" . $now . "'");
            $criteria->order = "RAND()";
            $criteria->limit = 1;

            $with_array["ArchiveFichier"] = array('alias' => 'af', 'together' => true, 'select' => 'af.ID_CATEGORIE,af.FICHIER');

            $criteria->with = $with_array;

            $result = PublicityAds::model()->find($criteria);
        }

        return $result;
    }

    public static function currencyFormat($number) {

        $result = self::numberFormat($number);
        return $result . ' CAD' . $c;
    }

    public static function numberFormat($number) {
        if (Yii::app()->session['language'] == 'FR') {
            return number_format($number, 2, ",", " ");
        } else {
            return number_format($number, 2);
        }
    }

    public static function rep_taxpercentage() {
        $regionid = "";
        $tax_percentage = self::TAX;
        
        if (isset(Yii::app()->session['registration']['step2']['RepCredentialProfiles']['region'])) {
            $regionid = Yii::app()->session['registration']['step2']['RepCredentialProfiles']['region'];
        } elseif (isset(Yii::app()->user->id)) {
            $uid = Yii::app()->user->id;
            $profile_infos = RepCredentialProfiles::model()->find("rep_credential_id=" . $uid);
            $ville = $profile_infos->ID_VILLE;
            $regionid = CityDirectory::model()->findByPk($ville)->ID_REGION;
        }

        if ($regionid != '') {
            $taxprce = self::calculatetax($regionid);
            $tax_percentage = $taxprce['total_tax'];
        }
        
        return $tax_percentage;
    }

    public static function priceCalculation($no_of_accounts_purchased) {
        $findSubscriptionType = RepSubscriptionTypes::model()->findByAccountMembers($no_of_accounts_purchased);
        $subscription_type_id = $findSubscriptionType['rep_subscription_type_id'];
        $per_account_price = $findSubscriptionType['rep_subscription_price'];
        $total_price = $no_of_accounts_purchased * $per_account_price;
        $tax_percentage = self::rep_taxpercentage();
        $tax = $total_price * $tax_percentage / 100;
        $grand_total = $total_price + $tax;
        $result = array();
        $result['subscription_type_id'] = $subscription_type_id;
        $result['per_account_price'] = self::numberFormat($per_account_price);
        $result['total_price'] = self::numberFormat($total_price);
        $result['tax'] = self::numberFormat($tax);
        $result['grand_total'] = self::numberFormat($grand_total);
        return $result;
    }

    public static function priceCalculationWithMonths($months = 1, $no_of_accounts_purchased = 1, $offer_calculate = true) {
        $findSubscriptionType = RepSubscriptionTypes::model()->findByAccountMembers($no_of_accounts_purchased);
        $subscription_type_id = $findSubscriptionType['rep_subscription_type_id'];
        $per_account_price = $findSubscriptionType['rep_subscription_price'];
        $total_month_price = $per_account_price * $no_of_accounts_purchased * $months;

        if ($offer_calculate) {
            $offer_in_percentage = self::monthWiseOffer($months);
            $offer_price = $total_month_price * $offer_in_percentage / 100;
            $total = $total_month_price - $offer_price;
        } else {
            $offer_in_percentage = 0;
            $offer_price = 0;
            $total = $total_month_price;
        }

        $tax_percentage = self::rep_taxpercentage();

        $tax = $total * ($tax_percentage / 100);

        $grand_total = $total + $tax;

        $result = array();
        $result['subscription_type_id'] = $subscription_type_id;
        $result['per_account_price'] = self::numberFormat($per_account_price);
        $result['no_of_months'] = $months;
        $result['no_of_accounts_purchased'] = $no_of_accounts_purchased;
        $result['total_month_price'] = self::numberFormat($total_month_price);
        $result['offer_in_percentage'] = $offer_in_percentage;
        $result['offer_price'] = self::numberFormat($offer_price);
        $result['total_price'] = self::numberFormat($total);
        $result['tax'] = self::numberFormat($tax);
        $result['grand_total'] = self::numberFormat($grand_total);
        return $result;
    }

    public static function repAdminBuyMoreAccountsPriceCalculation($total_no_accounts, $no_of_accounts_purchase, $months = 1) {
        $findSubscriptionType = RepSubscriptionTypes::model()->findByAccountMembers($total_no_accounts);
        $subscription_type_id = $findSubscriptionType['rep_subscription_type_id'];
        $per_account_price = $findSubscriptionType['rep_subscription_price'];

        $total_month_price = $no_of_accounts_purchase * $per_account_price * $months;
        $total_price = $total_month_price;
        $tax_percentage = self::TAX;
        $tax = $total_price * $tax_percentage / 100;
        $grand_total = $total_price + $tax;

        $result = array();
        $result['subscription_type_id'] = $subscription_type_id;
        $result['per_account_price'] = self::numberFormat($per_account_price);
        $result['no_of_months'] = $months;
        $result['no_of_accounts_purchased'] = $no_of_accounts_purchase;
        $result['total_month_price'] = self::numberFormat($total_month_price);
        $result['total_price'] = self::numberFormat($total_price);
        $result['tax'] = self::numberFormat($tax);
        $result['grand_total'] = self::numberFormat($grand_total);
        return $result;
    }

    public static function generatemaplocation($address, $country, $region, $cty) {
        $geo_values = '';

        if ($address != '' && $country != '' && $region != '' && $cty != '') {
            $results = Yii::app()->db->createCommand() //this query contains all the data
                    ->select('NOM_VILLE ,  NOM_REGION_EN , ABREVIATION_EN ,  NOM_PAYS_EN')
                    ->from(array('repertoire_ville rv', 'repertoire_region rr', 'repertoire_pays AS rp'))
                    ->where("rv.ID_REGION = rr.ID_REGION AND  rr.ID_PAYS = rp.ID_PAYS AND rv.ID_VILLE = " . $cty)
                    ->queryAll();

            if (!empty($results)) {
                foreach ($results as $info) {
                    $city_nme = $info['NOM_VILLE'];
                    $region_nme = $info['NOM_REGION_EN'];
                    $country_nme = $info['NOM_PAYS_EN'];
                }

                $sample_address = $address . " , " . $city_nme . " ," . $region_nme . " ," . $country_nme;

                //Get lat ad long vales from gven addres
                Yii::import('ext.gmaps.*');
                $gMap = new EGMap();
                $geocoded_address = new EGMapGeocodedAddress($sample_address);
                $geocoded_address->geocode($gMap->getGMapClient());
                $lat_val = $geocoded_address->getLat();
                $long_val = $geocoded_address->getLng();

                $geo_values = $lat_val . "~" . $long_val;
            }
        }

        return $geo_values;
    }

    public static function format_numbers_words($totalusers) {

        if (!is_numeric($totalusers)) {
            return false;
        }

        // filter and format it 
        if ($totalusers > 1000000000000) {
            return round(($totalusers / 1000000000000)) . ' trillion';
        } elseif ($totalusers > 1000000000) {
            return round(($totalusers / 1000000000)) . ' billion';
        } elseif ($totalusers > 1000000) {
            return round(($totalusers / 1000000)) . ' million';
        } elseif ($totalusers > 10000) {
            return Myclass::t('OG210') . round(($totalusers / 1000)) . ' 000';
        } elseif ($totalusers > 1000) {
            return Myclass::t('OG210') . round(($totalusers / 1000)) . '000';
        } elseif ($totalusers > 100) {
            return Myclass::t('OG210') . round(($totalusers / 100)) . '00';
        } else {
            return $totalusers;
        }
    }

    public static function stats_display() {
        $stats_disp = 0;
        $repid = isset(Yii::app()->user->id) ? Yii::app()->user->id : '';
        if ($repid != '') {

            $get_uinfos = RepCredentials::model()->findByPk($repid);
            if (!empty($get_uinfos)) {
                $exprydate = date("Y-m-d", strtotime($get_uinfos['stat_expiry_date']));
                $stats_disp = ($exprydate > date("Y-m-d")) ? "1" : "0";
            }
        }
        return $stats_disp;
    }

    public static function noOfMonths() {
        $no_of_months = array(
            1 => '1 '.Myclass::t('OR755', '', 'or'),
            6 => '6 '.Myclass::t('OR755', '', 'or'),
            12 => '1 Year',
        );

        return $no_of_months;
    }

    public static function monthWiseOffer($month) {
        //1 - 1 Month, 0% OFFER
        //2 - 6 Months, 5% OFFER
        //3 - 1 Year, 10% OFFER
        if ($month == 12) {
            $offer_in_percentage = 10;
        } elseif ($month == 6) {
            $offer_in_percentage = 5;
        } else {
            $offer_in_percentage = 0;
        }
        return $offer_in_percentage;
    }

    public static function dateFormat($date) {
        if (strtotime($date) > 0)
            return date("Y-m-d", strtotime($date));
        else
            return '-';
    }

}
