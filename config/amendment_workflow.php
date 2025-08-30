<?php
return [
  'standard' => [
    'hierarchy' => [
      'arcs' => 'drcs',
      // 'arcs' => 'ado',
      // 'ado' => 'drcs',
      'drcs' => null, // final approval
    ],
    'reverse_hierarchy' => [
      'drcs' => 'arcs',
      // 'drcs' => 'ado',
      // 'ado' => 'arcs',
    ],
  ],

  'apex' => [
    'hierarchy' => [
      'arcs' => 'drcs',
      'drcs'=>'registrar',
      'registrar'=>null,
      // 'arcs' => 'ado',
      // 'ado' => 'drcs',
      // 'drcs' => 'registrar',
      // 'registrar' => null, // final approval
    ],
    'reverse_hierarchy' => [
      'registrar' => 'drcs',
      'drcs'=>'arcs',
      // 'registrar' => 'drcs',
      // 'drcs' => 'ado',
      // 'ado' => 'arcs',
    ],
  ],
];
