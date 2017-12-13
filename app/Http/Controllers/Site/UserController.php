<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Models\User\User;
use Auth;

class UserController extends BaseController {

    function avatarEdit(Request $request) {
        $input = $request->all();
        $userObj = new User();
        $file = @$input['user_image'];
        $data = $userObj->uploaduserImage($file, Auth::user()->user_id);
        return json_encode($data);
    }

   

    public function editInfo(Request $request) {
        $input = $request->all();
        $input['user_id'] = Auth::user()->user_id;
        $userObj = new User();
        $data = $userObj->editInfo($input);
        return json_encode($data);
    }
}
