<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\CommonHelper;
use App\Helpers\SimpleImage;
use App\Models\User\User;
use Config;
use Auth,
    Session;

class SocialLogin extends Model {

    protected $table = 'users';
    public $primaryKey = "user_id";

    /*
      All model relations arrives here
     */

    function checkSocial($socialid, $type) {
        if ($type == 1) {
            return $this->where('is_social_login', 1)->where('google_login_id', $socialid)->first();
        } else if ($type == 2) {
            return $this->where('is_social_login', 1)->where('facebook_login_id', $socialid)->first();
        }
        return false;
    }

    function checkUser($user_data, $type) {
        $data = $this->checkSocial($user_data->id, $type);
        if (!empty($data)) {
            $data->online_status = 1;
            $data->last_login_date = date('Y-m-d:H:i:s');
            $data->facebook_login_id = $user_data->id;
            $data->facebook_info = serialize($user_data->user);
            if ($user_data->refreshToken) {
                $data->facebook_access = $user_data->refreshToken;
            } else {
                $data->facebook_access = $user_data->token;
            }
            $data->save();
            Auth::loginUsingId($data->user_id);
            return true;
        }
        return false;
    }

    function checkSetUser($user_data, $type) {
        $userObj = new User();
        $user_db_data = $this->checkSocial($user_data->id, $type);
        if (empty($user_db_data)) {
            $udata = $user = $userObj->getUserProfileByEmail($user_data->email);
            if (empty($udata)) {
                $user = new User();
                $name = explode(" ", $user_data->name);
                $first_name = $name[0];
                unset($name[0]);
                $last_name = implode(" ", $name);
                if (strlen(trim($user_data->email)) > 0) {
                    $user->email = $user_data->email;
                }
                $user->first_name = $first_name;
                $user->last_name = $last_name;
                $user->email_verified = 1;
                $user->role_id = Role::getRoleIdBySlug('member');
                $user->is_social_login = 1;
                if ($type == 1) {
                    $user->google_login_id = $user_data->id;
                }

                if ($type == 2) {
                    $user->facebook_login_id = $user_data->id;
                    $user->facebook_info = serialize($user_data);
                    if ($user_data->refreshToken) {
                        $user->facebook_access = $user_data->refreshToken;
                    } else {
                        $user->facebook_access = $user_data->token;
                    }
                }
                $user->online_status = 1;
                $user->last_login_date = date('Y-m-d:H:i:s');
                $user->save();
            } else {
                $user->is_social_login = 1;
                $user->email_verified = 1;
                if ($type == 1) {
                    $user->google_login_id = $user_data->id;
                } else if ($type == 2) {
                    $user->facebook_login_id = $user_data->id;
                    if ($user_data->refreshToken) {
                        $user->facebook_access = $user_data->refreshToken;
                    } else {
                        $user->facebook_access = $user_data->token;
                    }
                }
                $user->online_status = 1;
                $user->last_login_date = date('Y-m-d:H:i:s');

                $user->update();
            }
            //echo $user->toSql();die;
            Auth::loginUsingId($user->user_id);
        } else {
            Auth::loginUsingId($user_db_data->user_id);
            $user_db_data->online_status = 1;
            $user_db_data->last_login_date = date('Y-m-d:H:i:s');
            $user_db_data->facebook_login_id = $user_data->id;
            $user_db_data->facebook_info = serialize($user_data->user);
            if ($userdata->refreshToken) {
                $user_db_data->facebook_access = $user_data->refreshToken;
            } else {
                $user_db_data->facebook_access = $user_data->token;
            }

            $user_db_data->save();
        }
        return true;
    }

    function UserLoginWithSocial($input, $user_data, $type, $email) {
        $jsondata = CommonHelper::defaultJson();
        $rules['email'] = 'required|email|unique:users,email|max:255';
        $newnames = array(
            'email' => 'Email',
        );
        $messages = array();
        $v = \Validator::make($input, $rules, $messages);
        $v->setAttributeNames($newnames);
        if ($v->passes()) {
            $userObj = new User();
            $user_db_data = $this->checkSocial($user_data->id, $type);
            if (empty($user_db_data)) {
                $udata = $user = $userObj->getUserProfileByEmail($email);
                if (empty($udata)) {
                    $user = new User();
                    $name = explode(" ", $user_data->name);
                    $first_name = $name[0];
                    unset($name[0]);
                    $last_name = implode(" ", $name);
                    if (strlen(trim($email)) > 0) {
                        $user->email = $email;
                    }
                    $user->first_name = $first_name;
                    $user->last_name = $last_name;
                    $user->email_verified = 1;
                    $user->role_id = Role::getRoleIdBySlug('member');
                    $user->is_social_login = 1;
                    if ($type == 1) {
                        $user->google_login_id = $user_data->id;
                    }
                    if ($type == 2) {
                        $user->facebook_login_id = $user_data->id;
                        $user->facebook_info = serialize($user_data);
                        if ($user_data->refreshToken) {
                            $user->facebook_access = $user_data->refreshToken;
                        } else {
                            $user->facebook_access = $user_data->token;
                        }
                    }
                    $user->online_status = 1;
                    $user->last_login_date = date('Y-m-d:H:i:s');
                    $user->save();
                } else {
                    $user->is_social_login = 1;
                    $user->email_verified = 1;
                    if ($type == 1) {
                        $user->google_login_id = $user_data->id;
                    } else if ($type == 2) {
                        $user->facebook_login_id = $user_data->id;
                        if ($user_data->refreshToken) {
                            $user->facebook_access = $user_data->refreshToken;
                        } else {
                            $user->facebook_access = $user_data->token;
                        }
                    }
                    $user->online_status = 1;
                    $user->last_login_date = date('Y-m-d:H:i:s');
                    $user->update();
                }
                Auth::loginUsingId($user->user_id);
            } else {
                Auth::loginUsingId($user_db_data->user_id);
                $user_db_data->online_status = 1;
                $user_db_data->last_login_date = date('Y-m-d:H:i:s');
                $user_db_data->facebook_login_id = $user_data->id;
                $user_db_data->facebook_info = serialize($user_data->user);
                if ($userdata->refreshToken) {
                    $user_db_data->facebook_access = $user_data->refreshToken;
                } else {
                    $user_db_data->facebook_access = $user_data->token;
                }
                $user_db_data->save();
            }
            $jsondata['success'] = 1;
            $jsondata['success_mess'] = "Successfully login...";
            Session::forget('SOCIAL_USER');
            Session::forget('SOCIAL_TYPE');
        } else {
            $jsondata['error'] = 1;
            $jsondata['error_mess'] = $v->messages();
        }
        return $jsondata;
    }

    function uploadImage($avatar_original) {
        $image_content = @file_get_contents($avatar_original);


        $photo_id = Config::get("params.photo_id");
        $id = time();
        $path = $photo_id['base_path'];
        $path = base_path($path) . "/" . $id . "/";
        if (!is_dir($path)) {
            umask(0);
            mkdir($path, 0777, true);
            chmod($path, 0777); //incase mkdir fails
        }
        $size = getimagesize($avatar_original);
        $extension = image_type_to_extension($size[2]);
        $fileName = time() . "_" . rand(11111, 99999) . $extension; // renameing image
        @file_put_contents($path . $fileName, $image_content);
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
        ///unlink($path.$fileName);
        ///rename($path.$max_w_h.'_'.$fileName,$path.$fileName );
        return array('status' => 1, 'file_name' => $fileName, 'path' => $path);
    }

}
