<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\CommonHelper as CommonHelper;
use App\Helpers\ViewsHelper as Views;
use App\Helpers\SimpleImage as SimpleImage;
use Config;
use \Session;

class DBConfig extends Model {

    protected $table = 'config';
    protected $primaryKey = 'config_id';
    private $conf_arr = array();

    /**
     * roles() many-to-many relationship method
     * 
     * @return QueryBuilder
     */
//    public function roles() {
//        return $this->belongsToMany('App\Models\Role');
//    }

    public function theme_data() {
        
        return $this->belongsTo('App\Models\Themes','theme_id');
    }
    
    public function getThemeData(){
        $theme_id = $this->where("def_key", "theme_id")->first();
        $theme = new Themes();
        return $theme->getById($theme_id->def_value);
        
    }
    
    public function getPagingCustomConfig($is_static = 0)
    {
        $paginate = Views::getConfigKeyData('pagination');
        if($is_static)
            return $this->where('is_static',$is_static)->orderBy('created_at', 'DESC')->paginate($paginate);
        return $this->where('is_static','=','0')->orderBy('created_at', 'DESC')->paginate($paginate);
    }
    
    public function getConfigByKey($key)
    {
        return $this->where("config_key", $key)->first();
    }
    public function getConfigByDefKey($def_key)
    {
        return $this->where("def_key", $def_key)->first();
    }
    
    public function setStaticData()
    {
        $static_data = $this->getAllConfigStaticData();
        foreach ($static_data as $data)
        {
            $this->conf_arr[$data->def_key] = $data->def_value;
        }
    }
    
    public function getStaticData($key)
    {
        return  $this->conf_arr[$key];
        
    }
    public function getValueByDefKey($def_key)
    {
        $data = $this->where("def_key", $def_key)->first();
        return $data->def_value;
    }
    public function getAllActiveConfig()
    {
        return $this->where("status", "1")->get();
    }
    public function getAllStaticConfigData()
    {
        return $this->where("status", "1")->get();
    }
     public function getAllConfigStaticData($is_static = 1)
    {
        return $this->where('is_static','=',$is_static)->get();
    }
    
    public function addNew($input) {
        
        $jsondata = CommonHelper::defaultJson();
        $modelObj = new DBConfig();
        $cdata = $confdata = $modelObj->getConfigByKey($input['config_edit_key']);
        $rules = array(
            'def_key' => 'required|alpha_underscore|max:100|unique:'.$this->table.',def_key',
            'def_value' => 'required',
        );
        if(!empty($cdata)){
            $rules['def_key'] = 'required|alpha_underscore|max:200|unique:'.$this->table.',def_key,'.$input['config_edit_key'].',config_key';
        }
        $newnames = array(
            'def_key' => 'Config slug',
            'def_value' => 'Config value',
        );
        $messages = array(
            'required' => ':attribute is required.',
            'max' => ':attribute max characters limit exceed (:max).',
            "alpha_spaces" => "The :attribute may only contain letters and spaces.",
            "alpha_underscore" => "The :attribute may only contain letters and underscore.",
        );
        $v = \Validator::make($input, $rules, $messages);
        $v->setAttributeNames($newnames);
        if ($v->passes()) {
            if(empty($confdata)){
                $confdata = new DBConfig();
                $confdata->config_key = CommonHelper::getEncryptedKey();
            }
          //  if(isset($input['is_static']))
            $confdata->def_key = $input['def_key'];
            $confdata->def_value = $input['def_value'];
            $confdata->status = 1;
            if(empty($cdata)){
                $confdata->save();
                $jsondata['success_mess'] = trans('messages.success.save');
            }
            else{
                $confdata->update();
                $jsondata['success_mess'] = trans('messages.success.update');
            }
            $jsondata['success'] = 1;
        } else {
            $jsondata['error'] = 1;
            $jsondata['error_mess'] = $v->messages();
        }
        return $jsondata;
    }

    
    
    public function addWebsiteLogo($input) {
        $uploaded = array();
        $jsondata = CommonHelper::defaultJson();
        $modelObj = new DBConfig();
        $cdata = $confdata = $modelObj->getConfigByDefKey($input['config_edit_key']);
        $rules = array(
        );
        $newnames = array(
            'website_logo' => 'Website Logo',
        );
        $messages = array(
            'required' => ':attribute is required.',
        );
        $v = \Validator::make($input, $rules, $messages);
        $v->setAttributeNames($newnames);
        if ($v->passes()) {
            $this->file_obj = @$input['website_logo'];
            $uploaded['status'] = 0;
            $uploaded['error'] = "Error unknown";
            if (!empty($this->file_obj) && !empty($cdata)) {
                $uploaded = $this->uploadLogo($this->file_obj, 'logo');
                $this->remove_old_logo($cdata);
            }
            if($uploaded['status'] == 1){
                $confdata->def_value = $uploaded['file_name'];
                $confdata->update();
                $jsondata['success'] = 1;
                
                $jsondata['image_logo'] = Views::getWebsiteLogo($confdata)."?t=".time();
                $jsondata['success_mess'] = "Uploaded successfully";
            }else{
                $jsondata['error'] = 1;
                $jsondata['error_mess'] = $v->errors()->add("website_logo", $uploaded['error']);
            }
        } else {
            $jsondata['error'] = 1;
            $jsondata['error_mess'] = $v->messages();
        }
        return $jsondata;
    }
    
    function uploadLogo($file) {
        $website_logo = Config::get("params.website_logo");
        $allowed = $website_logo['mimes'];
        $mimeType = $file->getMimeType();
        if (!in_array($mimeType, $allowed)) {
            return array("status" => 0, 'error' => "please use a valid image to upload");
        }
        $path = $website_logo['base_path'];
        $path = base_path($path). "/";
        if (!is_dir($path)) {
            umask(0);
            mkdir($path, 0777, true);
            chmod($path, 0777); //incase mkdir fails
        }
        $extension = $file->getClientOriginalExtension(); // getting image extension
        $fileName = time() . "_" . rand(11111, 99999) . '.' . $extension; // renameing image
        $file->move($path, $fileName); // uploading file to given path
        
        if ($file->isValid())
            return array("status" => 0, 'error' => $file->getError());

        $sizes = explode(",", $website_logo['sizes']);
        $imageObj = new SimpleImage();
        $max_w = 0;
        $max_w_h = "";
        foreach ($sizes as $size) {
            list($width, $height) = explode("x", $size);
            if($width  > $max_w){
                $max_w = $width;
                $max_w_h = $width.'_'.$height;
            }
            $imageObj->load($path . $fileName);
            $imageObj->resizeToWidth($width);
            $imageObj->save($path . $width . "_" . $height . "_" . $fileName);
        }
//        unlink($path.$fileName);
//        rename($path.$max_w_h.'_'.$fileName,$path.$fileName );
        return array('status' => 1, 'file_name' => $fileName);
    }

    function remove_old_logo($confidata, $rm_dir = false) {
        $website_logo = Config::get("params.website_logo");
        $sizes = $website_logo['sizes'];
        $sizes = explode(",", $sizes);
        if (!empty($sizes)) {
            foreach ($sizes as $size) {
                list($width, $height) = explode("x", $size);
                $image_path = base_path($website_logo['base_path'] . "/");
                @unlink($image_path . '/' . $width . "_" . $height . "_" . $confidata->def_value);
            }
            @unlink($image_path . '/' . $confidata->def_value);
        }
        if ($rm_dir)
            @rmdir($image_path);
    }
    
    
    public function updateActive($input) {
        $modelObj = new DBConfig();
        $config_key = $input['config_key'];
        $status = $input['status'];
        $updata = $modelObj->getConfigByKey($config_key);
        $jsondata = CommonHelper::defaultJson();
        $updata->status = $status;
        $updata->save();
        $jsondata['success'] = 1;
        $jsondata['success_mess'] = trans('messages.success.update');
        return $jsondata;
    }
    
    public function updateStaticConfig($input) {
        $modelObj = new DBConfig();
        $def_key = $input['def_key'];
        $def_value = $input['def_value'];
        $updata = $modelObj->getConfigByDefKey($def_key);
        $jsondata = CommonHelper::defaultJson();
        $updata->def_value = $def_value;
        $updata->save();
        $jsondata['success'] = 1;
        $jsondata['success_mess'] = trans('messages.success.update');
        return $jsondata;
    }

    
    public function deleteSelected($input){
        $jsondata = CommonHelper::defaultJson();
        $checkval = explode(",",$input['checkval']);
        if(!empty($checkval))
        {
            foreach ($checkval as $key)
            {
                $this->deleteThis($key);
            }
            $jsondata['success'] = 1;
            $jsondata['success_mess'] = trans('messages.success.delete');
        }
        else
        {
            $jsondata['error_mess'] = trans('messages.delete');
            $jsondata['error'] = 1;
        }
        return $jsondata;
    }
    
    function deleteThis($key)
    {
        DBConfig::where('config_key', $key)->delete();
    }

    public function deleteStatic($input){
        $jsondata = CommonHelper::defaultJson();
        $checkval = explode(",",$input['checkval']);
        if(!empty($checkval))
        {
            foreach ($checkval as $defkey)
            {
                $confdata = $this->getConfigByDefKey($defkey);
                $confdata->delete();
            }
            $jsondata['success'] = 1;
            $jsondata['success_mess'] = trans('messages.success.delete');
        }
        else
        {
            $jsondata['error_mess'] = trans('messages.delete');
            $jsondata['error'] = 1;
        }
        return $jsondata;
    }

}
