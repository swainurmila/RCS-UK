<?php
return [
    'hierarchy' => [
        'registrar' => ['jrcs'],
        'additionalrcs' => ['jrcs', 'rcs'],
        'drcs' => ['jrcs', 'additionalrcs'],
        'jrcs' => ['arcs'],
        'arcs' => ['Jrcs', 'drcs'],
    ],
];

/* return [
    'standard' => [
        'hierarchy' => [
            'arcs' => 'ado',
            'ado' => 'drcs',
            'drcs' => null, // final approval
        ],
        'reverse_hierarchy' => [
            'drcs' => 'ado',
            'ado' => 'arcs',
        ],
    ],

    'apex' => [
        'hierarchy' => [
            'arcs' => 'ado',
            'ado' => 'drcs',
            'drcs' => 'registrar',
            'registrar' => null, // final approval
        ],
        'reverse_hierarchy' => [
            'registrar' => 'drcs',
            'drcs' => 'ado',
            'ado' => 'arcs',
        ],
    ],
]; */