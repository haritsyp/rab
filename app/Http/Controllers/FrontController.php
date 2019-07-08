<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class FrontController extends Controller
{

    public function index() {
        $menu = [];
        $header = DB::select("SELECT * FROM HEADER");
        foreach ($header as $key => $value) {
            $menu[$key]['nama_header'] = $value->nama_header;
            $mn = DB::select("SELECT * FROM MENU WHERE ID_HEADER = $value->id_header");
            foreach ($mn as $i => $val) {
                $menu[$key]['menu'][$i]['nama_menu'] = $val->nama_menu;
                $menu[$key]['menu'][$i]['url'] = $val->url;
                $menu[$key]['menu'][$i]['icon'] = $val->icon;              

                $mnp = DB::select("SELECT * FROM MENU_PARENT WHERE ID_MENU = $val->id_menu");
                foreach ($mnp as $y => $item) {
                    if(request()->is($item->url)){
                        $menu[$key]['menu'][$i]['isactive'] = "active";
                    }else{
                        $menu[$key]['menu'][$i]['isactive'] = "";
                    }
                    
                    $menu[$key]['menu'][$i]['submenu'][$y]['namasub']= $item->nama_parent;
                    $menu[$key]['menu'][$i]['submenu'][$y]['urlsub']= $item->url;
                }
            }

            
        }
        return response()->json($menu);
    }
}
