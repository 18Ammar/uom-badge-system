<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class authorized extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id',
        'status',
        'message'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
