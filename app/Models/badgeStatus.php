<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class badgeStatus extends Model
{
    use HasFactory;
    protected $fillable = 
    [
        'recipient_id_image',
        'receipt_image',
        'status',
        'user_id'
    ];

    public function recipient(){
        return $this->belongsTo(User::class);
    }
}
