<?php

namespace App\Models\User;

use Session,
    Config, App;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use App\Models\User\Traits\UserACL;
use App\Models\User\Traits\UserRelationShips;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;
use App\Models\Base;

class UserBase extends Base implements AuthenticatableContract, CanResetPasswordContract {

    use Authenticatable,
        CanResetPassword;

/**
     * Application's Traits (Separation of various types of methods)
     */
    use UserACL,
        UserRelationShips;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    public $timestamps = true;
    protected $table = 'users';
    protected $primaryKey = 'user_id';

    public static function tableName() {
        return with(new static)->getTable();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['first_name', 'last_name', 'email', 'login_pass', 'created_at', 'updated_at'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at', 'login_pass', "remember_token"];

    public function setAttributeNames(array $attributes) {
        $this->customAttributes = $attributes;
        return $this;
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier() {
        return $this->getKey();
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword() {
        return $this->login_pass;
    }

    /**
     * Get the e-mail address where password reminders are sent.
     *
     * @return string
     */
    public function getReminderEmail() {
        return $this->email;
    }

    public function getRememberToken() {
        return $this->remember_token;
    }

    public function setRememberToken($value) {
        $this->remember_token = $value;
    }

    public function getRememberTokenName() {
        return 'remember_token';
    }

    // overriding getter & setter
    function getEmailAttribute() {
        return $this->attributes['email'];
    }

    function setEmailAttribute($value) {
        return $this->attributes['email'] = $value;
    }

    function getPasswordAttribute() {
        return $this->attributes['login_pass'];
    }

    function setPasswordAttribute($value) {
        return $this->attributes['login_pass'] = $value;
    }

    public function roledata() {
        $role = $this->hasOne('App\Models\Role');
        return $role;
    }
    public function getMyProfile() {
        return User::whereUser_id(Auth::user()->user_id)->first();
    }

    public static function getMyRole() {
        return Auth::user()->role->role_slug;
    }

    public static function getRole() {
        return $this->role->role_slug;
    }

    public function getUserProfile($user_id) {
        return User::whereUser_id($user_id)->first();
    }
    
    public function getUserProfileByEmail($user_email) {
        return User::whereEmail($user_email)->first();
    }

    public function getUserProfileBySocialLoginId($id) {
        return User::where("social_login_id", $id)->first();
    }

    public function getAllUsersList() {
        $role = Role::where('role_slug', 'stylist')->first();
        $role_id = $role->role_id;
        return $this->where('role_id', '!=', $role_id)->sort()->search()->dpaginate();
    }
    
    public function getAllStylistUsers() {
        $role = Role::where('role_slug', 'stylist')->first();
        $role_id = $role->role_id;
        return $this->where('role_id', $role_id)->sort()->search()->dpaginate();
    }

    
    public function countTotalUsers() {
        return $this->count();
    }

    public function getConfirmationToken($token) {
        return User::where("signup_activation_key", $token)->where('blocked', 0)->where('email_verified', 0)->first(); // Blocked = 2 means user has registered and not still verified account account
    }

    public function getModelConfirmationToken($token) {
        return User::where("signup_activation_key", $token)->where('blocked', 0)->first(); // Blocked = 2 means user has registered and not still verified account account
    }

    public function getResetToken($token) {
        return User::whereReset_key($token)->where('blocked', 0)->first();
    }
    
    public function getVerifyResetToken($input) {
        return User::whereReset_key($input['token'])->where("user_id", $input['user_id'])->where('blocked', 0)->first();
    }

    public static function getAllUsersBySearch($input) {
        return User::where("email", "like", "%" . $input . "%")->where('blocked', 0)->select("user_id", "email")->get();
    }

    public function getUserByRefUserId($ref_uer_id) {
        return $this->where('ref_user_id', $ref_uer_id)->sort()->dpaginate();
    }

    public function countUserByRefApproveUserId($ref_uer_id) {
        return $this->where('ref_user_id', $ref_uer_id)->where('blocked', 0)->count();
    }

}
