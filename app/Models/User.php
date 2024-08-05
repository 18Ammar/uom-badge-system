<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\userImage;
use App\Models\userInformation;
use App\Models\carInformation;
use App\Models\requestStatus;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable,HasApiTokens,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id'
    ];

    public function userInformation()
    {
        return $this->hasOne(UserInformation::class,'user_id');
    }
    public function userImage()
    {
        return $this->hasOne(userImage::class,'user_id');
    }
    public function carInformation()
    {
        $this->hasOne(carInformation::class,'user_id');
    }
    public function requestStatusFromAdmin()
    {
        return $this->hasMany(RequestStatus::class,'user_id');
    }
    public function requestStatusFromAuthorizer()
    {
        return $this->hasMany(authorized::class,'user_id');
    }

    public function recipient(){
        return $this->hasMany(badgeStatus::class,'user_id');
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
