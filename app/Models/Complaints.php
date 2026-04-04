<?php

namespace App\Models;

use App\Models\ComplaintLinks;
use Illuminate\Database\Eloquent\Model;

class Complaints extends Model
{
    protected $table = 'complaints';
    protected $guarded =[];

    public function complaintLinks()
    {
        return $this->hasMany(ComplaintLinks::class, 'complaint_id');
    }
}
