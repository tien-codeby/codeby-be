<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title', 
        'description', 
        'user_id', 
        'views',
        'link', 
        'is_campaign', 
        'content', 
        'service_title',
        'service_list', 
        'attachment',
    ];

    protected $casts = [
        'attachment' => 'json',
        'service_list' => 'json'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function feelings()
    {
        return $this->hasMany(CustomerFeeling::class);
    }
}
