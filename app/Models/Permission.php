<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\CommonHelper as CommonHelper;
use App\Helpers\ViewsHelper as Views;
use App\Models\PermissionRole;
use Config;

class Permission extends Model {

    protected $table = 'permissions';
    protected $primaryKey = 'permission_id';

    /**
     * roles() many-to-many relationship method
     * 
     * @return QueryBuilder
     */
//    public function roles() {
//        return $this->belongsToMany('App\Models\Role');
//    }

    public function getAllPermissionsList() {
        $paginate = Views::getConfigKeyData('pagination');
        return $this->orderBy('created_at', 'DESC')->paginate($paginate);
    }
    
    public function getAllPermissions($orderBy) {
        return Permission::orderBy($orderBy)->get();
    }
    
    public function getPermissionById($permission_id) {
        return Permission::wherePermission_id($permission_id)->first();
    }
    
    

    public function addNew($input) {
        $jsondata = CommonHelper::defaultJson();
        $rules = array(
            'permission_title' => 'required|alpha_spaces|max:100',
            'permission_slug' => 'required|alpha_underscore|max:100|unique:'.$this->table.',permission_slug',
            'permission_description' => 'required|max:500',
        );

        $newnames = array(
            'permission_title' => 'Permission Title',
            'permission_slug' => 'Permission Slug',
            'permission_description' => 'Permission Description',
        );
        $messages = array(
            'required' => ':attribute is required.',
            'max' => ':attribute max characters limit exceed (:max).',
            "alpha_spaces" => "The :attribute may only contain letters and spaces.",
            "alpha_underscore" => "The :attribute may only contain letters and underscore.",
        );
        $v = \Validator::make($input, $rules, $messages);
        $v->setAttributeNames($newnames);
        if ($v->passes()) {
            $permission = new Permission();
            $roleObj = new Role();
            $permissionRoleObj = new PermissionRole();
            $permission->permission_title = $input['permission_title'];
            $permission->permission_slug = $input['permission_slug'];
            $permission->permission_description = $input['permission_description'];
            $permission->created_at = date('Y-m-d H:i:s');
            $permission->updated_at = date('Y-m-d H:i:s');
            $permission->save();
            $insertedId = $permission->permission_id;
            $role_id = $roleObj->getRoleIdBySlug('super_admin');
            if(isset($role_id)){
                $permissionRoleObj->role_id = $role_id;
                $permissionRoleObj->permission_id = $insertedId;
                $permissionRoleObj->is_set = 1;
                $permissionRoleObj->created_at = date('Y-m-d H:i:s');
                $permissionRoleObj->updated_at = date('Y-m-d H:i:s');
                $permissionRoleObj->save();
            }
            
            $jsondata['success'] = 1;
            $jsondata['success_mess'] = trans('messages.success.save');;
        } else {
            $jsondata['error'] = 1;
            $jsondata['error_mess'] = $v->messages();
        }
        return $jsondata;
    }

    public function updateThis($input) {
        $jsondata = CommonHelper::defaultJson();
        
        $rules = array(
            'permission_title' => 'required|alpha_spaces|max:100',
            'permission_slug' => 'required|alpha_underscore|max:100',
            'permission_description' => 'required|max:500',
        );

        $newnames = array(
            'permission_title' => 'Permission Title',
            'permission_slug' => 'Permission Slug',
            'permission_description' => 'Permission Description',
        );
        $messages = array(
            'required' => ':attribute is required.',
            'max' => ':attribute max characters limit exceed (:max).',
            "alpha_spaces" => "The :attribute may only contain letters and spaces.",
            "alpha_underscore" => "The :attribute may only contain letters and underscore.",
        );
        $v = \Validator::make($input, $rules, $messages);
        $v->setAttributeNames($newnames);
        if ($v->passes()) {
            $permissionObj = new Permission();
            $permission_id = $input['permission_id'];
            $updata = $permissionObj->getPermissionById($permission_id);
            
            $updata->permission_title = $input['permission_title'];
            $updata->permission_slug = $input['permission_slug'];
            $updata->permission_description = $input['permission_description'];
            $updata->updated_at = date('Y-m-d H:i:s');
            $updata->save();
            $jsondata['success'] = 1;
            $jsondata['success_mess'] = trans('messages.success.update');
        } else {
            $jsondata['error'] = 1;
            $jsondata['error_mess'] = $v->messages();
        }
        return $jsondata;
    }
    
    public function deleteSelected($input){
        $jsondata = CommonHelper::defaultJson();
        $checkval = explode(",",$input['checkval']);
        if(!empty($checkval))
        {
            foreach ($checkval as $id)
            {
                $this->deleteThis($id);
            }
            $jsondata['success'] = 1;
            $jsondata['success_mess'] = trans('messages.success.delete');;
        }
        else
        {
            $jsondata['error_mess'] = "delete error";
            $jsondata['error'] = 1;
        }
        return $jsondata;
    }
    
    function deleteThis($id)
    {
        Permission::where('permission_id', $id)->delete();
        PermissionRole::where('permission_id',$id)->delete();
    }


}
