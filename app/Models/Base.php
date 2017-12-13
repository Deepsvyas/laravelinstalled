<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Session, Config, Request, Lang, DB;
use App\Helpers\ViewsHelper;
use App\Helpers\CommonHelper;

class Base extends Model {
    
    public function scopeSort($query){
        $sort = Request::get("sort");
        $order = Request::get("order");
        if(strlen($sort) == 0){
            $sort = 'created_at';
            $order = 'desc';
        }
        return $query = $query->orderBy($sort, $order);
    }
    
    function scopeSearch($query)
    {
        $search_data = json_decode(Request::get("search_data"));
        if($search_data != null && count($search_data) > 0)
        {
            foreach($search_data as $key => $search){
                $query = $query->where($key, "like", "%".$search."%");
            }
        }
        return $query;
    }
    
    function scopeCreatedDesc($query)
    {
        return $query->orderBy("created_at", "DESC");
    }
    
    function scopeDpaginate($query,$value = false)
    {
        if(!$value){
            $paginate = ViewsHelper::getConfigKeyData('pagination');
        }
        else{
            $paginate = $value;
        }
        return $query->paginate($paginate);
    }
    
    function scopeByLang($query){
        $lang_id = CommonHelper::getLang();
        $query->where("lang_id", $lang_id);
    }
    function scopeThisMonth($query){
        return $query->whereMonth('created_at', '=', date('m') )->whereYear('created_at', '=', date('Y') );
    }
}