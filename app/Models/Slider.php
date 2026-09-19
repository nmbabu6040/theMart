<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'btn_text',
        'btn_link',
        'image',
        'status',
        'serial_number',
    ];
}
