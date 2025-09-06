<?php namespace App\Http\Controllers;

		use Session;
		use Request;
		use DB;
		use CRUDBooster;

		class ApiQrAbsenController extends \crocodicstudio\crudbooster\controllers\ApiController {

		    function __construct() {
				$this->table       = "cms_settings";
				$this->permalink   = "qr_absen";
				$this->method_type = "get";
		    }


		    public function hook_before(&$postdata) {
		        //This method will be execute before run the main process
				$result["api_status"] = 0;
				$result["api_message"] = "Error";
				if($postdata["device_id"] == null || $postdata["device_id"] == ""){
					$result["api_message"] = "Anda bukan admin";
				}else{
					$employee = DB::table('m_employee')->where("device_id", $postdata["device_id"])->first();

					if($employee != null && $employee->is_admin == 1){
						$tokenhash = rand(100000, 999999);
						DB::table("cms_settings")->where("name", "absensi_token")->update([
							"content" => $tokenhash
						]);
						$result["api_status"] = 1;
						$result["api_message"] = "Success get token";
						$result["data"] = [
							"token" => $tokenhash
						];
					}else{
						$result["api_message"] = "Anda bukan admin";
					}
				}
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
