<?php
namespace App\Models;
use Hash;
use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesTransaction extends Model
{
    protected $table = 't_sales_header';
    protected $fillable = [
        'customer_id', 
        'code', 
        'total_price', 
        'status',
        'date',
        'created_at',
    ];
    public function salesdetail(){
        return $this->hasMany(SalesDetail::class,'sales_id');
    }
    
}