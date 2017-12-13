<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\CommonHelper as CommonHelper;

class PermissionRole extends Model {

    protected $table = 'permission_role';
    protected $primaryKey = 'permission_role_id';
    
    
    public function getPermissionRoleByRoleId($id){
        return PermissionRole::whereRole_id($id)->get();
    }

    public function update_is_set($input) {
        $permissionRoleObj = new PermissionRole();
        $role_id = $input['role_id'];
        $permission_id = $input['permission_id'];
        $isset = $input['isset'];
        $updata = $permissionRoleObj->where('role_id', $role_id)->where('permission_id', $permission_id)->first();
        $jsondata = CommonHelper::defaultJson();
        if(!empty($updata)){
            $updata->updated_at = date('Y-m-d H:i:s');
            $updata->is_set = $isset;
            $updata->save();
        }else{
            $permissionRoleObj->is_set = $isset;
            $permissionRoleObj->role_id = $role_id;
            $permissionRoleObj->permission_id = $permission_id;
            $permissionRoleObj->created_at = date('Y-m-d H:i:s');
            $permissionRoleObj->updated_at = date('Y-m-d H:i:s');
            $permissionRoleObj->save();
        }
        $jsondata['success'] = 1;
        $jsondata['success_mess'] = trans('messages.success.update');;
        return $jsondata;
    }
    
}
