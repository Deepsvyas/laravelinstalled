<?php

namespace App\Helpers;

use Auth,
    Config,
    App;
use App\Models\Likes;
use Illuminate\Support\Facades\Request;
use Collective\Html\FormFacade as Form;

class ViewsHelper {

    public static function asset($path, $secure = null) {
        $path = "application/" . $path;
        return app('url')->asset($path, $secure);
    }

    public static function css($path, $secure = null) {
        $path = "application/css/" . $path;
        return app('url')->asset($path . ".css", $secure);
    }

    public static function js($path, $secure = null) {
        $path = "application/js/" . $path;
        return app('url')->asset($path . ".js", $secure);
    }

    public static function img($path = "default.jpg", $secure = null) {
        $path = "application/img/" . $path;
        if (!file_exists(public_path() . "/" . $path))
            $path = "application/img/site/default.jpg";
        return app('url')->asset($path, $secure);
    }

    public static function icons($path, $secure = null) {
        $path = "application/img/icons/" . $path;
        return app('url')->asset($path, $secure);
    }

    public static function userImg($path, $secure = null) {
        $path = "application/userdata/" . $path;
        return app('url')->asset($path, $secure);
    }

    public static function themeImg($path, $theme = "default", $secure = null) {
        $path = "themes/" . $theme . "/img/" . $path;
        if (!file_exists(public_path() . "/" . $path))
            return ViewsHelper::img();
        return app('url')->asset($path, $secure);
    }

    public static function hasAccessTo($access) {
        return true;
//        $permissions = Auth::user()->role->permissions;
//        $ret = false;
//        foreach ($permissions as $per) {
//            if ($per->permission_slug == $access) {
//                $ret = true;
//                break;
//            }
//        }
//
//        return $ret;
    }

    public static function url($url, $check_prefix = true) {
        $prefix = ViewsHelper::getUrlPrefix();
        $urlp = "";
        if ($check_prefix) {
            $urlp = $prefix;
        }
        return url($urlp . $url);
    }

    public static function getUrlPrefix() {
        return Request::route()->getPrefix();
    }

    public static function isActiveNav($nav) {
        $url = CommonHelper::getCurrentUrl();

        if (strpos($url, $nav) !== false) {
            return "active";
        }
    }

    public static function getConfigData() {
        return Config::get('CONFIG_DATA');
    }

    public static function getConfigKeyData($key) {
        $config_data = ViewsHelper::getConfigData();
        return $config_data->$key;
    }

    public static function getJsonDecodeConfigKeyData($key, $array = true, $type = false) {
        $config_data = ViewsHelper::getConfigData();
        if ($array) {
            $data = json_decode($config_data->$key, TRUE);
            return ViewsHelper::transArray($data, $type);
        } else {
            return $config_data->$key;
        }
    }

    public static function getWebsiteLogo($obj, $size = "100_100") {
        $logo = $obj->def_value;
        $web_logo = Config::get("params.website_logo");
        $base_path = base_path($web_logo['base_path']);

        if (!empty($obj)) {
            $base_path = $base_path . "/" . $size . "_" . $logo;
            $path = url($web_logo['path'] . "/" . $size . "_" . $logo);
        } else {
            $base_path = "";
        }
        if (!file_exists($base_path)) {
            //$path = url("fn/getimage/application~img~admin~boxed-bg.png/".$size);
            $path = '';
        }
        return $path;
    }

    public static function getWebsiteLogoByName($logoname, $size = "100_100") {
        $web_logo = Config::get("params.website_logo");
        $base_path = base_path($web_logo['base_path']);
        $base_path = $base_path . "/" . $size . "_" . $logoname;
        $path = url($web_logo['path'] . "/" . $size . "_" . $logoname);
        if (!file_exists($base_path)) {
            $path = url("fn/getimage/application~img~admin~boxed-bg.png/" . $size);
        }
        return $path;
    }

    public static function getAppJsMessages() {
        $data = [
            'confirm_delete' => trans("messages.confirm.delete.common"),
            'wait' => trans("messages.wait"),
            'please_wait' => trans("messages.please_wait"),
            'logged_out' => trans("messages.logged_out"),
            'messages' => [
                'time' => [
                    'seconds' => trans("messages.time.seconds"),
                    '1_minute' => trans("messages.time.1_minute"),
                    'minutes' => trans("messages.time.minutes"),
                    '1_hour' => trans("messages.time.1_hour"),
                    'hours' => trans("messages.time.hours"),
                    'yesterday' => trans("messages.time.yesterday"),
                    'days' => trans("messages.time.days"),
                    'last_week' => trans("messages.time.last_week"),
                    'date_show' => trans("messages.time.date_show"),
                ]
            ],
        ];
        return json_encode($data);
    }

    public static function getAmountWithSymbol($amount) {
        return '$ ' . $amount;
    }

    public static function getHelpTip($string) {
        return '<i class="fa fa-question-circle" data-toggle="tooltip" title="' . trans($string) . '"></i>';
    }

    public static function getPercentage($num) {
        $likeObj = new Likes();
        $total = $likeObj->count();
        if($total == 0){
            return 0;
        }
        $perc = ($num * 100 / $total);
        return number_format($perc, 0)."%";
    }

    public static function getLikeGraphs() {
        $likeObj = new Likes();
        $likescount = $likeObj->getLikeCount();
        return ViewsHelper::getPercentage($likescount);
    }

    public static function getHappyGraphs() {
        $likeObj = new Likes();
        $count = $likeObj->getHappyCount();
        return ViewsHelper::getPercentage($count);
    }

    public static function getUnlikeGraphs() {
        $likeObj = new Likes();
        $count = $likeObj->getUnlikeCount();
        return ViewsHelper::getPercentage($count);
    }
    
    public static function countTotalReact() {
        $likeObj = new Likes();
        $count = $likeObj->countTotalReact();
        return $count;
    }

}
