<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit8be9eea91130467a6ce6181d971a0a10
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Pentiminax\\DuplicatePost\\' => 25,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Pentiminax\\DuplicatePost\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInit8be9eea91130467a6ce6181d971a0a10::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit8be9eea91130467a6ce6181d971a0a10::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit8be9eea91130467a6ce6181d971a0a10::$classMap;

        }, null, ClassLoader::class);
    }
}
