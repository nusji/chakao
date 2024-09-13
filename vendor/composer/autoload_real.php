<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit238e6df299ee032fdb0949be0fec0b59
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInit238e6df299ee032fdb0949be0fec0b59', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit238e6df299ee032fdb0949be0fec0b59', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit238e6df299ee032fdb0949be0fec0b59::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
