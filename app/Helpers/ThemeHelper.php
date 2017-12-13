<?php

namespace app\Helpers;
use App\Helpers\CommonHelper as CommonHelper;
use Config;
class ThemeHelper {
    private $theme;
    
    function __construct() {
        $theme = Config::get("CONFIG_THEME");
    }
    
    public static function asset($path, $secure = null)
    {
        return app('url')->asset("themes/hautestep/".$path, $secure);
    }
    
    public static function css($path, $secure = null)
    {
        return app('url')->asset("themes/hautestep/"."css/".$path.".css", $secure);
    }
    
    public static function js($path, $secure = null)
    {
        return app('url')->asset("themes/hautestep/"."js/".$path.".js", $secure);
    }
    
    public static function img($path, $secure = null)
    {
        return app('url')->asset("themes/hautestep/"."img/".$path, $secure);
    }
    public function icons($path, $secure = null)
    {
        return app('url')->asset("themes/hautestep/"."img/icons/".$path, $secure);
    }
    
    public static function userImg($path, $secure = null)
    {
        return app('url')->asset("themes/hautestep/"."userdata/".$path, $secure);
    }
    
    public static function contactForm()
    {
        $webdata = \Session::get("WEBSITE_DATA");
        $fields = ($webdata->contact_fields);
        return view('site.contact_form',['fields' => $fields]);
    }
    public static function contactAddress()
    {
        $webdata = \Session::get("WEBSITE_DATA");
        $websitedata = ($webdata->website_data);
        return view('site.contact_address',['websitedata' => $websitedata]);
    }
    
    public static function socialLink($data)
    {
        $confdata = \Session::get("CONFIG_DATA");
        
        return @$confdata->{"social_".$data};
    }
    
    public static function dynamicPage($content)
    {
        $content = CommonHelper::nohtmldata($content);
        return view('site.dynamic_page',['content' => $content ]);
    }
    
    /**
     * Handle dynamic method calls into the model.
     *
     * @param  string  $method
     * @param  array   $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return call_user_func_array([$this, $method], $parameters);
    }

    /**
     * Handle dynamic static method calls into the method.
     *
     * @param  string  $method
     * @param  array   $parameters
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        $instance = new static;

        return call_user_func_array([$instance, $method], $parameters);
    }
}