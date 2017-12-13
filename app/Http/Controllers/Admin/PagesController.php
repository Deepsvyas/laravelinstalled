<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Pages ;

class PagesController extends BaseController
{
    public function index(Request $request)
    {
        return view('admin.pages.list',['request' => $request]);
    }
    
    public function pagelist(Request $request) {
        $json_data = \CommonHelper::defaultJson();
        $pageObj = new Pages();
        $data = $pageObj->getPagingPages();
        $html = view('admin.pages.ajax_pages_list', ['request' => $request, 'data' => $data]);
        $json_data['html'] = $html->render();
        $json_data['success'] = 1;
        $json_data['success_mess'] = 1;
        return $json_data;
    }
    
    public function addnewpageajax(Request $request) {
        $pageObj = new Pages();
        $input = $request->all();
        $data = $pageObj->addNew($input);
        return json_encode($data);
    }
    
    public function get_page_data(Request $request) {
        $page_key = $request->input("page_key");
        $pageObj = new Pages();
        $pagedata = $pageObj->getPageByKey($page_key);

        $data = \CommonHelper::defaultJson();
        $data['page_title'] = $pagedata->page_title;
        $data['page_heading'] = $pagedata->page_heading;
        $data['page_slug'] = $pagedata->page_slug;
        $data['page_content'] = \CommonHelper::htmldata($pagedata->page_content);
        $data['page_meta_keywords'] = $pagedata->page_meta_keywords;
        $data['page_meta_description'] = $pagedata->page_meta_description;
        $data['success'] = 1;
        $data['success_mess'] = 1;
        return json_encode($data);
    }
      
    public function update_active(Request $request)
    {
        $modelObj = new Pages();
        $input = $request->all();
        $data = $modelObj->updateActive($input);
        return json_encode($data);
    }
    
    public function delete(Request $request) 
    {
        $pageObj = new Pages();
        $input = $request->all();
        $data = $pageObj->deleteSelected($input);
        return json_encode($data);
    }
    
}
