<?php

namespace App\Helpers;

use Session;
use App;
use Carbon\Carbon;

class CommonHelper {

    public static function getClientUserData($format = 0, $skipIp = false) {
        $ret_arr = array();
        if (!$skipIp) {
            $ret_arr['ip'] = CommonHelper::get_client_ip();
        }

        $ret_arr['user_agent'] = @$_SERVER['HTTP_USER_AGENT'];

        switch ($format) {
            case 0:
                $ret_arr = json_encode($ret_arr);
                break;
            case 1:
                $ret_arr = serialize($ret_arr);
                break;
            case 2:
                break;
            default:
                $ret_arr = serialize($ret_arr);
                break;
        }

        return $ret_arr;
    }

    public static function get_client_ip() {
        $ipaddress = '';

        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if (isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';

        return $ipaddress;
    }

    static public function timestampToDate($timestamp, $time = false, $timeStamp = false, $day = false) {
        if ($timeStamp == false)
            $timestamp = strtotime($timestamp);
        if ($day) {
            $day = "l, ";
        } else {
            $day = "";
        }
        if (strlen($timestamp) > 0 && $timestamp > 0) {
            $date = date($day . " M d, Y", $timestamp);

            if ($time != false) {
                $date = date($day . "M d, Y h:i A", $timestamp);
            }

            return $date;
        } else {
            return "--";
        }
    }

    static public function timestampToTime($time) {
        return date('H:s a', strtotime($time));
    }

    static public function dateToDBTime($date) {
        return date('Y-m-d H:i:s', strtotime($date));
    }

    static public function dateRangeToDBTime($dates) {
        $date_arr = explode("-", $dates);
        $from_date = CommonHelper::dateToDBTime($date_arr[0]);
        $to_date = CommonHelper::dateToDBTime($date_arr[1]);
        return array($from_date, $to_date);
    }

    public static function daysBetweenDates($dates) {
        $date_arr = explode("-", $dates);
        return round(abs(strtotime($date_arr[1]) - strtotime($date_arr[0])) / 86400);
    }

    public static function daysBetweenDBDates($from_date, $to_date) {
        return round(abs(strtotime($to_date) - strtotime($from_date)) / 86400);
    }

    /**
     * Generate Random Key for ID
     * @return string
     */
    public static function random_guid() {
        $randomKey = 0;
        $randomKey2 = 0;
        do {
            $randomKey = CommonHelper::randomKey();
            $randomKey2 = CommonHelper::randomKey();
        } while ($randomKey == $randomKey2);

        return ($randomKey2);
    }

    public static function randomKey() {
        return mt_rand(10000, 999999);
    }

    /**
     * Function to Generate Random Salt ..
     * @author cis
     * @todo Need to change the Salt generation logic
     */
    public static function getRandomSalt() {
        $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
        return $random_salt;
    }

    /**
     * Function to Encrypt password ...
     * @param unknown_type $password
     * @return string | encrypted password string
     */
    public static function encryptPassword($password = null, $random_salt = null) {

        if (strlen($password) < 1) {
            return false;
        }

        if (is_null($random_salt)) {
            $random_salt = self::getRandomSalt();
        }

        $password = self::passwordEncryptionMethod($password, $random_salt);
        return array($password, $random_salt);
    }

    /**
     * Function to validate User Password ...
     * @param string $requestPassword
     * @param string $random_salt
     * @param string $dbPassword
     * @return boolean
     */
    public static function validateUserPassword($requestPassword = null, $random_salt = null, $dbPassword = null) {
        if (is_null($requestPassword) || is_null($random_salt) || is_null($dbPassword)) {
            return false;
        }
        $generatedHashedPassword = self::passwordEncryptionMethod($requestPassword, $random_salt);
        if (strcmp($generatedHashedPassword, $dbPassword) === 0) {
            return true;
        }

        return false;
    }

    /**
     * Function for Core Password Encryption Logic ...
     * @param string $password
     * @param string $random_salt
     * @return string
     * @todo Need to alter this logic for encryption
     */
    public static function passwordEncryptionMethod($password = null, $random_salt = null) {

        try {
            $password = hash('sha512', $password . $random_salt);
            return $password;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Function to generate random password for the first Use ...
     * @param integer $length
     * @return string
     */
    public static function generateRandomPassword($length = '4') {
        $str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-_?/:(){}[]0123456789';
        $max = strlen($str);
        $length = @round($length);
        if (empty($length)) {
            $length = rand(8, 12);
        }
        $password = '';
        for ($i = 0; $i < $length; $i++) {
            $password.=$str{rand(0, $max - 1)};
        }
        return $password;
    }

    public static function defaultJson() {
        return array(
            'success' => 0,
            'success_mess' => "",
            'error' => 0,
            'error_mess' => "",
        );
    }

    /**
     * Generate Random Key for Document
     * @return string
     */
    public static function getEncryptedKey() {
        $randomKey = 0;
        $randomKey2 = 0;
        do {
            $randomKey = CommonHelper::randomKey();
            $randomKey2 = CommonHelper::randomKey();
        } while ($randomKey == $randomKey2);

        return md5($randomKey2 . time());
    }

    function copyr($source, $dest) {
        // Check for symlinks
        if (is_link($source)) {
            return symlink(readlink($source), $dest);
        }

        // Simple copy for a file
        if (is_file($source)) {
            return copy($source, $dest);
        }

        // Make destination directory
        if (!is_dir($dest)) {
            mkdir($dest);
        }

        // Loop through the folder
        $dir = dir($source);
        while (false !== $entry = $dir->read()) {
            // Skip pointers
            if ($entry == '.' || $entry == '..') {
                continue;
            }

            // Deep copy directories
            CommonHelper::copyr("$source/$entry", "$dest/$entry");
        }

        // Clean up
        $dir->close();
        return true;
    }

    static public function nohtmldata($text) {
        $text = CommonHelper::cleaninputdata($text);
        $text = htmlspecialchars($text);
        return $text;
    }

    public static function htmldata($text) {
        $text = CommonHelper::uncleaninputdata($text);
        $text = htmlspecialchars_decode($text);
        return $text;
    }

    static public function cleaninputdata($text) {

        return stripslashes($text);
    }

    static public function uncleaninputdata($text) {

        return addslashes($text);
    }

    static public function spacetounderscore($text) {
        return str_replace(" ", "_", $text);
    }

    public static function convert_special_simple($txt) {
        $transliterationTable = array(
            'á' => 'a', 'Á' => 'A', 'à' => 'a', 'À' => 'A', 'ă' => 'a', 'Ă' => 'A', 'â' => 'a',
            'Â' => 'A', 'å' => 'a', 'Å' => 'A', 'ã' => 'a', 'Ã' => 'A', 'ą' => 'a', 'Ą' => 'A',
            'ā' => 'a', 'Ā' => 'A', 'ä' => 'ae', 'Ä' => 'AE', 'æ' => 'ae', 'Æ' => 'AE', 'ḃ' => 'b',
            'Ḃ' => 'B', 'ć' => 'c', 'Ć' => 'C', 'ĉ' => 'c', 'Ĉ' => 'C', 'č' => 'c', 'Č' => 'C', 'ċ' => 'c',
            'Ċ' => 'C', 'ç' => 'c', 'Ç' => 'C', 'ď' => 'd', 'Ď' => 'D', 'ḋ' => 'd', 'Ḋ' => 'D', 'đ' => 'd',
            'Đ' => 'D', 'ð' => 'dh', 'Ð' => 'Dh', 'é' => 'e', 'É' => 'E', 'è' => 'e', 'È' => 'E', 'ĕ' => 'e',
            'Ĕ' => 'E', 'ê' => 'e', 'Ê' => 'E', 'ě' => 'e', 'Ě' => 'E', 'ë' => 'e', 'Ë' => 'E', 'ė' => 'e',
            'Ė' => 'E', 'ę' => 'e', 'Ę' => 'E', 'ē' => 'e', 'Ē' => 'E', 'ḟ' => 'f', 'Ḟ' => 'F', 'ƒ' => 'f',
            'Ƒ' => 'F', 'ğ' => 'g', 'Ğ' => 'G', 'ĝ' => 'g', 'Ĝ' => 'G', 'ġ' => 'g', 'Ġ' => 'G', 'ģ' => 'g',
            'Ģ' => 'G', 'ĥ' => 'h', 'Ĥ' => 'H', 'ħ' => 'h', 'Ħ' => 'H', 'í' => 'i', 'Í' => 'I', 'ì' => 'i',
            'Ì' => 'I', 'î' => 'i', 'Î' => 'I', 'ï' => 'i', 'Ï' => 'I', 'ĩ' => 'i', 'Ĩ' => 'I', 'į' => 'i',
            'Į' => 'I', 'ī' => 'i', 'Ī' => 'I', 'ĵ' => 'j', 'Ĵ' => 'J', 'ķ' => 'k', 'Ķ' => 'K', 'ĺ' => 'l',
            'Ĺ' => 'L', 'ľ' => 'l', 'Ľ' => 'L', 'ļ' => 'l', 'Ļ' => 'L', 'ł' => 'l', 'Ł' => 'L', 'ṁ' => 'm',
            'Ṁ' => 'M', 'ń' => 'n', 'Ń' => 'N', 'ň' => 'n', 'Ň' => 'N', 'ñ' => 'n', 'Ñ' => 'N', 'ņ' => 'n',
            'Ņ' => 'N', 'ó' => 'o', 'Ó' => 'O', 'ò' => 'o', 'Ò' => 'O', 'ô' => 'o', 'Ô' => 'O', 'ő' => 'o',
            'Ő' => 'O', 'õ' => 'o', 'Õ' => 'O', 'ø' => 'oe', 'Ø' => 'OE', 'ō' => 'o', 'Ō' => 'O', 'ơ' => 'o',
            'Ơ' => 'O', 'ö' => 'oe', 'Ö' => 'OE', 'ṗ' => 'p', 'Ṗ' => 'P', 'ŕ' => 'r', 'Ŕ' => 'R', 'ř' => 'r',
            'Ř' => 'R', 'ŗ' => 'r', 'Ŗ' => 'R', 'ś' => 's', 'Ś' => 'S', 'ŝ' => 's', 'Ŝ' => 'S', 'š' => 's',
            'Š' => 'S', 'ṡ' => 's', 'Ṡ' => 'S', 'ş' => 's', 'Ş' => 'S', 'ș' => 's', 'Ș' => 'S', 'ß' => 'SS',
            'ť' => 't', 'Ť' => 'T', 'ṫ' => 't', 'Ṫ' => 'T', 'ţ' => 't', 'Ţ' => 'T', 'ț' => 't', 'Ț' => 'T',
            'ŧ' => 't', 'Ŧ' => 'T', 'ú' => 'u', 'Ú' => 'U', 'ù' => 'u', 'Ù' => 'U', 'ŭ' => 'u', 'Ŭ' => 'U',
            'û' => 'u', 'Û' => 'U', 'ů' => 'u', 'Ů' => 'U', 'ű' => 'u', 'Ű' => 'U', 'ũ' => 'u', 'Ũ' => 'U',
            'ų' => 'u', 'Ų' => 'U', 'ū' => 'u', 'Ū' => 'U', 'ư' => 'u', 'Ư' => 'U', 'ü' => 'ue', 'Ü' => 'UE',
            'ẃ' => 'w', 'Ẃ' => 'W', 'ẁ' => 'w', 'Ẁ' => 'W', 'ŵ' => 'w', 'Ŵ' => 'W', 'ẅ' => 'w', 'Ẅ' => 'W',
            'ý' => 'y', 'Ý' => 'Y', 'ỳ' => 'y', 'Ỳ' => 'Y', 'ŷ' => 'y', 'Ŷ' => 'Y', 'ÿ' => 'y', 'Ÿ' => 'Y',
            'ź' => 'z', 'Ź' => 'Z', 'ž' => 'z', 'Ž' => 'Z', 'ż' => 'z', 'Ż' => 'Z', 'þ' => 'th', 'Þ' => 'Th',
            'µ' => 'u', 'а' => 'a', 'А' => 'a', 'б' => 'b', 'Б' => 'b', 'в' => 'v', 'В' => 'v', 'г' => 'g',
            'Г' => 'g', 'д' => 'd', 'Д' => 'd', 'е' => 'e', 'Е' => 'e', 'ё' => 'e', 'Ё' => 'e', 'ж' => 'zh',
            'Ж' => 'zh', 'з' => 'z', 'З' => 'z', 'и' => 'i', 'И' => 'i', 'й' => 'j', 'Й' => 'j', 'к' => 'k',
            'К' => 'k', 'л' => 'l', 'Л' => 'l', 'м' => 'm', 'М' => 'm', 'н' => 'n', 'Н' => 'n', 'о' => 'o',
            'О' => 'o', 'п' => 'p', 'П' => 'p', 'р' => 'r', 'Р' => 'r', 'с' => 's', 'С' => 's', 'т' => 't',
            'Т' => 't', 'у' => 'u', 'У' => 'u', 'ф' => 'f', 'Ф' => 'f', 'х' => 'h', 'Х' => 'h', 'ц' => 'c',
            'Ц' => 'c', 'ч' => 'ch', 'Ч' => 'ch', 'ш' => 'sh', 'Ш' => 'sh', 'щ' => 'sch', 'Щ' => 'sch',
            'ъ' => '', 'Ъ' => '', 'ы' => 'y', 'Ы' => 'y', 'ь' => '', 'Ь' => '', 'э' => 'e', 'Э' => 'e',
            'ю' => 'ju', 'Ю' => 'ju', 'я' => 'ja', 'Я' => 'ja');
        $txt = str_replace(array_keys($transliterationTable), array_values($transliterationTable), $txt);
        return $txt;
    }

    public static function replaceTitle($retour) {

        $retour = str_replace(" ", "-", $retour);
        $retour = str_replace(",", "-", $retour);
        $retour = str_replace("-", "-", $retour);
        $retour = str_replace(".", "-", $retour);
        $retour = str_replace("*", "-", $retour);
        $retour = str_replace("#", "-", $retour);
        $retour = str_replace("@", "-", $retour);
        $retour = str_replace("&amp;", "-", $retour);
        $retour = str_replace("|", "-", $retour);
        $retour = str_replace("&", "-", $retour);
        $retour = str_replace("(", "-", $retour);
        $retour = str_replace(";", "-", $retour);
        $retour = str_replace(")", "-", $retour);
        $retour = str_replace(",", "-", $retour);
        $retour = str_replace("/", "-", $retour);
        $retour = str_replace("+", "-", $retour);
        $retour = str_replace("=", "-", $retour);
        $retour = str_replace("]", "-", $retour);
        $retour = str_replace("[", "-", $retour);
        $retour = str_replace("°", "-", $retour);
        $retour = str_replace("?", "-", $retour);
        $retour = str_replace("!", "-", $retour);
        $retour = str_replace("%", "-", $retour);
        $retour = str_replace("µ", "-", $retour);
        $retour = str_replace("§", "-", $retour);
        $retour = str_replace(":", "-", $retour);
        $retour = str_replace("$", "-", $retour);
        $retour = str_replace("£", "-", $retour);
        $retour = str_replace("¤", "-", $retour);
        $retour = str_replace("\xE2\x82\xAc", "-", $retour);

        return $retour;
    }

    public static function createItemUrl($url) {
        $url = strtolower($url);
        $url = CommonHelper::convert_special_simple($url);
        $url = CommonHelper::replaceTitle($url);
        $url = preg_replace('/[^A-Za-z0-9\-]/', '', $url);
        $url = rtrim($url, "-");
        return $url;
    }

    public static function getCurlData($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.16) Gecko/20110319 Firefox/3.6.16");
        $curlData = curl_exec($curl);
        curl_close($curl);
        return $curlData;
    }

    public static function getCurrentUrl() {
        // return \Url::full();
        return \Request::url();
    }

    public static function getBrowser() {
        $u_agent = $_SERVER['HTTP_USER_AGENT'];
        $bname = 'Unknown';
        $platform = 'Unknown';
        $version = "";

        //First get the platform?
        if (preg_match('/linux/i', $u_agent)) {
            $platform = 'linux';
        } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            $platform = 'mac';
        } elseif (preg_match('/windows|win32/i', $u_agent)) {
            $platform = 'windows';
        }

        // Next get the name of the useragent yes seperately and for good reason
        if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
            $bname = 'Internet Explorer';
            $ub = "MSIE";
        } elseif (preg_match('/Firefox/i', $u_agent)) {
            $bname = 'Mozilla Firefox';
            $ub = "Firefox";
        } elseif (preg_match('/Chrome/i', $u_agent)) {
            $bname = 'Google Chrome';
            $ub = "Chrome";
        } elseif (preg_match('/Safari/i', $u_agent)) {
            $bname = 'Apple Safari';
            $ub = "Safari";
        } elseif (preg_match('/Opera/i', $u_agent)) {
            $bname = 'Opera';
            $ub = "Opera";
        } elseif (preg_match('/Netscape/i', $u_agent)) {
            $bname = 'Netscape';
            $ub = "Netscape";
        }

        // finally get the correct version number
        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) .
                ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (!preg_match_all($pattern, $u_agent, $matches)) {
            // we have no matching number just continue
        }

        // see how many we have
        $i = count($matches['browser']);
        if ($i != 1) {
            //we will have two since we are not using 'other' argument yet
            //see if version is before or after the name
            if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
                $version = $matches['version'][0];
            } else {
                $version = $matches['version'][1];
            }
        } else {
            $version = $matches['version'][0];
        }

        // check if we have a number
        if ($version == null || $version == "") {
            $version = "?";
        }

        return array(
            'userAgent' => $u_agent,
            'name' => $bname,
            'version' => $version,
            'platform' => $platform,
            'pattern' => $pattern
        );
    }

    public static function getBrowserName() {
        $browser = CommonHelper::getBrowser();
        return $browser['name'];
    }

    public static function getHttpReffer() {
        if (isset($_SERVER['HTTP_REFERER']))
            return $_SERVER['HTTP_REFERER'];
        else
            return false;
    }

    public static function getIpData($ip) {
        $url = "http://ip-api.com/php/";
        $content = @file_get_contents($url);
        return $content = unserialize($content);
    }

    public static function display_money($number) {
        return "$" . number_format($number, 2, ".", ",");
    }

    public static function titleName($title) {
        $title = strtolower($title);
        return ucfirst($title);
    }

    public static function time_elapsed_string($ptime) {
        $etime = $ptime - time(); // formula to convert into elapsed time
        return CommonHelper::getInElapsed($etime);
    }

    public static function time_ago($ptime) {
        $etime = time() - $ptime; // formula to convert into ago time
        return CommonHelper::getInElapsed($etime);
    }

    public static function getInElapsed($etime) {
        if ($etime < 1) {
            return '0 seconds';
        }

        $a = array(365 * 24 * 60 * 60 => 'year',
            30 * 24 * 60 * 60 => 'month',
            24 * 60 * 60 => 'day',
            60 * 60 => 'hour',
            60 => 'minute',
            1 => 'second'
        );
        $a_plural = array('year' => 'years',
            'month' => 'months',
            'day' => 'days',
            'hour' => 'hours',
            'minute' => 'minutes',
            'second' => 'seconds'
        );

        foreach ($a as $secs => $str) {
            $d = $etime / $secs;
            if ($d >= 1) {
                $r = round($d);
                return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str);
            }
        }
    }

    public static function getRefferId() {
        $ref_id = Session::get("REF_ID");
        if ($ref_id <= 0) {
            $ref_id = 0;
        }
        return $ref_id;
    }

    public static function findAge($date) {

        $today_date = date("Y-m-d h:s");
        $diff = abs(strtotime($today_date) - strtotime($date));
        $years = floor($diff / (365 * 60 * 60 * 24));
        $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
        $data = $years . " Years " . $months . " months ";
        return $data;
    }
    public static function diffbetweentodates($date1, $date2) {
        $diff = abs(strtotime($date2) - strtotime($date1));
        $years = floor($diff / (365 * 60 * 60 * 24));
        $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
        $data =  $days . " days ";
        return $data;
    }

    public static function toName($value) {
        $value = strtolower(trim($value));
        $value = ucfirst($value);
        return $value;
    }

    public static function toEmail($value) {
        return $value = strtolower(trim($value));
    }

    public static function toEmailDate($date) {
        $timest = strtotime($date);
        if (date('Ymd') == date('Ymd', $timest)) {
            return date("H:i A", $timest);
        }
        return date("M d", $timest);
    }

    public static function getMonthName($monthNum) {
        $dateObj = \DateTime::createFromFormat('!m', $monthNum);
        return $dateObj->format('F'); // March
    }


    public static function getDBdate($date) {
        $date1 = strtotime($date);
        $new_date = date('Y-m-d', $date1);
        return $new_date;
    }

    public static function getDBTime($time) {
        $time1 = strtotime($time);
        $new_time = date('H:i:s', $time1);
        return $new_time;
    }

    public static function getDateRangePickerFormat($date) {
        return date("m/d/Y", strtotime($date));
    }

    public static function setCarbonDateTimeFormat($date, $timezone) {
        $carbon = new Carbon();
        $date = $carbon->createFromFormat('Y-m-d H:i:s', $date)->timezone($timezone);
        return CommonHelper::timestampToDate($date, true);
    }

}
