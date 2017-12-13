<?php

namespace App\Http\Controllers\Admin;
//use App\Helpers\CommonHelper;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Permission as Permission;
use App\Models\Role as Role;


class PermissionController extends BaseController
{
    public function permissionlist(Request $request)
    {
        $permissionObj = new Permission();
        $data = $permissionObj->getAllPermissionsList();
        return view('admin.permission.permission_list',['request' => $request,'data' => $data, 'page_header'=>"ACL",'sub_header'=>"", 'icon'=>"legal"]);
    }
    
    public function addnew(Request $request)
    {
        return view('admin.permission.addnew',['request' => $request, 'page_header'=>"ACL",'sub_header'=>"", 'icon'=>"legal"]);
    }
    
    public function addnewajax(Request $request)
    {
        $permissionObj = new Permission();
        $input = $request->all();
        $data = $permissionObj->addNew($input);
        return json_encode($data);
    }
    
    public function edit(Request $request, $permission_id)
    {
        $permissionObj = new Permission();
        $data = $permissionObj->getPermissionById($permission_id);
        if(!empty($data)){
            return view('admin.permission.edit',['request' => $request, 'data' => $data, 'page_header'=>"ACL",'sub_header'=>"", 'icon'=>"legal"]);
        }else{
            return redirect('admin/permission');
        }
    }
    
    public function editajax(Request $request)
    {
        $permissionObj = new Permission();
        $input = $request->all();
        $data = $permissionObj->updateThis($input);
        return json_encode($data);
    }
    
    
    public function editprofile(Request $request)
    {
        $userObj = new User();
        $data = $userObj->getMyProfile();
        if(!empty($data)){
            $countries = Countries::lists('Country', 'CountryId')->all();
            $countries = ['' => 'Select country'] + $countries;
            return view('admin.user.edit_profile',['request' => $request,'data' => $data,'countries' => $countries]);
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
    
    public function deletepermission(Request $request) {
        $permissionObj = new Permission();
        $input = $request->all();
        $data = $permissionObj->deleteSelected($input);
        return json_encode($data);
    }

}
