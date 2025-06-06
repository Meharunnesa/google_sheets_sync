<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2dee6ad40994fdf3c39a0fa5d2b19632
{
    public static $prefixLengthsPsr4 = array (
        'B' => 
        array (
            'Bristy\\GoogleSheets\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Bristy\\GoogleSheets\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit2dee6ad40994fdf3c39a0fa5d2b19632::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit2dee6ad40994fdf3c39a0fa5d2b19632::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit2dee6ad40994fdf3c39a0fa5d2b19632::$classMap;

        }, null, ClassLoader::class);
    }
}
