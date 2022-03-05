<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PDF;


class PreorderController extends Controller
{
    public function loaddata(Request $req){
        $isEmpty = true;
        $data = null;
        $dataopsi = null;
        if($req->session()->has('id_nb')){
           $data =  DB::table('nota_besar')->where('id_transaksi', $req->session()->get('id_nb'))->first();
           $dataopsi =  DB::table('nb_detail')->where('id_nb', $req->session()->get('id_nb'))->get()->toArray();
           $isEmpty = false;
        }
        return json_encode(['data' => (array)$data, 'dataopsi' => (array) $dataopsi, 'isEmpty'  => $isEmpty,'page'=>'kasir']);
    }
    public function index(Request $req,$id = null){
        if($id != null){
            return view("notabesar", ["id"=>$id]);
        }else{
            return view("notabesar");
        }
            
          
        
     
    }

    public function bayaring($id){

        return view("notabesar");
        
}





    public function tambahtransaksi(Request $req){
        // $ttd = $req->input('ttd');
        // $up = $req->input('up');
        // $us = $req->input('us');
        // $brp = $req->input('brp');
        // $gm = $req->input('gm');
        // $total = $req->input('total');

        $judulopsi = $req->input('judulopsi');
        $ketopsi = $req->input('ketopsi');
        $formdata = $req->input('formData');
        $tanggal = $req->tanggal;
        

        $tanggal2 = Carbon::createFromFormat("Y.m.d", date("Y.m.d",strtotime($tanggal)))->addDays(20)->format("Y-m-d");



        $id;
        $id2 = "";
        $id3;
        $no;
        if($req->session()->has('id_nb')){
            $id = $req->session()->get('id_nb');
            DB::table('nota_besar')->where('id_transaksi', $id)->update($req->input('formData'));
        }else{
            $counter = DB::table('nota_besar')->count();
            $counter = $counter+1;
            $no = date("ymd").$counter;
            $counting = DB::table('nota_besar')->where("no_nota",$no)->count();
            if($counting < 1){
                switch ($req->tp) {


                        case '2':
                            $id = DB::table('nota_besar')->insertGetId(array_merge($req->input('formData'),['no_nota' => $no, 'termin' => 1, "status" => "dibayar",'created_at'=>$tanggal, 'jatuh_tempo'=>$tanggal2,'tp' => $req->tp]));
                            $id3 = DB::table('nota_besar')->insertGetId(['ttd'=> $formdata["ttd"],'ttd'=> $formdata["ttd"],'up'=> $formdata["up"],'gm'=> $formdata["gm"],'total'=> $formdata["total"],'no_nota' => $no, 'termin' => 3,'jatuh_tempo'=>$tanggal2]);
                            break;

                        case '3':
                            $id = DB::table('nota_besar')->insertGetId(array_merge($req->input('formData'),['no_nota' => $no, 'termin' => 1, "status" => "dibayar",'created_at'=>$tanggal, 'jatuh_tempo'=>$tanggal2, 'tp' => $req->tp]));
                            $id2 = DB::table('nota_besar')->insertGetId(['ttd'=> $formdata["ttd"],'ttd'=> $formdata["ttd"],'up'=> $formdata["up"],'gm'=> $formdata["gm"],'total'=> $formdata["total"],'no_nota' => $no, 'termin' => 2, "status" => "ready",'jatuh_tempo'=>$tanggal2,'tp' => $req->tp]);
                            $id3 = DB::table('nota_besar')->insertGetId(['ttd'=> $formdata["ttd"],'ttd'=> $formdata["ttd"],'up'=> $formdata["up"],'gm'=> $formdata["gm"],'total'=> $formdata["total"],'no_nota' => $no, 'termin' => 3,'jatuh_tempo'=>$tanggal2,'tp' => $req->tp]);
                        break;
                    
                    default:
                        # code...
                        break;
                }
                
            }
          
        }


       

    
        
        for($i = 0; $i < count($judulopsi);$i++){
            if($req->session()->has('id_nb')){
              
                $count = DB::table('nb_detail')->where('id_nb', $id)->where('opsi',$i+1)->count();
                if($count > 0){
                    DB::table('nb_detail')->where('id_nb', $id)->where('opsi',$i+1)->update(['judul' => $judulopsi[$i],'ket' => $ketopsi[$i]]);
                }else{
                    DB::table('nb_detail')->insert(['id_nb' => $id, 'opsi' => $i+1, 'judul' => $judulopsi[$i],'ket' => $ketopsi[$i]]);
                }
            }else{
                DB::table('nb_detail')->insert(['id_nb' => $id, 'opsi' => $i+1, 'judul' => $judulopsi[$i],'ket' => $ketopsi[$i]]);
            }
            
        }

        for($i = 0; $i < count($judulopsi);$i++){
            if($req->session()->has('id_nb')){
              
                $count = DB::table('nb_detail')->where('id_nb', $id2)->where('opsi',$i+1)->count();
                if($count > 0){
                    DB::table('nb_detail')->where('id_nb', $id2)->where('opsi',$i+1)->update(['judul' => $judulopsi[$i],'ket' => $ketopsi[$i]]);
                }else{
                    DB::table('nb_detail')->insert(['id_nb' => $id2, 'opsi' => $i+1, 'judul' => $judulopsi[$i],'ket' => $ketopsi[$i]]);
                }
            }else{
                DB::table('nb_detail')->insert(['id_nb' => $id2, 'opsi' => $i+1, 'judul' => $judulopsi[$i],'ket' => $ketopsi[$i]]);
            }
            
        }

        for($i = 0; $i < count($judulopsi);$i++){
            if($req->session()->has('id_nb')){
              
                $count = DB::table('nb_detail')->where('id_nb', $id3)->where('opsi',$i+1)->count();
                if($count > 0){
                    DB::table('nb_detail')->where('id_nb', $id3)->where('opsi',$i+1)->update(['judul' => $judulopsi[$i],'ket' => $ketopsi[$i]]);
                }else{
                    DB::table('nb_detail')->insert(['id_nb' => $id3, 'opsi' => $i+1, 'judul' => $judulopsi[$i],'ket' => $ketopsi[$i]]);
                }
            }else{
                DB::table('nb_detail')->insert(['id_nb' => $id3, 'opsi' => $i+1, 'judul' => $judulopsi[$i],'ket' => $ketopsi[$i]]);
            }
            
        }

        



       

        return json_encode(["id_nb" => $id, "no_nota" => $no]);
        
    }


    public function bayarpreorder(Request $req){
        $id = $req->input("id_transaksi");
        $formdata = $req->input("formData");
        
        $termin = DB::table("nota_besar")->where("id_transaksi", $id)->get()[0]->termin;



        $no_nota = DB::table("nota_besar")->where("id_transaksi", $id)->get()[0]->no_nota;
        DB::table("nota_besar")->where("no_nota", $no_nota)->where("termin",$termin)->update(["status" => "dibayar"]);
        DB::table("nota_besar")->where("no_nota", $no_nota)->where("termin",$termin+1)->update(["status" => "ready"]);
        DB::table('nota_besar')->where("id_transaksi", $id)->update(['us'=> $formdata["us"],'brp'=> $formdata["brp"]]);

        return json_encode(["id_nb" => $id,"no_nota" => $no_nota]);
    }









    public function resettrans(Request $req){
        $req->session()->forget('id_nb');
    }


    public function search(Request $req){
        $no_nota = $req->input("kw");


        $data = DB::table("nota_besar")->where("no_nota",$no_nota)->get();

        return json_encode($data);
    }

    public function getnb(Request $req){
        $id_trans = $req->input("id_transaksi");

       
        $data1 = DB::table('nota_besar')->where('id_transaksi', $id_trans)->get();
        $data2 = DB::table('nb_detail')->where('id_nb', $id_trans)->get();
        $nn = $data1[0]->no_nota;
        
        $termin = $data1[0]->termin;

         //cek apakah termin sebelumnya sudah lunas
         $status = DB::table('nota_besar')->where("no_nota",$nn)->where("termin", $termin-1)->get()[0]->status;

         if($status == "dibayar"){
            
            $td = DB::table("nota_besar")->where("no_nota", $nn)->where("termin", "<", $termin)->sum("us");
            return json_encode(["nb" => $data1,  "opsi" => $data2, "td"=>$td,]);
         }else{
            $data1 = DB::table('nota_besar')->where("no_nota",$nn)->where("termin", $termin-1)->get();
            $td = DB::table("nota_besar")->where("no_nota", $nn)->where("termin", "<", $termin-1)->sum("us");
            return json_encode(["nb" => $data1,  "opsi" => $data2, "td"=>$td, "peringatan"=>"Termin Sebelumnya harus dilunasi"]);
         }
        
      
    }

    public function cetaknotabesar(Request $req){
        $id_trans = $req->input("id_transaksi");

        $data = DB::table("nota_besar")->where('id_transaksi', $id_trans)->get();
        $td = DB::table("nota_besar")->where('no_nota',$data[0]->no_nota)->where("termin","<",$data[0]->termin)->count();
        $opsi = DB::table("nb_detail")->join("nota_besar", "nota_besar.id_transaksi", "=", "nb_detail.id_nb")->where("id_nb", $id_trans)->get();
        
        $pdf = PDF::loadview('nota_besar', ["data" => $data[0],"opsi"=>$opsi, "td" => $td < 1 ? 0 : $td = DB::table("nota_besar")->where('no_nota',$data[0]->no_nota)->where("termin","<",$data[0]->termin)->sum("us")]);
        $path = public_path('pdf/');
        $fileName =  date('mdy').'-'.$data[0]->id_transaksi. '.' . "nota_besar".'pdf' ;
        $pdf->save(storage_path("pdf/$fileName"));
        $storagepath = storage_path("pdf/$fileName");
        $base64 = chunk_split(base64_encode(file_get_contents($storagepath)));

    	return response()->json(["filename" => $base64]);
    }

  
}
