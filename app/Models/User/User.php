<?php

namespace App\Models\User;

use Config;
use App\Helpers\MailFunctions;
use App\Helpers\SimpleImage;
use App\Models\Role;
use App\Models\Topics;
use App\Models\Categories;
use UserHelper,
    CommonHelper,
    Auth;

class User extends UserBase {
    
    
    public static function tableName() {
        return with(new static)->getTable();
    }

    public function getUserProfile($user_id) {
        return $this->where('user_id', $user_id)->first();
    }

    function checkSocialId($checkSocialId) {
        return $this->where('social_login_id', $checkSocialId)->first();
    }

    function getTotalTopics() {
        $topicObj = new Topics();
        return $topicObj->where('user_id', $this->user_id)->where('approved', 1)->count();
    }

    public function updateProfile($input) {

        $jsondata = CommonHelper::defaultJson();
        $rules = array(
            'first_name' => 'required',
            'last_name' => 'required',
            'mobile_number' => 'required',
        );
        $newnames = array(
            'first_name' => 'First Name',
            'login_pass' => 'Password',
            'conf_password' => 'Confirm Password',
        );
        $messages = array();
        $v = \Validator::make($input, $rules, $messages);
        $v->setAttributeNames($newnames);
        if ($v->passes()) {
            $userObj = new User();
            $updata = $userObj->getUserProfile($input['user_id']);

            $updata->first_name = CommonHelper::toName($input['first_name']);
            $updata->last_name = CommonHelper::toName($input['last_name']);
            $updata->email = $input['email'];
            $updata->phone_number = $input['phone_number'];
            $updata->update();
            $jsondata['success'] = 1;
            $jsondata['success_mess'] = trans('messages.success.update');
        } else {
            $jsondata['error'] = 1;
            $jsondata['error_mess'] = $v->messages();
        }
        return $jsondata;
    }

    public function editInfo($input) {
        $jsondata = CommonHelper::defaultJson();
        $required = "";
        $rules = array(
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required',
            'mobile_number' => 'required|numeric',
            'birthday' => 'required',
        );
        $newnames = array();
        $messages = array();
        $v = \Validator::make($input, $rules, $messages);
        $v->setAttributeNames($newnames);
        if ($v->passes()) {
            $userObj = new User();
            $updata = $userObj->getUserProfile($input['user_id']);
            if (!empty($updata)) {
                $updata->first_name = CommonHelper::toName($input['first_name']);
                $updata->last_name = CommonHelper::toName($input['last_name']);
                $updata->gender = $input['gender'];
                $updata->public_profile = $input['public_profile'];
                $updata->phone_number = $input['mobile_number'];
                $updata->birthday = $input['birthday'];
                $updata->location = $input['location'];
                $updata->facebook_url = $input['facebook_url'];
                $updata->twitter_url = $input['twitter_url'];
                $updata->linkedin_url = $input['linkedin_url'];
                $updata->update();
                $jsondata['success'] = 1;
                $jsondata['success_mess'] = "User information updated successfully";
            } else {
                $jsondata['error'] = 1;
                $jsondata['error_mess'] = "Somthing error Please try again !";
            }
        } else {
            $jsondata['error'] = 1;
            $jsondata['error_mess'] = $v->messages();
        }
        return $jsondata;
    }

    public function updateActive($input) {
        $userObj = new User();
        $user_id = $input['user'];
        $blocked = $input['blocked'];
        $updata = $userObj->getUserProfile($user_id);
        $jsondata = CommonHelper::defaultJson();
        $updata->updated_at = date('Y-m-d H:i:s');
        $updata->blocked = $blocked;
        $updata->save();
        $jsondata['success'] = 1;
        $jsondata['success_mess'] = trans('messages.success.update');
        return $jsondata;
    }

    public function update_feature($input) {
        $userObj = new User();
        $user_id = $input['user'];
        $featured = $input['featured'];
        $updata = $userObj->getUserProfile($user_id);
        $jsondata = CommonHelper::defaultJson();
        $updata->is_feature_user = $featured;
        $updata->updated_at = date('Y-m-d H:i:s');
        $updata->save();
        $jsondata['success'] = 1;
        $jsondata['success_mess'] = trans('messages.success.update');
        return $jsondata;
    }

    public function deleteSelected($input) {
        $jsondata = CommonHelper::defaultJson();
        $checkval = explode(",", $input['checkval']);
        if (!empty($checkval)) {
            foreach ($checkval as $id) {
                $this->deleteThis($id);
            }
            $jsondata['success'] = 1;
            $jsondata['success_mess'] = trans('messages.success.delete');
        } else {
            $jsondata['error_mess'] = trans('messages.error.delete');
            $jsondata['error'] = 1;
        }
        return $jsondata;
    }

    function deleteThis($id) {
        $user = $this->getUserProfile($id);
        $this->remove_old_image($user, true);
        $user->delete();
    }

    function full_name() {
        if (!isset($this->first_name)) {
            return false;
        }
        return $this->first_name . " " . $this->last_name;
    }

    public function getforgotPasswordByEmail($input) {

        $jsondata = CommonHelper::defaultJson();
        $rules = array(
            'forgotPasswordEmail' => 'required|email',
        );
        $newnames = array(
            'forgotPasswordEmail' => "Email",
        );
        $messages = array();
        $v = \Validator::make($input, $rules, $messages);
        $v->setAttributeNames($newnames);
        if ($v->passes()) {
            $user = new User();
            $data = $user->getUserProfileByEmail($input['forgotPasswordEmail']);
            if (!empty($data)) {
                $data->reset_key = CommonHelper::getEncryptedKey();
                $data->update();
                $this->sendPasswordResetEmail($data);
                $jsondata['success'] = 1;
                $jsondata['success_mess'] = trans('messages.success.reset');
                $jsondata['user_data'] = $data->toArray();
            } else {
                $jsondata['error'] = 1;
                $jsondata['error_mess'] = $v->errors()->add('forgotPasswordEmail', "This account does not exist!");
            }
        } else {
            $jsondata['error'] = 1;
            $jsondata['error_mess'] = $v->messages();
        }
        return $jsondata;
    }

    public function resetpassword($input) {
        $jsondata = CommonHelper::defaultJson();
        $rules = array(
            'new_password' => 'required|min:6|max:15',
            'confirm_password' => 'required|same:new_password',
        );
        $newnames = array(
            'new_password' => "New Password",
            'confirm_password' => "Confirm Password",
        );
        $messages = array();
        $v = \Validator::make($input, $rules, $messages);
        $v->setAttributeNames($newnames);
        if ($v->passes()) {
            $updata = User::getResetToken($input['token']);
            if (!empty($updata)) {
                $password = $input['new_password'];
                list($encpassword, $random_salt) = CommonHelper::encryptPassword($password);
                $updata->login_pass = $encpassword;
                $updata->salt = $random_salt;
                $updata->reset_key = "";
                $updata->save();
                //$CI->coresession->unset_userdata("USER_RESET_TOKEN");
                $jsondata['success'] = 1;
                $jsondata['success_mess'] = 'Change password successfully';
            } else {
                $jsondata['error'] = 1;
                $v->errors()->add('new_password', 'not a valid user');
                $jsondata['error_mess'] = $v->messages();
            }
        } else {
            $jsondata['error'] = 1;
            $jsondata['error_mess'] = $v->messages();
        }
        return $jsondata;
    }

    function quickSignUp($user) {
        //$user->lang_id = CommonHelper::getLang();
        //$user->lang_id = Session::get("LOCALE_LANG_ID");
        $user->ref_user_id = CommonHelper::getRefferId();
        $user->save();
        return $user;
    }

    public function signUp($input) {
        $jsondata = CommonHelper::defaultJson();
        if (!isset($input['social_login_id'])) {
            $rules['first_name'] = 'required|alpha_spaces|min:3';
            $rules['last_name'] = 'required|alpha_spaces|min:3';
            $rules['phone_number'] = 'required|numeric';
            $rules['email'] = 'required|email|unique:users,email|min:8|max:255';
            $rules['password'] = 'required|min:6|max:50';
            $rules['conf_password'] = 'required|same:password';
        }
        $newnames = array(
            'email' => 'Email',
            'password' => 'Password',
            'conf_password' => 'Confirm Password',
        );
        $messages = array();
        $v = \Validator::make($input, $rules, $messages);
        $v->setAttributeNames($newnames);
        if ($v->passes()) {
            $user = new User();
            $user->signup_activation_key = CommonHelper::getEncryptedKey();
            if (!isset($input['social_login_id'])) {
                $user->first_name = CommonHelper::toEmail($input['first_name']);
                $user->last_name = CommonHelper::toEmail($input['last_name']);
                $user->email = CommonHelper::toEmail($input['email']);
                $user->phone_number = CommonHelper::toEmail($input['phone_number']);
                $role = $user->role_id = Role::getRoleIdBySlug('member');
                $user->last_login_date = date('Y-m-d:H:i:s');
                $password = $input['password'];
                list($encpassword, $random_salt) = CommonHelper::encryptPassword($password);
                $user->login_pass = $encpassword;
                $user->salt = $random_salt;
            } else {
                $user->is_social_login = 1;
                $user->social_login_id = $input['social_login_id'];
                $user->social_login_type = "facebook";
            }
            $user->blocked = 0;
            $user->save();
            Auth::loginUsingId($user->user_id);
            $this->sendUserConfirmationRequest($user);
            $jsondata['success'] = 1;
            $jsondata['success_mess'] = "Your registration is done.!!";
            $jsondata['user_data'] = $user->toArray();
        } else {
            $jsondata['error'] = 1;
            $jsondata['error_mess'] = $v->messages();
        }
        return $jsondata;
    }

    function email_check($input) {
        $jsondata = CommonHelper::defaultJson();
        $rules = array(
            'email' => 'required|email|unique:users,email|max:255',
        );
        $newnames = array(
            'email' => 'Email',
        );
        $messages = array();
        $v = \Validator::make($input, $rules, $messages);
        $v->setAttributeNames($newnames);
        if ($v->passes()) {
            $jsondata['error'] = 0;
            $jsondata['error_mess'] = 'success';
        } else {
            $jsondata['error'] = 1;
            $jsondata['error_mess'] = $v->messages();
        }
        return $jsondata;
    }

    function uploaduserImage($file, $user_id = false) {
        $json = CommonHelper::defaultJson();
        if (empty($file)) {
            $json['error'] = 1;
            $json['error_mess'] = "You havn't select file";
            return $json;
        }
        $data = $this->uploadImage($file, $user_id);
        if ($data['status'] == 1) {
            $userObj = new User();
            $updata = $userObj->getUserProfile($user_id);
            $this->remove_old_image($updata);
            $updata->user_image = $data['file_name'];
            $updata->update();
            $json['success'] = 1;
            $json['success_mess'] = "Avatar updated successfully";
            $json['user_image'] = UserHelper::getAvatar($updata, '400_400');
        } else {
            $json['error'] = 1;
            $json['error_mess'] = "Image should be a .jpg or a .png file . Recommended file size should be maximum 2.5MB";
        }
        return $json;
    }

    function uploadImage($file, $id = false) {
        $photo_id = Config::get("params.user_image");
        $allowed = $photo_id['mimes'];
        $mimeType = $file->getMimeType();
        if (!in_array($mimeType, $allowed)) {
            return array("status" => 0, 'error' => 'Image should be a .jpg or a .png file . Recommended file size should be maximum 2.5MB');
        }
        if (!$id)
            $id = time();
        $path = $photo_id['base_path'];
        $file_path = url($photo_id['path'] . "/" . $id) . "/";
        $path = base_path($path) . $id . "/";


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

        $sizes = explode(",", $photo_id['sizes']);
        $imageObj = new SimpleImage();
        $max_w = 0;
        $max_w_h = "";
        foreach ($sizes as $size) {
            list($width, $height) = explode("x", $size);

            if ($width > $max_w) {
                $max_w = $width;
                $max_w_h = $width . '_' . $height;
            }
            $imageObj->load($path . $fileName);
            $imageObj->resizeToWidth($width);
            $imageObj->save($path . $width . "_" . $height . "_" . $fileName);
        }
        //unlink($path . $fileName);
        //rename($path . $max_w_h . '_' . $fileName, $path . $fileName);

        return array('status' => 1, 'file_name' => $fileName, 'path' => $path, 'file_path' => $file_path);
    }

    function remove_old_image($user, $rm_dir = false) {
        $photo_id = Config::get("params.user_image");
        $sizes = $photo_id['sizes'];
        $sizes = explode(",", $sizes);
        if (!empty($sizes)) {
            foreach ($sizes as $size) {
                list($width, $height) = explode("x", $size);
                $image_path = base_path($photo_id['base_path'] . $user->user_id);
                @unlink($image_path . '/' . $width . "_" . $height . "_" . $user->user_image);
            }
            @unlink($image_path . '/' . $user->user_image);
        }
        if ($rm_dir)
            @rmdir($image_path);
    }

    function sendUserConfirmationRequest($user) {
        if (!is_object($user) || empty($user)) {
            return false;
        }
        $theme = Config::get("CONFIG_THEME");
        $config = Config::get("CONFIG_DATA");
        $theme_path = "themes." . $theme;
        $mailObj = new MailFunctions();
        //  $mailObj->print = true;
        $mailObj->auto = true;
        $mailObj->subject = sprintf("Welcome to " . $config->website_title);
        $mailObj->fromEmail = $config->no_reply_email;
        $mailObj->toEmail = $user->email;
        $html = $mailObj->sendmail($theme_path . ".emails.signup_welcome", ['userObj' => $user, 'title' => "Welcome mail", 'theme_path' => $theme_path]);
        return $html;
    }

    function sendPasswordResetEmail($user) {
        if (!is_object($user) || empty($user)) {
            return false;
        }
        $theme = Config::get("CONFIG_THEME");
        $config = Config::get("CONFIG_DATA");
        $theme_path = "themes." . $theme;
        $mailObj = new MailFunctions();
        //  $mailObj->print = true;
        $mailObj->auto = true;
        $mailObj->subject = sprintf("Password Reset");
        $mailObj->fromEmail = $config->no_reply_email;
        $mailObj->toEmail = $user->email;

        $html = $mailObj->sendmail($theme_path . ".emails.reset_password", ['model' => $user, 'title' => "Forgot Password", 'theme_path' => $theme_path, 'config' => $config]);
        return $html;
    }

    function email_confirmation_mail($user) {
        if (!is_object($user) || empty($user)) {
            return false;
        }
        $theme = Config::get("CONFIG_THEME");
        $config = Config::get("CONFIG_DATA");
        $theme_path = "themes." . $theme;
        $mailObj = new MailFunctions();
        //  $mailObj->print = true;
        $mailObj->auto = true;
        $mailObj->subject = sprintf("Email verification to " . $config->website_title);
        $mailObj->fromEmail = $config->no_reply_email;
        $mailObj->toEmail = $user->email;
        $html = $mailObj->sendmail($theme_path . ".emails.email_verification", ['userObj' => $user, 'title' => "Email verification mail", 'theme_path' => $theme_path]);
        return $html;
    }

    function send_email_verification_mail($user_id) {
        $jsondata = CommonHelper::defaultJson();
        $data = $this->getUserProfile($user_id);
        $data->signup_activation_key = CommonHelper::getEncryptedKey();
        $data->update();
        $this->email_confirmation_mail($data);
        $jsondata['success'] = 1;
        $jsondata['success_mess'] = trans('messages.success.email_verification_request');
        return $jsondata;
    }

    public function addNew($input) {
        $jsondata = CommonHelper::defaultJson();
        $rules = array(
            'first_name' => 'required|alpha_spaces|max:100',
            'last_name' => 'required|alpha_spaces|max:100',
            'email' => 'required|email|unique:users,email|max:255',
            'phone_number' => 'required|digits_between:6,15',
            'password' => 'required|min:6|max:15',
            'conf_password' => 'required|same:password',
        );
        $newnames = array(
            'first_name' => 'First Name',
            'login_pass' => 'Password',
            'conf_password' => 'Confirm Password',
        );
        $messages = array();
        $v = \Validator::make($input, $rules, $messages);
        $v->setAttributeNames($newnames);
        if ($v->passes()) {
            $this->file_obj2 = @$input['user_image'];
            $uploaded2['status'] = 0;
            if (empty($this->file_obj2)) {
                $jsondata['error'] = 1;
                $jsondata['error_mess'] = $v->errors()->add("user_image", "User Images is required ");
                return $jsondata;
            }
            $uploaded2 = $this->uploadImage($this->file_obj2);
            if ($uploaded2['status'] == 0) {
                $jsondata['error'] = 1;
                $jsondata['error_mess'] = $v->errors()->add("user_image", $uploaded2['error']);
                return $jsondata;
            }
            $user = new User();
            $user->signup_activation_key = CommonHelper::getEncryptedKey();
            $user->first_name = CommonHelper::toName($input['first_name']);
            $user->last_name = CommonHelper::toName($input['last_name']);
            $user->email = CommonHelper::toEmail($input['email']);
            $user->phone_number = trim($input['phone_number']);
            $user->role_id = Role::getRoleIdBySlug('member');
            $user->blocked = 0;
            $password = $input['password'];
            list($encpassword, $random_salt) = CommonHelper::encryptPassword($password);
            $user->login_pass = $encpassword;
            $user->salt = $random_salt;
            $user->user_image = $uploaded2['file_name'];
            $user->save();
            if (!empty($this->file_obj2)) {
                $user_photo = Config::get('params.user_image');
                $curr_upload_path = $uploaded2['path'];
                $now_path = base_path($user_photo['base_path']) . $user->user_id;
                rename($curr_upload_path, $now_path);
            }
            $html = $this->sendUserConfirmationRequest($user);
            $jsondata['html'] = $html;

            $jsondata['success'] = 1;
            $jsondata['success_mess'] = 'Saved successfully';
        } else {
            $jsondata['error'] = 1;
            $jsondata['error_mess'] = $v->messages();
        }
        return $jsondata;
    }

    public function updateThis($input) {
        $userObj = new User();
        $user_key = $input['user_key'];
        $updata = $userObj->getUserProfile($user_key);

        $required = "";
        $jsondata = CommonHelper::defaultJson();
        if (strlen($input['password']) > 0) {
            $required = "|required";
        }
        $rules = array(
            'first_name' => 'required|alpha_spaces|max:100',
            'last_name' => 'required|alpha_spaces|max:100',
            'email' => 'required|email|max:255|unique:users,email,' . $input['user_key'] . ',user_id',
            'password' => 'min:6|max:15',
            'phone_number' => 'required|digits_between:6,15',
            // 'role_id' => 'required',
            'conf_password' => 'same:password' . $required,
        );

        //if($updata->email != trim($input['email'])){
        //$rules['email'] = 'required|email|max:255|unique:users,email,' . $input['user_key'] . ',user_id';
        // }

        $newnames = array();
        $messages = array();
        $v = \Validator::make($input, $rules, $messages);
        $v->setAttributeNames($newnames);
        if ($v->passes()) {
//            $this->file_obj2 = @$input['user_image'];
//            $uploaded2['status'] = 0;
//            if (empty($this->file_obj2)) {
//                $jsondata['error'] = 1;
//                $jsondata['error_mess'] = $v->errors()->add("user_image", "User Images is required ");
//                return $jsondata;
//            }
//            $this->remove_old_image($updata);
//            $uploaded2 = $this->uploadImage($this->file_obj2, $updata->user_id);
//            if ($uploaded2['status'] == 0) {
//                $jsondata['error'] = 1;
//                $jsondata['error_mess'] = $v->errors()->add("user_image", $uploaded2['error']);
//                return $jsondata;
//            }
            $updata->first_name = CommonHelper::toName($input['first_name']);
            $updata->last_name = CommonHelper::toName($input['last_name']);
            $updata->email = CommonHelper::toEmail($input['email']);
            $updata->phone_number = trim($input['phone_number']);
            $updata->updated_at = date('Y-m-d H:i:s');
            if (strlen($input['password']) > 0) {
                $password = $input['password'];
                list($encpassword, $random_salt) = CommonHelper::encryptPassword($password);
                $updata->login_pass = $encpassword;
                $updata->salt = $random_salt;
            }
            // $updata->user_image = $uploaded2['file_name'];
            $updata->save();
            $jsondata['success'] = 1;
            $jsondata['success_mess'] = 'Saved successfully';
        } else {
            $jsondata['error'] = 1;
            $jsondata['error_mess'] = $v->messages();
        }
        return $jsondata;
    }

    public function getActiveUsers() {
        $date = date("Y-m-d H:i:s");
        $endTime = strtotime("-20 minutes", strtotime($date));
        $dd = date('Y-m-d H:i:s', $endTime);
        $adminroleid = Role::getRoleIdBySlug('super_admin');
        $query = $this->where('last_login_date', '>=', $dd)->where('role_id', '!=', $adminroleid);
        if (Auth::check()) {
            $query->where('user_id', '!=', Auth::user()->user_id);
        }
        return $query->where('online_status', 1)->take(5)->get();
    }

    public function getUserProfileUrl() {
        if ($this != null) {
            return url('profile/' . $this->user_id . "/" . $this->first_name . "-" . $this->last_name);
        }
        return '#';
    }

    public function getGender() {
        $fb_info = $this->facebook_info;
        if (strlen($fb_info) > 0) {
            $info = unserialize($fb_info);
            if (isset($info['gender']) && strlen($info['gender']) > 0)
                return $info['gender'];
        }

        return '---';
    }

    public function getDob() {
        $fb_info = $this->facebook_info;
        if (strlen($fb_info) > 0) {
            $info = unserialize($fb_info);
            //print_R($info);die;
            if (isset($info['birthday']) && strlen($info['birthday']) > 0)
                return $info['birthday'];
        }

        return '---';
    }

    public function getLocation() {
        $fb_info = $this->facebook_info;
        if (strlen($fb_info)) {
            $info = unserialize($fb_info);
//            if (isset($info['location']) && strlen($info['location']) > 0)
//                return $info['location'];
        }

        return '---';
    }

    public function getdbdate() {
        if ($this->birthday > 0) {
            return date($this->birthday);
        }
        return date('Y-m-d');
    }

}
