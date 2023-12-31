<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitee2d6b765c8a1a0d5e3e7a1c50a8f33a
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

        require __DIR__ . '/platform_check.php';

        spl_autoload_register(array('ComposerAutoloaderInitee2d6b765c8a1a0d5e3e7a1c50a8f33a', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitee2d6b765c8a1a0d5e3e7a1c50a8f33a', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitee2d6b765c8a1a0d5e3e7a1c50a8f33a::getInitializer($loader));

        $loader->register(true);

        $includeFiles = \Composer\Autoload\ComposerStaticInitee2d6b765c8a1a0d5e3e7a1c50a8f33a::$files;
        foreach ($includeFiles as $fileIdentifier => $file) {
            composerRequireee2d6b765c8a1a0d5e3e7a1c50a8f33a($fileIdentifier, $file);
        }

        return $loader;
    }
}

/**
 * @param string $fileIdentifier
 * @param string $file
 * @return void
 */
function composerRequireee2d6b765c8a1a0d5e3e7a1c50a8f33a($fileIdentifier, $file)
{
    if (empty($GLOBALS['__composer_autoload_files'][$fileIdentifier])) {
        $GLOBALS['__composer_autoload_files'][$fileIdentifier] = true;

        require $file;
    }
}
