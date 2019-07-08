<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kas;


class KasController extends Controller
{
    public function index(){
    	$this->page_attributes->title = 'kas'; 
    	$kas = Kas::get();
        $this->view = view('pages.kas.index',compact('kas'));
        return $this->generateView(); 
    }

    public function create(){
    	$this->page_attributes->title = 'Tambah kas'; 
        $this->view = view('pages.kas.add');
        return $this->generateView(); 
    }

    public function store(Request $request){
    	$kas = new Kas();
    	$kas->fill($request->all());
    	$kas->save();
    	return redirect('kas');
    }

    public function edit($id){
    	$this->page_attributes->title = 'Edit kas'; 
    	$kas = Kas::find($id);
        $this->view = view('pages.kas.edit',compact('kas'));
        return $this->generateView(); 
    }

    public function update(Request $request, $id){
    	$kas = kas::find($id);
    	$kas->fill($request->all());
    	$kas->save();
    	return redirect('kas');
    }


    public function destroy($id){
        $kas = kas::find($id)->delete();
    }
}
