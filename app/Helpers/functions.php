<?php

function locale_url($url){
    $locale =  App::getLocale();
    if($locale =="en" || $locale == "en_US"){
        $locale = "";
    }
    else
    {
        $locale .= "/";
    }
    return url($locale.$url);
}

function locale_redirect($url){
    $locale =  App::getLocale();
    if($locale =="en" || $locale == "en_US"){
        $locale = "";
    }
    else
    {
        $locale .= "/";
    }
    return redirect($url);
}