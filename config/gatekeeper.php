<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Gatekeeper User Models
    |--------------------------------------------------------------------------
    |
    | This is the array that contains the information of the user models.
    | This information is used in the add-trait command, for the roles and
    | permissions relationships with the possible user models, and the
    | administration panel to add roles and permissions to the users.
    |
    | The key in the array is the name of the relationship inside the roles and permissions.
    |
    */
    'user_models' => [
        'users' => App\Models\User::class
    ],

    /*
    |--------------------------------------------------------------------------
    | Gatekeeper Models
    |--------------------------------------------------------------------------
    |
    | These are the models used by Gatekeeper to define the roles, permissions and branches.
    | If you want the Gatekeeper models to be in a different namespace or
    | to have a different name, you can do it here.
    |
    */
    'models' => [
        'role' => Kettasoft\Gatekeeper\Models\Role::class,

        'permission' => Kettasoft\Gatekeeper\Models\Permission::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Gatekeeper Tables
    |--------------------------------------------------------------------------
    |
    | These are the tables used by Gatekeeper to store all the authorization data.
    |
    */
    'tables' => [

        'roles' => 'roles',

        'permissions' => 'permissions',

        /**
         * Will be used only if the branches functionality is enabled.
         */
        'branches' => 'branches',

        'role_user' => 'role_user',

        'permission_user' => 'permission_user',

        'permission_role' => 'permission_role',
    ],
];