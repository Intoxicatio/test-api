<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TokenType extends Model
{
    use HasFactory;

    protected $table = 'token_types';

    protected $fillable = ['name'];

    public function services()
    {
        return $this->belongsToMany(Service::class, 'service_token_types');
    }
}
