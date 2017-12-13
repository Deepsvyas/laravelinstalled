<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\User\User;
use App\Models\Topics;
use App\Models\Analyse;

class DashboardController extends BaseController
{
    public function index(Request $request)
    {
    	$userObj = new User();
    	$totaluser = $userObj->countTotalUsers();
        return view('admin.home.index',['request'=>$request,'page_header'=>"Dashboard","sub_header"=>"", "icon"=>"dashboard", 'totaluser' => $totaluser]);
    }
    
    
//     function getOnlineVisitors($request){
//        //getting
//        $users = array();
//        $path = storage_path("app/");
//
//        $dataFile = $path."visitors.txt";
//        $fp = @fopen($dataFile, "r");
//        flock($fp, LOCK_SH);
//        if($fp)
//        while (($line = fgets($fp)) !== false) {
//            if(strlen(trim($line)) > 0){
//                $users[] = explode("|",$line);
//            }
//        }
//        flock($fp, LOCK_UN);
//        fclose($fp);
//        return $users;
//    }
    
}
