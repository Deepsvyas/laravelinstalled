<?php

namespace App\Models;

use App\Helpers\CommonHelper as CommonHelper;
use App\Helpers\ViewsHelper as Views;
use App\Helpers\SimpleImage;
use Config;
use Session;

class Faq extends Base {

    public $num;
    protected $table = 'faqs';
    public $primaryKey = "faq_id";

    /*
      All model relations arrives here
     */

    function getFaqById($id) {
        return $this->where("faq_id", $id)->first();
    }
    
    public function countTotalBanner() {
        return $this->count();
    }

    public static function getFaqIdByKey($key) {
        $data = Faq::where("faq_id", $key)->first();
        return $data->faq_id;
    }

    function getPagingFaqs($status = null) {
        $faq = new Faq();
        if ($status)
            $faq = $faq->where('status', $status);
        //return $faq->sort()->search()->bylang()->dpaginate();
        return $faq->sort()->search()->dpaginate();
    }
    
    function getMostViewedFaqs($limit = 10) {
        return $this->where('status', 1)->orderBy('counter', 'DESC')->limit($limit)->get();
    }
    function getRecentFaqs($limit = 5) {
        return $this->where('status', 1)->orderBy('created_at', 'DESC')->limit($limit)->get();
    }
    function getSearchFaqs($search) {
        $search = trim($search);
        return $this->where('status', 1)->where('faq_title', 'like', '%'.$search.'%')->orWhere('faq_description', 'like', '%'.$search.'%')->orderBy('created_at', 'DESC')->paginate(2);
    }

    function addNew($input) {
        
        $uploaded = array();
        $jsondata = CommonHelper::defaultJson(); 
        $pdata = $faqdata = $this->getFaqById($input['faq_id']);
        $rules = array( 
            'faq_title' => 'required|max:200',
            'faq_desc_h' => 'required', 
        );
       
        $newnames = array();
        $messages = array();
        $v = \Validator::make($input, $rules, $messages);
        $v->setAttributeNames($newnames);
        if ($v->passes()) {
            
            if (empty($pdata)) {
                $faqdata = new Faq();
            }
            $faqdata->faq_title = ucfirst($input['faq_title']);
            $faqdata->faq_description = CommonHelper::nohtmldata(urldecode($input['faq_desc_h']));
                if (isset($input['faq_publish']))
                    $faqdata->status = $input['faq_publish'];
                else
                    $faqdata->status = 0;
                if (empty($pdata)) {
                    $faqdata->save();
                    $jsondata['success_mess'] = trans('messages.success.save');
                } else {
                    $faqdata->update();
                    $jsondata['success_mess'] = trans('messages.success.update');
                }

                $jsondata['success'] = 1;
            
        } else {
            $jsondata['error'] = 1;
            $jsondata['error_mess'] = $v->messages();
        }
        return $jsondata;
    }

 

    public function updateActive($input) {
        $faqObj = new Faq();
        $faq_id = $input['id'];
        $status = $input['status'];
        $updata = $faqObj->getFaqById($faq_id);
        //$updata = $banner_id;
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

    public function deleteThis($faq_id) {
        $faq = $this->getFaqById($faq_id);
        //$this->remove_old_image($faq, true);
        // foreach ($faq->comments as $comment) {
        //     $comment->delete();
        // }
        // foreach ($faq->faqTags as $faqtag) {
        //     $faqtag->delete();
        // }
        $faq->delete();
    }
 
    
    function short_title($len = 50)
    {
        $title = substr($this->faq_title,0,$len);
        if(strlen($this->faq_title) > $len)
            $title .= "...";
        return $title;
    }
    
    function short_desc($len = 500, $no_html = false)
    {
        if($no_html){
            $clean_title = $title = strip_tags(CommonHelper::htmldata($this->faq_description));
        }
        else
        {
            $clean_title = $title = $this->faq_description;
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
        return url('blog/'.$this->faq_id.'/'.CommonHelper::createItemUrl($this->faq_title));
    }

}
