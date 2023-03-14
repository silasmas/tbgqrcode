<?php

namespace App\Models;

use App\Models\User;
use App\Models\reunion;
use App\Models\presence;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class participan extends Model
{
    use HasFactory;
    protected $guarded = [];
    // protected $with = ['reunion'];
    protected $dates = ['created_at', 'updated_at'];

    public function reunion()
    {
        return $this->belongsToMany(reunion::class,"reunion_participans")->withPivot('participan_id', 'reunion_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
