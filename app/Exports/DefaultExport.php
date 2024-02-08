<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DefaultExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
        // dd($this->data);
    }

    public function view(): View
    {
        return view("backend.export.default_export",$this->data);
    }
}
