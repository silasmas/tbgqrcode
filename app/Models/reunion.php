<?php

namespace App\Models;

use App\Models\presence;
use App\Models\participan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class reunion extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $dates = ['created_at', 'updated_at'];
    public function participan()
    {
        return $this->belongsToMany(participan::class,"reunion_participans")->withPivot('participan_id', 'reunion_id');
    }
}
