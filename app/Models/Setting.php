<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting
{
    use HasFactory;

    protected $table = 'settings';

    protected $fillable = [
        'setting_id',
        'value'
    ];
}
