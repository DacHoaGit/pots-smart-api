<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suggestion extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'user_id',
        'description',
        'nhiet_do_bom_min',
        'nhiet_do_bom_max',
        'do_am_khong_khi_bom_min',
        'do_am_khong_khi_bom_max',
        'do_am_dat_bom_min',
        'do_am_dat_bom_max',
        'nhiet_do_den_min',
        'nhiet_do_den_max',
        'do_am_khong_khi_den_min',
        'do_am_khong_khi_den_max',
        'do_am_dat_den_min',
        'do_am_dat_den_max',
        'image',
    ];
}
