<?php

namespace App\Http\Controllers;

use App\Seminar;
use App\SeminarUser;
use App\Topik;
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DateTime;
use DB;

class SeminarController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        // $this->middleware('admin');
    }

    public function show(Request $request, $id_seminar){
        // dd($id_seminar);
        ////->first() kalo cmn satu
        $seminar = Seminar::LeftJoin('table_sfile','id_seminar','seminar_id')->where('id_seminar','=',$id_seminar)->first();
        // $seminar = Seminar::where('id_seminar','=',$id_seminar)->first();
        // compat sama dengan yng ['Seminar'=>$seminar]
        // dd($seminar);
        return view('seminar.detail', compact('seminar'));
    }
    public function create(){
        $topik = Topik::select('id_topik', 'nama_topik')->get();
        $user = User::all();
        return view('seminar.create', compact('topik','user'));
    }

    function store(Request $request){

        $request = parse_str($request->data, array());
        $request = json_decode(json_encode($request)); 
        //dd($request->input());
        // $request->validate([
        //     'nama_seminar' => ['required', 'string', 'max:255'],
        //     'waktu' => 'required|date_format:"dd-mm-yyyy"',
        //     'topik_id' => ['required'],
        //     'deskripsi' => ['required', 'string', 'max:300'],
        // ],
        // [
        //     'nama_seminar.required'=>'Nama Seminar harus diisi',
        //     'waktu.required'=>'Waktu harus diisi',
        //     'topik_id.required'=>'Topik harus diisi',
        //     'deskripsi.required'=>'Deskripsi harus diisi',
        // ]); 
        $final=DB::transaction(function() use($request){
            $seminar = new Seminar();
            $seminar->nama_seminar = $request->nama_seminar;
            $seminar->waktu_mulai = $request->waktu_mulai;
            $seminar->waktu_selesai = $request->waktu_selesai;
            $seminar->topik_id = $request->topik_id;
            $seminar->deskripsi = $request->deskripsi;
            $seminar->durasi = $request->waktu_mulai;
    
            Seminar::create([
                'nama_seminar' => $request['nama_seminar'],
                'waktu_mulai' => $request['waktu_mulai'],
                'waktu_selesai' => $request['waktu_selesai'],
                'topik_id' => $request['topik_id'],
                'deskripsi' => $request['deskripsi'],
                // 'durasi' => $request['waktu_selesai']->Carbon::diffInHours($request['waktu_mulai']),
                'durasi' => ((new DateTime($request['waktu_selesai']))->diff(new DateTime($request['waktu_mulai'])))
                // ->format('%i' == 0 ? '%h jam' : ('%h'==0? '%i menit' : '%h jam %i menit') ),
                ->format('%h jam %i menit' ),
            ]);

            $pb = new SeminarUser();
            $pb->user_id = $request['pb'];
            $pb->sebagai = "Pembicara";
            $pb->seminar_id = $seminar->id_seminar;
            $pb->save();

            $py = new SeminarUser();
            $py->user_id = $request['py'];
            $py->sebagai = "Penyelenggara";
            $py->seminar_id = $seminar->id_seminar;
            $py->save();

            foreach($request->input('hidden_nama') as $key => $value) {
                $su = new SeminarUser();
                $su->user_id = $request->get('hidden_nama')[$key];
                $su->sebagai = $request->get('hidden_sebagai')[$key];
                $su->seminar_id = $seminar->id_seminar;
                $su->save();
            }
            
            return redirect('/seminar')->with('status','Data Seminar berhasil ditambah!');

        });
        return $final;
    }

    public function destroy(Seminar $seminar){
        Seminar::destroy($seminar->id_seminar);
        return redirect('/seminar')->with('status','Data Seminar berhasil dihapus!');
    }

    public function edit(Seminar $seminar){
        $topik = Topik::select('id_topik', 'nama_topik')->get();
        return view('seminar.edit', compact('seminar','topik'));
    }

    public function update(Request $request, Seminar $seminar){

        // $request->validate([
        //     'nama_seminar' => ['required', 'string', 'max:255'],
        //     'waktu' => 'required|date_format:"m-d-Y"',
        //     'topik_id' => ['required'],
        //     'desktripsi' => ['required', 'string', 'max:300'],
        // ],
        // [
        //     'nama_seminar.required'=>'Nama Seminar harus diisi',
        //     'waktu.required'=>'Waktu harus diisi',
        //     'topik_id.required'=>'Topik harus diisi',
        //     'deskripsi.required'=>'Deskripsi harus diisi',
        // ]);


        Seminar::where('id_seminar',$seminar->id_seminar)
        ->update([
            'nama_seminar' => $request['nama_seminar'],
            'waktu_mulai' => $request['waktu_mulai'],
            'waktu_selesai' => $request['waktu_selesai'],
            'topik_id' => ($request['topik_id']),
            'deskripsi' => $request['deskripsi'],
            // 'durasi' => $request['waktu_selesai']->Carbon::diffInHours($request['waktu_mulai']),
            // $dur = ((new DateTime($request['waktu_selesai']))->diff(new DateTime($request['waktu_mulai']))),
            'durasi' => ((new DateTime($request['waktu_selesai']))->diff(new DateTime($request['waktu_mulai'])))
            // (Condition)?(thing's to do if condition true):(thing's to do if condition false);
            // kalau abis : ada yang ? nya lagi berarti itu elseif nya ternary :) 
            // ->format(('%i' == 0 ? '%h jam' : ('%h' == 0 ? '%i menit' : ('%h jam %i menit' )))),
            ->format('%h jam %i menit'),
        ]);

        return redirect('/seminar')->with('status','Data Seminar berhasil diupdate!');

    }

    public function index(){
        $seminar = Seminar::all();
        // $topik = Topik::select('id_topik', 'nama_topik')->get();
        // return $topik;

        return view('seminar',['seminar'=>$seminar]);
    }

    
    ////////////////////////////API//////////////////////
    // function getAllSeminar(Request $request){
    //     $seminar = Seminar::all();
    //     return json_encode($seminar);
    // }

    // function getSeminarByTopik(Request $request, $id) {
    //     $hasil =  Seminar::where('topik_id', '=', $id)->get();
    //     return json_encode($hasil);
    // }

    // function getOneSeminar(Request $request, $id) {
    //     $hasil =  Seminar::where('id_seminar', '=', $id)->first();
    //     return json_encode($hasil);
    // }

    // function insertSeminar(Request $request){
    //     $temp = new Seminar;
    //     $temp->topik_id = $request->input('topik_id');
    //     $temp->nama_seminar = $request->input('nama_seminar');
    //     $temp->deskripsi = $request->input('deskripsi');
    //     $temp->waktu = $request->input('waktu');
    //     $temp->save();
    //     $result = array();
    //     $result["id"] =1;
    //     $result["message"] = 'Insert Successfull';
    //     return json_encode($result);
    // }

    // function updateSeminar(Request $request, $id){
    //     $temp= Seminar::where('id_seminar','=',$id)->first();
    //     $temp->topik_id = $request->input('topik_id');
    //     $temp->nama_seminar = $request->input('nama_seminar');
    //     $temp->deskripsi = $request->input('deskripsi');
    //     $temp->waktu = $request->input('waktu');
    //     $temp->update();
    //     $result = array();
    //     $result["id"] =1;
    //     $result["message"] = 'Update Successfull';
    //     return json_encode($result);
    // }
    // public function deleteSeminar($id) {
    //     $temp= Seminar::where('id_seminar','=',$id)->first();
    //     $temp->delete();
    //     $result = array();
    //     $result["id"] =1;
    //     $result["message"] = 'Delete Successfull';
    //     return json_encode($result);
    // }
}
