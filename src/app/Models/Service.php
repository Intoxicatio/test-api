<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';

    protected $fillable = ['name'];

    public function accounts()
    {
        return $this->hasMany(Account::class, 'service_id', 'id');
    }

    public function tokenTypes()
    {
        return $this->belongsToMany(TokenType::class, 'service_token_types', 'service_id', 'token_type_id');
    }
}
