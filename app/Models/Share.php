<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Share extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_id',
        'user_id',
        'status',
    ];

    

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
