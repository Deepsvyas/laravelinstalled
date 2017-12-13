<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\User\User;
use App\Models\Fbcomments;
use App\Models\Twittercomments;
use App\Models\SocialLogin;
use App\Models\Pages;
use App\Helpers\CommonHelper;
use App\Helpers\ViewsHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Session;
use Socialite,
    Config;

class AuthController extends BaseController {

    public $json_data;
    public $validate;

    public function construct() {
        $this->jsondata = CommonHelper::defaultJson();
    }

    public function getLogin(Request $request) {
        if (Auth::check()) {
            return redirect($this->module . '/dashboard');
        } else {
            return view('admin.auth.login', ['request' => $request]);
        }
    }

    private function _set_validates($input) {
        $rules = array('sEmail' => 'required', 'sPassword' => 'required');
        $newnames = array(
            'sEmail' => 'Email',
            'sPassword' => 'Password'
        );

        $messages = array(
            'required' => ':attribute is required.',
        );
        $this->validate = Validator::make($input, $rules, $messages);
        $this->validate->setAttributeNames($newnames);
    }

    public function postLogin(Request $request) {
        $input = $request->all();
        $this->_set_validates($input);
        if ($this->validate->fails()) {
            if ($request->ajax()) {
                $this->jsondata['error'] = 1;
                $this->jsondata['error_mess'] = $this->validate->messages();
                return json_encode($this->jsondata);
            }

            return redirect($this->module)->withErrors($this->validate)->withInput(\Input::except('sPassword'));
        } else {
            $userTab = new User();
            $user = $userTab->getUserProfileByEmail(trim($input['sEmail']));
            if (empty($user)) {
                return $this->_login_auth_failed($request);
            } else {
                return $this->_check_password($request, $user);
            }
        }
    }

    private function _return_ajax_error($key, $val) {
        $this->jsondata['error'] = 1;
        $this->jsondata['error_mess'] = $this->validate->errors()->add($key, $val);
        return json_encode($this->jsondata);
    }

    private function _login_auth_failed($request) {
        $input = $request->all();
        if ($request->ajax()) {
            return $this->_return_ajax_error('sEmail', 'Login Authentication failed.');
        }
        return redirect('/admin')->withInput($input['sPassword'])->withErrors("Login Authentication failed.");
    }

    private function _login_success() {
        $this->jsondata['success'] = 1;
        $this->jsondata['success_mess'] = "Login successfull.";
        $this->jsondata['redirect'] = "";
    }

    private function _check_password($request, $user) {
        $input = $request->all();
        $ret = CommonHelper::validateUserPassword($input['sPassword'], $user->salt, $user->login_pass);

        // now check if is true then login else
        // 
        //return  false with redirect
        if (($ret == false) || $user->blocked != 0) {
            return $this->_login_auth_failed($request);
        } else if ($ret == true && $user->blocked == 0) {
            Auth::loginUsingId($user->user_id);

            $user->last_login_date = date('Y-m-d H:i:s');
            $user->online_status = 1;
            $user->save();
            if ($request->ajax()) {
                $this->_login_success();
                return json_encode($this->jsondata);
            }

            if (strpos($this->module, "admin") !== false) {
                return redirect($this->module . "/dashboard");
            } elseif (strpos($this->module, "site") !== false) {
                return redirect($this->module . "/home");
            }
        }
    }

    public function signup(Request $request) {
        $userObj = new User();
        $input = $request->all();
        $data = $userObj->signUp($input);
        echo json_encode($data);
    }

    public function forgotpassword(Request $request) {
        $userObj = new User();
        $input = $request->all();
        $data = $userObj->getforgotPasswordByEmail($input);
        echo json_encode($data);
    }

    public function confirm_account(Request $request, $token) {

        $config_data = $this->configs;
        $valid = false;
        if (strlen($token) > 0) {
            $userObj = new User();
            $userData = $userObj->getConfirmationToken($token);
            if (isset($userData->signup_activation_key)) {
                $valid = true;
                $userData->signup_activation_key = "";
                $userData->email_verified = 1;
                $userData->update();
            }
        }
        return $this->view("auth.account_activation", array('request' => $request, "valid" => $valid, 'config_data' => $config_data));
    }

    public function email_verified_request(Request $request, $token) {

        $config_data = $this->configs;
        $valid = false;
        if (strlen($token) > 0) {
            $userObj = new User();
            $userData = $userObj->getConfirmationToken($token);
            if (Auth::user()->user_id == $userData->user_id) {
                if (isset($userData->signup_activation_key)) {
                    $valid = true;
                    $userData->blocked = 0;
                    $userData->signup_activation_key = "";
                    $userData->email_verified = 1;
                    $userData->update();
                }
            }
        }

        return $this->view("auth.account_activation", array('request' => $request, "valid" => $valid, 'config_data' => $config_data));
    }

    public function resetpassword(Request $request, $token) {

        if (Auth::check()) {
            return $this->abort("404", ['request' => $request, 'code' => '404']);
        }
        $config_data = $this->configs;

        if (strlen($token) > 0) {
            $userObj = new User();
            $userData = $userObj->getResetToken($token);
            if (!empty($userData)) {
                return $this->view("auth.reset_pass_form", array('request' => $request, "token" => $token, 'config_data' => $config_data));
            } else {
                return $this->view("auth.reset_pass_err", array('request' => $request));
            }
        } else {
            return $this->view("auth.reset_pass_err", array('request' => $request));
        }
    }

    public function resetpasswordajax(Request $request) {
        $userObj = new User();
        $input = $request->all();
        $data = $userObj->resetpassword($input);
        echo json_encode($data);
    }

    public function updateProfile(Request $request) {
        $userObj = new User();
        $input = $request->all();
        $data = $userObj->updateProfile($input);
        return $this->json($data);

        //$this->uploadImage($input['user_image'], $user->user_id);
    }

    /**
     * Redirect the user to the Facebook authentication page.
     *
     * @return Response
     */
    public function redirectToFacebook(Request $request) {
        /* if (Auth::check()) {
          return $this->abort("404", ['request' => $request, 'code' => '404']);
          } */
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from Facebook.
     *
     * @return Response
     */
    public function handleFacebookCallback(Request $request) {
        $input = $request->all();
        if (Auth::check()) {
            $social = new SocialLogin();
            $userdata = Socialite::driver('facebook')->user();
            //echo '<pre>';print_r($userdata);
            Auth::user()->is_social_login = 1;
            Auth::user()->facebook_login_id = $userdata->id;
            Auth::user()->facebook_access = $userdata->token;
            Auth::user()->facebook_info = serialize($userdata->user);
            Auth::user()->update();
            $this->getandstorefbcommentsondbfromfacebook();
            $url = explode('?', redirect()->getUrlGenerator()->previous());
            $addurl = "active-tab=facebook";
            $url = $url[0] . "?" . $addurl;
            return redirect($url);
        }
        $social = new SocialLogin();
        $user = Socialite::driver('facebook')->user();
        if ($social->checkUser($user, 2)) {
            $this->getandstorefbcommentsondbfromfacebook();
            return redirect("/");
        }
        if (isset($user->email) && !empty($user->email)) {
            $social->checkSetUser($user, 2);
        } else {
            Session::set('SOCIAL_USER', $user);
            Session::set('SOCIAL_TYPE', 2);

            return $this->view("auth.social_login", array('request' => $request));
        }
        $this->getandstorefbcommentsondbfromfacebook();
        return redirect("/");
    }

    /*  get and update all the facebook post from the user profile when user login with facebook */

    function getandstorefbcommentsondbfromfacebook() {
        $sharedlink = Socialite::driver('facebook')->getUserFeeds(Auth::user()->facebook_access, Auth::user()->facebook_login_id);
        $facebookdatatostore = array();
        foreach ($sharedlink['data'] as $fbdata) {
            if (isset($fbdata['link']) && strpos($fbdata['link'], 'topic/details')) {
                $facebookdatatostore[] = $fbdata;
            }
        }
        if (isset($sharedlink['paging']) && isset($sharedlink['paging']['next'])) {
            $facebookdatatostore1 = $this->netxpagepostdatafromfacebook($sharedlink['paging']['next']);
            $finalarray = array_merge($facebookdatatostore, $facebookdatatostore1);
        }
        $fbcommObj = new Fbcomments();
        $fbcommObj->insertFBpostdata($finalarray, Auth::user()->user_id);
    }

    //get pagging data from the facebook
    function netxpagepostdatafromfacebook($url) {
        $nextpagedata = $this->file_get_contents_curl($url);
        $returnarray = array();
        if (!empty($nextpagedata) && isset($nextpagedata['data'])) {
            foreach ($nextpagedata['data'] as $fbdatanext) {
                if (isset($fbdatanext['link']) && strpos($fbdatanext['link'], 'topic/details')) {
                    $returnarray[] = $fbdatanext;
                }
            }
        }
        if (isset($nextpagedata['paging']) && isset($nextpagedata['paging']['next'])) {
            $returnarray[] = $this->netxpagepostdatafromfacebook($nextpagedata['paging']['next']);
        }
        return $returnarray;
    }

    // curl function for the get data frm the facebook
    function file_get_contents_curl($url) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);

        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }

    /**
     * Obtain the user information from Google.
     *
     * @return Response
     */
    public function redirectToGoogle(Request $request) {
        if (Auth::check()) {
            return $this->abort("404", ['request' => $request, 'code' => '404']);
        }
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Facebook.
     *
     * @return Response
     */
    public function handleGoogleCallback(Request $request) {
        if (Auth::check()) {
            return $this->abort("404", ['request' => $request, 'code' => '404']);
        }
        $social = new SocialLogin();
        $user = Socialite::driver('google')->user();
        if ($social->checkUser($user, 1)) {
            return redirect("/");
        }
        if (isset($user->email) && !empty($user->email)) {
            $social->checkSetUser($user, 1);
        } else {
            Session::set('SOCIAL_USER', $user);
            Session::set('SOCIAL_TYPE', 1);
            return $this->view("auth.social_login", array('request' => $request));
        }
        return redirect("/");
    }

    public function dosociallogin(Request $request) {
        $social = new SocialLogin();
        $input = $request->all();
        $user = Session::get('SOCIAL_USER');
        $type = Session::get('SOCIAL_TYPE');
        $email = trim($input['email']);
        $data = $social->UserLoginWithSocial($input, $user, $type, $email);
        $this->getandstorefbcommentsondbfromfacebook();
        return json_encode($data);
    }

    /**
     * Redirect the user to the Facebook authentication page.
     *
     * @return Response
     */
    public function redirectToTwitter(Request $request) {
//        if (!Auth::check()) {
//            return $this->abort("404", ['request' => $request, 'code' => '404']);
//        }
        return Socialite::driver('twitter')->redirect();
    }

    /**
     * Obtain the user information from Facebook.
     *
     * @return Response
     */
    public function handleTwitterCallback(Request $request) {
        if (!Auth::check()) {
            return $this->abort("404", ['request' => $request, 'code' => '404']);
        }
        if ($request->has('oauth_token')) {
            $user = Socialite::driver('twitter')->user();
            $session = Session::get('SOCIAL_USER');
            $social = new SocialLogin();
            //$social->checkSetUser($user, "twitter");

            Auth::user()->twitter_login_id = $user->id;
            Auth::user()->twitter_info = serialize($user);
            Auth::user()->update();
            $this->twitterdata();
            return redirect("/");
            //return redirect("/");
        } else {
            Session::flash("GLOBAL_ERROR", "Authentication failed from Twitter login");
        }
    }

    //store twitter post to database when login by twitter.
    function twitterdata() {
        $configdata = Config::get('services.twitter');
        //print_r($configdata);      

        $social = new Socialite();

        $twitterdata = unserialize(Auth::user()->twitter_info);
        //echo $twitterdata->token;
        $url = "https://api.twitter.com/1.1/statuses/user_timeline.json";

        $oauth_access_token = $twitterdata->token;
        $oauth_access_token_secret = $twitterdata->tokenSecret;
        $consumer_key = $configdata['client_id'];
        $consumer_secret = $configdata['client_secret'];

        $oauth = array('oauth_consumer_key' => $consumer_key,
            'oauth_nonce' => time(),
            'oauth_signature_method' => 'HMAC-SHA1',
            'oauth_token' => $oauth_access_token,
            'oauth_timestamp' => time(),
            'oauth_version' => '1.0');

        $base_info = $this->buildBaseString($url, 'GET', $oauth);
        $composite_key = rawurlencode($consumer_secret) . '&' . rawurlencode($oauth_access_token_secret);
        $oauth_signature = base64_encode(hash_hmac('sha1', $base_info, $composite_key, true));
        $oauth['oauth_signature'] = $oauth_signature;

        // Make requests
        $header = array($this->buildAuthorizationHeader($oauth), 'Expect:');
        $options = array(CURLOPT_HTTPHEADER => $header,
            //CURLOPT_POSTFIELDS => $postfields,
            CURLOPT_HEADER => false,
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false);

        $feed = curl_init();
        curl_setopt_array($feed, $options);
        $json = curl_exec($feed);
        curl_close($feed);

        $twitter_data = json_decode($json);

        //print it out
        $tsharedarray = array();
        $i = 0;
        foreach ($twitter_data as $tdata) {
            if (count($tdata->entities->urls) > 0 && strpos($tdata->entities->urls[0]->expanded_url, 'topic/details')) {
                $tsharedarray[$i]['id'] = $tdata->id;
                $tsharedarray[$i]['created_time'] = $tdata->created_at;
                $tsharedarray[$i]['text'] = $tdata->text;
                $tsharedarray[$i]['expanded_url'] = $tdata->entities->urls[0]->expanded_url;
                $comments = $this->searcharray($tdata->id, 'in_reply_to_status_id', $twitter_data);
                //echo "<pre>";print_r ($comments);echo "</pre>";
                $tsharedarray[$i]['comments'] = $comments;
                $i++;
            }
        }
        $TWcommObj = new Twittercomments();
        $TWcommObj->insertTwitterpostdata($tsharedarray, Auth::user()->user_id);
    }

    function searcharray($value, $key, $array) {
        $returnarray = array();
        $j = 0;
        foreach ($array as $k => $val) {
            if ($val->$key == $value) {
                //$returnarray[$j] = $val;
                $returnarray[$j]['id'] = $val->id;
                $returnarray[$j]['created_time'] = $val->created_at;
                $returnarray[$j]['text'] = $val->text;
                $returnarray[$j]['username'] = $val->user->name;
                $returnarray[$j]['userid'] = $val->user->id;
                $returnarray[$j]['user_screen_name'] = $val->user->screen_name;
                $returnarray[$j]['userimg'] = $val->user->profile_image_url;
                $returnarray[$j]['recomment'] = $this->searcharray($val->id, 'in_reply_to_status_id', $array);
                $j++;
            }
        }
        return $returnarray;
    }

    function buildBaseString($baseURI, $method, $params) {
        $r = array();
        ksort($params);
        foreach ($params as $key => $value) {
            $r[] = "$key=" . rawurlencode($value);
        }
        return $method . "&" . rawurlencode($baseURI) . '&' . rawurlencode(implode('&', $r));
    }

    function buildAuthorizationHeader($oauth) {
        $r = 'Authorization: OAuth ';
        $values = array();
        foreach ($oauth as $key => $value)
            $values[] = "$key=\"" . rawurlencode($value) . "\"";
        $r .= implode(', ', $values);
        return $r;
    }

    /**
     * Affiliate reffer the new user for signup.
     */
    public function refference_signup(Request $request, $refferer_key) {
        $userObj = new User();
        $refferer = $userObj->getUserByKey($refferer_key);
        if (!empty($refferer) && $refferer->blocked == 0) {
            Session::put("REF_ID", $refferer->user_id);
        }
        return redirect('/');
    }

    public function getLoginFrm(Request $request) {
        $this->doAnalyse($request);
        if (Auth::check()) {
            return redirect('/');
        }
        return $this->view('auth.login', ['request' => $request]);
    }

    public function getSignupFrm(Request $request) {
        if (Auth::check()) {
            return redirect('/');
        }
        $this->doAnalyse($request);
        $pageObj = new Pages();
        $page = $pageObj->getPageContentBySlug('join-us');
        return $this->view('auth.signup', ['request' => $request, 'page' => $page]);
    }

    public function logout() {
        if (Auth::check()) {
            Auth::user()->online_status = 0;
            Auth::user()->update();
        }

        Auth::logout();
        Session::flush();
        return redirect($this->module . '/')->with('message', 'Your are now logged out!');
    }

    public function sociallogin(Request $request) {
        return $this->view("auth.social_login", array('request' => $request));
    }

}
