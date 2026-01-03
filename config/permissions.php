<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Permissions
    |--------------------------------------------------------------------------
    |
    | This list defines all available permissions in the system.
    |
    */

    'all' => [
        'users.list',
        'users.create',
        'users.edit',
        'users.delete',
        'cases.list',
        'cases.create',
        'cases.edit',
        'cases.delete',
        'settings.access',
    ],

    /*
    |--------------------------------------------------------------------------
    | Role Permissions Mapping
    |--------------------------------------------------------------------------
    |
    | Define which permissions belong to which role.
    |
    */

    'role_mapping' => [
        'Admin' => [
            'users.list',
            'users.create',
            'users.edit',
            'users.delete',
            'cases.list',
            'cases.create',
            'cases.edit',
            'cases.delete',
            'settings.access',
        ],
        'Manager' => [
            'users.list',
            'cases.list',
            'cases.create',
        ],
        'Editor' => [
            'users.list',
            'cases.list',
            'cases.edit',
        ],
    ],
];
