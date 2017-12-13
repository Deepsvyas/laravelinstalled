<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Role as Role;
use App\Models\Permission as permission;
use App\Models\PermissionRole as PermissionRole;


class RoleController extends BaseController
{
    public function rolelist(Request $request)
    {
        $roleObj = new Role();
        $data = $roleObj->getAllRoleList();
        return view('admin.role.rolelist',['request' => $request,'data' => $data, 'page_header'=>"ACL",'sub_header'=>"", 'icon'=>"legal"]);
    }
    
    public function addnew(Request $request)
    {
        return view('admin.role.addnew',['request' => $request, 'page_header'=>"ACL",'sub_header'=>"", 'icon'=>"legal"]);
    }
    
    public function addnewajax(Request $request)
    {
        $roleObj = new Role();
        $input = $request->all();
        $data = $roleObj->addNew($input);
        return json_encode($data);
    }
    
    public function edit(Request $request, $role_id)
    {
        $roleObj = new Role();
        $data = $roleObj->getRoleById($role_id);
        if(!empty($data)){
            return view('admin.role.edit',['request' => $request, 'data' => $data, 'page_header'=>"ACL",'sub_header'=>"", 'icon'=>"legal"]);
        }else{
            return redirect('admin/role');
        }
    }
    
    public function editajax(Request $request)
    {
        $roleObj = new Role();
        $input = $request->all();
        $data = $roleObj->updateThis($input);
        return json_encode($data);
    }
    
    public function relationrolepermission(Request $request){
        $roleObj = new Role();
        $permissionObj = new Permission();
        //$roles = $roleObj->lists('role_title', 'role_id')->all();
        //$permissions = $permissionObj->lists('permission_title', 'permission_id')->all();
        $roles = $roleObj->getAllRoles('role_title');
        $permissions  = $permissionObj->getAllPermissions("permission_title");
        
        return view('admin.role.role_permission_list',['request' => $request,'roles' => $roles, 'permission' => $permissions,'permissionObj' => $permissionObj, 'page_header'=>"ACL",'sub_header'=>"", 'icon'=>"legal"]);
    }
    
    public function update_is_set(Request $request)
    {
        $permissionRoleObj = new PermissionRole();
        $input = $request->all();
        $data = $permissionRoleObj->update_is_set($input);
        return json_encode($data);
    }
    
    public function deleterole(Request $request) {
        
        $roleObj = new Role();
        $input = $request->all();
        $data = $roleObj->deleteSelected($input);
        return json_encode($data);
    }
    
    public function  project_include_update(Request $request){
        $roleObj = new Role();
        $input = $request->all();
        $data = $roleObj->project_include_update($input);
        return json_encode($data);
    }
    
    
}
