<?php
// Describe your component
$componentMeta = [
    'title' => 'sampleComponent',
    'status' => 'wip',
    'visible' => true,
    'type' => 'atom',
    'path' => '_atoms/sampleComponent/',
    'description' => 'sampleComponent Description'
];

$defaultVariant = [
    'title' => 'sampleComponent Variant Title',
    'status' => '', // if empty the global status is used
    'description' => 'sampleComponent Variant Description'
];

return [
    'meta' => array_merge($componentMeta, []),
];
