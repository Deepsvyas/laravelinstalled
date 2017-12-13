<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\CommonHelper as CommonHelper;
use App\Helpers\ViewsHelper as Views;
use Config;
use Session;

class Themes extends Model {

    protected $table = 'themes';
    public $primaryKey = "theme_id";
    private $theme_check_slug = "";

    /*
      All model relations arrives here
     */

    public function getAllList() {
        $paginate = Views::getConfigKeyData('pagination');
        return $this->orderBy('created_at', 'DESC')->paginate($paginate);
    }
    
    public function getAllActiveThemes() {
        return $this->orderBy('created_at', 'DESC')->where('status',1)->get();
    }

    public function getById($id) {
        return Themes::whereTheme_id($id)->first();
    }

    public function getBySlug($slug) {
        return Themes::whereThemeSlug($slug)->first();
    }

    public function getByKey($key) {
        return Themes::whereTheme_key($key)->first();
    }

    public function addNew($input) {
        $jsondata = CommonHelper::defaultJson();
        $rules = array(
            'theme_name' => 'required|alpha_spaces|max:100|unique:' . $this->table . ',theme_name',
            'theme_path' => 'required',
        );

        $newnames = array(
            'theme_name' => 'Theme Name',
            'theme_path' => 'Theme Zip',
        );
        $messages = array(
            'required' => ':attribute is required.',
            'max' => ':attribute is not a valid URL',
            "alpha_spaces" => ":attribute allows only alpha with spaces.",
            'unique' => "Theme name already used!",
        );
        $v = \Validator::make($input, $rules, $messages);
        $v->setAttributeNames($newnames);

        if ($v->passes()) {
            $file = $input['theme_path'];
            $this->theme_check_slug = strtolower(str_replace(" ", "-", $input['theme_name']));
            $uploaded = $this->uploadTheme($file);
            if ($uploaded['status'] == 1) {
                $theme = new Themes();
                $theme->theme_key = CommonHelper::getEncryptedKey();
                $theme->theme_name = $input['theme_name'];
                $theme->theme_slug = $this->theme_check_slug;
                $theme->theme_path = $uploaded['file_name'];
                $theme->status = 1;
                $theme->save();
                $jsondata['success'] = 1;
                $jsondata['success_mess'] = trans('messages.success.save');
            } else {
                $jsondata['error'] = 1;
                $jsondata['error_mess'] = $v->errors()->add("theme_path", $uploaded['error']);
            }
        } else {
            $jsondata['error'] = 1;
            $jsondata['error_mess'] = $v->messages();
        }
        return $jsondata;
    }

    public function updateThis($input) {
        $jsondata = CommonHelper::defaultJson();

        $rules = array(
            'theme_name' => 'required|alpha_spaces|max:100|unique:' . $this->table . ',theme_name,' . $input['theme_key'] . ',theme_key',
            'theme_path' => '',
        );
        $theme = new Themes();
        $updata = $theme->getByKey($input['theme_key']);
        if ($updata->fixed_pos == 1)
            $rules['theme_name'] = 'alpha_spaces|max:100|unique:' . $this->table . ',theme_name,' . $input['theme_key'] . ',theme_key';
        $newnames = array(
            'theme_name' => 'Theme Name',
            'theme_path' => 'Theme Zip',
        );
        $messages = array(
            'required' => ':attribute is required.',
            'max' => ':attribute is not a valid URL',
            "alpha_spaces" => ":attribute allows only alpha with spaces.",
            'unique' => "Theme name already used!",
        );

        $v = \Validator::make($input, $rules, $messages);
        $v->setAttributeNames($newnames);
        if ($v->passes()) {
            $file = @$input['theme_path'];
            $uploaded = array("status" => 0, 'file_name' => "");
            if ($updata->fixed_pos == 0)
                $this->theme_check_slug = strtolower(str_replace(" ", "-", $input['theme_name']));
            else
                $this->theme_check_slug = $updata->theme_slug;
            if (empty($file)) {
                $uploaded['status'] = 1;
            } else {
                $uploaded = $this->uploadTheme($file);
            }
            if ($uploaded['status'] == 1) {
                $old_slug = $updata->theme_slug;
                if ($updata->fixed_pos == 0) {
                    $updata->theme_name = $input['theme_name'];
                    $updata->theme_slug = $this->theme_check_slug;
                    if ($uploaded['status'] == 1 && !empty($uploaded['file_name']) && $old_slug != $updata->theme_slug) {
                        $theme->removeOldTheme($old_slug);
                    }
                }
                if (!empty($uploaded['file_name'])) {
                    $updata->theme_path = $uploaded['file_name'];
                } else {
                    $this->renameTheme($old_slug, $updata->theme_slug);
                }
                $updata->save();
                $jsondata['success'] = 1;
                $jsondata['success_mess'] = trans('messages.success.save');
            } else {
                $jsondata['error'] = 1;
                $jsondata['error_mess'] = $v->errors()->add("theme_path", $uploaded['error']);
            }
        } else {
            $jsondata['error'] = 1;
            $jsondata['error_mess'] = $v->messages();
        }
        return $jsondata;
    }

    function renameTheme($old_name, $new_name = false) {
        $path = Config::get("params.upload_theme_path");
        $path = base_path($path) . "/";
        rename($path . $old_name, $path . $new_name);
        $path = Config::get("params.upload_theme_views_path");
        $path = base_path($path) . "/";
        rename($path . $old_name, $path . $new_name);
    }
    
    
    function removeOldThemeDir($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir . "/" . $object) == "dir")
                        $this->removeOldThemeDir($dir . "/" . $object);
                    else
                        @unlink($dir . "/" . $object);
                }
            }
            reset($objects);
            rmdir($dir);
        }
    }
    
    function removeOldTheme($theme) {
        $path = Config::get("params.upload_theme_path");
        $path = base_path($path) . "/";
        $this->removeOldThemeDir($path.$theme);
        $path = Config::get("params.upload_theme_views_path");
        $path = base_path($path) . "/";
        $this->removeOldThemeDir($path.$theme);
    }

    function uploadTheme($file, $id = false) {
        $allowed = array('application/x-zip', 'application/x-gzip', 'application/zip', 'application/x-zip-compressed');
        $mimeType = $file->getMimeType();
        if (!in_array($mimeType, $allowed)) {
            return array("status" => 0, 'error' => "please use a valid zip file to upload");
        }
        if (!$id)
            $id = time();
        $path = Config::get("params.upload_theme_path");
        $path = base_path($path) . "/" . $id . "/";

        if (!is_dir($path)) {
            umask(0);
            mkdir($path, 0777, true);
            chmod($path, 0777); //incase mkdir fails
        }

        if (substr($file->getClientOriginalName(), -6) == 'tar.gz') {
            $extension = substr($file->getClientOriginalName(), -6);
        } else {
            $extension = $file->getClientOriginalExtension(); // getting image extension
        }

        $fileName = time() . "_" . rand(11111, 99999) . '.' . $extension; // renameing image
        $file->move($path, $fileName); // uploading file to given path
        $missing = $this->checkThemeStructure($path, $fileName);

        if ($missing)
            return array("status" => 0, 'error' => $missing);

        return array('status' => 1, 'file_name' => $fileName);
    }

    function checkThemeStructure($path, $fileName) {
        $zipper = new \Chumper\Zipper\Zipper;
        chmod($path . $fileName, 0777);
        //exec("unzip -d ".$path."theme/"." ".$path.$fileName,$retvar);
        $zipper->make($path . $fileName)->extractTo($path);
        unlink($path . $fileName);
        $missing = $this->getDirContents($path);
        if ($missing)
            return $missing;
        else {
            $this->moveThemeContents($path);
            //$this->setFileData($this->theme_check_slug);
        }
    }

    function moveThemeContents($folder) {
        $this->removeOldTheme($this->theme_check_slug);
        $path = Config::get("params.upload_theme_path");
        $path = base_path($path) . "/";
        rename($folder . "assets", $path . $this->theme_check_slug);
        $path = Config::get("params.upload_theme_views_path");
        $path = base_path($path) . "/";
        rename($folder . "views", $path . $this->theme_check_slug);
        rmdir($folder);
    }

    function getDirContents($folder) {

        $searches = array(
            "assets/",
            "assets/img/screenshot.png",
            "views/",
            "views/layouts",
            "views/home.blade.php",
            "views/layouts/main.blade.php",
            "views/layouts/header.blade.php",
            "views/layouts/footer.blade.php",
        );
        $missing = "";
        foreach ($searches AS $search) {
            if (!file_exists($folder . DIRECTORY_SEPARATOR . $search)) {
                $missing = "Missing '" . $search . "' file/directory in theme";
                break;
            }
        }
        return $missing;
    }
    
    /*
    Need to remove this function as it has no use of it
     *      */
    
    function setFileData($theme)
    {
        $path = Config::get("params.upload_theme_views_path");
        $path = base_path($path) . "/".$theme."/";
        $searches = array(
            "layouts/main.blade.php",
            "layouts/header.blade.php",
            "layouts/footer.blade.php",
            "layouts/meta_css.blade.php",
            "layouts/nav_bar.blade.php",
            "layouts/scripts.blade.php",
        );
        foreach ($searches as $search)
        {
            if(file_exists($path.$search))
            {
                $filedata = file_get_contents($path.$search);
                if (preg_match_all("/{{(.*?)}}/", $filedata, $m)) {
                    foreach ($m[1] as $i => $varname) {
                        /*if(strtolower(trim($varname)) == "app_js")
                        {
                            $filedata = str_replace($m[0][$i], sprintf('%s','<script type="text/javascript" src="{{ ViewsHelper::js(\'custom/app\') }}"></script>'), $filedata);
                        }*/

                        //$template = str_replace($m[0][$i], sprintf('%s', $varname), $template);
                    }
                }
                //file_put_contents($path.$search, $filedata);
            }
        }
        $filedata = file_get_contents($path."layouts/scripts.blade.php");
        $filedata = $filedata."\n<script type='text/javascript' src='{{ ViewsHelper::js(\"custom/app\") }}'></script>";
        file_put_contents($path."layouts/scripts.blade.php", $filedata);
        $filedata = file_get_contents($path."layouts/meta_css.blade.php");
        $filedata = $filedata."\n<link rel='stylesheet' type='text/css' href='{{ ViewsHelper::css(\"style\") }}' />\n<meta name='csrf-token' content='{{ csrf_token() }}'>";
        file_put_contents($path."layouts/meta_css.blade.php", $filedata);
    }

    public function updateActive($input) {
        $themeObj = new Themes();
        $status = $input['status'];
        $updata = $themeObj->getByKey($input['website_key']);
        $jsondata = CommonHelper::defaultJson();
        $updata->updated_at = date('Y-m-d H:i:s');
        $updata->status = $status;
        $updata->save();
        $jsondata['success'] = 1;
        $jsondata['success_mess'] = trans('messages.success.update');
        return $jsondata;
    }
    
    public function activateTheme($input) {
        $websiteObj = new DBConfig();
        $themeObj = new Themes();
        $theme_key = $input['theme_key'];
        $theme_data = $themeObj->getByKey($theme_key);
        $updata = $websiteObj->getConfigByDefKey("theme_id");
        $jsondata = CommonHelper::defaultJson();
        if (!empty($updata) && !empty($theme_data)) {
            $updata->updated_at = date('Y-m-d H:i:s');
            $updata->def_value = $theme_data->theme_id;
            $updata->save();
            $jsondata['success'] = 1;
            $jsondata['success_mess'] = trans('messages.success.update');
        } else {
            $jsondata['error'] = 1;
            $jsondata['error_mess'] = trans('messages.error.theme.active_theme');
        }
        return $jsondata;
    }

    public function deleteSelected($input) {
        $jsondata = CommonHelper::defaultJson();
        $checkval = explode(",", $input['checkval']);
        if (!empty($checkval)) {
            foreach ($checkval as $key) {
                $this->deleteThis($key);
            }
            $jsondata['success'] = 1;
            $jsondata['success_mess'] = trans('messages.success.delete');
        } else {
            $jsondata['error_mess'] = trans('messages.error.theme.delete');
            $jsondata['error'] = 1;
        }
        return $jsondata;
    }

    function deleteThis($key) {
        $theme_data = Themes::getByKey($key);
        $this->removeOldTheme($theme_data->theme_slug);
        $theme_data->delete();
    }

}
