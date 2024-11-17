<?php
$finder = PhpCsFixer\Finder::create()
    ->exclude(['vendor/'])
    ->in(__DIR__)
    ->name('*.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

$config = new PhpCsFixer\Config();
$config
    ->setRiskyAllowed(true)
    ->setUsingCache(true)
    ->setRules(['@PhpCsFixer' => true, '@PHP81Migration' => true])
    ->setFinder($finder);

return $config;
