<?php

namespace App;

use App\Models\Call;
use App\Models\Message;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Profile;
use App\Models\Response;
use App\Models\Service;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, HasRoles;

    protected $guard_name = 'api';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id');
    }

    public function calls()
    {
        return $this->belongsToMany(Call::class, 'users_calls', 'user_id', 'call_id');
    }

    public function services()
    {
        return $this->hasMany(Service::class, 'user_id');
    }

    public function responses()
    {
         return $this->belongsToMany(Response::class, 'users_calls', 'response_id');
    }

    public function messages ()
    {
        return $this->hasMany(Message::class, 'from');
    }
}
