<?php
// return [
//   'application_life_period' => 90,
//   'standard' => [
//     'hierarchy' => [
//       'arcs' => 'ado',
//       'ado' => 'drcs',
//       'drcs' => null, // final approval
//     ],
//     'reverse_hierarchy' => [
//       'drcs' => 'ado',
//       'ado' => 'arcs',
//     ],
//   ],

//   'apex' => [
//     'hierarchy' => [
//       'arcs' => 'ado',
//       'ado' => 'drcs',
//       'drcs' => 'registrar',
//       'registrar' => null, // final approval
//     ],
//     'reverse_hierarchy' => [
//       'registrar' => 'drcs',
//       'drcs' => 'ado',
//       'ado' => 'arcs',
//     ],
//   ],
// ];
return [

    'application_life_period' => 90,

    'standard' => [
        'hierarchy' => [
            'arcs' => ['ado', 'drcs'], // ARCS goes to ADO, then to DRCS
            'ado' => ['arcs'],         // ADO → ARCS (back for inspection)
            'drcs' => [null],          // Final approval
        ],
        'reverse_hierarchy' => [
            'drcs' => ['arcs'],
            // 'arcs' => ['ado'],
            // 'ado' => ['arcs'],
        ],
    ],

    'apex' => [
        'hierarchy' => [
            'arcs' => ['ado', 'drcs'],
            'ado' => ['arcs'],
            'drcs' => ['registrar'],
            'registrar' => [null],
        ],
        'reverse_hierarchy' => [
            'registrar' => ['drcs'],
            'drcs' => ['arcs'],
            // 'arcs' => ['ado'],
            // 'ado' => ['arcs'],
        ],
    ],

];

