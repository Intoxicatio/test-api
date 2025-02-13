<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BearerToken extends Model
{
    use HasFactory;

    protected $table = 'bearer_tokens';

    protected $fillable = [
        'token'
    ];

    public function tokenable()
    {
        return $this->morphTo();
    }

}
