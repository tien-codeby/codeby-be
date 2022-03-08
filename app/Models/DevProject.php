<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class DevProject extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'status',
        'description',
        'attachments',
        'free_support',
        'fee_support',
        'categories',
        'demo_link',
        'price',
        'sale_price',
    ];

    protected $casts = [
        'goal_ids' => 'json',
        'attachments' =>  'json',
        'free_support' => 'json',
        'fee_support' => 'json',
        'categories' =>  'json',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
