<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';

    protected $fillable = [
        'call_id',
        'from',
        'to',
        'content',
    ];

    public function call()
    {
        return $this->hasOne(Call::class, 'call_id');
    }
}
