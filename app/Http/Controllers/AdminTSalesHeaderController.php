<?php namespace App\Http\Controllers;

	use Request;
	use DB;
	use CRUDBooster;
	use App\Imports\PenjualanImport;

	class AdminTSalesHeaderController extends \crocodicstudio\crudbooster\controllers\CBController {

	    public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field = "id";
			$this->limit = "20";
			$this->orderby = "id,desc";
			$this->global_privilege = false;
			$this->button_table_action = true;
			$this->button_bulk_action = true;
			$this->button_action_style = "button_icon";
			$this->button_add = true;
			$this->button_edit = true;
			$this->button_delete = true;
			$this->button_detail = true;
			$this->button_show = true;
			$this->button_filter = true;
			$this->button_import = false;
			$this->button_export = true;
			$this->table = "t_penjualan";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] = ["label"=>"ID","name"=>"id"];
			$this->col[] = ["label"=>"Date","name"=>"date", "callback" => function($row){
				$date = date_format(date_create($row->date), "d-M-Y");
				return $date;
			}];
			$this->col[] = ["label"=>"Item","name"=>"item"];
			$this->col[] = ["label"=>"Qty","name"=>"qty"];
			$this->col[] = ["label"=>"Total","name"=>"total", "callback" => function($row){
				$tot = "Rp. " . number_format($row->total);
				return $tot;
			}];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
			$this->form[] = ['label'=>'Date','name'=>'date','type'=>'date','validation'=>'required','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Total','name'=>'total','type'=>'money','validation'=>'required','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Item','name'=>'item','type'=>'text','validation'=>'required','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'QTY','name'=>'qty','type'=>'number','validation'=>'required|integer','width'=>'col-sm-10'];


			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ["label"=>"Code","name"=>"code","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Total Price","name"=>"total_price","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Total Item","name"=>"total_item","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
			//$this->form[] = ["label"=>"Status","name"=>"status","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			# OLD END FORM

			/* 
	        | ---------------------------------------------------------------------- 
	        | Sub Module
	        | ----------------------------------------------------------------------     
			| @label          = Label of action 
			| @path           = Path of sub module
			| @foreign_key 	  = foreign key of sub table/module
			| @button_color   = Bootstrap Class (primary,success,warning,danger)
			| @button_icon    = Font Awesome Class  
			| @parent_columns = Sparate with comma, e.g : name,created_at
	        | 
	        */
	        $this->sub_module = array();


	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add More Action Button / Menu
	        | ----------------------------------------------------------------------     
	        | @label       = Label of action 
	        | @url         = Target URL, you can use field alias. e.g : [id], [name], [title], etc
	        | @icon        = Font awesome class icon. e.g : fa fa-bars
	        | @color 	   = Default is primary. (primary, warning, succecss, info)     
	        | @showIf 	   = If condition when action show. Use field alias. e.g : [id] == 1
	        | 
	        */
	        $this->addaction = array();


	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add More Button Selected
	        | ----------------------------------------------------------------------     
	        | @label       = Label of action 
	        | @icon 	   = Icon from fontawesome
	        | @name 	   = Name of button 
	        | Then about the action, you should code at actionButtonSelected method 
	        | 
	        */
	        $this->button_selected = array();

	                
	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add alert message to this module at overheader
	        | ----------------------------------------------------------------------     
	        | @message = Text of message 
	        | @type    = warning,success,danger,info        
	        | 
	        */
	        $this->alert        = array();
	                

	        
	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add more button to header button 
	        | ----------------------------------------------------------------------     
	        | @label = Name of button 
	        | @url   = URL Target
	        | @icon  = Icon from Awesome.
	        | 
	        */
	        $this->index_button = array();
			$this->index_button[] = ['label'=>'Import Data','url'=>action('AdminTSalesHeaderController@getImportXls'),'icon'=>'fa fa-upload'];


	        /* 
	        | ---------------------------------------------------------------------- 
	        | Customize Table Row Color
	        | ----------------------------------------------------------------------     
	        | @condition = If condition. You may use field alias. E.g : [id] == 1
	        | @color = Default is none. You can use bootstrap success,info,warning,danger,primary.        
	        | 
	        */
	        $this->table_row_color = array();     	          

	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | You may use this bellow array to add statistic at dashboard 
	        | ---------------------------------------------------------------------- 
	        | @label, @count, @icon, @color 
	        |
	        */
	        $this->index_statistic = array();



	        /*
	        | ---------------------------------------------------------------------- 
	        | Add javascript at body 
	        | ---------------------------------------------------------------------- 
	        | javascript code in the variable 
	        | $this->script_js = "function() { ... }";
	        |
	        */
	        $this->script_js = NULL;

            /*
	        | ---------------------------------------------------------------------- 
	        | Include HTML Code before index table 
	        | ---------------------------------------------------------------------- 
	        | html code to display it before index table
	        | $this->pre_index_html = "<p>test</p>";
	        |
	        */
	        $this->pre_index_html = null;
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include HTML Code after index table 
	        | ---------------------------------------------------------------------- 
	        | html code to display it after index table
	        | $this->post_index_html = "<p>test</p>";
	        |
	        */
	        $this->post_index_html = null;
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include Javascript File 
	        | ---------------------------------------------------------------------- 
	        | URL of your javascript each array 
	        | $this->load_js[] = asset("myfile.js");
	        |
	        */
	        $this->load_js = array();
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Add css style at body 
	        | ---------------------------------------------------------------------- 
	        | css code in the variable 
	        | $this->style_css = ".style{....}";
	        |
	        */
	        $this->style_css = NULL;
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include css File 
	        | ---------------------------------------------------------------------- 
	        | URL of your css each array 
	        | $this->load_css[] = asset("myfile.css");
	        |
	        */
	        $this->load_css = array();
	        
	        
	    }


	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for button selected
	    | ---------------------------------------------------------------------- 
	    | @id_selected = the id selected
	    | @button_name = the name of button
	    |
	    */
	    public function actionButtonSelected($id_selected,$button_name) {
	        //Your code here
	            
	    }


	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate query of index result 
	    | ---------------------------------------------------------------------- 
	    | @query = current sql query 
	    |
	    */
	    public function hook_query_index(&$query) {
	        //Your code here
	            
	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate row of index table html 
	    | ---------------------------------------------------------------------- 
	    |
	    */    
	    public function hook_row_index($column_index,&$column_value) {	        
	    	//Your code here
	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate data input before add data is execute
	    | ---------------------------------------------------------------------- 
	    | @arr
	    |
	    */
	    public function hook_before_add(&$postdata) {        
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after add public static function called 
	    | ---------------------------------------------------------------------- 
	    | @id = last insert id
	    | 
	    */
	    public function hook_after_add($id) {        
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate data input before update data is execute
	    | ---------------------------------------------------------------------- 
	    | @postdata = input post data 
	    | @id       = current id 
	    | 
	    */
	    public function hook_before_edit(&$postdata,$id) {        
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after edit public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_after_edit($id) {
	        //Your code here 

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command before delete public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_before_delete($id) {
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after delete public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_after_delete($id) {
	        //Your code here

	    }


		public function getImportXls() {
	    	return view('backend.penjualan.penjualan_import');
		}
		public function postImportXls() {
	    	ini_set('memory_limit', '256M');
	    	set_time_limit(1000);
	    	$file = Request::file('userfile');
	    	$file->move(public_path('import'),$file->getClientOriginalName());
			$dataimport = \Maatwebsite\Excel\Facades\Excel::toArray(new PenjualanImport, public_path('import/'.$file->getClientOriginalName()));
			$no = 1;
			$isstart = 0;
			$dataPenjualan = [];
			$dataPengeluaran = [];
			try {
				foreach($dataimport[0] as $row) {
					if($row[0] == "TANGGAL"){
						$isstart = 1;
						continue;
					}
					if($isstart){
						if(trim($row[0]) != ""){
							$tmp["date"] = date("Y-m-d", strtotime($row[0]));
							$tmp["item"] = str_replace(["&","%","$","#"],"",trim($row[1]));
							$tmp["qty"] = $row[2];
							$tmp["total"] = intval(str_replace(["IDR",","], "", $row[3]));
							array_push($dataPenjualan, $tmp);
						}
					}
				}
				foreach($dataimport[1] as $row) {
					if($row[0] == "TANGGAL"){
						$isstart = 1;
						continue;
					}
					if($isstart){
						if(trim($row[0]) != ""){
							$tmp["date"] = date("Y-m-d", strtotime($row[0]));
							$tmp["item"] = str_replace(["&","%","$","#"],"",trim($row[1]));
							$tmp["qty"] = $row[2];
							$tmp["total"] = intval(str_replace(["IDR",","], "", $row[3]));
							array_push($dataPengeluaran, $tmp);
						}
					}
				}
				DB::table("t_penjualan")->insert($dataPenjualan);
				DB::table("t_pengeluaran")->insert($dataPengeluaran);
				return Redirect()->back()->with([
					'data' => count($dataPenjualan),
					'total' => count($dataPenjualan),
					'totalpengeluaran' => count($dataPengeluaran)
				]);

			} catch (\Illuminate\Database\QueryException $ex) {
				return Redirect()->back()->with([
					'error' => $ex,
					'msg' => "Error saat upload!"]);
			}
			
		}
	    //By the way, you can still create your own method in here... :) 


	}