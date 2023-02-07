<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'device',
    ];

    public function shares()
    {
        return $this->hasMany(Device::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
