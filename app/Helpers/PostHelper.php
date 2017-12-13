<?php
namespace App\Helpers;
use App\Models\Posts;
use Config;
class PostHelper {

    public static function hasPostImage($postDataObj = array(),$size = "100_100", $get_real = false) {
        
        $post_image  = Config::get("params.post_image");
        $base_path = base_path($post_image['base_path']);
        if($get_real){
            $size = "";
        }else{
            $size .= "_";
        }
        if(!empty($postDataObj)){
            $base_path = $base_path.'/'.$postDataObj->post_id."/".$size.$postDataObj->post_image;
        }else{
            $base_path = "";
        }
        if(!file_exists($base_path))
        {
            return false;
        }
        return true;
    }
    
    public static function getPostImage($postDataObj = array(),$size = "100_100", $get_real = false) {
        
        $post_image  = Config::get("params.post_image");
        $base_path = base_path($post_image['base_path']);
        if($get_real){
            $size = "";
        }else{
            $size .= "_";
        }
        if(!empty($postDataObj)){
            $base_path = $base_path.'/'.$postDataObj->post_id."/".$size.$postDataObj->post_image;
            $path = url($post_image['path']."/".$postDataObj->post_id."/".$size.$postDataObj->post_image);
        }else{
            $base_path = "";
        }
        if(!file_exists($base_path))
        {
            $path = url("fn/getimage/application~img~admin~boxed-bg.png/".$size);
        }
        return $path;
    }
    
    public static function postImage($post_id, $size = "100_100") {
        $postObj = new Posts();
        $post = $postObj->getPostById($post_id);
        $path = PostHelper::getPostImage($post,$size);
        return $path;
    }
    
    public static function getRecentPosts() {
        $postObj = new Posts();
        return $recent_posts = $postObj->getRecentPosts();
    }


    public static function getBannerImage($bannerDataObj = array(),$size = "100_100", $get_real = false) {
        
        $banner_image  = Config::get("params.banner_image");
        $base_path = base_path($banner_image['base_path']);
        if($get_real){
            $size = "";
        }else{
            $size .= "_";
        }
        if(!empty($bannerDataObj)){
            $base_path = $base_path.'/'.$bannerDataObj->banner_id."/".$size.$bannerDataObj->banner_image;
            $path = url($banner_image['path']."/".$bannerDataObj->banner_id."/".$size.$bannerDataObj->banner_image);
        }else{
            $base_path = "";
        }
        if(!file_exists($base_path))
        {
            $path = url("fn/getimage/application~img~admin~boxed-bg.png/".$size);
        }
        return $path;
    }

    public static function getCategoryImage($categoryDataObj = array(),$size = "100_100", $get_real = false) {
        
        $category_image  = Config::get("params.category_image");
        $base_path = base_path($category_image['base_path']);
        if($get_real){
            $size = "";
        }else{
            $size .= "_";
        }
        if(!empty($categoryDataObj)){
            $base_path = $base_path.'/'.$categoryDataObj->category_id."/".$size.$categoryDataObj->category_image;
            $path = url($category_image['path']."/".$categoryDataObj->category_id."/".$size.$categoryDataObj->category_image);
        }else{
            $base_path = "";
        }
        if(!file_exists($base_path))
        {
            $path = url("fn/getimage/application~img~admin~boxed-bg.png/".$size);
        }
        return $path;
    }
    
}
