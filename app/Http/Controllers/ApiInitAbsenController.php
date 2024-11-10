<?php namespace App\Http\Controllers;

use Session;
		use Request;
		use DB;
		use CRUDBooster;

		class ApiInitAbsenController extends \crocodicstudio\crudbooster\controllers\ApiController {

		    function __construct() {    
				$this->table       = "t_absensi";        
				$this->permalink   = "init_absen";    
				$this->method_type = "get";    
		    }
		

		    public function hook_before(&$postdata) {
		        //This method will be execute before run the main process
				$date = date("Y-m-d");
				$time = date("H:i:s");
				$dateYesterday = date('Y-m-d',strtotime("-1 days"));
				$message = "";
				$data = [];
				if($postdata["device_id"] != null && $postdata["device_id"] != ""){
					$idEmployee = DB::table('m_employee')->where("device_id", $postdata["device_id"])->first();
					if($idEmployee == null){
						$message = "Device anda belum terdaftar, silahkan minta password pada admin";
						$data["id"] = 0;
						$result["data"] = $data;
					}else{
						
						$message = "Selamat datang kembali, ".$idEmployee->name;
						$lastAbsen = DB::table('t_absensi')
						->where("employee_id", $idEmployee->id)
						->whereIn("checkin_date", [$date, $dateYesterday])
						->orderBy("id", "desc")
						->first();
						
						if($lastAbsen->checkout_time != null && $lastAbsen->checkout_time != ""){
							$lastAbsen = DB::table('t_absensi')
								->where("employee_id", $idEmployee->id)
								->whereIn("checkin_date", [$date])
								->orderBy("id", "desc")
								->first();
						}
						$data = [
							"is_admin" => $idEmployee->is_admin ?? "",
							"name" => $idEmployee->name,
							"id" => $idEmployee->id,
							"checkin_date" => ($lastAbsen != null) ? trim($lastAbsen->checkin_date . " " . $lastAbsen->checkin_time) : "",
							"checkout_date" => ($lastAbsen != null) ? trim($lastAbsen->checkout_date . " " . $lastAbsen->checkout_time) : "", 	
							"lembur_hour" => ($lastAbsen != null) ? trim($lastAbsen->lembur_hour) : "",
							"lembur" => ($lastAbsen != null) ? $lastAbsen->lembur : ""
						];
						$result["data"] = $data;
					}
					$result["api_status"] = 1;
					$result["api_message"] = $message;
				}else{
					$result["api_status"] = 0;
					$result["api_message"] = "Error, Device tidak support";
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