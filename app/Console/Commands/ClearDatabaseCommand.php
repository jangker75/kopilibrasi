<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Illuminate\Support\Facades\Schema;
class ClearDatabaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kemhan:cleardb';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command untuk clear database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->dropDB();
        $this->info('Table successfully cleared!');

    }

    private function dropDB(){
        Schema::dropIfExists('reset_password');
        Schema::dropIfExists('setting_apps');
        Schema::dropIfExists('attachment_tenaga_ahli');
        Schema::dropIfExists('perusahaan_supplier');
        Schema::dropIfExists('perusahaan_tenaga_ahli');
        Schema::dropIfExists('product_supplier');
        Schema::dropIfExists('product_tipe_product');
        Schema::dropifExists('peralatan_workshop');
        Schema::dropifExists('riwayat_pekerjaan');
        Schema::dropifExists('attachment_legalitas');
        Schema::dropifExists('legalitas');
        Schema::dropifExists('tenaga_ahli');
        Schema::dropifExists('product');
        Schema::dropifExists('supplier');
        Schema::dropifExists('jenis_sertifikasi_product');
        Schema::dropifExists('perusahaan');
        Schema::dropifExists('md_status_product');
        Schema::dropifExists('md_status_email');
        Schema::dropIfExists('sub_sub_category');
        Schema::dropifExists('sub_category');
        Schema::dropifExists('category');
        Schema::dropifExists('md_satuan_kemampuan_produksi');
        Schema::dropifExists('md_currency');
        Schema::dropifExists('tipe_product');
        DB::table('media')->truncate();
        DB::table('cms_users')->where('id_cms_privileges',2)->delete();
    }
    
}
