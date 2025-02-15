<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

class Account extends Authenticatable
{
    use HasApiTokens, HasFactory;

    protected $table = 'accounts';

    protected $fillable = [
        'name',
        'company_id',
        'service_id',
        'token_type_id'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }

    public function apiKey()
    {
        return $this->morphOne(ApiKey::class, 'tokenable');
    }
    public function logPass()
    {
        return $this->morphOne(LogPass::class, 'tokenable');
    }

    public function bearerToken()
    {
        return $this->morphOne(BearerToken::class, 'tokenable');
    }

    public function createBearerToken()
    {
        if ($this->token !== null)
        {
            return ['error' => 'This account already has a token'];
        }

        $this->bearerToken()->create([
            'token' => hash('sha256', $plainTextToken = Str::random(40)),
        ]);

        $this->token_type_id = TokenType::where('name', 'bearer')->first()->id;
        $this->save();

        return ['token' => $plainTextToken];
    }

    public function createApiKey ()
    {
        if ($this->token !== null)
        {
            return ['error' => 'This account already has a token'];
        }

        $this->apiKey()->create([
            'key' => hash('sha256', $plainTextToken = Str::random(20))
        ]);

        $this->token_type_id = TokenType::where('name', 'api_key')->first()->id;;
        $this->save();

        return ['key' => $plainTextToken];
    }

    public function createBasic(string $login, string $password)
    {
        if ($this->token !== null)
        {
            return ['error' => 'This account already has a token'];
        }

        $this->logPass()->create([
            'login' => $login,
            'password' => hash('sha256', $password)
        ]);

        $this->token_type_id = TokenType::where('name', 'basic')->first()->id;
        $this->save();

        return [
            'login' => $login,
            'password' => $password
        ];
    }
}
