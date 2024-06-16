<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TakedownRequest
{
    use HasFactory, Uuid;

    protected $table = 'takedown_requests';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'url_id',
        'reason',
        'status',
        'observations'
    ];

     public function shortened_url() {
         return $this->belongsTo(ShortenedUrl::class);
     }
}
