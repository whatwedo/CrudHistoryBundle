<?php
declare(strict_types=1);

use PHP_CodeSniffer\Standards\Squiz\Sniffs\Classes\ValidClassNameSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\Commenting\ClassCommentSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\Commenting\FileCommentSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\Commenting\FunctionCommentThrowTagSniff;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\EasyCodingStandard\ValueObject\Option;

return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::PATHS, [
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ]);


    // run and fix, one by one
    $containerConfigurator->import('vendor/whatwedo/php-coding-standard/config/whatwedo-symfony.php');

    $containerConfigurator->parameters()->set(Option::SKIP, [
        FileCommentSniff::class,
        ClassCommentSniff::class,
        FunctionCommentThrowTagSniff::class,
        ValidClassNameSniff::class
        => [
            __DIR__ . '/tests/App/var/*',
            __DIR__ . '/src/whatwedoCrudHistoryBundle.php',
            __DIR__ . '/src/DependencyInjection/whatwedoCrudHistoryExtension.php',
        ]

    ]);


    $parameters->set(Option::PARALLEL, true);
};
