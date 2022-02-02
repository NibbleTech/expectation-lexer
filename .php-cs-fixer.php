<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__ . '/src');

$config = new PhpCsFixer\Config();
return $config->setRules([
    '@PSR12'                       => true,
    'array_syntax'                 => ['syntax' => 'short'],
    'fully_qualified_strict_types' => true,
    'global_namespace_import'      => true,
    'no_unused_imports'            => true,
])
    ->setFinder($finder);