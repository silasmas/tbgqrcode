<?php

namespace App\Models;

use App\Models\participan;
use App\Models\reunion;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class presence extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $dates = ['created_at', 'updated_at'];

    public function participan()
    {
        return $this->belongsTo(participan::class);
    }
}
