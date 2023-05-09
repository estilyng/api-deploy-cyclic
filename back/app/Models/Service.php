<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'services';

    protected $fillable = ['user_id', 'name', 'description', 'destiny', 'term', 'initials', 'priority'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
