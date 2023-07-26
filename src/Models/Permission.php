<?php

namespace Kettasoft\Gatekeeper\Models;

use Illuminate\Database\Eloquent\Model;
use Kettasoft\Gatekeeper\Services\ConvertPermissionArrayToJson;

class Permission extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'permissions',
        'status'
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
    public function getPermissionsAttribute($permissions)
    {
        return json_decode($permissions, TRUE);
    }

    /**
     * Convert the permissions from array to json string on create.
     */
    public function setPermissionsAttribute($permissions)
    {
        $this->attributes['permissions'] = ConvertPermissionArrayToJson::convert($permissions);
    }
}
