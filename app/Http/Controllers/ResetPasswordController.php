<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use App\Models\ResetPassword;
use CRUDBooster;
use Illuminate\Http\Request;
use Webpatser\Uuid\Uuid;
use DB;
class ResetPasswordController extends Controller
{
    public function forgot()
    {
        if (CRUDBooster::myId()) {
            return redirect(CRUDBooster::adminPath());
        }

        return view('backend.reset-password.request_password');
    }
    public function postForgot(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:'.'cms_users',
        ],[
            'email.exists' => 'Email tidak terdaftar',
        ]);
        $user = DB::table('cms_users')->where('email', g('email'))->first();
        $perusahaan = Perusahaan::findOrFail($user->perusahaan_id);
        $isexist = ResetPassword::where('user_id', $user->id)->active()->latest()->first();
        if($isexist){
            $isexist->update([
                'expired_date' => $isexist->created_at,
            ]);
        }
        $token = Uuid::generate(4)->string;
        $durasi_uuid = 10;
        $data['user_id'] = $user->id;
        $data['token'] = $token;
        $data['uuid'] = (string)Uuid::generate();
        $data['expired_date'] = now()->addMinutes($durasi_uuid);
        ResetPassword::insert($data);
        $dataEmail = collect([
            'url' => url('admin/reset-pass/'.$data['uuid']),
            'nama_pt' => $perusahaan->nama,
            'durasi' => $durasi_uuid.' Menit',
        ]);
        CRUDBooster::sendEmail(
            [
                'send_at' => now()->addSeconds(10),
                'to' => $user->email, 
                'data' => $dataEmail, 
                'template' => 'lupa_password_perusahaan'
            ]);

        CRUDBooster::insertLog(cbLang("log_forgot", ['email' => g('email'), 'ip' => $request->server('REMOTE_ADDR')]));

        return redirect()->route('getLogin')->with('message', cbLang("message_forgot_password"));
    }
    public function getReset($uuid)
    {
        
        $isexist = ResetPassword::where('uuid', $uuid)->active()->latest()->first();
        if($isexist){
            // dd($isexist->token);
            return redirect()->route('resetpass.token',[$isexist->token]);
            
        }else{
            $a['error'] = 'Link Expired silahkan request link baru';
            return view('backend.reset-password.reset_password', $a);
        }
        
    }
    public function getResetToken($token)
    {
        // dd($token);
        $userid = ResetPassword::where('token', $token)->active()->latest()->first();
        if (!$userid) {
            $a['error'] = 'Link Expired silahkan request link baru';
        }
        else{
            $userid->update([
                'isused' => $userid->isused+1,
            ]);
        }
        $a['token'] = $token;
        $a['user_id'] = $userid->user_id;
        return view('backend.reset-password.reset_password', $a);
    }
    public function postReset()
    {
        // dd(request()->all());
        if(g('new_password') == g('conf_password')){
            $pass = \Hash::make(g('new_password'));
            DB::table('cms_users')->where('id',g('user_id'))->update([
                'password' => $pass
            ]);
            ResetPassword::where('token',g('resettoken'))->update([
                'expired_date' => now(),
            ]);
            $data['successreset'] = 'Reset password berhasil, silahkan login kembali dengan password baru anda';
        }else{
            $data['errorreset'] = 'Reset password Gagal, konfirmasi password tidak sesuai';
        }
        return Redirect()->back()->with($data);
    }
}
