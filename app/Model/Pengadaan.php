<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Pengadaan extends Model
{
    //
    protected $fillable = [
        'product_name', 'product_code', 'product_quantity','selling_price','sub_total'
    ];
}
