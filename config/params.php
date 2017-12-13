<?php

return [
    //'paginate' => 10,
    'noReplyEmail' => "no-reply@test.com",
    'upload_theme_path' => 'public/themes',
    'upload_theme_views_path' => 'resources/views/themes',
    'post_image' => array(
        'base_path' => 'public/posts',
        'path' => 'posts',
        'sizes' => "200x200,20x20,50x50,100x100,400x400,800x800",
        'mimes' => array('image/gif', 'image/jpeg', 'image/jpg', 'image/png'),
    ),
    'user_image' => array(
        'base_path' => 'public/user/',
        'path' => 'user',
        'sizes' => "400x400,50x50,100x100,200x200,600x600,800x800",
        'mimes' => array('image/jpeg', 'image/jpg', 'image/png'),
    ),
    'topic_image' => array(
        'base_path' => 'public/user/%d/topic/%d/',
        'path' => 'user/%d/topic/%d/',
        'sizes' => " 100x100,200x200,300x300,400x400,600x600,800x800",
        'mimes' => array('image/jpeg', 'image/jpg', 'image/png', 'image/gif'),
    ),
    'comment_image' => array(
        'base_path' => 'public/user/%d/comments/%d/',
        'path' => 'user/%d/comments/%d/',
        'sizes' => " 100x100,200x200,300x300,400x400,600x600,800x800",
        'mimes' => array('image/jpeg', 'image/jpg', 'image/png', 'image/gif'),
    ),
    'topic_type' => array(
        '1' => 'Text',
        '2' => 'Youtube',
        '3' => 'Vimeo',
    ),
    'banner_image' => array(
        'base_path' => 'public/banners',
        'path' => 'banners',
        'sizes' => "200x200,20x20,50x50,100x100,400x400,800x800",
        'mimes' => array('image/gif', 'image/jpeg', 'image/jpg', 'image/png'),
    ),
    'category_image' => array(
        'base_path' => 'public/categories',
        'path' => 'categories',
        'sizes' => "200x200,20x20,50x50,100x100,400x400,800x800",
        'mimes' => array('image/gif', 'image/jpeg', 'image/jpg', 'image/png'),
    ),
    'captcha_site_key' => "6Ldd9A8TAAAAAGSqgHX8TcalD6goqtUE-7meDnjd",
    'captcha_secret_key' => "6Ldd9A8TAAAAAPBlCaeMAdq64T69uuycXb6Jm__G",
    'ENCRYPTION_KEY' => 'd0a7e7997b6d5fcd55f4b5c32611b87cd923e88837b63bf2941ef819dc8ca282',
];
