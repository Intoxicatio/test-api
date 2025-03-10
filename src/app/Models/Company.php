<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = 'companies';

    protected $fillable = [
        'name',
    ];

    public function accounts()
    {
        return $this->hasMany(Account::class, 'company_id', 'id');
    }
}
