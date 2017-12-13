<?php

namespace App\Models;

use App\Helpers\CommonHelper as CommonHelper;
use App\Helpers\ViewsHelper as Views;
use App\Helpers\SimpleImage;
use App\Models\Comments;
use App\Models\PostTags;
use Config;
use Session;

class Posts extends Base {

    public $num;
    protected $table = 'posts';
    public $primaryKey = "post_id";

    /*
      All model relations arrives here
     */

    public function comments() {
        return $this->hasMany('App\Models\Comments', 'post_id', 'post_id');
    }

    public function comments_count() {
        $comments_c = $this->comments()->count();
        if (!$comments_c)
            $comments_c = 0;
        return $comments_c;
    }

    public function postTags() {
        return $this->hasMany('App\Models\PostTags', 'post_id', 'post_id');
    }
    
    public function tag_count() {
        $tag_c = $this->postTags()->count();
        if (!$tag_c)
            $tag_c = 0;
        return $tag_c;
    }

    function getPostById($id, $status = null) {
        if($status)
            return $this->where("post_id", $id)->where('status',$status)->first();
        else
            return $this->where("post_id", $id)->first();
    }

    function getPostByKey($key) {
        return $this->where("post_key", $key)->first();
    }
    
    public function countTotalPosts() {
        return $this->count();
    }

    public static function getPostIdByKey($key) {
        $data = Posts::where("post_key", $key)->first();
        return $data->post_id;
    }

    function getPagingPosts($status = null) {
        $post = new Posts();
        if ($status)
            $post = $post->where('status', $status);
        //return $post->sort()->search()->bylang()->dpaginate();
        return $post->sort()->search()->dpaginate();
    }
    
    function getMostViewedPosts($limit = 10) {
        return $this->where('status', 1)->orderBy('counter', 'DESC')->limit($limit)->get();
    }
    function getRecentPosts($limit = 5) {
        return $this->where('status', 1)->orderBy('created_at', 'DESC')->limit($limit)->get();
    }
    function getSearchPosts($search) {
        $search = trim($search);
        return $this->where('status', 1)->where('post_title', 'like', '%'.$search.'%')->orWhere('post_desc', 'like', '%'.$search.'%')->orderBy('created_at', 'DESC')->paginate(2);
    }

    function addNew($input) {
        
        $uploaded = array();
        $jsondata = CommonHelper::defaultJson();
        $pdata = $postdata = $this->getPostByKey($input['post_key']);
       // $post_image_required = views::getConfigKeyData('post_image_required');
        $rules = array(
            'post_author' => 'required|max:100',
            //'post_title' => 'required|alpha_comma_num_spaces|max:200',
            'post_title' => 'required|max:200',
            'post_desc_h' => 'required',
            //'post_youtube_video_url' => 'url',
        );
        if (empty($pdata)) {
            $rules['post_image'] = 'required';
        }

        $newnames = array();
        $messages = array();
        $v = \Validator::make($input, $rules, $messages);
        $v->setAttributeNames($newnames);
        if ($v->passes()) {
            
            $this->file_obj = @$input['post_image'];
            $uploaded['status'] = 0;

            if (empty($this->file_obj) && empty($pdata) && $post_image_required == 1) {
                $jsondata['error'] = 1;
                $jsondata['error_mess'] = $v->errors()->add("post_image", trans('messages.img_required'));
                return $jsondata;
            }
            if (empty($this->file_obj) && !empty($pdata)) {
                $uploaded['status'] = 1;
            }
            if (!empty($this->file_obj) && !empty($pdata)) {
                $uploaded = $this->uploadImage($this->file_obj, $postdata->post_id);
                $this->remove_old_image($postdata);
            } else if (!empty($this->file_obj)) {
                $uploaded = $this->uploadImage($this->file_obj);
            }
            if ($uploaded['status'] == 1) {
                $post_image = Config::get("params.post_image");
                if (empty($pdata)) {
                    $postdata = new Posts();
                    $postdata->post_key = CommonHelper::getEncryptedKey();
                }
                if (!empty($this->file_obj)) {
                    $postdata->post_image = $uploaded['file_name'];
                }
                $postdata->post_author = strtolower($input['post_author']);
               // $postdata->post_youtube_video_url = $input['post_youtube_video_url'];
                $postdata->post_title = ucfirst($input['post_title']);
                $postdata->post_desc = CommonHelper::nohtmldata(urldecode($input['post_desc_h']));
                if (isset($input['post_publish']))
                    $postdata->status = $input['post_publish'];
                else
                    $postdata->status = 0;
                if (empty($pdata)) {
                    $postdata->save();
                    $jsondata['success_mess'] = trans('messages.success.save');
                    if (!empty($this->file_obj)) {
                        $curr_upload_path = $uploaded['path'];
                        $now_path = base_path($post_image['base_path']) . "/" . $postdata->post_id;
                        rename($curr_upload_path, $now_path);
                    }
                } else {
                    $postdata->update();
                    $jsondata['success_mess'] = trans('messages.success.update');
                }

                $jsondata['success'] = 1;
            } else {
                $jsondata['error'] = 1;
                $jsondata['error_mess'] = $v->errors()->add("post_image", $uploaded['error']);
            }
        } else {
            $jsondata['error'] = 1;
            $jsondata['error_mess'] = $v->messages();
        }
        return $jsondata;
    }

    function uploadImage($file, $id = false) {
        $post_image = Config::get("params.post_image");
        $allowed = $post_image['mimes'];
        $mimeType = $file->getMimeType();
        if (!in_array($mimeType, $allowed)) {
            return array("status" => 0, 'error' => trans('messages.valid_img'));
        }
        if (!$id)
            $id = time();
        $path = $post_image['base_path'];
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

        $sizes = explode(",", $post_image['sizes']);
       
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

    function remove_old_image($post, $rm_dir = false) {
        $post_image = Config::get("params.post_image");
        $sizes = $post_image['sizes'];
        $sizes = explode(",", $sizes);
        if (!empty($sizes)) {
            foreach ($sizes as $size) {
                list($width, $height) = explode("x", $size);
                $image_path = base_path($post_image['base_path'] . "/" . $post->post_id);
                @unlink($image_path . '/' . $width . "_" . $height . "_" . $post->post_image);
            }
            @unlink($image_path . '/' . $post->post_image);
        }
        if ($rm_dir)
            @rmdir($image_path);
    }

    public function updateActive($input) {
        $postObj = new Posts();
        $post_key = $input['id'];
        $status = $input['status'];
        $updata = $postObj->getPostByKey($post_key);
        $jsondata = CommonHelper::defaultJson();
        $updata->status = $status;
        $updata->save();
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

    public function deleteThis($key) {
        $post = $this->getPostByKey($key);
        $this->remove_old_image($post, true);
        foreach ($post->comments as $comment) {
            $comment->delete();
        }
        foreach ($post->postTags as $postag) {
            $postag->delete();
        }
        $post->delete();
    }

    public function submitBlogAnalyseData($post_key) {
        $need_to_set = false;
        if (Session::has('BLOG_ANALYSE_DATA')) {
            $analyse_data = Session::get('BLOG_ANALYSE_DATA');
            if (!in_array($post_key, $analyse_data)) {
                $need_to_set = true;
            }
        } else {
            $need_to_set = true;
        }
        if ($need_to_set) {
            $post_data = $this->getPostByKey($post_key);
            if(!empty($post_data)){
                $counter = $post_data->counter + 1;
                $post_data->counter = $counter;
                $post_data->update();
                Session::push('BLOG_ANALYSE_DATA', $post_key);
            }
        }
    }
    
    function short_title($len = 50)
    {
        $title = substr($this->post_title,0,$len);
        if(strlen($this->post_title) > $len)
            $title .= "...";
        return $title;
    }
    
    function short_desc($len = 500, $no_html = false)
    {
        if($no_html){
            $clean_title = $title = strip_tags(CommonHelper::htmldata($this->post_desc));
        }
        else
        {
            $clean_title = $title = $this->post_desc;
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
        return url('blog/'.$this->post_id.'/'.CommonHelper::createItemUrl($this->post_title));
    }

}
