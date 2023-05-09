<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';

    protected $fillable = ['path', 'call_id'];

    public function call()
    {
        return $this->belongsTo(Call::class, 'call_id');
    }
}
