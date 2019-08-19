<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Agenda;
use App\Laporan;
use Carbon\Carbon;
use App\Pictures;

class UserController extends Controller
{

    public function index(){
        return view('user_management');
    }

    public function laporan(){
        return view('laporan');
    }

    public function job_management(){
        return view('job_management');
    }

    public function list_sales(){
        $user = User::where('role', 1)->paginate(10);
        return response($user, 200);
    }

    public function list_sales_outpage(){
        $user = User::where('role', 1)->get();
        return response($user, 200);
    }

    public function update(Request $request){
        $user = User::where('id', $request->id)->first();
        $user->identitas = $request->identitas;
        $user->name = $request->name;
        $user->alamat = $request->alamat;
        $user->email = $request->email;
        $user->no_hp = $request->no_hp;
        $user->save();
        return response()->json([
            'message' => 'success'
        ]);
    }

    public function store(Request $request){
        $user = User::where('email', $request->email)->first();
        if($user) {
            return response()->json([
                'message' => 'fails'
            ]);
        } else {
            $user = new User;
            $user->identitas = $request->identitas;
            $user->name = $request->name;
            $user->alamat = $request->alamat;
            $user->email = $request->email;
            $user->no_hp = $request->no_hp;
            $user->password = bcrypt($request->password);
            $user->save();
            return response()->json([
                'message' => 'success'
            ]);
        }
    }

    public function delete(Request $request){
        User::where('id', $request->id)->delete();
        return response()->json([
            'message' => 'success'
        ]);
    }

    public function search(Request $request){
        $users = User::where('name', 'LIKE', '%'.$request->search.'%')->orWhere('email', 'LIKE','%'.$request->search.'%')->orWhere('no_hp', 'LIKE', '%'.$request->search.'%')->get();
        return response()->json(
            $users
        );
    }

    public function getJob(Request $request){
        $agenda = Agenda::where('user_id_sasaran', $request->id)->get();
        return response()->json([
            'message' => 'true',
            'data' => $agenda
        ]);
    }

    public function store_job(Request $request){
        $agenda = Agenda::where('id', $request->agenda_id)->first();
        if(!$agenda){
            $agenda = new Agenda;
            $agenda->user_id = $request->user_id;
            $agenda->user_id_sasaran = $request->user_id_sasaran;
            $agenda->nama_agenda = $request->nama_agenda;
            $agenda->alamat_tujuan = $request->alamat_tujuan;
            $agenda->nama_toko = $request->nama_toko;
            $agenda->telephone = $request->telephone;
            $agenda->lokasi = $request->lokasi;
            $agenda->tanggal = $request->tanggal;
            $agenda->save();
            return response()->json([
                'message' => 'true'
            ]);
        } else {
            $agenda->user_id = $request->user_id;
            $agenda->user_id_sasaran = $request->user_id_sasaran;
            $agenda->nama_agenda = $request->nama_agenda;
            $agenda->alamat_tujuan = $request->alamat_tujuan;
            $agenda->nama_toko = $request->nama_toko;
            $agenda->telephone = $request->telephone;
            $agenda->lokasi = $request->lokasi;
            $agenda->tanggal = $request->tanggal;
            $agenda->save();
            return response()->json([
                'message' => 'true'
            ]);
        }
    }

    public function delete_job(Request $request){
        Agenda::where('id', $request->agenda_id)->delete();
        return response()->json([
            'message' => 'true'
        ]);
    }

    //Semua API di bawah ini
    public function login(Request $request){
        $user = User::where('email',$request->email)->where('role','!=',3)->first();

        if($user){
            if(Hash::check($request->password, $user->password)){
                $var['id'] = $user->id;
                return response()->json([
                    'success' => true,
                    'payload' => $var
                ], 200);
            }else{
                $var['code'] = 401;
                $var['message'] = 'Invalid Username or Password';
                return response()->json([
                    'success' => false,
                    'payload' => $var
                ], 401);
            }
        } else {
            $var['code'] = 401;
            $var['message'] = 'User '. $request->email .' Not Found';
            return response()->json([
                'success' => false,
                'payload' => $var
            ], 401);
        }
    }

    public function profile(Request $request){
        $user = User::where('id', $request->id)->first();
        if($user){
            $var['email'] = $user->email;
            $var['fullname'] = $user->name;
            $var['address'] = $user->alamat;
            $var['phone'] = $user->no_hp;
            return response()->json([
                'success' => true,
                'payload' => $var
            ], 200);
        } else {
            $var['code'] = 401;
            $var['message'] = 'User Not Found';
            return response()->json([
                'success' => false,
                'payload' => $var
            ], 401);
        }
    }

    public function job_active_all(Request $request){
        $agendas = Agenda::where('user_id_sasaran', $request->id)->get();
        $var= array();
        if(!$agendas->isEmpty()){
            foreach($agendas as $agenda){
                    $jobs['job_id'] = $agenda->id;
                    $jobs['job_description'] = $agenda->nama_agenda;
                    $jobs['shop_name'] = $agenda->nama_toko;
                    $jobs['shop_address'] = $agenda->lokasi;
                    $jobs['shop_phone'] = $agenda->telephone;
                    $var[] = $jobs;
            }
            return response()->json([
                'success' => true,
                'payload' => array('jobs' => $var)
            ]);
        } else {
            $var['code'] = 401;
            $var['message'] = 'User Not Found';
            return response()->json([
                'success' => false,
                'payload' => $var
            ], 401);
        }
    }

    public function job_active(Request $request){
        $agendas = Agenda::where('id', $request->id)->get();
        $var= array();
        if(!$agendas->isEmpty()){
            foreach($agendas as $agenda){
                if($agenda->laporan->status == 'selesai'){
                    $jobs['job_id'] = $agenda->id;
                    $jobs['job_description'] = $agenda->nama_agenda;
                    $jobs['shop_name'] = $agenda->nama_toko;
                    $jobs['shop_address'] = $agenda->lokasi;
                    $jobs['shop_phone'] = $agenda->telephone;
                    $var[] = $jobs;
                } else {
                    $var['code'] = 200;
                    $var['message'] = 'Belum ada pekerjaan yang sudah selesai';
                    return response()->json([
                        'success' => true,
                        'payload' => $var
                    ], 401);
                }
            }
            return response()->json([
                'success' => true,
                'payload' => array('jobs' => $var)
            ]);
        } else {
            $var['code'] = 401;
            $var['message'] = 'User Not Found';
            return response()->json([
                'success' => false,
                'payload' => $var
            ], 401);
        }
    }

    public function list_report_recent(){
        $laporan = Laporan::where('tanggal_kerjakan', '>=',Carbon::now()->subDays(3)->toDateTimeString())->get();
        $data = array();
        foreach($laporan as $lapor){
            $var['id'] = $lapor->id;
            $var['agenda'] = $lapor->agenda->nama_agenda;
            $var['description'] = $lapor->agenda->description;
            $var['alamat_tujuan'] = $lapor->agenda->alamat_tujuan;
            $var['nama_toko'] = $lapor->agenda->nama_toko;
            $var['telephone'] = $lapor->agenda->telephone;
            $var['lokasi'] = $lapor->agenda->lokasi;
            $var['lokasi_laporan'] = $lapor->lokasi_laporan;
            $var['tanggal'] = strftime("%A, %e %B %Y", strtotime($lapor->agenda->tanggal));
            $var['ttd_client'] = $lapor->ttd_client;
            $data[] = $var;
        }
        return response()->json([
            'message' => true,
            'data' => $data
        ]);
    }

    public function list_report_previous(){
        $laporan = Laporan::where('tanggal_kerjakan', '<=',Carbon::now()->subDays(3)->toDateTimeString())->get();
        $data = array();
        foreach($laporan as $lapor){
            $var['id'] = $lapor->id;
            $var['agenda'] = $lapor->agenda->nama_agenda;
            $var['description'] = $lapor->agenda->description;
            $var['alamat_tujuan'] = $lapor->agenda->alamat_tujuan;
            $var['nama_toko'] = $lapor->agenda->nama_toko;
            $var['telephone'] = $lapor->agenda->telephone;
            $var['lokasi'] = $lapor->agenda->lokasi;
            $var['lokasi_laporan'] = $lapor->lokasi_laporan;
            $var['tanggal'] = strftime("%A, %e %B %Y", strtotime($lapor->agenda->tanggal));
            $var['ttd_client'] = "http://127.0.0.1:8000/img/ttd/".$lapor->ttd_client;
            $data[] = $var;
        }
        return response()->json([
            'message' => true,
            'data' => $data
        ]);
    }

    public function report_send(Request $request){
        $laporan = new Laporan;
        $picture = new Pictures;

        if(!empty($request->proof_image)){
            $laporan->id_agenda = $request->job_id;
    
            $laporan->lokasi_laporan = $request->location;
            $laporan->tanggal_kerjakan = date('Y-m-d H:i:s');
            $laporan->description = $request->description;
            $laporan->status = 'selesai';
            $laporan->save();
            
            $picture->laporan_id = $laporan->id;

            $file = $request->proof_image;
            $imageName = $laporan->lokasi_laporan.sha1(time()) . "." . $file->getClientOriginalExtension();
            $file->move("img/laporan", $imageName);
            $picture->foto = $imageName;
            $picture->save();

            if($laporan->save() && $picture->save()){
                return response()->json([
                    'success' => true,
                ]);
            } else {
                $var['code'] = 401;
                $var['message'] = 'Something Wrong!';
                return response()->json([
                    'success' => false,
                    'payload' => $var
                ], 401);
            }
        } else {
            $var['code'] = 401;
            $var['message'] = "Image doesn't available";
            return response()->json([
                'success' => false,
                'payload' => $var
            ], 401);
        }
    }

    public function report_all(Request $request){
        $agenda = Agenda::where('user_id_sasaran', $request->id)->pluck('id')->toArray();
        $laporan = Laporan::whereIn('id_agenda', $agenda)->get();

        $var = array();
        if(!$laporan->isEmpty()){
            foreach($laporan as $report){
                $laporanId = Laporan::where('id_agenda', $report->id_agenda)->get();
                foreach($laporanId as $lapor){
                    $picture = Pictures::where('laporan_id', $lapor->id)->first();
                }
                $jobs['job_id'] = $report->id_agenda;
                $jobs['report_id'] = $report->id;
                $jobs['proof_image'] = $picture->foto;
                $jobs['location'] = $report->lokasi_laporan;
                $jobs['status'] = $report->status;
                $jobs['description'] = $report->description;
                $jobs['created_at'] = $report->created_at;
                $var[] = $jobs;
            }
            return response()->json([
                'success' => true,
                'payload' => array('reports' => $var)
            ]);
        } else {
            $var['code'] = 401;
            $var['message'] = 'User Not Found';
            return response()->json([
                'success' => false,
                'payload' => $var
            ], 401);
        }
    }

    public function report_id(Request $request){
        $laporan = Laporan::where('id_agenda', $request->report_id)->get();
        $var = array();
        if(!$laporan->isEmpty()){
            foreach($laporan as $report){
                $jobs['job_id'] = $report->id_agenda;
                $jobs['report_id'] = $report->id;
                $jobs['proof_image'] = Pictures::where('laporan_id', $report->id)->pluck('foto');
                $jobs['location'] = $report->lokasi_laporan;
                $jobs['status'] = $report->status;
                $jobs['description'] = $report->description;
                $jobs['created_at'] = Carbon::parse($report->created_at)->format('d-m-Y H:i:s');
                $var[] = $jobs;
            }
            return response()->json([
                'success' => true,
                'payload' => $var
            ]);
        } else {
            $var['code'] = 401;
            $var['message'] = 'User Not Found';
            return response()->json([
                'success' => false,
                'payload' => $var
            ], 401);
        }
    }

    public function get_foto(Request $request){
        $pictures = Pictures::where('laporan_id',$request->laporan_id)->get();
        return response()->json([
            'success' => true,
            'data' => $pictures
        ]);
    }

    public function list_report_search(Request $request){
        //TODO : Fitur Search by Agenda
        $agenda = Agenda::where('nama_agenda', 'LIKE','%'.$request->search.'%')->get();
        foreach($agenda as $kerja){
            $var['id'] = $kerja->laporan->id;
            $var['agenda'] = $kerja->nama_agenda;
            $var['description'] = $kerja->description;
            $var['alamat_tujuan'] = $kerja->alamat_tujuan;
            $var['nama_toko'] = $kerja->nama_toko;
            $var['telephone'] = $kerja->telephone;
            $var['lokasi'] = $kerja->lokasi;
            $var['lokasi_laporan'] = $kerja->laporan->lokasi_laporan;
            $var['tanggal'] = $kerja->tanggal;
            $var['ttd_client'] = "http://127.0.0.1:8000/img/ttd/".$kerja->laporan->ttd_client;
            $data[] = $var;
        }
        return response()->json([
            'message' => true,
            'data' => $data
        ]);
    }

    public function simpleApi(){
        // return response()->json([
        //     'message' => 'oke'
        // ]);
        // dd(date("Y-m-d") <= "2019-06-03");
    }

}
