<?php namespace App\Http\Controllers;

		use Session;
		use Request;
		use DB;
		use CRUDBooster;

		class ApiSubmitAbsenController extends \crocodicstudio\crudbooster\controllers\ApiController {

		    function __construct() {
				$this->table       = "t_absensi";
				$this->permalink   = "submit_absen";
				$this->method_type = "get";
		    }


		    public function hook_before(&$postdata) {
		        //This method will be execute before run the main process
				$result["api_status"] = 0;
				$result["api_message"] = "Error";
				$data = [];
				$type = [
					"checkin" => "Masuk",
					"checkout" => "Pulang",
				];
				$date = date("Y-m-d");
				$dateYesterday = date('Y-m-d',strtotime("-1 days"));
				$time = date("H:i:s");
				$dataInsert = [];
				$idEmployee = null;
				$tokenNow = DB::table("cms_settings")->where("name", "absensi_token")->first();
                $idEmployee = DB::table('m_employee')->where("device_id", $postdata["device_id"])->first();
                if(env('APP_DEBUG', true)){
                        \Log::info('SubmitAbsenController - Incoming postdata:', $postdata);
                        \Log::info('SubmitAbsenController - Found employee:', (array) $idEmployee);
                        dd([
                            $postdata,
                            $idEmployee
                        ]);
                    }
				if($tokenNow == null || $tokenNow->content == "" || $postdata["token"] != $tokenNow->content){
					$result["api_message"] = "Error, QR Code tidak valid";
					response() -> json($result) -> send();
					exit();
				}
				if($postdata["password"] != null && $postdata["password"] != ""){
					$idEmployee = DB::table('m_employee')->where("password", $postdata["password"])->first();
					if($idEmployee == null){
						$result["api_status"] = 0;
						$result["api_message"] = "Error, password salah";

						response() -> json($result) -> send();
						exit();
					}else{
						DB::table('m_employee')->where("id", $idEmployee->id)->update([
							'device_id' => $postdata["device_id"],
						]);
					}
				}
				if($postdata["device_id"] != null && $postdata["device_id"] != ""){
					$idEmployee = DB::table('m_employee')->where("device_id", $postdata["device_id"])->first();
					if($idEmployee == null){
						// DB::table('m_employee')->insert([
						// 	'device_id' => $idEmployee->device_id,
						// 	'name' => $idEmployee->name,
						// 	'status' => "ACTIVE",
						// 	'is_admin' => 0,
						// ]);
						// $idEmployee = DB::table('m_employee')->where("device_id", $postdata["device_id"])->first();
						$result["api_status"] = 0;
						$result["api_message"] = "Silahkan hubungi admin utk register akun";

						response() -> json($result) -> send();
						exit();
					}
				}else{
					$result["api_status"] = 0;
					$result["api_message"] = "Error something wrong";

					response() -> json($result) -> send();
					exit();
				}

				if($postdata["type"] == "checkin"){
					$checkin = DB::table('t_absensi')
					->where('employee_id', $idEmployee->id)
					->whereIn("checkin_date", [$date, $dateYesterday])
					->where("checkout_date", null)
					->orderBy('id', 'desc')->first();

					if($checkin != null){
						$result["api_status"] = 0;
						$result["api_message"] = "Maaf, Anda sudah melakukan checkin";
						response() -> json($result) -> send();
						exit();
					}
					$dataInsert = [
						'employee_id' => $idEmployee->id,
						'checkin_date' => $date,
						'checkin_time' => $time,
						'lembur' => 0
					];
					DB::table('t_absensi')->insert($dataInsert);
					$tokenhash = rand(100000, 999999);
					DB::table("cms_settings")->where("name", "absensi_token")->update([
						"content" => $tokenhash
					]);
				}

				if($postdata["type"] == "checkout"){
					$lembur = 0;
					$hours = "0:00";
					$lastcheckin = DB::table('t_absensi')
					->where('employee_id', $idEmployee->id)
					->whereIn("checkin_date", [$date, $dateYesterday])
					->where("checkout_date", null)
					->orderBy('id', 'desc')->first();
					if($lastcheckin != null){
						$lembursetting = DB::table("cms_settings")->where("name", "jam_pulang")->first();
						// $from_time = strtotime($lastcheckin->checkin_date . " " . $lastcheckin->checkin_time);
						$from_time = strtotime($lastcheckin->checkin_date . " " . $lembursetting->content);
						$to_time = strtotime($date . " " . $time);
						$isLembur = $to_time > $from_time ? 1 : 0;
						if($isLembur > 0){
							$diffLembur = round(abs($to_time - $from_time) / 60,2);

							$hours = intdiv($diffLembur, 60).':'. (($diffLembur % 60) < 10 ? '0'.($diffLembur % 60) : ($diffLembur % 60));
							$lembur = $diffLembur;
						}

						$dataInsert = [
							'employee_id' => $idEmployee->id,
							'checkout_date' => $date,
							'checkout_time' => $time,
							'lembur' => $lembur,
							"lembur_hour" => $hours
						];
						DB::table('t_absensi')
						->where('id', $lastcheckin->id)->update($dataInsert);
						$tokenhash = rand(100000, 999999);
						DB::table("cms_settings")->where("name", "absensi_token")->update([
							"content" => $tokenhash
						]);
					}
				}

				if(count($dataInsert) > 0){
					$result["api_status"] = 1;
					$result["api_message"] = "Anda berhasil melakukan absen " . $type[$postdata["type"]];
				}else{
					$result["api_status"] = 0;
					$result["api_message"] = "Gagal absen coba lagi nanti";
				}
				$result["data"] = $data;
				response() -> json($result) -> send();
				exit();
		    }

		    public function hook_query(&$query) {
		        //This method is to customize the sql query

		    }

		    public function hook_after($postdata,&$result) {
		        //This method will be execute after run the main process

		    }

		}
