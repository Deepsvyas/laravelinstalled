<?php

namespace App\Helpers;

use App\Models\User\User;
use Config,
    Auth;
use Intervention\Image\ImageManager;

class ImageHelper {

//    public static function getImage($imgName, $size = "200_200") {
//        $image = Config::get("params.banner_image");
//        $base_path = base_path($image['base_path']);
//
//        $base_path = $base_path . '/' . $imgName;
//        $path = url($image['path']) . "/" . $imgName;
//
//        if (!file_exists($base_path)) {
//            $path = url("fn/getimage/application~img~admin~boxed-bg.png/" . $size);
//        }
//        return $path;
//    }

    public static function cropAvatar($userObj, $file_name, $input) {
        $manager = new ImageManager();
        if ($userObj->role->role_slug == "models") {
            $photo = Config::get("params.model_photo");
            $path = $photo['base_path'];
            $path = base_path(sprintf($path, $userObj->user_id));
        } else {
            $photo = Config::get("params.user_image");
            $path = $photo['base_path'];
            $path = base_path($path) . $userObj->user_id . "/";
        }
        $img = $path . "800_800_" . $file_name;

        if (isset($userObj->user_image)) {
            $photo = Config::get("params.user_image");
            $path = $photo['base_path'];
            $path = base_path($path) . $userObj->user_id . "/";
            $sizes = explode(",", $photo['sizes']);
            if ($userObj->role->role_slug == "models") {
                foreach ($sizes as $size) {
                    list($width, $height) = explode("x", $size);
                    $file = $path . $width . "_" . $height . "_" . $userObj->user_image;
                    if (file_exists($file)) {
                        unlink($file);
                    }
                }
                @unlink($path . $userObj->user_image);
            }
            if ($input['dataWidth'] < $input['dataHeight']) {
                $input['dataWidth'] = $input['dataHeight'];
            } elseif ($input['dataHeight'] < $input['dataWidth']) {
                $input['dataHeight'] = $input['dataWidth'];
            }
            $manager->make($img)->crop($input['dataWidth'], $input['dataHeight'], $input['dataX'], $input['dataY'])->save($path . $file_name);

            /* Creating new sizes for profile photo                
             */

            $imageObj = new SimpleImage();
            $max_w = 0;
            $max_w_h = "";
            foreach ($sizes as $size) {
                list($width, $height) = explode("x", $size);
                if ($width > $input['dataWidth']) {
                    continue;
                }
                if ($width > $max_w) {
                    $max_w = $width;
                    $max_w_h = $width . '_' . $height;
                }
                $imageObj->load($path . $file_name);
                $imageObj->resizeToWidth($width);
                $imageObj->save($path . $width . "_" . $height . "_" . $file_name);
            }
        }
    }
}
