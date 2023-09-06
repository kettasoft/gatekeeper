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

        'default_status' => TRUE,

        'roles' => 'roles',

        'permissions' => 'permissions',

        'role_user' => 'role_user',
    ],

    /*
    |--------------------------------------------------------------------------
    | Gatekeeper Foreign Keys
    |--------------------------------------------------------------------------
    |
    | These are the foreign keys used by Gatekeeper in the intermediate tables.
    |
    */
    'foreign_keys' => [
        /**
         * Role foreign key on Gatekeeper's role_user and permission_role tables.
         */
        'role' => 'role_id',

        /**
         * Role foreign key on Gatekeeper's permission_user and permission_role tables.
         */
        'permission' => 'permission_id',
    ],

    /*
    |--------------------------------------------------------------------------
    | Checkers
    |--------------------------------------------------------------------------
    |
    | Manage Gatekeeper's role and permissions checkers configurations.
    |
    */
    'checkers' => [

        /*
        |--------------------------------------------------------------------------
        | Which permissions checker to use.
        |--------------------------------------------------------------------------
        |
        | Defines if you want to use the roles and permissions checker.
        | Available:
        | - default: Check for the roles and permissions using the method that Gatekeeper
        |            has always used.
        | - query: Check for the roles and permissions using direct queries to the database.
        |           This method doesn't support cache yet.
        | - class that extends Gatekeeper\Checkers\User\UserChecker
        */
        'user' => 'default',

        /*
        |--------------------------------------------------------------------------
        | Which role checker to use.
        |--------------------------------------------------------------------------
        |
        | Defines if you want to use the roles and permissions checker.
        | Available:
        | - default: Check for the roles and permissions using the method that Gatekeeper has always used.
        | - query: Check for the roles and permissions using direct queries to the database.
        |          This method doesn't support cache yet.
        | - class that extends Gatekeeper\Checkers\Role\RoleChecker
        */
        'role' => 'default',
    ],

    /*
    |--------------------------------------------------------------------------
    | Gatekeeper cache
    |--------------------------------------------------------------------------
    |
    | Manage Gatekeeper cache configurations. It uses the driver defined in the
    | config/cache.php file.
    |
    */
    'cache' => [
        /*
        |--------------------------------------------------------------------------
        | Use cache in the package
        |--------------------------------------------------------------------------
        |
        | Defines if Gatekeeper will use Laravel's Cache to cache the roles and permissions.
        | NOTE: Currently the database check does not use cache.
        |
        */
        'enabled' => env('GATEKEEPER_ENABLE_CACHE', env('APP_ENV') === 'production'),

        /*
        |--------------------------------------------------------------------------
        | Time to store in cache Gatekeeper's roles and permissions.
        |--------------------------------------------------------------------------
        |
        | Determines the time in SECONDS to store Goverable's roles and permissions in the cache.
        |
        */
        'expiration_time' => 60 * 60,
    ],

    /*
    |--------------------------------------------------------------------------
    | Gatekeeper Middleware
    |--------------------------------------------------------------------------
    |
    | This configuration helps to customize the Gatekeeper middleware behavior.
    |
    */
    'middleware' => [
        /**
         * Define if the Gatekeeper middleware are registered automatically in the service provider.
         */
        'register' => true,

        /**
         * Method to be called in the middleware return case.
         * Available: abort|redirect.
         */
        'handling' => 'abort',

        /**
         * Handlers for the unauthorized method in the middlewares.
         * The name of the handler must be the same as the handling.
         */
        'handlers' => [
            /**
             * Aborts the execution with a 403 code and allows you to provide the response text.
             */
            'abort' => [
                'code' => 403,
                'message' => 'User does not have any of the necessary access rights.',
            ],

            /**
             * Redirects the user to the given url.
             * If you want to flash a key to the session,
             * you can do it by setting the key and the content of the message
             * If the message content is empty it won't be added to the redirection.
             */
            'redirect' => [
                'url' => '/home',
                'message' => [
                    'key' => 'error',
                    'content' => '',
                ],
            ],
        ],
    ],
];
