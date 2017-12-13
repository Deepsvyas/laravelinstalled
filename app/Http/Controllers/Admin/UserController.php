<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Models\User\User;
use App\Models\Role;
use Auth, CommonHelper;

class UserController extends BaseController
{
    public function userlist(Request $request)
    {
        return view('admin.user.list',['request' => $request, 'role_slug' => "member"]);
    }
    
    public function stylistlist(Request $request)
    {
        return view('admin.user.list',['request' => $request, 'role_slug' => "stylist"]);
    }
    
    public function ajaxuserlist(Request $request){
        $json = CommonHelper::defaultJson();
        $userObj = new User();
        $data = $userObj->getAllUsersList();
        $html = view('admin.user.ajax_user_list',['request' => $request,'data' => $data,'page_header'=>"Users","sub_header"=>"", "icon"=>"users"]);
        $json['success'] = 1;
        $json['html'] = $html->render();
        $json['success_mes'] = "loaded";
        return json_encode($json);
    }
    
    public function addnew(Request $request)
    {
        $role_level = Auth::user()->role->role_level;
        if($role_level == 1){
            $role_level = 0;
        }
        $roles = Role::where('role_level','>',$role_level)->pluck('role_title', 'role_id')->all();
        $roles = ['' => 'Select role'] + $roles;
        return view('admin.user.addnew',['request' => $request,'roles' => $roles,'page_header'=>"Users","sub_header"=>"", "icon"=>"users"]);
    }
    
    public function addnewajax(Request $request)
    {
        $userObj = new User();
        $input = $request->all();
        $data = $userObj->addNew($input);
        return json_encode($data);
    }
    
    public function edit(Request $request, $user_key)
    {
        $userObj = new User();
        $data = $userObj->getUserProfile($user_key);
        if(!empty($data)){
            $role_level = Auth::user()->role->role_level;
            if($role_level == 1){
                $role_level = 0;
            }
            $roles = Role::where('role_level','>',$role_level)->pluck('role_title', 'role_id')->all();
            $roles = ['' => 'Select role'] + $roles;
            return view('admin.user.edit',['request' => $request,'roles' => $roles, 'data' => $data,'page_header'=>"Users","sub_header"=>"", "icon"=>"users"]);
        }else{
            return redirect('admin/users');
        }
    }
    
    public function editajax(Request $request)
    {
        $userObj = new User();
        $input = $request->all();
        $data = $userObj->updateThis($input);
        return json_encode($data);
    }
    
    
    public function editprofile(Request $request)
    {
        $userObj = new User();
        $data = $userObj->getMyProfile();
        if(!empty($data)){
            return view('admin.user.edit_profile',['request' => $request,'data' => $data, 'page_header'=>"Profile",'sub_header'=>"", 'icon'=>"user"]);
        }else{
            return redirect('logout');
        }
    }
    
    public function editprofileajax(Request $request)
    {
        $userObj = new User();
        $input = $request->all();
        $data = $userObj->updateProfile($input);
        return json_encode($data);
    }
    
    
    public function update_active(Request $request)
    {
        $userObj = new User();
        $input = $request->all();
        $data = $userObj->updateActive($input);
        return json_encode($data);
    }
    
    public function update_feature(Request $request)
    {
        $userObj = new User();
        $input = $request->all();
        $data = $userObj->update_feature($input);
        return json_encode($data);
    }
    
    public function norif_update_active(Request $request){
        $userObj = new User();
        $input = $request->all();
        $data = $userObj->norif_update_active($input);
        return json_encode($data);
    }
    
    public function deleteusers(Request $request) {
        
        $userObj = new User();
        $input = $request->all();
        $data = $userObj->deleteSelected($input);
        return json_encode($data);
    }
    
}
