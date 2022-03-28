<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SplitRatio extends Model
{
    use HasFactory;

    protected $fillable = [
        'dev_project_id',
        'price',
        'price_dev_recieve',
        'price_admin_recieve',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
