<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Agenda;
use App\Laporan;
use Carbon\Carbon;
use App\Pictures;
use DB;

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

    // DC024
    public function sendPushNotification($token, $notificationTitle, $notificationBody, $payloadTitle, $payloadMessage){
        if(trim($token) == ""  || trim($token) == "-")	return "Invalid device ID";

        $data = array(
                "to" => $token,
                "notification" => array(
                  "title" => $notificationTitle,
                  "body" => $notificationBody
                ),
                "data" => array(
                  "title" => $payloadTitle,
                  "message" => $payloadMessage
                )
            );
          $data_string = json_encode($data);

          $headers = array(
              'Authorization: key=AIzaSyB_Rw_acR4mYBJSDOYT3rSsBf5D1a12Zdc',
              'Content-Type: application/json'
          );

          $ch = curl_init();

          curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
          curl_setopt( $ch,CURLOPT_POST, true );
          curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
          curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
          curl_setopt( $ch,CURLOPT_POSTFIELDS, $data_string);

          $result = curl_exec($ch);

          curl_close ($ch);

          // $user = DB::table("users")
          //   ->where("android_token", $token)
          //   ->first();
          //
          // if(count($user) > 0) {
          //   $uName = $user->name;
          //   $uEmail = $user->email;
          // }
          // else {
          //   $uName = "-";
          //   $uEmail = "-";
          // }

          return $result;
    }

    public function sendPushNotification2(){
        $token = "f99t9jy_nOk:APA91bHREvNYF6Wu2n3uQSSw5Xy50WEgMouIHP5fox0RVUow6o_S3d0Tty5EqSp-f0wsvoiuIrbdvQohseTKQpXlf4sk-Z2efhPG3dk5bVUn1J0J9kAUGeCTntX8M_IGqXquOG5H8v5G";
        $notificationTitle = "dwedww";
        $notificationBody = "dwedww";
        $payloadTitle = "dwedww";
        $payloadMessage = "dwedww";

        if(trim($token) == ""  || trim($token) == "-")	return "Invalid device ID";

        $data = array(
                "to" => $token,
                "notification" => array(
                  "title" => $notificationTitle,
                  "body" => $notificationBody
                ),
                "data" => array(
                  "title" => $payloadTitle,
                  "message" => $payloadMessage
                )
            );
          $data_string = json_encode($data);

          $headers = array(
              'Authorization: key=AIzaSyB_Rw_acR4mYBJSDOYT3rSsBf5D1a12Zdc',
              'Content-Type: application/json'
          );

          $ch = curl_init();

          curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
          curl_setopt( $ch,CURLOPT_POST, true );
          curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
          curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
          curl_setopt( $ch,CURLOPT_POSTFIELDS, $data_string);

          $result = curl_exec($ch);

          curl_close ($ch);

          // $user = DB::table("users")
          //   ->where("android_token", $token)
          //   ->first();
          //
          // if(count($user) > 0) {
          //   $uName = $user->name;
          //   $uEmail = $user->email;
          // }
          // else {
          //   $uName = "-";
          //   $uEmail = "-";
          // }

          return $result;
    }

    public function kirimWoe(){
        $token = "fxCTO-iPXjM:APA91bE76EaBWru96eyK0RubhoKzJA6LiVyuWNawFGEWbdmNhVeTMd9DhPy-aYGfE38M1TQ25cWjviBN7ZzpRcisuiMRhU_g0UKf11e-hxr9zu0h7GVx70rlR5EVNe9lNEngVehn4aF-";
        $title = "dwewedwed";
        $message = "wfewefwe";

        define( 'API_ACCESS_KEY', 'AAAAfqVEU1s:APA91bEM5GPflT4Q4CoJQ4R4jQxcOFC1FZFkepHYjfPvQ0xng5GIogvQlpmSLAd73fcBEgtTyrHH0reTNX1AQP-VyXSwNEyXlE-WdiPVnncOMzN5RYoP0LHgGRI_ET861p9K-mrLHeyA' );
        $msg = array(
            "message"  => $message,
            "title"  => $title
        );
        $fields = array(
            'registration_ids' => array($token),
            'data'   => $msg
        );
        // echo response()->json($fields);
        // echo json_encode($fields, JSON_PRETTY_PRINT);
        $headers = array(
            'Authorization: key=' . API_ACCESS_KEY,
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch );
        curl_close( $ch );
        echo $result;
        return response()->json( $result );
    }

    public function store_job(Request $request){
        $agenda = Agenda::where('id', $request->agenda_id)->first();
        if(!$agenda){
            $user1 = User::where('id', $request->user_id_sasaran)->first();
            $android_token1 = $user1->android_token;

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

            // push notif to sales
            $notiiTitle = "FBI Sales";
            $notifBody = "Informasi dari Admin";
            $payloadTitle = "Pesan dari Admin";
            $payloadBody = "Anda Memiliki Job Baru Dari Admin, ".$request->nama_agenda;
            //sendPushNotification($android_token1, $notiiTitle, $notifBody, $payloadTitle, $payloadBody);

            return response()->json([
                'message' => 'true'
            ]);
        } else {
            $user2 = User::where('id', $request->user_id_sasaran)->first();
            $android_token2 = $user2->android_token;

            $agenda->user_id = $request->user_id;
            $agenda->user_id_sasaran = $request->user_id_sasaran;
            $agenda->nama_agenda = $request->nama_agenda;
            $agenda->alamat_tujuan = $request->alamat_tujuan;
            $agenda->nama_toko = $request->nama_toko;
            $agenda->telephone = $request->telephone;
            $agenda->lokasi = $request->lokasi;
            $agenda->tanggal = $request->tanggal;
            $agenda->save();

            // push notif to sales
            $notiiTitle = "FBI Sales";
            $notifBody = "Informasi FBI Sales";
            $payloadTitle = "Pesan dari Admin";
            $payloadBody = "Anda Memiliki Job Baru, ".$request->nama_agenda;
            //sendPushNotification($android_token2, $notiiTitle, $notifBody, $payloadTitle, $payloadBody);

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
                User::where('email', $request->email)->update(array(
                    "android_token" => $request->fcm_token
                ));
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
        $agendas = Agenda::where('user_id_sasaran', $request->id)->where('status', 'active')->get();
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
        } elseif ($agendas->isEmpty()) {
              return response()->json([
                  'success' => true,
                  'payload' => null
              ]);
        }
         else {
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

            Agenda::where('id', $request->job_id)->update(array(
                "status" => "done"
            ));

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
