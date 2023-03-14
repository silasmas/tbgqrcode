<?php

namespace App\Models;

use App\Models\reunion;
use App\Models\participan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class reunionParticipan extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $dates=['created_at','updated_at'];
    protected $table=['reunion_oarticipans'];
    public function reunion()
    {
        return $this->belongsTo(reunion::class);
    }
    public function participan()
    {
        return $this->belongsTo(participan::class);
    }
}
