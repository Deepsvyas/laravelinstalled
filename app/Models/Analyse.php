<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\CommonHelper;
use Illuminate\Http\Request;
use Session, /*GeoIP,*/  Agent, DB;

class Analyse extends Model{
    
    protected $table = 'analyse';
    public $primaryKey = "analyse_id";
    
    
    function addNewAnalyze($page_num, $url, $request) {
//        $agent = new Agent();
//        $ip = CommonHelper::get_client_ip();
//        $analyseObj = new Analyse();
//        $location = GeoIP::getLocation($ip);
//        $analyseObj->ip = $ip;
//        $analyseObj->country = $location['country'];
//        $analyseObj->isoCode = $location['isoCode'];
//        $analyseObj->city = $location['city'];
//        $analyseObj->date = date('Y-m-d');
//        $analyseObj->pages = $page_num;
//        $analyseObj->referer = strlen($request->header('referer')) > 0 ? $request->header('referer') : "-";
//        $analyseObj->url = $url;
//        $analyseObj->state = $location['state'];
//        $analyseObj->postal_code = $location['postal_code'];
//        $analyseObj->browser_name = $agent::browser();
//        $analyseObj->browser_version = $agent::Version($agent::browser());
//        $analyseObj->browser_platform = $agent::platform();
//        if($agent::isDesktop()){
//          $analyseObj->device = 0;  
//        }else{
//          $analyseObj->device = 1;  
//        }        
//        $analyseObj->device_name = $agent::device();
//        $analyseObj->save();
//        Session::push('ANALYZE_DATA', $url);
    }
    
    function visitorsPerMonth(){
        return $this->select(DB::raw('YEAR(date) AS year, MONTH(date) AS month'), DB::raw('count(*) as total'))
                ->groupBy('year')
                ->groupBy('month')
                ->orderBy('year', 'desc')
                ->orderBy('month', 'desc')
                ->orderBy('analyse_id', 'desc')
                ->get();
    }
    
    function readsPerMonth(){
        $to_read = array(4,5,6,7);
        return $this->select(DB::raw('YEAR(date) AS year, MONTH(date) AS month'), DB::raw('count(*) as total'))
                ->groupBy('year')
                ->groupBy('month')
                ->orderBy('year', 'desc')
                ->orderBy('month', 'desc')
                ->orderBy('analyse_id', 'desc')
                ->whereIn('pages', $to_read)
                ->get();
    }
    
    function latestCounts(){
        return $this->select("url", DB::raw('count(*) as total'))
                ->groupBy('pages')
                ->where("created_at", ">=", DB::raw('(DATE(NOW()) - INTERVAL 7 DAY)'))
                ->take(20)->get();
        
    }
    
    function browsersC(){
        return $this->select("browser_name", DB::raw('count(*) as total'))
                ->groupBy('browser_name')
                ->get();
    }
    
    function osC(){
        return $this->select("browser_platform", DB::raw('count(*) as total'))
                ->groupBy('browser_platform')
                ->get();
    }
    function deviceC(){
        return $this->select("device", DB::raw('count(*) as total'))
                ->groupBy('device')
                ->get();
    }
    
    function refers($request){
        return $this->select("referer",  DB::raw('count(*) as total'))
                ->groupBy('referer')
                ->where("created_at", ">=", DB::raw('(DATE(NOW()) - INTERVAL 30 DAY)'))
                ->where("referer", "NOT LIKE", "%".$request->root()."%")
                ->where("referer", "<>", "-")
                ->take(20)->get();
        
    }
    
    function total_percent($total){
        
        return intval(round(($this->total/$this->total_browsersC($total)) * 100));
    }
    
    function total_browsersC($total){
        $sum = 0;
        foreach ($total as $t){
            $sum += $t->total;
        }
        return $sum;
    }
    
}
