<?php

return [
    'limit' => [
        'default' => 20,
        'filter' => [
            'type'      => 'integer',
            'config'    => [
                'minimum' => 1
            ]
        ]
    ],
    'page' => [
        'default'   => 1,
        'filter'    => [
            'type' => 'integer'
        ]
    ],
    'ordering' => [
        'default'   => 'id',
        'filter'    => [
            'type' => 'string'
        ]
    ],
    'direction' => [
        'default'   => 'asc',
        'filter'    => [
            'type' => 'string'
        ]
    ],
];