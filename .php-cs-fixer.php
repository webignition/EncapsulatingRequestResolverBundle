<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__ . '/Model')
    ->in(__DIR__ . '/Services')
    ->in(__DIR__ . '/Tests');

$config = new PhpCsFixer\Config();
return $config->setRules([
    '@PSR12' => true,
    '@PhpCsFixer' => true,
    'concat_space' => [
        'spacing' => 'one',
    ],
    'trailing_comma_in_multiline' => false,
    'php_unit_internal_class' => false,
    'php_unit_test_class_requires_covers' => false,
    'declare_strict_types' => true,
])->setFinder($finder);
