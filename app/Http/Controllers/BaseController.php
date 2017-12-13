<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Themes;
use Config,
    Session;
use App\Models\DBConfig;
use App\Models\Analyse;
use App,
    Response;

class BaseController extends Controller {

    public $module;
    public $theme;
    private $request;
    public $breadcrumb;
    public $configs;
    public $geo_data;
    public $post_login = false;

    function __construct(Request $request) {
        $prefix = trim($request->route()->getPrefix(), '/');
        $pos = strpos($prefix, "admin");
        if ($pos !== false) {
            $this->module = "admin";
        }
        //$this->checkSetLang($request);
        $configObj = new DBConfig();
        //$themedata = $configObj->getThemeData();
        $this->configs = $configObj->getAllActiveConfig();
        $conf_arr = array();

        foreach ($this->configs as $arr) {
            $conf_arr[$arr->def_key] = $arr->def_value;
        }
        $this->configs = (object) $conf_arr;
        $this->theme = "hautestep";
        Config::set("CONFIG_DATA", $this->configs);
        Config::set("CONFIG_THEME", $this->theme);
    }

    function view($file, $data = array()) {
        return view('themes.' . $this->theme . "." . $file, $data)->with(array('theme' => $this->theme, 'theme_path' => 'themes.' . $this->theme, 'config_data' => $this->configs, 'post_login' => $this->post_login));
    }

    function abort($file, $data = array()) {
        return view('themes.' . $this->theme . ".errors." . $file, $data)->with(array('theme' => $this->theme, 'theme_path' => 'themes.' . $this->theme, 'config_data' => $this->configs, 'post_login' => $this->post_login), '404');
    }

    function json($data = array(), $type = 200) {
        $response = Response::make($data, $type);
        $response->header("Content-Type", "application/json");
        return $response;
    }

    function error_messages() {
        $n_arr = array();
        foreach ($this->validate->messages()->toArray() as $arr) {
            $n_arr[] = $arr[0];
        }
        return $n_arr;
    }

    function checkSetLang($request) {
        $locale = App::getLocale();
        $sess_locale = Session::get("LOCALE_LANG");
        if ($locale != $sess_locale) {
            App::setLocale($sess_locale);
        }
        if ($request->is('fn/setlang/*')) {
            // set user language is auth check
        }
    }

    function doAnalyse($request) {
        $need_to_set = false;
        $url = $request->url();
        $segment = $request->segment(1);
        if (strlen($segment) == 0) {
            $segment = "/";
        }
        $arr = $this->_get_all_page_name_and_url();
        if (Session::has('ANALYZE_DATA')) {
            $page = Session::get('ANALYZE_DATA');
            if (strlen($this->searchUrlInArrayExact($url, $page)) == 0) {
                $need_to_set = true;
            }
        } else {
            $need_to_set = true;
        }

        if ($need_to_set) {
            $analyseObj = new Analyse();
            $page_name = $this->searchUrlInArray($segment, $arr, 2);
            $page_num = array_search($page_name, array_keys($arr)); // insreeting number of index
            $analyseObj->addNewAnalyze($page_num, $url, $request);
        }
    }

    function searchUrlInArray($url, $arr) {
        $hasString = false;
        foreach ($arr as $key => $keyword) {
            if (strpos($keyword, $url) !== false) {
                $hasString = $key;
                break; // stops searching the rest of the keywords if one was found
            }
        }
        return $hasString;
    }

    function searchUrlInArrayExact($url, $arr) {
        $hasString = false;
        foreach ($arr as $keyword) {
            if ($keyword == $url) {
                $hasString = $url;
                break; // stops searching the rest of the keywords if one was found
            }
        }
        return $hasString;
    }

    function _get_all_page_name_and_url() {
        return $arr = [
            'home_page' => url('/'),
            'login' => url('login'),
            'choose_signup' => url('new-signup'),
            'profile' => url('profile/{user_id}/{user_name}'),
            'thread_details' => url('/topic/details/{topic_id}'),
            'contact_us' => url('contact_us'),
            'community_rules' => url('page/community-rules'),
            'thread_search' => url('t/search'),
            'thread_category' => url('topic/cat/search/{category_id}'),
            'thread_tag' => url('f/topics'),
            'about_us' => url('page/about-us'),
            'faqs' => url('page/faqs'),
            'pages' => url('page/{page_slug}'),
            
        ];
    }

    function trackVisitors($request) {
//        $path = storage_path("app/");
//        $dataFile = $path . "visitors.txt";
//        $sessionTime = 30;
//
//
//        if (!file_exists($dataFile)) {
//            $fp = fopen($dataFile, "w+");
//            fclose($fp);
//        }
//
//        $ip = $request->ip();
//        $location = GeoIP::getLocation($ip);
//        $users = array();
//        $onusers = array();
//
//        //getting
//        $fp = fopen($dataFile, "r");
//        flock($fp, LOCK_SH);
//        if ($fp)
//            while (($line = fgets($fp)) !== false) {
//                $users[] = $line;
//            }
//        flock($fp, LOCK_UN);
//        fclose($fp);
//
//        //cleaning
//        $x = 0;
//        $alreadyIn = FALSE;
//        foreach ($users as $key => $data) {
//            @list($u, $lastvisit) = explode("|", $data);
//            //print_r(explode("|", $data));
//            if (time() - $lastvisit >= $sessionTime * 60) {
//                $users[$x] = "";
//            } else
//            if (strpos($data, Session::getId()) !== FALSE) {
//                $alreadyIn = TRUE;
//                $users[$x] = Session::getId() . "|" . time() . "|" . $location['country']; //updating
//            }
//            $x++;
//        }
//
//        if ($alreadyIn == FALSE) {
//            $users[] = Session::getId() . "|" . time() . "|" . $location['country'];
//        }
//
//        //writing
//        $fp = fopen($dataFile, "w+");
//        flock($fp, LOCK_EX);
//        $i = 0;
//
//        foreach ($users as $single) {
//            if ($single != "") {
//                fwrite($fp, $single . "\r\n");
//                $i++;
//            }
//        }
//        flock($fp, LOCK_UN);
//        fclose($fp);
    }

}
