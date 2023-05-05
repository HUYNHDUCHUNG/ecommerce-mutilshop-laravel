<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $guarded = [];
    use HasFactory;
    public function product(){
        return $this->hasOne(Product::class,'id','product_id');
    }
}
