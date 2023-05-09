<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    protected $table = 'responses';

    protected $fillable = ['created_by', 'updated_by', 'text', 'rating', 'posted'];

    protected $dates = ['created_at', 'updated_at'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_calls', 'user_id')->withPivot('call_id');
    }
    
    public function call()
    {
        return $this->belongsTo(Call::class, 'call_id');
    }
}
