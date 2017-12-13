<?php
namespace App\Models;

use App\Helpers\CommonHelper as CommonHelper;
use App\Helpers\ViewsHelper as Views;
use Config;
use Session;
class Pages extends Base
{
    public $num;
    protected $table = 'pages';
    public $primaryKey = "page_id";
    
    /*
      All model relations arrives here
     */
    
    function getPageByKey($key)
    {
        return $this->where("page_id",$key)->first();
    }
    
    function getPageContentBySlug($slug)
    {
        return $this->where("page_slug",$slug)->first();
    }
    
    function getPagingPages()
    {
        return $this->sort()->search()->dpaginate();
    }
    
    function addNew($input)
    {
        $data = CommonHelper::defaultJson();
        $rules = array(
            //'page_title' => 'required|alpha_spaces|max:100',
            'page_heading' => 'required|alpha_spaces|max:100',
            //'page_slug' => 'required|menu_slug|max:200|unique:'.$this->table.',page_slug',
            //'page_meta_keywords' => 'max:255',
            //'page_meta_description' => 'max:255',
            'page_content' => 'required',
        );
        
        $pdata = $pagedata = $this->getPageByKey($input['page_edit_key']);
//        if(!empty($pdata))
//        {
//            $rules['page_slug'] = 'required|menu_slug|max:200|unique:'.$this->table.',page_slug,'.$input['page_slug'].',page_slug';
//        }
        $newnames = array(
            'page_heading' => 'Page Heading',
            'page_content' => 'Page Content',
        );
        $messages = array();
        $v = \Validator::make($input, $rules, $messages);
        $v->setAttributeNames($newnames);
        if ($v->passes()) {
            if(empty($pdata))
            {
                $pagedata = new Pages();
                //$pagedata->page_key = CommonHelper::getEncryptedKey();
                //$pagedata->lang_id = Session::get("LOCALE_LANG_ID");
            }
            //$pagedata->page_slug = strtolower($input['page_slug']);
            //$pagedata->page_title = ucfirst($input['page_title']);
            $pagedata->page_heading = ucfirst($input['page_heading']);
            //$pagedata->page_meta_keywords = ($input['page_meta_keywords']);
            //$pagedata->page_meta_description = $input['page_meta_description'];
            $pagedata->page_content = CommonHelper::nohtmldata($input['page_content']);
            
            if(empty($pdata))
            {
                $pagedata->save();
                $data['success_mess'] = 'Saved successfully';
            }else{
                $pagedata->update();
                $data['success_mess'] = 'Updated successfully';
            }
            $data['success'] = 1;
        }else{
            $data['error'] = 1;
            $data['error_mess'] = $v->messages();
        }
        return $data;
    }
    
    public function updateActive($input) {
        $modelObj = new Pages();
        $page_key = $input['id'];
        $status = $input['status'];
        $updata = $modelObj->getPageByKey($page_key);
        $jsondata = CommonHelper::defaultJson();
        $updata->status = $status;
        $updata->save();
        $jsondata['success'] = 1;
        $jsondata['success_mess'] = trans('messages.success.update');
        return $jsondata;
    }

    
    function deleteSelected($input)
    {
        $checkval = explode(",",$input['checkval']);
        
        $data = \CommonHelper::defaultJson();
        if(!empty($checkval))
        {
            foreach ($checkval as $id)
            {
                $page_delete = $this->getPageByKey($id);
                $page_delete->delete();
            }
            $data['success'] = 1;
            $data['success_mess'] = trans('messages.success.delete');
        }
        else
        {
            $data['error_mess'] = trans('messages.error.delete');
            $data['error'] = 1;
        }
        return $data;
    }
    
}
