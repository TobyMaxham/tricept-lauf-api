<?php

return [
    'api_key' => env('LAUF_APIKEY'),
    'api_user' => env('LAUF_USERNAME'),
    'api_password' => env('LAUF_PASSWORD'),
    'api_baseurl' => env('LAUF_BASEURL'),
    'api_type_param' => env('LAUF_TYPE_PARAM'),
    'usernames_file' => env('LAUF_USERNAMES_FILE', 'usernames.json'),
    'gravatar_icon' => env('LAUF_GRAVATAR', 'identicon'),
    'auth_ttl' => 60 * 60 * 4,
    'image_ttl' => 60 * 5,
    'step_cm' => 75,
];
