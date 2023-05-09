<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Call extends Model
{

    protected $table = 'calls';

    protected $fillable = [
        'name',
        'description',
        'term',
        'destiny',
        'initials',
        'priority',
        'statu',

        'created_by',
        'updated_by'
    ];

    protected $dates = ['updated_at', 'created_at'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_calls', 'call_id', 'user_id')->withPivot('user_id', 'call_id');
    }

    public function responses()
    {
         return $this->hasMany(Response::class, 'call_id')->orderBy('id', 'asc');
    }
    public function solver()
    {
         return $this->hasOne(Solver::class, 'call_id');
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'call_id');
    }
}
