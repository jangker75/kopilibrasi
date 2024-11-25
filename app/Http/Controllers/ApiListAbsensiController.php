<?php namespace App\Http\Controllers;

		use Session;
		use Request;
		use DB;
		use CRUDBooster;

		class ApiListAbsensiController extends \crocodicstudio\crudbooster\controllers\ApiController {

		    function __construct() {    
				$this->table       = "t_absensi";        
				$this->permalink   = "list_absensi";    
				$this->method_type = "get";    
		    }
		

		    public function hook_before(&$postdata) {
		        //This method will be execute before run the main process
				$result["api_status"] = 1;
				$result["api_message"] = "success";
				$employeeId = 0;
				if($postdata['employee_name'] != "" ){
					$employee = DB::table('m_employee')->where("name", "like", "%".$postdata['employee_name']."%")->first();
					$employeeId = $employee->id;
				}
				$data = DB::table('t_absensi')
				->select([
					't_absensi.*',
					'm_employee.name'])
				->leftjoin("m_employee", "t_absensi.employee_id", "=", "m_employee.id");
				if($postdata['checkin_date_from'] != ""){
					$data = $data->whereBetween("checkin_date", [$postdata['checkin_date_from'], $postdata['checkin_date_to']]);
				}
				if($postdata['employee_name'] != "" ){
					$data = $data->where("t_absensi.employee_id", $employeeId);
				}
				$data = $data->orderBy("id","desc")
				->get();
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