<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectSellBuy extends Model
{
    use HasFactory;


    protected $fillable = [
        'project_id',
        'user_sell',
        'user_buy',
        'status',
        'split_id',
        'cart_id',
    ];

}
