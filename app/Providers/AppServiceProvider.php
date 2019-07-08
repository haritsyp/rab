<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $menu = [];
        $header = DB::select("SELECT * FROM HEADER");
        foreach ($header as $key => $value) {
            $menu[$key]['nama_header'] = $value->nama_header;
            $mn = DB::select("SELECT * FROM MENU WHERE ID_HEADER = $value->id_header");
            foreach ($mn as $i => $val) {
                $menu[$key]['menu'][$i]['nama_menu'] = $val->nama_menu;
                $menu[$key]['menu'][$i]['url'] = $val->url;
                $menu[$key]['menu'][$i]['icon'] = $val->icon;              
                $menu[$key]['menu'][$i]['isactive'] = "";
                $menu[$key]['menu'][$i]['show'] = "";
                $mnp = DB::select("SELECT * FROM MENU_PARENT WHERE ID_MENU = $val->id_menu");
                foreach ($mnp as $y => $item) {
                    if(request()->segment(1) == $item->url){
                        $menu[$key]['menu'][$i]['isactive'] = "active";
                        $menu[$key]['menu'][$i]['show'] = "show";
                    }
                    
                    $menu[$key]['menu'][$i]['submenu'][$y]['namasub']= $item->nama_parent;
                    $menu[$key]['menu'][$i]['submenu'][$y]['urlsub']= $item->url;
                }
            }

            
        }
        $data = json_encode($menu);
        View::share('menudata', json_decode($data));
    }
}
