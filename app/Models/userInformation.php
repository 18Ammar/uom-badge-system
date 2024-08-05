<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class userInformation extends Model
{
    use HasFactory;
    protected $table = 'user_information';
    protected $fillable = [
        'user_id',
        'first_name',
        'father_name',
        'grandfather_name',
        'family_name',
        'nickname',
        'mother_name',
        'date_of_birth',
        'gender',
        'address',
        'nearest_landmark',
        'phone_number',
        'driver_phone_number',
        'college',
        'department',
        'job_title',
        'academic_title',
        'id_type',
        'civil_or_unified_number',
        'civil_or_unified_date',
        'record',
        'page',
        'registry_office',
    ];
    public function user()
    {
        $this->belongsTo(User::class,'user_id');
    }
}
