<?php

namespace Kettasoft\Gatekeeper\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'permissions'
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table;

    /**
     * Creates a new instance of the model.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('gatekeeper.tables.permissions.table_name', 'permissions');
    }

    /**
     * Convert the permissions from json string to array.
     */
    public function getPermissionsAttribute(string $permissions): array
    {
        return json_decode($permissions, TRUE);
    }
}
