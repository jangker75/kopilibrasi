<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateDatabaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kemhan:createdb';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Ulang database';

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
        $pathmigration = "database".DIRECTORY_SEPARATOR."migrations".DIRECTORY_SEPARATOR;
        $this->call('migrate:refresh', [
            '--path'=>[
                $pathmigration.'2021_10_18_225241_create_setting_apps_table.php',
                $pathmigration.'2021_09_01_000001_create_jenis_sertifikasi_product_table.php',
                $pathmigration.'2021_09_02_000002_create_category_table.php',
                $pathmigration.'2021_09_03_000003_create_sub_category_table.php',
                $pathmigration.'2021_09_08_000009_create_sub_sub_categories_table.php',
                $pathmigration.'2021_09_04_000004_create_tenaga_ahli_table.php',
                $pathmigration.'2021_09_05_000005_create_perusahaan_table.php',
                $pathmigration.'2021_09_06_000006_create_perusahaan_tenaga_ahli_table.php',
                $pathmigration.'2021_09_07_000007_create_peralatan_workshop_table.php',
                $pathmigration.'2021_09_08_000008_create_supplier_table.php',
                $pathmigration.'2021_09_09_000009_create_product_table.php',
                $pathmigration.'2021_09_12_000010_create_legalitas_table.php',
                $pathmigration.'2021_09_11_000011_create_riwayat_pekerjaan_table.php',
                $pathmigration.'2021_09_12_000012_create_attachment_legalitas_table.php',
                $pathmigration.'2021_10_16_131741_create_attachment_tenaga_ahlis_table.php',
                $pathmigration.'2021_10_21_105932_create_reset_passwords_table.php',
                $pathmigration.'2021_10_23_023937_create_m_d_status_products_table.php',
                $pathmigration.'2021_10_23_024013_create_m_d_status_emails_table.php',
                $pathmigration.'2021_11_01_073753_create_perusahaan_supplier_table.php',
                $pathmigration.'2021_11_03_111809_md_satuan_kemampuan_produksi.php',
                $pathmigration.'2021_11_03_111837_md_satuan_harga_product.php',
                $pathmigration.'2021_11_03_112102_product_supplier.php',
                $pathmigration.'2021_11_03_112133_tipe_product.php',
                $pathmigration.'2021_11_03_112151_product_tipe_product.php',
                $pathmigration.'2021_11_03_112238_add_field_satuan_tipe_product_to_product_table.php',
                ]
            
        ]);
    }
}
