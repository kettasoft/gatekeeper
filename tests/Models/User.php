<?php

namespace Gatekeeper\Tests\Models;

use Kettasoft\Gatekeeper\Traits\Gatekeeper;
use Kettasoft\Gatekeeper\Contracts\GatekeeperInterface;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements GatekeeperInterface, AuthenticatableContract
{
    use Gatekeeper, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    public static function new(): self
    {
        return static::create([
            'name' => 'John Doe',
            'email' => 'john@abstract.com',
            'password' => 'password',
        ]);
    }
}
