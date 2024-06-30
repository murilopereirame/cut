<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TakedownRequest extends Model
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
        'password',
        'reason',
        'status',
    ];

     public function shortened_url() {
         return $this->belongsTo(ShortenedUrl::class);
     }
}
