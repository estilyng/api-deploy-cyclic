<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solver extends Model
{
    protected $table = 'solvers';
    protected $fillable = ['name', 'user_id', 'call_id'];


    public function calls()
    {
        return $this->belongsTo(Call::class, 'call_id');
    }
}
