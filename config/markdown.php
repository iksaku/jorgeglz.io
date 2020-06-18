<?php

return [
    'heading_permalink' => [
        'html_class' => 'permalink',
        'insert' => 'after',
        'inner_contents' => '<span class="fas fa-link inline align-middle"></span>',
    ],

    'external_link' => [
        'internal_hosts' => env('APP_URL'),
        'open_in_new_window' => true,
    ],
];
