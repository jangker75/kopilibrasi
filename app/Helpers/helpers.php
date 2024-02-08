<?php namespace App\Helpers;

use App\Exports\DefaultExport;
use App\Models\SettingApps;
use DB;
use crocodicstudio\crudbooster\helpers\CRUDBooster;
use Illuminate\Support\Facades\App;
use Maatwebsite\Excel\Facades\Excel;

class MyHelper {

    public function dataSettingApp(){
        $data = SettingApps::first();
        return $data;
    }

    public static function getPerusahaanId(){
        $id = CRUDBooster::myId();
        $pid = DB::table('cms_users')->where('id',$id)->first();
        return $pid->perusahaan_id;
    }
    public static function noImage()
    {
        $image = asset('assets/no-image.png');
        return $image;
    }

	public function isAdmin()
	{
		$isadmin = ((CRUDBooster::myPrivilegeId() == 1) || (CRUDBooster::myPrivilegeId() == 3)) ? true : false;
		return $isadmin;
	}

    public static function exportDefault($header, $columns, $data, $format,$name)
    {
        ini_set('memory_limit', '1024M');
        		set_time_limit(180);
				// $header = ['NIP', 'Nama Perusahaan', 'Telepon','PIC'];
				// $columns = ['nomor_induk_perusahaan', 'nama', 'telepon', 'pic'];
				
				$result['header'] = $header;
				$result['columns'] = $columns;
				$result['data'] = $data;
				// $result['data'] = $this->getIndex()->html_contents['data']->toArray();
				$result['iscb'] = true;
				$filename = $name;
                // dd($data);
				// $filename = 'Data-'.date('Y-m-d H:i:s');
				switch ($format) {
					case 'xls':
						return Excel::download(new DefaultExport($result), $filename.'.xlsx');
						break;
					case 'csv':
						return Excel::download(new DefaultExport($result),  $filename.'.csv');
						break;
					case 'pdf':
						$view = view('backend.export.default_export', $result)->render();
						$pdf = App::make('dompdf.wrapper');
						$pdf->loadHTML($view);
						$pdf->setPaper('A4', 'portrait');
						return $pdf->download( $filename.'.pdf');
						break;
					default:
						# code...
						break;
				}
    }
}
