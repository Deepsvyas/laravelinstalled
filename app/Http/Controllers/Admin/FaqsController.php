<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Faq;
use App\Models\Comments;
use App\Models\Tags;
use App\Models\PostTags;
use App\Helpers\PostHelper;

class FaqsController extends BaseController {
    
    /* == faq Section Started == */
    
    public function index(Request $request,$new_faq=false) {
        return view('admin.faq.list', ['request' => $request,'new_faq' => $new_faq]);
    }

    public function faqlist(Request $request) {
        $json_data = \CommonHelper::defaultJson();
        $faqObj = new Faq();
        $data = $faqObj->getPagingFaqs();
        $html = view('admin.faq.ajax_faq_list', ['request' => $request, 'data' => $data]);
        $json_data['html'] = $html->render();
        $json_data['success'] = 1;
        $json_data['success_mess'] = 1;
        return $json_data;
    }

    public function addnewfaqajax(Request $request) {
        $faqObj = new Faq();
        $input = $request->all();
        $data  = $faqObj->addNew($input);
        return json_encode($data);
    }

    public function get_faq_data(Request $request) {
        $faq_id = $request->input("faq_id");
        $faqObj = new Faq();
        $postdata = $faqObj->getFaqById($faq_id);
        //print_r($postdata);die;
        $data = \CommonHelper::defaultJson();
        $data['faq_id'] = $postdata->faq_id;
        $data['faq_title'] = $postdata->faq_title;
        $data['faq_publish'] = $postdata->status; 
        $data['faq_desc'] = \CommonHelper::htmldata($postdata->faq_description);
        $data['success'] = 1;
        $data['success_mess'] = 1;
        return json_encode($data);
    }

    public function update_active(Request $request) {
        $faqObj = new Faq();
        $input = $request->all();
        $data = $faqObj->updateActive($input);
        return json_encode($data);
    }

    public function delete(Request $request) {
        $faqObj = new Faq();
        $input = $request->all();
        $data = $faqObj->deleteSelected($input);
        return json_encode($data);
    }
        
        /*  == End faq Section ==  */


    /*  == End Tag section ==  */

}
