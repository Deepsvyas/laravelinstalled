<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\CommonHelper as CommonHelper;
use App\Helpers\ViewsHelper as Views;
use App\Models\PermissionRole;
use Config;

class Role extends Base {

    protected $table = 'roles';
    public $primaryKey = "role_id";

    /**
     * users() one-to-many relationship method
     * 
     * @return QueryBuilder
     */
    public function users() {
        return $this->hasMany('App\Models\User\User', 'user_id', 'user_id');
    }

    /**
     * permissions() many-to-many relationship method
     * 
     * @return QueryBuilder
     */
    public function permissions() {
        //return Permission::lists('permission_slug');
    }

    public function getAllRoleList() {
        $paginate = Views::getConfigKeyData('pagination');
        return $this->orderBy('created_at', 'DESC')->paginate($paginate);
    }
    
    public function getAllRoles($orderBy = null) {
        if($orderBy)
            return $this->orderBy($orderBy)->get();
        else
            return $this->all();
    }

    public function getRoleById($role_id) {
        return Role::whereRole_id($role_id)->first();
    }
    
    public static function getRoleIdBySlug($role_slug) {
        $role_data =  Role::whereRole_slug($role_slug)->first();
        return $role_data->role_id;
    }
    
    
    public function addNew($input) {
        $jsondata = CommonHelper::defaultJson();
        $rules = array(
            'role_title' => 'required|alpha_spaces|max:100',
            'role_slug' => 'required|alpha_underscore|max:100|unique:'.$this->table.',role_slug',
            //'role_slug' => 'required|alpha_underscore|max:100|unique:'.$this->table.',role_slug',
            'role_level' => 'required|numeric|min:1|max:100',
            'description' => 'required|max:500',
        );

        $newnames = array(
            'role_title' => 'Role Title',
            'role_slug' => 'Role Slug',
            'role_level' => 'Role Level',
            'description' => 'Description',
        );
        $messages = array(
            'required' => ':attribute is required.',
            'max' => ':attribute max characters limit exceed (:max).',
            'min' => ':attribute min number atleast  (:min).',
            'role_level' => 'required|numeric|min:1|max:100|digits_between:1,3',
            "alpha_spaces" => "The :attribute may only contain letters and spaces.",
            'alpha_underscore'=>"Only alphabets are allowed with '_'",
            'numeric' => "The field under validation must have a numeric value.",
            
        );
        $v = \Validator::make($input, $rules, $messages);
        $v->setAttributeNames($newnames);
        if ($v->passes()) {
            $role = new Role();
            $role->role_title = $input['role_title'];
            $role->role_slug = $input['role_slug'];
            $role->role_level = $input['role_level'];
            $role->description = $input['description'];
            $role->created_at = date('Y-m-d H:i:s');
            $role->updated_at = date('Y-m-d H:i:s');
            $role->save();
            $jsondata['success'] = 1;
            $jsondata['success_mess'] = trans('messages.success.save');
        } else {
            $jsondata['error'] = 1;
            $jsondata['error_mess'] = $v->messages();
        }
        return $jsondata;
    }

    public function updateThis($input) {
        $jsondata = CommonHelper::defaultJson();
        
        $rules = array(
            'role_title' => 'required|alpha_spaces|max:100',
            'role_slug' => 'required|alpha_underscore|max:100|unique:'.$this->table.',role_slug,'.$input['role_id'].',role_id',
            'role_level' => 'required|numeric|min:1|max:100',
            //'role_slug' => 'required|alpha_underscore|max:100|unique:'.$this->table.',role_slug',
            'description' => 'required|max:500',
        );

        $newnames = array(
            'role_title' => 'Role Title',
            'role_slug' => 'Role Slug',
            'role_levlel' => 'Role Level',
            'description' => 'Description',
        );
        $messages = array(
            'required' => ':attribute is required.',
            'max' => ':attribute max characters limit exceed (:max).',
            'min' => ':attribute min number atleast  (:min).',
            "alpha_spaces" => "The :attribute may only contain letters and spaces.",
            'alpha_underscore'=>"Only alphabets are allowed with '_'",
            'numeric' => "The field under validation must have a numeric value.",
        );
        $v = \Validator::make($input, $rules, $messages);
        $v->setAttributeNames($newnames);
        if ($v->passes()) {
            $roleObj = new Role();
            $role_id = $input['role_id'];
            $updata = $roleObj->getRoleById($role_id);
            
            $updata->role_title = $input['role_title'];
            $updata->role_slug = $input['role_slug'];
            $updata->role_level = $input['role_level'];
            $updata->description = $input['description'];
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
    
    function isChecked($role_id,$permission_id)
    {
        $prObj = new PermissionRole();
        $prole = $prObj->where("permission_id",$permission_id)->where("role_id",$role_id)->where('is_set',1)->first();
        if(count($prole))
            return true;
        else {
            return false;
        }
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
            $jsondata['success_mess'] = trans('messages.success.delete');
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
        Role::where('role_id', $id)->delete();
        PermissionRole::where('role_id',$id)->delete();
    }


}
