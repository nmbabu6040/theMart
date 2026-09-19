<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactQuestion extends Model
{
    protected $fillable = [
        'name',
        'email',
        'subject',
        'address',
        'service',
        'note',
    ];
}
