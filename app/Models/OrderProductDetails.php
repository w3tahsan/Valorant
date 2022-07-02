<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProductDetails extends Model
{

    function rel_to_user(){
        return $this->belongsTo(CustomerLogin::class, 'user_id');
    }

    use HasFactory;
    protected $guarded = ['id'];
}
