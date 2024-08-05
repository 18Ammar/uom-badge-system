<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class userImage extends Model
{
    use HasFactory;
    protected $fillable = [
        'driver_photo', 
        'applicant_photo', 
        'civil_or_unified_id_front', 
        'civil_or_unified_id_back',
        'iraqi_nationality',
        'ration_card',
        'green_card_front',
        'green_card_back',
        'residence_certification',
        'continuous_service_letter',
        'university_id_front',
        'university_id_back',
        'user_id'
    ];
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
