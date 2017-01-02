<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitbfd20e2b579134aff1675c0e57e4719c
{
    public static $prefixLengthsPsr4 = array (
        'f' => 
        array (
            'fpoirotte\\Pssht\\' => 16,
        ),
        'S' => 
        array (
            'Symfony\\Component\\Filesystem\\' => 29,
            'Symfony\\Component\\DependencyInjection\\' => 38,
            'Symfony\\Component\\Config\\' => 25,
        ),
        'P' => 
        array (
            'Plop\\' => 5,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'fpoirotte\\Pssht\\' => 
        array (
            0 => __DIR__ . '/..' . '/fpoirotte/pssht/src',
        ),
        'Symfony\\Component\\Filesystem\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/filesystem',
        ),
        'Symfony\\Component\\DependencyInjection\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/dependency-injection',
        ),
        'Symfony\\Component\\Config\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/config',
        ),
        'Plop\\' => 
        array (
            0 => __DIR__ . '/..' . '/erebot/plop/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitbfd20e2b579134aff1675c0e57e4719c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitbfd20e2b579134aff1675c0e57e4719c::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
