<?php

namespace Kettasoft\Gatekeeper\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        //
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('gatekeeper.tables.roles', 'roles');
    }

}
