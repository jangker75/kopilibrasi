<?php

namespace App\Console\Commands;

use Cache;
use crocodicstudio\crudbooster\helpers\CRUDBooster;
use DB;
use Illuminate\Console\Command;
class SendMailQueues extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kemhan:mailqueues';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run Mail Queues';

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
        $now = date('Y-m-d H:i:s');

        $this->comment('Mail Queues Started '.$now);

        $queues = db('cms_email_queues')->where('is_sent', 0)->where('send_at', '<=', $now)->take(25)->get();

        $this->comment('Total Queues : '.count($queues));

        Cache::increment('total_email_sent', count($queues));
        Cache::put('last_email_sent', date('Y-m-d H:i:s'));

        foreach ($queues as $q) {
            try {
                if (filter_var($q->email_recipient, FILTER_VALIDATE_EMAIL) !== false) {
                    CRUDBooster::sendEmailQueue($q);
                }
                DB::table('cms_email_queues')->where('id', $q->id)->update(['is_sent'=>1]);
                $this->comment('Email success sent to -> '.$q->email_subject.' ('.$q->email_recipient.')');
            } catch (\Throwable $th) {
                $this->comment('Email failed send to -> '.$q->email_subject.' ('.$q->email_recipient.')');
                // $this->comment($th);
            }
            
        }
    }
}
