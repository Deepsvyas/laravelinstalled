<?php

/*
 * app/validators.php
 */

Validator::extend('alpha_spaces', function($attribute, $value) {
    return preg_match('/^[\pL\s]+$/u', $value);
});

Validator::extend('alpha_num_spaces', function($attribute, $value) {
    return preg_match('/^([a-zA-Z0-9_ \-\s])+$/u', $value);
});

Validator::extend('menu_slug', function($attribute, $value) {
    return preg_match('/^([a-zA-Z0-9_-])+$/u', $value);
});

Validator::extend('menu_url', function($attribute, $value) {
    return preg_match('/^([a-zA-Z0-9_\-\/#\.])+$/u', $value);
});

Validator::extend('alpha_comma_num_spaces', function($attribute, $value) {
    return preg_match('/^([a-zA-Z0-9_, \-\s])+$/u', $value);
});

Validator::extend('common_name_title', function($attribute, $value) {
    return preg_match('/^([a-zA-Z0-9_,\'’\:;\[\]\(\) \-\s])+$/u', $value);
});

Validator::extend('common_slug', function($attribute, $value) {
    return preg_match('/^([a-zA-Z0-9-])+$/u', $value);
});

Validator::extend('alpha_underscore', function($attribute, $value) {
    return preg_match('/^([a-zA-Z_])+$/u', $value);
});

Validator::extend('course_cat_slug', function($attribute, $value) {
    return preg_match('/^([a-zA-Z0-9_-])+$/u', $value);
});

Validator::extend('without_spaces', function($attr, $value){
    return preg_match('/^([a-zA-Z0-9])+$/u', $value);
});

Validator::extend("emails", function($attribute, $value, $parameters, $validator) {
            $rules = [
                $attribute => 'email',
            ];
            $exp_arr = explode(",", $value);
            $exp_arr = array_map('trim',$exp_arr);
            foreach ($exp_arr as $email) {
                $data = [
                    $attribute => $email
                ];
                $validator = Validator::make($data, $rules);
                if ($validator->fails()) {
                    return false;
                }
            }
            return true;
        });
