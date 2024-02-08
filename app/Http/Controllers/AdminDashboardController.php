<?php namespace App\Http\Controllers;

	use App\Services\DashboardService;
	use Session;
	use Request;
	use DB;
	use CRUDBooster;

	class AdminDashboardController extends \crocodicstudio\crudbooster\controllers\CBController {

		public function getIndex()
		{
			$data["title"] = "Dashboard Kopilibrasi";
			$data["dataBar"] = $this->getDataBar();
			$data["dataTotal"] = $this->getTotal();
			return view('backend.dashboard.index', $data);
		}
		public function getDataBar(){
			$penjualan = DB::table('t_penjualan')->selectRaw("date, sum(total) as total")
							->groupBy("date")->get();
			$labels = [];
			$datas = [];
			foreach ($penjualan as $key => $value) {
				$value->date = date("d M Y", strtotime($value->date));
				array_push($labels, $value->date);
				array_push($datas, $value->total);
			}
			$data["penjualan"]["labels"] = $labels;
			$data["penjualan"]["datas"] = $datas;
			$data["pengeluaran"] = [""];
			return $data;
		}
		public function getTotal(){

			$data['penjualan'] = DB::table('t_penjualan')->selectRaw("sum(total) as total")->first();
			$data['pengeluaran'] = DB::table('t_pengeluaran')->selectRaw("sum(total) as total")->first();
			return $data;
		}
	}