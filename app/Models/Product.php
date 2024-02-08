<?php
namespace App\Models;
use Hash;
use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'm_product';
    protected $fillable = [
        'name', 
        'base_price', 
        'sale_price', 
        'description', 
        'is_active',
        'category_id',
    ];
}