<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesDetail extends Model
{
    protected $table = 't_sales_detail';
    protected $fillable = [
        'sales_id', 
        'product_id', 
        'base_price', 
        'sale_price',
        'sub_total',
        'discount_percent',
        'discount',
        'qty',
    ];
    public function salesHeader(){
        return $this->belongsTo(SalesTransaction::class,'sales_id');
    }
}
