<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Collective\Html\FormFacade as Form;
use App\Helpers\CommonHelper;
use App\Helpers\SimpleImage;
use App\Helpers\MailFunctions;
use App\Models\States;
use App\Models\Cities;
use App\Models\Countries;
//use App\Models\Language;
use Redirect, Session, App, Config, Auth;


class FnController extends BaseController
{
    public function getCountries(Request $request){
        
        $ret_arr = CommonHelper::defaultJson();
        $country_field = $request->get("country_field");
        if(strlen($country_field) == 0)
            $country_field = "country";
        $country = Countries::where('ISO2', '!=', '--')->lists('Country', 'ISO2')->all();
        $country = ['' => 'Select Country'] + $country;
        $ret_arr['success'] = 1;
        $ret_arr['success_mess'] = "Countries loaded";
        $ret_arr['countries'] = Form::select($country_field, $country,null, array('class' => 'form-control', 'id' => $country_field));
        echo json_encode($ret_arr);
    }
    public function getStatesByCountryId(Request $request){
        $model = new States();
        
        $ret_arr = CommonHelper::defaultJson();
        $countryId = $request->get('countryId');
        //$data = $model->getStatesListByCountryId($countryId);
        $states = States::where('CountryId',$countryId)->lists('StateName', 'StateId')->all();
        $ret_arr['has_states'] = count($states);
        $states = ['' => 'Select state'] + $states;
        $ret_arr['success'] = 1;
        $ret_arr['success_mess'] = "States loaded";
        $ret_arr['states'] = Form::select('state', $states,null, array('class' => 'form-control','id' => 'state'));
        echo json_encode($ret_arr);
    }
    public function getCitiesByCountryId(Request $request){
        $model = new Cities();
        
        $ret_arr = CommonHelper::defaultJson();
        $countryId = $request->get('countryId');
        //$data = $model->getCitiesListByCountryId($countryId);
        $cities = Cities::where('CountryId',$countryId)->lists('CityName', 'CityId')->all();
        $cities = ['' => 'Select city'] + $cities;
        $ret_arr['success'] = 1;
        $ret_arr['success_mess'] = "Cities loaded";
        $ret_arr['cities'] = Form::select('city',$cities, null, array('class' => 'form-control','id' => 'city'));;
        
        echo json_encode($ret_arr);
    }
    
    public function getCitiesByStateId(Request $request){
        $model = new Cities();
        
        $ret_arr = CommonHelper::defaultJson();
        $state = $request->get('state');
        $name = $request->get('name');
        if(!isset($name) && strlen($name) == 0){
            $name = 'city';
        }
        //$data = $model->getCitiesListByCountryId($countryId);
        $cities = Cities::where('StateId',$state)->lists('CityName', 'CityId')->all();
        $cities = ['' => 'Select city'] + $cities;
        $ret_arr['success'] = 1;
        $ret_arr['success_mess'] = "Cities loaded";
        $ret_arr['cities'] = Form::select($name,$cities, null, array('class' => 'form-control','id' => $name));
        
        echo json_encode($ret_arr);
    }
    
    public function getImage(Request $request,$image='',$img_size='100_100'){
        $imageObj = new SimpleImage();
        $image = base_path("public/".str_replace("~","/",$image));
        list($w,$h) = explode("_",$img_size);
        $imageObj->display($image,$w);
    }
    
    function setLang(Request $request, $lang = "en"){
        $langObj = new Language();
        $language = $langObj->getLangByCode($lang, 1);
        if(empty($language)){
            return redirect("/");
        }
        $back_url = Redirect::back()->getTargetUrl();
        $back_url_arr = parse_url($back_url);
        $back_url_e = $this->back_url_e($back_url_arr,$lang);
        $back_url_arr['path'] = $back_url_e;
        $next_url = $back_url_arr['path']."/".@$back_url_arr['query'];
        
        if(Auth::check()){
            Auth::user()->lang_id = $language->lang_id;
            Auth::user()->update();
        }
        Session::put("LOCALE_LANG", $lang);
        Session::put("LOCALE_LANG_ID", $language->lang_id);
        if(Auth::check() && (Auth::user()->roledata->role_slug == "admin" || Auth::user()->roledata->role_slug == "super_admin")){
            $next_url  = $back_url;
        }
        return redirect($next_url);
    }
    
    function back_url_e($back_url_arr, $lang){
         $langObj = new Language();
        if(isset($back_url_arr['path'])){
            $back_url_trim_arr = trim($back_url_arr['path'], "/");
            $back_url_e = explode("/",$back_url_trim_arr);
            if(isset($back_url_e[0])){
                if($back_url_e[0] == "en"){
                    unset($back_url_e[0]);
                }
                else{
                    $language_old = $langObj->getLangByCode($back_url_e[0], 1);
                    if(!empty($language_old)){ // it means url contains previous lang code
                        unset($back_url_e[0]);
                    }
                }
            }
            if($lang != "en"){
                array_unshift($back_url_e, $lang);
            }
            $back_url_e = implode("/", $back_url_e);
        }
        else{
            if($lang != "en"){
                $back_url_e = $lang;
            }
        }
        if(Auth::check() && (Auth::user()->roledata->role_slug == "admin" || Auth::user()->roledata->role_slug == "super_admin")){
            $back_url_e  = "";
        }
        return $back_url_e;
    }
    
    function getLocation(Request $request){
        $query = $request->get("query");
        $ret_arr = CommonHelper::defaultJson();
        $country = new Cities();
        $data = $country->getLocation($query);
        $ret_arr['success'] = 1;
        $ret_arr['location'] = $data;
        return json_encode($ret_arr);
    }
    
    function testEmail(Request $request){
        $theme = Config::get("CONFIG_THEME");
        $config = Config::get("CONFIG_DATA");
        $theme_path = "themes." . $theme;
        $mailObj = new MailFunctions();
        //  $mailObj->print = true;
        $mailObj->auto = true;
        $mailObj->subject = sprintf("Welcome to " . $config->website_title);
        $mailObj->fromEmail = $config->no_reply_email;
        $mailObj->toEmail = Auth::user()->email;
        $html = $mailObj->sendmail($theme_path . ".emails.test", ['title' => "Welcome mail", 'theme_path' => $theme_path]);
    }
}
