<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['preview'];


    function rel_to_thumbnail(){
        return $this->hasMany(ProductThumbnail::class, 'product_id');
    }
    function inventories(){
        return $this->hasMany(Inventory::class, 'product_id');
    }
}
