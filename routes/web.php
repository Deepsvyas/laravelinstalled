<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post('fn/getcountries', "FnController@getCountries");
Route::post('fn/getstatesbycountryid', "FnController@getStatesByCountryId");
Route::post('fn/getcitiesbycountryid', "FnController@getCitiesByCountryId");
Route::post('fn/getcitiesbystateid', "FnController@getCitiesByStateId");
Route::any('fn/getimage/{image}/{img_size}', "FnController@getImage");
Route::any('fn/setlang/{lang}', "FnController@setLang");
Route::any('fn/location', "FnController@getLocation");
Route::any('fn/testemail', "FnController@testEmail");

Route::group(['namespace' => 'Site'], function($router) {
    Route::get('/', "HomeController@index");
});

// ----- For only authorized members ----- //

$router->group([ 'namespace' => 'Site', 'middleware' => ['auth']], function() use ($router) {
    $router->post('user/avataredit', "UserController@avatarEdit");
    $router->post('user/editInfo', "UserController@editInfo");
    $router->get('/notif/{notif_id}', "NotifController@readNotif");
       
});






Route::group(['middleware' => 'auth'], function() {
    // Route::get('home', 'site\HomeController@index');  
    // need to remove this
    Route::any('logout', 'AuthController@logout');
});

$router->group(['prefix' => 'admin'], function() use ($router) {
    $router->get('/', "AuthController@getLogin");
    $router->post('/', "AuthController@postLogin");
    $router->post('send_mail/', "Admin\ProjectFindingController@send_mail");
    Route::any('logout', 'AuthController@logout');
});

$router->group(['prefix' => 'admin', 'namespace' => 'Admin\Cron'], function() use ($router) {
    Route::any('cron', 'CronController@sendnewsletter');
});

$router->group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth', 'acl']], function() use ($router) {

    $router->group(['prefix' => 'dashboard'], function() use ($router) {
        $router->get('/', [
            'uses' => 'DashboardController@index',
            'as' => 'dashboard',
            'permission' => 'dashboard',
        ]);
    });
        $router->get('/stylist', [
            'uses' => 'UserController@stylistlist',
            'as' => 'userslist',
            'permission' => 'users_list',
        ]);
    $router->group(['prefix' => 'users'], function() use ($router) {
        $router->get('/', [
            'uses' => 'UserController@userlist',
            'as' => 'userslist',
            'permission' => 'users_list',
        ]);
        
        $router->post('/userlist', [
            'uses' => 'UserController@ajaxuserlist',
            'as' => 'userslist',
            'permission' => 'users_list',
        ]);

        $router->get('addnew', [
            'uses' => 'UserController@addnew',
            'as' => 'addnew',
            'permission' => 'users_add'
        ]);

        $router->post('addnewajax', [
            'uses' => 'UserController@addnewajax',
            'as' => 'addnewajax',
            'permission' => 'users_add'
        ]);

        /* Edit user route starts here */
        $router->get('edit/{user_key}', [
            'uses' => 'UserController@edit',
            'as' => 'edit',
            'permission' => 'user_edit',
        ]);

        $router->post('editajax', [
            'uses' => 'UserController@editajax',
            'as' => 'editajax',
            'permission' => 'user_edit'
        ]);

        $router->post('deleteusers', [
            'uses' => 'UserController@deleteusers',
            'as' => 'deleteusers',
            'permission' => 'users_delete',
        ]);
        /* Edit user route end here */

        /* Update user blocked or unblocked starts here */
        $router->post('update_active', [
            'uses' => 'UserController@update_active',
            'as' => 'update_active',
            'permission' => 'user_edit'
        ]);
        
        $router->post('update_feature', [
            'uses' => 'UserController@update_feature',
            'as' => 'update_active',
            'permission' => 'user_edit'
        ]);
        /* Update user blocked or unblocked starts here */
    });

    /* Permissions module */
    $router->group(['prefix' => 'permission'], function() use ($router) {
        /* Permissions */
        $router->get('/', [
            'uses' => 'PermissionController@permissionlist',
            'as' => 'permissionlist',
            'permission' => 'list',
        ]);

        $router->get('addnew', [
            'uses' => 'PermissionController@addnew',
            'as' => 'addnew',
            'permission' => 'add'
        ]);

        $router->post('addnewajax', [
            'uses' => 'PermissionController@addnewajax',
            'as' => 'addnewajax',
            'permission' => 'add'
        ]);

        /* Edit permission route starts here */
        $router->get('edit/{permission_id}', [
            'uses' => 'PermissionController@edit',
            'as' => 'edit',
            'permission' => 'edit',
        ]);

        $router->post('editajax', [
            'uses' => 'PermissionController@editajax',
            'as' => 'editajax',
            'permission' => 'edit'
        ]);

        $router->post('deletepermission', [
            'uses' => 'PermissionController@deletepermission',
            'as' => 'deletepermission',
            'permission' => 'delete',
        ]);
        /* Edit permission route end here */
    });


    /* Role module */
    $router->group(['prefix' => 'role'], function() use ($router) {
        $router->get('/', [
            'uses' => 'RoleController@rolelist',
            'as' => 'rolelist',
            'permission' => 'list',
        ]);

        $router->get('addnew', [
            'uses' => 'RoleController@addnew',
            'as' => 'addnew',
            'permission' => 'add'
        ]);

        $router->post('addnewajax', [
            'uses' => 'RoleController@addnewajax',
            'as' => 'addnewajax',
            'permission' => 'add'
        ]);

        /* Edit role route starts here */
        $router->get('edit/{role_id}', [
            'uses' => 'RoleController@edit',
            'as' => 'edit',
            'permission' => 'edit',
        ]);

        $router->post('editajax', [
            'uses' => 'RoleController@editajax',
            'as' => 'editajax',
            'permission' => 'edit'
        ]);
        /* Edit role route end here */

        $router->post('deleterole', [
            'uses' => 'RoleController@deleterole',
            'as' => 'deleterole',
            'permission' => 'delete',
        ]);


        /* - Relation starts - */
        $router->get('relation', [
            'uses' => 'RoleController@relationrolepermission',
            'as' => 'relationrolepermission',
            'permission' => 'list',
        ]);

        /* - Relation end - */

        /* - Update is_set role permissions - */
        $router->post('update_is_set', [
            'uses' => 'RoleController@update_is_set',
            'as' => 'update_is_set',
            'permission' => 'edit',
        ]);
        $router->post('project_include_update', [
            'uses' => 'RoleController@project_include_update',
            'as' => 'update_is_set',
            'permission' => 'edit',
        ]);
        /* - end  Update is_set role permissions - */
    });
    /* - End Role module - */

    /* - Start DbConfig module - */
    $router->group(['prefix' => 'dbconfig'], function() use ($router) {
        /* ------- Static Config Start------- */
        $router->get('staticdata', [
            'uses' => 'DBConfigController@index',
            'as' => 'edit',
            'permission' => 'edit',
        ]);
        $router->post('update_static_config', [
            'uses' => 'DBConfigController@update_static_config',
            'as' => 'edit',
            'permission' => 'edit',
        ]);
    });
    /* - End DbConfig module - */

    
    
    $router->group(['prefix' => 'pages'], function() use ($router) {
        $router->get('/', [
            'uses' => 'PagesController@index',
            'as' => 'pagelist',
            'permission' => 'edit',
        ]);
        $router->post('pagelist', [
            'uses' => 'PagesController@pagelist',
            'as' => 'pagelist',
            'permission' => 'edit',
        ]);
        $router->post('addnewpageajax', [
            'uses' => 'PagesController@addnewpageajax',
            'as' => 'addnew',
            'permission' => 'edit',
        ]);
        $router->post('get_page_data', [
            'uses' => 'PagesController@get_page_data',
            'as' => 'edit',
            'permission' => 'edit',
        ]);
        $router->post('update_active', [
            'uses' => 'PagesController@update_active',
            'as' => 'edit',
            'permission' => 'edit',
        ]);
        $router->post('delete', [
            'uses' => 'PagesController@delete',
            'as' => 'edit',
            'permission' => 'edit',    
        ]);
    });
    
    
    $router->group(['prefix' => 'posts'], function() use ($router) {
        $router->get('/', ['uses' => 'PostsController@index', 'as' => 'postlist', 'permission' => 'users_list',]);
        $router->get('/{new_post}', ['uses' => 'PostsController@index', 'as' => 'postlist', 'permission' => 'users_list',]);
        $router->post('postlist', ['uses' => 'PostsController@postlist', 'as' => 'postlist', 'permission' => 'users_list',]);
        $router->post('addnewpostajax', ['uses' => 'PostsController@addnewpostajax', 'as' => 'addnew', 'permission' => 'users_list']);
        $router->post('get_post_data', ['uses' => 'PostsController@get_post_data', 'as' => 'edit', 'permission' => 'users_list']);
        $router->post('update_active', ['uses' => 'PostsController@update_active', 'as' => 'update_active', 'permission' => 'users_list']);
        $router->post('delete', ['uses' => 'PostsController@delete', 'as' => 'delete', 'permission' => 'users_list']);

        $router->any('commentslist', ['uses' => 'PostsController@commentslist', 'as' => 'comments_list', 'permission' => 'users_list']);
        $router->post('get_comment_data', ['uses' => 'PostsController@get_comment_data', 'as' => 'update_active', 'permission' => 'users_list']);
        $router->post('editcommentajax', ['uses' => 'PostsController@editcommentajax', 'as' => 'update_active', 'permission' => 'users_list']);
        $router->post('comment/update_active', ['uses' => 'PostsController@commentupdate_active', 'as' => 'update_active', 'permission' => 'users_list']);
        $router->post('deletecomment', ['uses' => 'PostsController@deletecomment', 'as' => 'delete', 'permission' => 'users_list']);

        $router->post('addnewtagajax', ['uses' => 'PostsController@addnewtagajax', 'as' => 'users_list', 'permission' => 'users_list']);
        $router->post('taglist', ['uses' => 'PostsController@taglist', 'as' => 'list', 'permission' => 'users_list']);
    });
    
    

    /* --------- Start Menus module ------- */

//    $router->group(['prefix' => 'menus'], function() use ($router) {
//        $router->get('/', ['uses' => 'MenusController@index', 'as' => 'menulist', 'permission' => 'menu_listing',]);
//        $router->post('menulist', ['uses' => 'MenusController@menulist', 'as' => 'menulist', 'permission' => 'menu_listing',]);
//        $router->post('addnewmenuajax', ['uses' => 'MenusController@addnewmenuajax', 'as' => 'addnew', 'permission' => 'add_menu']);
//        $router->post('update_active', ['uses' => 'MenusController@update_active', 'as' => 'edit', 'permission' => 'edit']);
//        $router->post('get_pages_dropdown', ['uses' => 'MenusController@pages_dropdown', 'as' => 'add_menu', 'permission' => 'menu_listing',]);
//        $router->post('menutree', ['uses' => 'MenusController@menutree', 'as' => 'add_menu', 'permission' => 'add_menu',]);
//        $router->post('get_menu_data', ['uses' => 'MenusController@get_menu_data', 'as' => 'edit', 'permission' => 'edit_menu']);
//        $router->post('delete', ['uses' => 'MenusController@delete', 'as' => 'delete', 'permission' => 'delete_menu']);
//    });
    
    

    /* Edit user profile starts here */
    $router->get('editprofile', [
        'uses' => 'UserController@editprofile',
        'as' => 'edit',
        'permission' => 'edit_profile',
    ]);

    $router->post('editprofileajax', [
        'uses' => 'UserController@editprofileajax',
        'as' => 'addnewajax',
        'permission' => 'edit_profile'
    ]);


    $router->group(['prefix' => 'banners'], function() use ($router) {
        $router->get('/', ['uses' => 'BannerController@index', 'as' => 'bannerlist', 'permission' => 'users_list',]);
        $router->get('/{new_post}', ['uses' => 'BannerController@index', 'as' => 'postlist', 'permission' => 'users_list',]);
        $router->post('bannerlist', ['uses' => 'BannerController@bannerlist', 'as' => 'postlist', 'permission' => 'users_list',]);
        $router->post('addnewbannerajax', ['uses' => 'BannerController@addnewbannerajax', 'as' => 'addnew', 'permission' => 'users_list']);
        $router->post('get_banner_data', ['uses' => 'BannerController@get_banner_data', 'as' => 'edit', 'permission' => 'users_list']);
        $router->post('update_active', ['uses' => 'BannerController@update_active', 'as' => 'update_active', 'permission' => 'users_list']);
        $router->post('delete', ['uses' => 'BannerController@delete', 'as' => 'delete', 'permission' => 'users_list']);

    });


    $router->group(['prefix' => 'faqs'], function() use ($router) {
        $router->get('/', ['uses' => 'FaqsController@index', 'as' => 'faqlist', 'permission' => 'users_list',]);
        $router->get('/{new_post}', ['uses' => 'FaqsController@index', 'as' => 'faqlist', 'permission' => 'users_list',]);
        $router->post('faqlist', ['uses' => 'FaqsController@faqlist', 'as' => 'faqlist', 'permission' => 'users_list',]);
        $router->post('addnewfaqajax', ['uses' => 'FaqsController@addnewfaqajax', 'as' => 'addnew', 'permission' => 'users_list']);
        $router->post('get_faq_data', ['uses' => 'FaqsController@get_faq_data', 'as' => 'edit', 'permission' => 'users_list']);
        $router->post('update_active', ['uses' => 'FaqsController@update_active', 'as' => 'update_active', 'permission' => 'users_list']);
        $router->post('delete', ['uses' => 'FaqsController@delete', 'as' => 'delete', 'permission' => 'users_list']);

    });


    $router->group(['prefix' => 'product-category'], function() use ($router) {
        $router->get('/', ['uses' => 'PcategoryController@index', 'as' => 'categorylist', 'permission' => 'users_list',]);
        $router->get('/{new_post}', ['uses' => 'PcategoryController@index', 'as' => 'categorylist', 'permission' => 'users_list',]);
        $router->post('categorylist', ['uses' => 'PcategoryController@categorylist', 'as' => 'categorylist', 'permission' => 'users_list',]);
        $router->post('addnewcategoryajax', ['uses' => 'PcategoryController@addnewcategoryajax', 'as' => 'addnew', 'permission' => 'users_list']);
        $router->post('get_category_data', ['uses' => 'PcategoryController@get_category_data', 'as' => 'edit', 'permission' => 'users_list']);
        $router->post('update_active', ['uses' => 'PcategoryController@update_active', 'as' => 'update_active', 'permission' => 'users_list']);
        $router->post('delete', ['uses' => 'PcategoryController@delete', 'as' => 'delete', 'permission' => 'users_list']);

    });

    
    /* Edit user route end here */
});




Route::get('/login', 'AuthController@getLoginFrm');
Route::post('signin', "AuthController@postLogin");
Route::get('sociallogin', "AuthController@sociallogin");
Route::post('sociallogin', "AuthController@dosociallogin");

Route::get('/new-signup', 'AuthController@getSignupFrm');
Route::post('/signup', "AuthController@signup");

Route::any('confirm-account/{token}', 'AuthController@confirm_account');
Route::any('model-confirm-account/{token}', 'AuthController@model_confirm_account');
Route::post('/forgotpassword', "AuthController@forgotpassword");
Route::any('resetpassword/{token}', 'AuthController@resetpassword');
Route::post('resetpasswordajax', 'AuthController@resetpasswordajax');

// social Login
Route::get('auth/facebook', 'AuthController@redirectToFacebook');
Route::get('auth/facebook/callback', 'AuthController@handleFacebookCallback');
Route::get('auth/twitter', 'AuthController@redirectToTwitter');
Route::get('auth/twitter/callback', 'AuthController@handleTwitterCallback');
Route::get('auth/google', 'AuthController@redirectToGoogle');
Route::get('auth/google/callback', 'AuthController@handleGoogleCallback');
// social Login

Route::any('logout', 'AuthController@logout');
/* * ***********Front Site routes Ends here *********** * */