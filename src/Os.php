<?php

/*
 * This file is part of the PHP OS Utils package.
 *
 * (c) Prince Dorcis <princedorcis@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Prinx;

/**
 * Os Utilities class.
 *
 * @author Prince Dorcis <princedorcis@gmail.com>
 */
class Os
{
    /**
     * Platforms.
     *
     * @var array
     */
    protected static $platforms = ['guess', 'win', 'windows', 'mac', 'linux', 'unix', 'forward', 'backward'];

    /**
     * Get the name of the OS on which the script is running.
     *
     * @return string
     */
    public static function name()
    {
        return php_uname('s');
    }

    /**
     * Check if the OS name passed is the same as the OS of the machine on
     * which the script is running.
     *
     * @param string $name
     *
     * @return bool
     */
    public static function is($name)
    {
        return Str::startsWith(strtolower($name), strtolower(self::name()));
    }

    /**
     * Return the string 'Cmd' if it is mac and 'Ctrl' else.
     *
     * @return string
     */
    public static function getCtrlKey()
    {
        return self::is('mac') ? 'Cmd' : 'Ctrl';
    }

    /**
     * Return the propoer slash according to the OS.
     * Backslash '\\' for Windows, normal slash '/' for the other OS.
     *
     * If platform is guess, returns the appropriate slash according to the OS running the script
     * Win and windows will produce the same result
     * Linux, Mac, unix will produce the same result.
     *
     * @throws \Exception If platform is unknown
     *
     * @return string
     */
    public static function slash($platform = 'guess')
    {
        $platform = strtolower($platform);

        if (!in_array($platform, self::$platforms, true)) {
            throw new \Exception('Platform must be one of "'.implode(', ', self::$platforms).'"');
        }

        if ('guess' === $platform) {
            return DIRECTORY_SEPARATOR;
        } elseif ('windows' === $platform || 'win' === $platform) {
            return '\\';
        } else {
            return '/';
        }
    }

    /**
     * Returns the path with the proper slash style.
     *
     * Win and windows will produce the same result
     * linux, mac, unix will produce the same result
     *
     * @param string $path
     *
     * @throws \Exception If platform is unknown
     *
     * @return string
     */
    public static function toPathStyle($path, $forcePlatformStyle = 'guess')
    {
        $slash = self::slash($forcePlatformStyle);

        if ($slash === '/') {
            return str_replace('\\', $slash, $path);
        }

        return str_replace('/', $slash, $path);
    }
}
