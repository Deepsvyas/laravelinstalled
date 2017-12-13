<?php

namespace App\Models;

use App\Helpers\CommonHelper as CommonHelper;
use App\Helpers\ViewsHelper as Views;
use App\Helpers\SimpleImage;
use Config;
use Session;

class Category extends Base {

    public $num;
    protected $table = 'categories';
    public $primaryKey = "category_id";

    /*
      All model relations arrives here
     */
 

    function getCategoryById($id) {
        return $this->where("category_id", $id)->first();
    }
    
    public function countTotalCategory() {
        return $this->count();
    }
 

    function getPagingCategories($status = null) {
        $post = new Category();
        if ($status)
            $post = $this->where('status', $status);
        //return $post->sort()->search()->bylang()->dpaginate();
        return $post->sort()->search()->dpaginate();
    }
    
    function getMostViewedCategories($limit = 10) {
        return $this->where('status', 1)->orderBy('counter', 'DESC')->limit($limit)->get();
    }
    function getRecentCategories($limit = 5) {
        return $this->where('status', 1)->orderBy('created_at', 'DESC')->limit($limit)->get();
    }
    function getSearchCategories($search) {
        $search = trim($search);
        return $this->where('status', 1)->where('category_title', 'like', '%'.$search.'%')->orWhere('category_desc', 'like', '%'.$search.'%')->orderBy('created_at', 'DESC')->paginate(2);
    }

    function addNew($input) {
        
        $uploaded = array();
        $jsondata = CommonHelper::defaultJson(); 
        $pdata = $postdata = $this->getCategoryById($input['category_id']);
        $rules = array( 
            'category_title' => 'required|max:200',
        );
        if (empty($pdata)) {
            $rules['category_image'] = 'required';
        }

        $newnames = array();
        $messages = array();
        $v = \Validator::make($input, $rules, $messages);
        $v->setAttributeNames($newnames);
        if ($v->passes()) {
            
            $this->file_obj = @$input['category_image'];
            $uploaded['status'] = 0;

            if (empty($this->file_obj) && empty($pdata) && $category_image_required == 1) {
                $jsondata['error'] = 1;
                $jsondata['error_mess'] = $v->errors()->add("category_image", trans('messages.img_required'));
                return $jsondata;
            }
            if (empty($this->file_obj) && !empty($pdata)) {
                $uploaded['status'] = 1;
            }
            if (!empty($this->file_obj) && !empty($pdata)) {
                $uploaded = $this->uploadImage($this->file_obj, $pdata->category_id);
                $this->remove_old_image($postdata);
            } else if (!empty($this->file_obj)) {
                $uploaded = $this->uploadImage($this->file_obj);
            }
            if ($uploaded['status'] == 1) {
                $post_image = Config::get("params.category_image");
                if (empty($pdata)) {
                    $postdata = new Category();
                    //$postdata->post_key = CommonHelper::getEncryptedKey();
                }
                if (!empty($this->file_obj)) {
                    $postdata->category_image = $uploaded['file_name'];
                }
                //$postdata->post_author = strtolower($input['post_author']);
               // $postdata->post_youtube_video_url = $input['post_youtube_video_url'];
                $postdata->category_title = ucfirst($input['category_title']);
                $postdata->category_desc = CommonHelper::nohtmldata(urldecode($input['category_desc_h']));
                if (isset($input['category_publish']))
                    $postdata->status = $input['category_publish'];
                else
                    $postdata->status = 0;
                if (empty($pdata)) {
                    $postdata->save();
                    $jsondata['success_mess'] = trans('messages.success.save');
                    if (!empty($this->file_obj)) {
                        $curr_upload_path = $uploaded['path'];
                        $now_path = base_path($post_image['base_path']) . "/" . $postdata->category_id;
                        rename($curr_upload_path, $now_path);
                    }
                } else {
                    $postdata->update();
                    $jsondata['success_mess'] = trans('messages.success.update');
                }

                $jsondata['success'] = 1;
            } else {
                $jsondata['error'] = 1;
                $jsondata['error_mess'] = $v->errors()->add("category_image", $uploaded['error']);
            }
        } else {
            $jsondata['error'] = 1;
            $jsondata['error_mess'] = $v->messages();
        }
        return $jsondata;
    }

    function uploadImage($file, $id = false) {
        $category_image = Config::get("params.category_image"); 
        $allowed = $category_image['mimes'];
        $mimeType = $file->getMimeType();
        if (!in_array($mimeType, $allowed)) {
            return array("status" => 0, 'error' => trans('messages.valid_img'));
        }
        if (!$id)
            $id = time();
        $path = $category_image['base_path'];
        $path = base_path($path) . "/" . $id . "/";
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

        $sizes = explode(",", $category_image['sizes']);
       
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
        return array('status' => 1, 'file_name' => $fileName, 'path' => $path);
    }

    function remove_old_image($postdata, $rm_dir = false) {
        $category_image = Config::get("params.category_image");
        $sizes = $category_image['sizes'];
        $sizes = explode(",", $sizes);
        if (!empty($sizes)) {
            foreach ($sizes as $size) {
                list($width, $height) = explode("x", $size);
                $image_path = base_path($category_image['base_path'] . "/" . $postdata->post_id);
                @unlink($image_path . '/' . $width . "_" . $height . "_" . $postdata->category_image);
            }
            @unlink($image_path . '/' . $postdata->category_image);
        }
        if ($rm_dir)
            @rmdir($image_path);
    }

    public function updateActive($input) {
        $postObj = new Category();
        $category_id = $input['id'];
        $status = $input['status'];
        $updata = $postObj->getCategoryById($category_id);
        //$updata = $category_id;
        $jsondata = CommonHelper::defaultJson(); 
        $updata->status = $status;
        $updata->update();
        $jsondata['success'] = 1;
        $jsondata['success_mess'] = trans('messages.success.update');
        return $jsondata;
    }

    function deleteSelected($input) {
        $checkval = explode(",", $input['checkval']);
        $data = CommonHelper::defaultJson();
        if (!empty($checkval)) {
            foreach ($checkval as $key) {
                $this->deleteThis($key);
            }
            $data['success'] = 1;
            $data['success_mess'] = trans('messages.success.delete');
        } else {
            $data['error_mess'] = trans('messages.error.delete');
            $data['error'] = 1;
        }
        return $data;
    }

    public function deleteThis($category_id) {
        $post = $this->getCategoryById($category_id);
        $this->remove_old_image($post, true);
        // foreach ($post->comments as $comment) {
        //     $comment->delete();
        // }
        // foreach ($post->postTags as $postag) {
        //     $postag->delete();
        // }
        $post->delete();
    }
    
    function short_title($len = 50)
    {
        $title = substr($this->category_title,0,$len);
        if(strlen($this->category_title) > $len)
            $title .= "...";
        return $title;
    }
    
    function short_desc($len = 500, $no_html = false)
    {
        if($no_html){
            $clean_title = $title = strip_tags(CommonHelper::htmldata($this->category_desc));
        }
        else
        {
            $clean_title = $title = $this->category_desc;
        }
        $title = substr($title,0,$len);
        
        if(strlen($clean_title) > $len)
            $title .= "...";
        return $title;
    }
    
    function default_c_date($time = false)
    {
        $timestamp = strtotime($this->created_at);
        if (strlen($timestamp) > 0) {
            $date = date("F j, Y", $timestamp);
            if ($time != false) {
                $date = date("F j, Y, h:i:s A", $timestamp);
            }
            return $date;
        }
    }
    
    function yearFromDate()
    {
        $timestamp = strtotime($this->created_at);
        if (strlen($timestamp) > 0) {
            //$date = date("F j, Y", $timestamp);
            $date = date('Y', $timestamp);
            return $date;
        }
    }
    function dateAndMonthFromDate()
    {
        $timestamp = strtotime($this->created_at);
        if (strlen($timestamp) > 0) {
            $date = date("j-M", $timestamp);
            return $date;
        }
    }
    
    function seoUrl()
    {
        return url('categories/'.$this->category_id.'/'.CommonHelper::createItemUrl($this->category_title));
    }

}
