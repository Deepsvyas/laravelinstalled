<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\User\User;
use Auth,
    CommonHelper;

class HomeController extends BaseController {

    function __construct(Request $request) {
        parent::__construct($request);
    }

    public function index(Request $request) {
        $this->doAnalyse($request);
        $input = $request->all();
        return $this->view('home.index', ['request' => $request]);
    }

    public function editprofile(Request $request) {
        $userObj = new User();
        $data = $userObj->getMyProfile();
        if (!empty($data)) {
            return $this->view('home.edit_profile', ['request' => $request, 'data' => $data]);
        } else {
            return redirect('logout');
        }
    }

    public function editprofileajax(Request $request) {
        $userObj = new User();
        $input = $request->all();
        $data = $userObj->updateProfile($input);
        return json_encode($data);
    }

    public function online_offline(Request $request) {
        $json_data = CommonHelper::defaultJson();
        Auth::user()->online_status = $request->get("status");
        Auth::user()->update();
        $json_data['success'] = 1;
        $json_data['success_mess'] = 1;
        return json_encode($json_data);
    }

    function addcontact(Request $request) {
        $postobj = new ContactForm();
        $input = $postobj->addnewform($request);
        return json_encode($input);
    }

}
