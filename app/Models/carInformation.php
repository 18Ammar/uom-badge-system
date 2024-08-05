<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class carInformation extends Model
{
    use HasFactory;
    protected $fillable  = [
        'car_number',
        'ownership',
        'car_type',
        'car_color',
        'car_model',
        'agency_1',
        'agency_2',
        'driving_license_face',
        'driving_license_back',
        'car_registration_face',
        'car_registration_back',
        'user_id'
    ];
    public function car(){
        $this->belongsTo(User::class,'user_id');
    }
}
