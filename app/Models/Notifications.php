<?php

namespace App\Models;

use App\Models\User\User;
use App\Helpers\CommonHelper as CommonHelper;
use Illuminate\Support\Facades\Auth;
use Config,
    GuzzleHttp\Client;

class Notifications extends Base {

    public $num;
    protected $table = 'notifications';
    public $primaryKey = "notification_id";
    public $outer_key = "54dfg543gh2243fg5432fgnmuk";

    /*
      All model relations arrives here
     */

    public function fromUser() {
        return $this->belongsTo('App\Models\User\User', 'from_user_id', 'user_id');
    }

    public function toUser() {
        return $this->belongsTo('App\Models\User\User', 'to_user_id', 'user_id');
    }

    public function getByKey($key) {
        $data = $this->where('notification_key', $key)->first();
        return $data;
    }

    public function getById($id) {
        $data = $this->where('notification_id', $id)->first();
        return $data;
    }
    
    public function getUnReadCount($id) {
        return $this->where('to_user_id', $id)->where("is_read", 0)->count();
    }


    public function getNotifPaging($id) {
        return $this->where('to_user_id', $id)->sort()->dpaginate(5);
    }

    public function getSendNotifPaging($id) {
        return $this->where('from_user_id', $id)->sort()->dpaginate();
    }

    public function getNotificationId($notification_id) {
        return $this->where('notification_id', notification_id)->first();
    }

    function addNew($input, $id = 0, $section_type = 0, $sub_section = 0) {
        $userObj = new User();
        $userData = $userObj->getUserProfile($input['to_user_id']);
        if (empty($userData)) {
            return false;
        }
        if (Auth::user()->user_id != $input['to_user_id']) {
            $notification = new Notifications();
            $notification->notification_key = CommonHelper::getEncryptedKey();
            $notification->notification = $input['notification'];
            $notification->subject = $input['subject'];
            $notification->to_user_id = $userData->user_id;
            $notification->from_user_id = $input['from_user_id'];
            $notification->topic_id = $input['topic_id'];
            $notification->section_id = $id;
            $notification->is_read = 0;
            $notification->section_type = $section_type;
            $notification->sub_section = $sub_section;
            $notification->save();
            return $notification;
        } else {
            return false;
        }
    }
    
    public function getTopicUrl(){ 
        return url('notif/'.$this->notification_id);
    }

//    function deleteSelected($input) {
//        $type = $input['type'];
//        $checkval = explode(",", $input['checkval']);
//        $data = CommonHelper::defaultJson();
//        if (!empty($checkval)) {
//            foreach ($checkval as $key) {
//                $this->deleteThis($key, $type);
//            }
//            $data['success'] = 1;
//            $data['success_mess'] = trans('notifications.success.delete');
//        } else {
//            $data['error_mess'] = trans('notifications.delete');
//            $data['error'] = 1;
//        }
//        return $data;
//    }

//    public function deleteThis($key, $type) {
//        $data = $this->getMessageByKey($key);
//        if ($type == 'inbox') {
//            $data->to_user_delete = Auth::user()->user_id;
//        } else if ($type == 'sent') {
//            $data->from_user_delete = Auth::user()->user_id;
//        }
//        $data->update();
//    }

    function short_subject($limit = 30) {
        $subject = substr($this->subject, 0, $limit);
        if (strlen($subject) < strlen($this->subject)) {
            $subject.= "...";
        }
        return $subject;
    }

    function short_notification($limit = 30) {
        $notification = substr($this->notification, 0, $limit);
        if (strlen($notification) < strlen($this->notification)) {
            $notification.= "...";
        }
        return $notification;
    }

//    function read_all_notif($user_id) {
//        $notifs = Notifications::where("to_user_id", $user_id)->where('is_read', 0)->get();
//        foreach ($notifs as $notif) {
//            $notif->is_read = 1;
//            $notif->updated_at = date('Y-m-d H:i:s');
//            $notif->update();
//        }
//        return true;
//    }

}
