<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitdc107b27948c120ecb1b11c92ea6209d
{
    public static $prefixLengthsPsr4 = array (
        'D' => 
        array (
            'Dealerdirect\\Composer\\Plugin\\Installers\\PHPCodeSniffer\\' => 55,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Dealerdirect\\Composer\\Plugin\\Installers\\PHPCodeSniffer\\' => 
        array (
            0 => __DIR__ . '/..' . '/dealerdirect/phpcodesniffer-composer-installer/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitdc107b27948c120ecb1b11c92ea6209d::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitdc107b27948c120ecb1b11c92ea6209d::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}