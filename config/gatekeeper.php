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
];