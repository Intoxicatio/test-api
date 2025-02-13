<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogPass extends Model
{
    use HasFactory;

    protected $table = 'log_pass';

    protected $fillable = [
        'login',
        'password'
    ];

    public function tokenable()
    {
        return $this->morphTo();
    }
}
