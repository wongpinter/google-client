<?php

return [
    'application_name' => env('GOOGLE_APPLICATION_NAME', ''),

    'client_id'       => env('GOOGLE_CLIENT_ID', ''),
    'client_secret'   => env('GOOGLE_CLIENT_SECRET', ''),
    'redirected_uri'  => env('GOOGLE_REDIRECTED_URI', ''),
    'scopes'          => [
                            'https://www.googleapis.com/auth/admin.directory.user'
                         ],
    'access_type'     => 'offline',
    'approval_prompt' => 'force',
    'developer_key'   => env('GOOGLE_DEVELOPER_KEY', ''),

    'credential_file' => base_path('.google.credentials.json')
];