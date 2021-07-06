<?php

declare(strict_types=1);
$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->exclude('vendor')
    ->exclude('config')
    ->exclude('docker')
    ->exclude('scripts')
    ->exclude('web')
    ->exclude('runtime')
    ->in(__DIR__)
    ->ignoreVCS(true)
    ->files()
;

$config = new PhpCsFixer\Config();

return $config->setRules([
    '@Symfony' => true,
    '@Symfony:risky' => true,
    'array_syntax' => ['syntax' => 'short'],
    'concat_space' => ['spacing' => 'one'],
    'general_phpdoc_annotation_remove' => ['annotations' => ['expectedException', 'expectedExceptionMessage', 'expectedExceptionMessageRegExp', 'return', 'param']],
    'strict_comparison' => true,
    'native_function_invocation' => true,
    'final_public_method_for_abstract_class' => false,
    'declare_strict_types' => true,
])
    ->setFinder($finder)
    ->setRiskyAllowed(true)
    ;
