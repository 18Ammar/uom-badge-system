<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class promoteAdmin extends Model
{
    use HasFactory;
    protected $fillable = [
        'employee_id',
        'name',
        'university_email',
        'college_name',
        'department',
        'mobile_number',
        'personal_photo',
        'authorization_document',
        'employee_type'
    ];

}
