<?php return [
    'plugin' => [
        'name' => 'Events',
        'description' => 'Plugin for KRNAP events API connection',
    ],
    'component' => [
        'events' => [
            'name' => 'Events',
            'description' => 'Display events from KRNAP API.',
            'page' => [
                'title' => 'Page number',
                'description' => 'This value is used to determine what page the user is on.',
            ],
            'per_page' => [
                'title' => 'Events per page',
                'validation_message' => 'Invalid format of the posts per page value',
            ],
            'event_page' => [
                'title' => 'Event page',
                'description' => 'Name of the event detail page file.',
            ],
            'place' => [
                'title' => 'Place',
                'description' => 'Places of events.',
            ],
        ],
        'event' => [
            'name' => 'Event',
            'description' => 'Display event detail.',
            'id' => [
                'title' => 'Event ID',
                'description' => 'Look up the event using the supplied id value.',
            ],
        ],
    ],
];
