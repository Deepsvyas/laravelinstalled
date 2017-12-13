<?php

namespace App\Models;

use App\Helpers\CommonHelper as CommonHelper;
use App\Helpers\ViewsHelper as Views;
use App\Models\User\User ;
use Config;
use Session;

class Comments extends Base {

    public $num;
    protected $table = 'comments';
    public $primaryKey = "comment_id";

    /*
      All model relations arrives here
     */
    
    public function user() {
        return $this->belongsTo('App\Models\User\User', 'user_id', 'user_id');
    }
    public function post() {
        return $this->belongsTo('App\Models\Posts', 'post_id', 'post_id');
    }

    function getCommentById($id) {
        return $this->where("comment_id", $id)->first();
    }

    function getCommentByKey($key) {
        return $this->where("comment_key", $key)->first();
    }
    function getCountOfCommentsByPostId($id) {
        return $this->where("post_id", $id)->count();
    }

    function getPagingCommentsByPostId($post_id ,$status = null) {
        $comments = new Comments();
        $comments = $comments->where('post_id',$post_id);
        if($status)
            $comments = $comments->where('status',$status);
        return $comments->sort()->search()->dpaginate();
    }

    function addNew($input) {
        $jsondata = CommonHelper::defaultJson();
        $cdata = $commentdata = $this->getCommentByKey($input['comment_edit_key']);
        
        $rules = array(
            'comment_message' => 'required|alpha_comma_num_spaces',
        );
        if(empty($cdata))
        {
            $rules['comment_name'] = 'required|alpha_spaces|max:100';
            $rules['comment_email'] = 'required|email';
        }
        $newnames = trans('comments.labels');
        $messages = array();
        $v = \Validator::make($input, $rules, $messages);
        $v->setAttributeNames($newnames);
        if ($v->passes()) {

            if (empty($cdata)) {
                $user = new User();
                $commentdata = new Comments();
                $commentdata->lang_id = Session::get("LOCALE_LANG_ID");
                $commentdata->comment_key = CommonHelper::getEncryptedKey();
                $commentdata->post_id = Posts::getPostIdByKey($input['post_key']);
                if(Views::getConfigKeyData("default_user_comments_active"))
                    $commentdata->status = 1;
                $user_data = $user->getUserProfileByEmail($input['comment_email']);
                if(empty($user_data)){
                    $userObj = new User();
                    $user->user_key = \CommonHelper::getEncryptedKey();
                    $user->first_name = $input['comment_name'];
                    $user->email = $input['comment_email'];
                    $user->role_id = 7;
                    $user = $userObj->quickSignUp($user);
                    $commentdata->user_id = $user->user_id;
                }else{
                    $commentdata->user_id = $user_data->user_id;
                }
            }
            $commentdata->comment_message = $input['comment_message'];
            //$commentdata->status = 0;
            if (empty($cdata)) {
                $commentdata->save();
                if(Views::getConfigKeyData("default_user_comments_active"))
                    $jsondata['success_mess'] = trans('messages.success.save');
                else
                    $jsondata['success_mess'] = trans('comments.success.save');
            } else {
                $commentdata->update();
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
        $commentObj = new Comments();
        $comment_key = $input['id'];
        $status = $input['status'];
       // $comment_key = $input['comment_key'];
        $updata = $commentObj->getCommentByKey($comment_key);
        $jsondata = CommonHelper::defaultJson();
        $updata->status = $status;
        $updata->save();
        $jsondata['success'] = 1;
        $jsondata['success_mess'] = trans('messages.success.update');
        return $jsondata;
    }

    function deleteSelected($input) {
        $checkval = explode(",", $input['checkval']);
        $data = \CommonHelper::defaultJson();
        if (!empty($checkval)) {
            foreach ($checkval as $key) {
                $this->deleteThis($key);
            }
            $data['success'] = 1;
            $data['success_mess'] = trans('messages.success.update');
        } else {
            $data['error_mess'] = trans('messages.error.delete');
            $data['error'] = 1;
        }
        return $data;
    }
    
    public function deleteThis($key){
        $comment = $this->getCommentByKey($key);
        $comment->delete();
    }

}
