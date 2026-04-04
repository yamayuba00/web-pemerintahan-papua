<?php

namespace App\Models;

use App\Models\Complaints;
use Illuminate\Database\Eloquent\Model;

class ComplaintLinks extends Model
{
    protected $table = 'complaint_links';
    protected $guarded = [];

    public function complaint()
    {
        return $this->belongsTo(Complaints::class, 'complaint_id', 'id');
    }
}
