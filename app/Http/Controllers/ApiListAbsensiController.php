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
				$data = DB::table('t_absensi')
				->select([
					't_absensi.*',
					'm_employee.name'])
				->leftjoin("m_employee", "t_absensi.employee_id", "=", "m_employee.id")
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