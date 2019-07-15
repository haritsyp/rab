<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proyek;
use App\Models\Pengajuan;
use App\Models\Rab;
// use App\Models\Satuan;
use App\Models\Kategori;
// use App\Models\Detailpengajuan;
// use App\Models\DetailBahan;
use Yajra\DataTables\DataTables;
use DB;


class PengajuanController extends Controller
{
    public function index(){
        $this->page_attributes->title = 'Pengajuan Tambah Bahan '; 
        $pengajuan = DB::select('SELECT * FROM pengajuan_tambah_bahan A JOIN proyek B ON A.ID_PROYEK = B.ID_PROYEK JOIN rab C ON A.ID_RAB = C.ID_RAB JOIN kategori D ON A.ID_KATEGORI = D.ID_KATEGORI');
        $this->view = view('pages.pengajuan.index',compact('pengajuan'));
        return $this->generateView(); 
    }

    public function create(){
        $this->page_attributes->title = 'Tambah Pengajuan Bahan';  
        $proyek = Proyek::get();
        $rab=rab::get();
        $kategori=kategori::get();
        $this->view = view('pages.pengajuan.add',compact('proyek','rab','kategori'));
        return $this->generateView(); 

    }

    public function show(Request $request, $id){
        // $pengajuan = pengajuan::where('pengajuan.id_pengajuan',$id)->leftJoin('proyek', 'proyek.id_proyek','=','pengajuan.id_proyek')->first();
        // $kategori = Kategori::get();
        // $satuan = Satuan::get();
        // $this->page_attributes->title = 'Tambah Detail pengajuan';
        // $this->view = view('pages.pengajuan.detailpengajuan', compact('pengajuan','kategori','satuan'));
        // return $this->generateView(); 
    }

    public function store(Request $request){
        $pengajuan = new pengajuan();
        $pengajuan->fill($request->all());
        $pengajuan->save();
        return redirect('pengajuan');
    }

    public function edit($id){
        $this->page_attributes->title = 'Edit Rencana Anggaran Biaya'; 
        $proyek = proyek::get();
        $rab = rab::get();
        $kategori = kategori::get();
        $pengajuan = pengajuan::find($id);
        $this->view = view('pages.pengajuan.edit',compact('pengajuan','proyek','rab','kategori'));
        return $this->generateView(); 
    }

    public function update(Request $request, $id){
        $pengajuan = pengajuan::find($id);
        $pengajuan->fill($request->all());
        $pengajuan->save();
        return redirect('pengajuan');
    }


    public function destroy($id){
        $pengajuan = pengajuan::find($id)->delete();
        // $pengajuan = pengajuan::where('id_pengajuan',$id)->get();
        // foreach ($detailpengajuan as $key => $value) {
        //     $detailbahan = DetailBahan::where('id_detail_pengajuan',$value->id_detail_pengajuan)->delete();
        // }
        // $detailpengajuan = Detailpengajuan::where('id_pengajuan',$id)->delete();
        // $pengajuan = pengajuan::find($id)->delete();
        
    }

    public function get_data(Request $request){
        $detailpengajuan = DB::select("SELECT *, DATEDIFF(tanggal_selesai,tanggal_mulai) AS durasi,IFNULL((SELECT SUM(VOLUME*HARGA) FROM detail_bahan WHERE id_detail_pengajuan = A.id_detail_pengajuan),0) as harga_satuan, volume_pengajuan,satuan_pengajuan,volume_pengajuan*IFNULL((SELECT SUM(VOLUME*HARGA) FROM detail_bahan WHERE id_detail_pengajuan = A.id_detail_pengajuan),0) as biaya FROM DETAIL_pengajuan A WHERE ID_pengajuan = $request->id_pengajuan and ID_KATEGORI = $request->id_kategori");
        return Datatables::of($detailpengajuan)->addColumn('action', function ($detailpengajuan) {
            return '<a href="" class="button" data-id="'.$detailpengajuan->id_pengajuan.'"><i class="glyphicon glyphicon-repeat"></i> Cancel</a>';
        })
        ->make(true);
    }

    public function get_datas(Request $request){
        $detailpengajuan = DB::select("SELECT D.ID_KATEGORI,F.NAMA_KATEGORI FROM DETAIL_pengajuan D JOIN Kategori F ON D.ID_KATEGORI=F.ID_KATEGORI left JOIN detail_bahan E ON E.id_detail_pengajuan=D.id_detail_pengajuan where id_pengajuan = $request->id_pengajuan GROUP BY D.id_kategori,F.nama_kategori");
        return Datatables::of($detailpengajuan)->make(true);
    }

    public function getDetail(Request $request){
        $detailpengajuan = DB::select("SELECT * FROM DETAIL_pengajuan A JOIN Kategori B ON A.ID_KATEGORI=B.ID_KATEGORI where a.id_detail_pengajuan = $request->id_detail_pengajuan");
        return response()->json($detailpengajuan[0]);
    }

    public function storeDetail(Request $request){
        $detailpengajuan = new Detailpengajuan();
        $detailpengajuan->fill($request->all());
        $detailpengajuan->save();
        return response()->json(['msg'=>'success']);
    }

    public function storeDetailBahan(Request $request){
        $detailpengajuan = Detailpengajuan::find($request->id_detail_pengajuan);
        $detailpengajuan->fill($request->all());
        $detailpengajuan->save();
        if(isset($request->data)){
        foreach ($request->data as $key => $value) {
            if($value['id_detail_bahan'] == -1){
                $detailpengajuan = new DetailBahan();
                $id_detail_bahan = DB::select("SELECT IFNULL(MAX(id_detail_bahan),0)+1 AS id_detail_bahan FROM detail_bahan");
                $detailpengajuan->id_detail_bahan = $id_detail_bahan[0]->id_detail_bahan;
                $detailpengajuan->id_detail_pengajuan = $request->id_detail_pengajuan;
                $detailpengajuan->id_bahan = $value['id_bahan'];
                $detailpengajuan->volume = $value['volume'];
                $detailpengajuan->satuan = $value['satuan'];
                $detailpengajuan->harga = $value['harga'];
                $detailpengajuan->save();
            }else{
                $detailpengajuan = DetailBahan::find($value['id_detail_bahan']);
                $detailpengajuan->id_bahan = $value['id_bahan'];
                $detailpengajuan->volume = $value['volume'];
                $detailpengajuan->satuan = $value['satuan'];
                $detailpengajuan->harga = $value['harga'];
                $detailpengajuan->save();
            }
        }
    }
        return response()->json(['msg' => 'success']);
    }

    public function destroyDetailBahan($id){
        $detail = DetailBahan::find($id);
        $detailbahan = DetailBahan::find($id)->delete();
        return response()->json($detail);
    }

    public function getDetailBahan(Request $request){
        $detailbahan = DB::select("SELECT * FROM detail_bahan A JOIN BAHAN B ON A.id_bahan=B.id_bahan WHERE id_detail_pengajuan = $request->id_detail_pengajuan");
        return response()->json($detailbahan);
    }

    public function destroyDetail($id){
        
        $detailpengajuan = Detailpengajuan::find($id)->delete();
        $detailbahan = DetailBahan::where('id_detail_pengajuan',$id)->delete();
        

    }
}
