<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Banner;
use App\Models\Comments;
use App\Models\Tags;
use App\Models\PostTags;
use App\Helpers\PostHelper;

class BannerController extends BaseController {
    
    /* == Banner Section Started == */
    
    public function index(Request $request,$new_banner=false) {
        return view('admin.banner.list', ['request' => $request,'new_banner' => $new_banner]);
    }

    public function bannerlist(Request $request) {
        $json_data = \CommonHelper::defaultJson();
        $bannerObj = new Banner();
        $data = $bannerObj->getPagingPosts();
        $html = view('admin.banner.ajax_posts_list', ['request' => $request, 'data' => $data]);
        $json_data['html'] = $html->render();
        $json_data['success'] = 1;
        $json_data['success_mess'] = 1;
        return $json_data;
    }

    public function addnewbannerajax(Request $request) {
        $bannerObj = new Banner();
        $input = $request->all();
        $data  = $bannerObj->addNew($input);
        return json_encode($data);
    }

    public function get_banner_data(Request $request) {
        $banner_id = $request->input("banner_id");
        $bannerObj = new Banner();
        $postdata = $bannerObj->getBannerById($banner_id);
        //print_r($postdata);die;
        $data = \CommonHelper::defaultJson();
        $data['banner_id'] = $postdata->banner_id;
        $data['banner_title'] = $postdata->banner_title;
        $data['banner_publish'] = $postdata->status; 
        $data['banner_desc'] = \CommonHelper::htmldata($postdata->banner_desc);
        $data['banner_image'] = PostHelper::getBannerImage($postdata, "100_100");
        $data['success'] = 1;
        $data['success_mess'] = 1;
        return json_encode($data);
    }

    public function update_active(Request $request) {
        $bannerObj = new Banner();
        $input = $request->all();
        $data = $bannerObj->updateActive($input);
        return json_encode($data);
    }

    public function delete(Request $request) {
        $bannerObj = new Banner();
        $input = $request->all();
        $data = $bannerObj->deleteSelected($input);
        return json_encode($data);
    }
        
        /*  == End Banner Section ==  */


    /*  == End Tag section ==  */

}
