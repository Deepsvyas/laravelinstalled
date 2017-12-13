<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\DBConfig ;

class DBConfigController extends BaseController
{
    /*----- Static Statrt -----*/
    
    public function index(Request $request)
    {
        $modelObj = new DBConfig();
        $modelObj->setStaticData();
        return view('admin.dbconfig.staticlist',['request' => $request , 'model' => $modelObj]);
    }
    
    public function update_static_config(Request $request)
    {
        $modelObj = new DBConfig();
        $input = $request->all();
        $data = $modelObj->updateStaticConfig($input);
        return json_encode($data);
    }
    
}
