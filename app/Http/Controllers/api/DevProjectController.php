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
        $dev = DevProject::select('*')->withTrashed();;
    
        if(isset($request['sort_field']) && $request['sort_field']!= null){
            if(isset($request['sort_order']) && $request['sort_order'] != null){
                $field = $request['sort_field'];
                $order = $request['sort_order'] == '' ? 'ASC' : $request['sort_order'];
                $dev->orderBy($field, $order);
            }
        }else{
            $dev->orderBy('created_at', 'desc');
        }
        $request = array_diff_key($request->all(), array_flip(['current', 'pageSize','sort_field','sort_order']));
        foreach($request as $key => $rq){
            if($rq){
                $dev->where($key, 'like', '%' . $rq . '%');
            }
        }

        $total  = count($dev->get()->toArray());
        $data = $dev->offset($start)->limit($pageSize)->get();
        $data->map(function ($dt) {
            $dt->deleted = $dt->deleted_at ? true : false;
        });
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
