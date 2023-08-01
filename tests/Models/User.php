<?php

namespace Gatekeeper\Tests\Models;

use Kettasoft\Gatekeeper\Traits\Gatekeeper;
use Illuminate\Database\Eloquent\Model;
use Kettasoft\Gatekeeper\Contracts\GatekeeperInterface;

class User extends Model implements GatekeeperInterface
{
    use Gatekeeper;

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
