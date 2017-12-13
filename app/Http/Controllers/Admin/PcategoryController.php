<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Category;
use App\Models\Comments;
use App\Models\Tags;
use App\Models\PostTags;
use App\Helpers\PostHelper;

class PcategoryController extends BaseController {
    
    /* == Category Section Started == */
    
    public function index(Request $request,$new_category=false) {
        return view('admin.pcategory.list', ['request' => $request,'new_category' => $new_category]);
    }

    public function categorylist(Request $request) {
        $json_data = \CommonHelper::defaultJson();
        $categoryObj = new Category();
        $data = $categoryObj->getPagingCategories();
        $html = view('admin.pcategory.ajax_category_list', ['request' => $request, 'data' => $data]);
        $json_data['html'] = $html->render();
        $json_data['success'] = 1;
        $json_data['success_mess'] = 1;
        return $json_data;
    }

    public function addnewcategoryajax(Request $request) {
        $categoryObj = new Category();
        $input = $request->all();
        $data  = $categoryObj->addNew($input);
        return json_encode($data);
    }

    public function get_category_data(Request $request) {
        $category_id = $request->input("category_id");
        $categoryObj = new Category();
        $postdata = $categoryObj->getCategoryById($category_id);
        //print_r($postdata);die;
        $data = \CommonHelper::defaultJson();
        $data['category_id'] = $postdata->category_id;
        $data['category_title'] = $postdata->category_title;
        $data['category_publish'] = $postdata->status; 
        $data['category_desc'] = \CommonHelper::htmldata($postdata->category_desc);
        $data['category_image'] = PostHelper::getBannerImage($postdata, "100_100");
        $data['success'] = 1;
        $data['success_mess'] = 1;
        return json_encode($data);
    }

    public function update_active(Request $request) {
        $categoryObj = new Category();
        $input = $request->all();
        $data = $categoryObj->updateActive($input);
        return json_encode($data);
    }

    public function delete(Request $request) {
        $categoryObj = new Category();
        $input = $request->all();
        $data = $categoryObj->deleteSelected($input);
        return json_encode($data);
    }
        
        /*  == End Category Section ==  */


    /*  == End Tag section ==  */

}
