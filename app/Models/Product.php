<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function productImgs(){
        return $this->hasMany(ProductImg::class, 'product_id', 'id');
    }


    public function getCategory(){
        return $this->hasOne(Category::class, 'id','category_id');
    }
}
