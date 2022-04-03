<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\DevProject;
use Illuminate\Http\Request;

class DevProjectController extends Controller
{
    function listDevProject(Request $request) {
        $current = $request->current;
        $pageSize = $request->pageSize;
    
        $start = (($current -1) * $pageSize);
    
        $dev = DevProject::select('*');
    
        $request = array_diff_key($request->all(), array_flip(['current', 'pageSize']));
        foreach($request as $key => $rq){
            if($rq){
                $dev->where($key, 'like', '%' . $rq . '%');
            }
        }
        $total  = count($dev->get()->toArray());
        $data = $dev->offset($start)->limit($pageSize)->get();
        $fit = (object)array(
            "data" => $data,
            "total"  => $total,
            "success" => true,
            "pageSize" => $pageSize,
            "current" => $current
        );
        return ($fit);
    
    }
}
